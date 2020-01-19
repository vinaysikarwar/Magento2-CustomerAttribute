<?php
namespace WebTechnologyCodes\CustomerAttribute\Controller\Adminhtml\customerattribute;

use Magento\Backend\App\Action;
use Magenest\CustomerAttributes\Model\ResourceModel\CustomerOption;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Model\AttributeFactory;
use Magento\Eav\Model\Config;
ini_set('display_errors','1');
/**
 * Class Save
 * @package Magenest\CustomerAttributes\Controller\Adminhtml\Customer\Attribute
 */
class Save extends Action
{
	
    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var Filesystem
     */
    protected $_filesystem;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    protected $setup;

    /**
     * @var \Magento\Customer\Model\AttributeFactory
     */
    protected $_attrFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param Filesystem $filesystem
     * @param AttributeSetFactory $attributeSetFactory
     * @param LoggerInterface $loggerInterface
     * @param ModuleDataSetupInterface $setup
     * @param AttributeFactory $attrFactory
     */
    public function __construct(
        Action\Context $context,
        Filesystem $filesystem,
        AttributeSetFactory $attributeSetFactory,
        LoggerInterface $loggerInterface,
        ModuleDataSetupInterface $setup,
        AttributeFactory $attrFactory,
		Config $eavConfig
    ) {
        $this->_logger = $loggerInterface;
        $this->_attrFactory = $attrFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->_filesystem = $filesystem;
        $this->setup = $setup;
		$this->eavConfig = $eavConfig;
        parent::__construct($context);
    }
    /**
     * save action
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
	
        $data = $this->getRequest()->getPostValue();
        $this->_logger->debug(print_r($data, true));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_attrFactory->create();
            if (isset($data['attribute_id'])) {
                $model->load($data['attribute_id']);
            }
            if (empty($data['attribute_label'])) {
                throw new LocalizedException(__('Wrong attribute rule.'));
            }
            $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData();
           
            try {
				
					
                $attribute['entity_type_id'] = 1;
                $attribute['backend_type'] = 'static';
				
                $array = $this->getInformation($data['attribute_type']);
				
                if (!empty($array)){
                    if (!(array_key_exists('attribute_id', $data))) {
                        $attribute['attribute_code'] = $data['attribute_code'];
                        $attribute['sort_order'] = $data['sort_order'];
                        $attribute['frontend_input'] = $array['frontend_input'];
                    }
					
                    $default = $array['default_value'];
					
                    if (!empty($default)) {
						$attribute['default_value'] = $data['default_value_text'];
                    }
				
						/*  echo '<pre>';
					print_r ($array);
					die('test'); 	 */
                }
                if ($data['attribute_type'] == 'multiselect') {
                    $attribute['source_model'] = 'Magento\Eav\Model\Entity\Attribute\Source\Table';
                }
                $attribute['frontend_label'] = $data['attribute_label'];
                $attribute['is_required'] = $data['required'];
                $attribute['note'] = 'is_new';
                $attribute['is_visible'] = $data['visibletocustomer'];
                $attribute['is_user_defined'] = $data['visibletocustomer'];
                $attribute['is_system'] = $data['system'];;
                $attribute['is_used_in_grid'] = $data['is_used_in_grid'];
                $attribute['is_filterable_in_grid'] = $data['is_filterable_in_grid'];
                $attribute['is_searchable_in_grid'] = $data['is_searchable_in_grid'];
				$attribute['used_in_forms'] = 'adminhtml_customer';


                $option = $this->saveCustomOption($data);
                $model->addData($attribute);
                $model->save();
				
				$sampleAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, $data['attribute_code']);

				// more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
				$sampleAttribute->setData(
					'used_in_forms',
					['adminhtml_customer']

				);
				$sampleAttribute->save();
				
				
                $this->_eventManager->dispatch('customer_custom_attribute_save_after', ['option' => $option, 'model' => $model]);
                $this->messageManager->addSuccessMessage(__('Custom Customer Attribute Created.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['attribute_id' => $model->getAttributeId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the invoice.'));
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                return $resultRedirect->setPath('*/*/edit', ['attribute_id' => $model->getAttributeId(), '_current' => true]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $data
     * @return array
     */
    public function saveCustomOption($data)
    {
        $option = [
            'type' => $data['attribute_type'],
            'validate_rules'=> $data['input_validation'],
            'is_registration' => $data['visibletocustomer'],
            'is_account' => 0,
            'is_checked' => 0,
        ];

        if ($data['attribute_type'] == 'image') {
            $option['value'] = $data['image_size'];
			$option['value'] = '';
        } elseif ($data['attribute_type'] == 'multiselect' || $data['attribute_type'] == 'select') {
            $optionArrayTemp = [];
            foreach ($data['option'] as $optionItem) {
                if (strlen($optionItem['title']) > 0) {
                    $optionArrayTemp[] = $optionItem;
                }
            }
            $infoOption = serialize($optionArrayTemp);
            $option['value'] = $infoOption;
        }

       /*  if ($data['is_checked'] == 1) {
            $option['country_code'] = serialize($data['country']);
        } else {
            $option['country_code'] = '';
        } */
        $option['country_code'] = '';
        return $option;
    }

    /**
     * @param $type
     * @return array
     */
    public function getInformation($type)
    {
        $info = [];
        switch ($type) {
            case 'text':
                $info = [
                    'frontend_input' => 'text',
                    'default_value' => 'value_text_field'
                ] ;
                break;
            case 'textarea':
                $info = [
                    'frontend_input' => 'textarea',
                    'default_value' => 'value_text_area'
                ] ;
                break;
            case 'date':
                $info = [
                    'frontend_input' => 'date',
                    'default_value' => 'value_date'
                ] ;
                break;
            case 'multiselect':
                $info = [
                    'frontend_input' => 'multiselect',
                    'default_value' => ''
                ] ;
                break;
            case 'select':
                $info = [
                    'frontend_input' => 'select',
                    'default_value' => ''
                ] ;
                break;
            case 'boolean':
                $info = [
                    'frontend_input' => 'boolean',
                    'default_value' => 'value_yes_no'
                ] ;
                break;
            case 'image':
                $info = [
                    'frontend_input' => 'image',
                    'default_value' => ''
                ] ;
                break;
            default:
                break;
        }

        return $info;
    }
    
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}

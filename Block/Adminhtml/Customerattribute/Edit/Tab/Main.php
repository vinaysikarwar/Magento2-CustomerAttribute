<?php

namespace WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Edit\Tab;

/**
 * Customerattribute edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \WebTechnologyCodes\CustomerAttribute\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \WebTechnologyCodes\CustomerAttribute\Model\Status $status,
        array $data = []
    ){
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \WebTechnologyCodes\CustomerAttribute\Model\BlogPosts */
        $model = $this->_coreRegistry->registry('customerattribute');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Attribute Properties')]);

        if ($model->getId()){
            $fieldset->addField('attribute_id', 'hidden', ['name' => 'attribute_id']);
        }
        
		
        $fieldset->addField(
            'attribute_code',
            'text',
            [
                'name' => 'attribute_code',
                'label' => __('Attribute Code'),
                'title' => __('Attribute Code'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
					
        $fieldset->addField(
            'attribute_label',
            'text',
            [
                'name' => 'attribute_label',
                'label' => __('Attribute Label'),
                'title' => __('Attribute Label'),
				'required' => true,
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'attribute_type',
            'select',
            [
                'label' => __('Attribute Type'),
                'title' => __('Attribute Type'),
                'name' => 'attribute_type',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray5(),
                'disabled' => $isElementDisabled
            ]
        );
									
						
        $fieldset->addField(
            'required',
            'select',
            [
                'label' => __('Values Required'),
                'title' => __('Values Required'),
                'name' => 'required',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2(),
                'disabled' => $isElementDisabled
            ]
        );
						
		$fieldset->addField(
            'default_value_text',
            'text',
            [
                'name' => 'default_value_text',
                'label' => __('Default Value'),
                'title' => __('Default Value'),
				'required' => false,
                'disabled' => $isElementDisabled
            ]
        );								
		
		$fieldset->addField(
            'input_validation',
            'select',
            [
                'label' => __('Input Validation'),
                'title' => __('Input Validation'),
                'name' => 'input_validation',
				'required' => false,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray6(),
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'input_filter',
            'select',
            [
                'label' => __('Input/Output Filter'),
                'title' => __('Input/Output Filter'),
                'name' => 'input_filter',
				'required' => false,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray7(),
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'is_used_in_grid',
            'select',
            [
                'label' => __('Add to Column Options'),
                'title' => __('Add to Column Options'),
                'name' => 'is_used_in_grid',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2(),
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'is_filterable_in_grid',
            'select',
            [
                'label' => __('Use in Filter Options'),
                'title' => __('Use in Filter Options'),
                'name' => 'is_filterable_in_grid',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2(),
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'is_searchable_in_grid',
            'select',
            [
                'label' => __('Use in Search Options'),
                'title' => __('Use in Search Options'),
                'name' => 'is_searchable_in_grid',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2(),
                'disabled' => $isElementDisabled
            ]
        );
		
		$fieldset->addField(
            'visibletocustomer',
            'select',
            [
                'label' => __('Visible To Customer'),
                'title' => __('Visible To Customer'),
                'name' => 'visibletocustomer',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray4(),
                'disabled' => $isElementDisabled
            ]
        );
        
        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'title' => __('Sort Order'),
				'disabled' => $isElementDisabled
            ]
        );
        
		$usedinform = [['value' => __('customer_account_create') , 'label' => __('Customer Registration')], ['value' => __('customer_account_edit'), 'label' => __('Customer Account Edit')],['value' => __('adminhtml_checkout'), 'label' => __('Admin Checkout')]];
		$fieldset->addField(
            'used_in_forms',
            'multiselect',
            [
                'name' => 'used_in_forms',
                'label' => __('Forms to Use In'),
                'title' => __('Forms to Use In'),
                'values' => $usedinform
            ]
        );

		
        $fieldset->addField(
            'system',
            'select',
            [
                'label' => __('System'),
                'title' => __('System'),
                'name' => 'system',
				'required' => true,
                'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray3(),
                'disabled' => $isElementDisabled
            ]
        );
						
		
        if (!$model->getId()){
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);
		
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Properties');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Properties');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    
    public function getTargetOptionArray(){
    	return array(
    	    '_self' => "Self",
			'_blank' => "New Page",
    	);
    }
}

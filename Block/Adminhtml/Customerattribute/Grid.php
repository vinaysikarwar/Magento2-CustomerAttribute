<?php
namespace WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \WebTechnologyCodes\CustomerAttribute\Model\customerattributeFactory
     */
    protected $_customerattributeFactory;

    /**
     * @var \WebTechnologyCodes\CustomerAttribute\Model\Status
     */
    protected $_status;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \WebTechnologyCodes\CustomerAttribute\Model\customerattributeFactory $customerattributeFactory
     * @param \WebTechnologyCodes\CustomerAttribute\Model\Status $status
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \WebTechnologyCodes\CustomerAttribute\Model\CustomerattributeFactory $CustomerattributeFactory,
        \WebTechnologyCodes\CustomerAttribute\Model\Status $status,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
        $this->_customerattributeFactory = $CustomerattributeFactory;
        $this->_status = $status;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->_customerattributeFactory->create()->getCollection();
        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );


		
				$this->addColumn(
					'attribute_code',
					[
						'header' => __('Attribute Code'),
						'index' => 'attribute_code',
					]
				);
				
				$this->addColumn(
					'attribute_label',
					[
						'header' => __('Attribute Label'),
						'index' => 'attribute_label',
					]
				);
				
						
						$this->addColumn(
							'required',
							[
								'header' => __('Required'),
								'index' => 'required',
								'type' => 'options',
								'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2()
							]
						);
						
						
						
						$this->addColumn(
							'system',
							[
								'header' => __('System'),
								'index' => 'system',
								'type' => 'options',
								'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray3()
							]
						);
						
						
						
						$this->addColumn(
							'visibletocustomer',
							[
								'header' => __('Visible To Customer'),
								'index' => 'visibletocustomer',
								'type' => 'options',
								'options' => \WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray4()
							]
						);
						
						
				$this->addColumn(
					'sort_order',
					[
						'header' => __('Sort Order'),
						'index' => 'sort_order',
					]
				);
				


		
        //$this->addColumn(
            //'edit',
            //[
                //'header' => __('Edit'),
                //'type' => 'action',
                //'getter' => 'getId',
                //'actions' => [
                    //[
                        //'caption' => __('Edit'),
                        //'url' => [
                            //'base' => '*/*/edit'
                        //],
                        //'field' => 'id'
                    //]
                //],
                //'filter' => false,
                //'sortable' => false,
                //'index' => 'stores',
                //'header_css_class' => 'col-action',
                //'column_css_class' => 'col-action'
            //]
        //);
		

		
		   $this->addExportType($this->getUrl('customerattribute/*/exportCsv', ['_current' => true]),__('CSV'));
		   $this->addExportType($this->getUrl('customerattribute/*/exportExcel', ['_current' => true]),__('Excel XML'));

        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }

        return parent::_prepareColumns();
    }

	
    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {

        $this->setMassactionIdField('id');
        //$this->getMassactionBlock()->setTemplate('WebTechnologyCodes_CustomerAttribute::customerattribute/grid/massaction_extended.phtml');
        $this->getMassactionBlock()->setFormFieldName('customerattribute');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('customerattribute/*/massDelete'),
                'confirm' => __('Are you sure?')
            ]
        );

        $statuses = $this->_status->getOptionArray();

        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('customerattribute/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses
                    ]
                ]
            ]
        );


        return $this;
    }
		

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('customerattribute/*/index', ['_current' => true]);
    }

    /**
     * @param \WebTechnologyCodes\CustomerAttribute\Model\customerattribute|\Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
		
        return $this->getUrl(
            'customerattribute/*/edit',
            ['id' => $row->getId()]
        );
		
    }

	
		static public function getOptionArray2()
		{
            $data_array=array(); 
			$data_array[0]='Yes';
			$data_array[1]='No';
            return($data_array);
		}
		static public function getValueArray2()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray2() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray3()
		{
            $data_array=array(); 
			$data_array[0]='Yes';
			$data_array[1]='No';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray4()
		{
            $data_array=array(); 
			$data_array[0]='Yes';
			$data_array[1]='No';
            return($data_array);
		}
		static public function getValueArray4()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray4() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array['text']='Text Field';
			$data_array['textarea']='Text Area';
			$data_array['multiline']='Multiple Line';
			$data_array['date']='Date';
			$data_array['select']='Dropdown';
			$data_array['multiselect']='Multiple Select';
			$data_array['boolean']='Yes/No';
			$data_array['file']='File (attachment)';
			$data_array['image']='Image File';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray6()
		{
            $data_array=array(); 
			$data_array['']='None';
			$data_array['alphanumeric']='Alphanumeric';
			$data_array['numeric']='Numeric Only';
			$data_array['alpha']='Alpha Only';
			$data_array['url']='URL';
			$data_array['email']='Email';
			return($data_array);
		}
		static public function getValueArray6()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray6() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray7()
		{
            $data_array=array(); 
			$data_array['']='None';
			$data_array['striptags']='Strip HTML Tags';
			$data_array['escapehtml']='Escape HTML Entities';
			return($data_array);
		}
		static public function getValueArray7()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray7() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray8()
		{
            $data_array=array(); 
			$data_array['customer_account_create']='Customer Registration';
			$data_array['customer_account_edit']='Customer Account Edit';
			$data_array['adminhtml_checkout']='Admin Checkout';
			return($data_array);
		}
		static public function getValueArray8()
		{
            $data_array=array();
			foreach(\WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Grid::getOptionArray8() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}
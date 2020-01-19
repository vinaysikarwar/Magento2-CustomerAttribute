<?php
namespace WebTechnologyCodes\CustomerAttribute\Block\Adminhtml\Customerattribute\Edit;

/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('customerattribute_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Customer Attribute Information'));
    }
	
	
	protected function _beforeToHtml()
    {
        $this->addTab(
            'labels',
            [
                'label' => __('Manage Labels'),
                'title' => __('Manage Labels'),
                'content' => $this->getChildHtml('labels')
            ]
        );
        return parent::_beforeToHtml();
    }
}
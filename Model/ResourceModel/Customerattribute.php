<?php
namespace WebTechnologyCodes\CustomerAttribute\Model\ResourceModel;

class Customerattribute extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('webtechnologycodes_customer_attributes', 'id');
    }
}
?>
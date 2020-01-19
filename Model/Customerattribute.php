<?php
namespace WebTechnologyCodes\CustomerAttribute\Model;

class Customerattribute extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WebTechnologyCodes\CustomerAttribute\Model\ResourceModel\Customerattribute');
    }
}
?>
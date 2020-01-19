<?php

namespace WebTechnologyCodes\CustomerAttribute\Model\ResourceModel\Customerattribute;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WebTechnologyCodes\CustomerAttribute\Model\Customerattribute', 'WebTechnologyCodes\CustomerAttribute\Model\ResourceModel\Customerattribute');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
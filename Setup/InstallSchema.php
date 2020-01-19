<?php

namespace WebTechnologyCodes\CustomerAttribute\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.0') < 0){

		$installer->run('create table webtechnologycodes_customer_attributes(id int not null auto_increment,attribute_code varchar(100),attribute_label varchar(100),
required varchar(10),system varchar(10),visibletocustomer varchar(10),sort_order varchar(10),primary key(id))');


		

		}

        $installer->endSetup();

    }
}
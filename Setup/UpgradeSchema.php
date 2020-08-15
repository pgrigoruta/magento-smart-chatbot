<?php

namespace Padaviva\Chatbot\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface {
    
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        
        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $installer->getConnection()->addColumn(
                $installer->getTable('padaviva_chatlog'),
                'type',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 1,
                    'nullable' => false,
                    'comment' => 'Type'
                ]
            );
        }
        
        $installer->endSetup();
    }
}
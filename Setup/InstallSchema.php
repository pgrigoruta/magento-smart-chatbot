<?php

namespace Padaviva\Chatbot\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface {
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('padaviva_chatlog')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('padaviva_chatlog')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Customer ID'
            )->addColumn(
                'session_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Session ID'
            )->addColumn(
                'message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Message'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At')
            ->setComment('Chat Log table');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('padaviva_chatlog'),
                $setup->getIdxName(
                    $installer->getTable('padaviva_chatlog'),
                    ['customer_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['customer_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            );

            $installer->getConnection()->addIndex(
                $installer->getTable('padaviva_chatlog'),
                $setup->getIdxName(
                    $installer->getTable('padaviva_chatlog'),
                    ['session_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['session_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            );

            $installer->endSetup();
        }
    }
}
<?php

namespace Xseed\LiveSalesPopup\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface {
    public function install( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
                           ->newTable( $installer->getTable( 'xseed_livesalespopup_data' ) )
                           ->addColumn(
                               'entity_id',
                               Table::TYPE_INTEGER,
                               null,
                               [ 'identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true ],
                               'Entity ID'
                           )
                           ->addColumn(
                               'order_number',
                               Table::TYPE_TEXT,
                               255,
                               [ 'nullable' => false ],
                               'Order Number'
                           )
                           ->addColumn(
                               'created_at',
                               Table::TYPE_TIMESTAMP,
                               null,
                               [ 'default' => Table::TIMESTAMP_INIT ],
                               'Created At'
                           )
                           ->setComment( 'Xseed Live Sales Popup Data' );

        $installer->getConnection()->createTable( $table );

        $installer->endSetup();
    }
}

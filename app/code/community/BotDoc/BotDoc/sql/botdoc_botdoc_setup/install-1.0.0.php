<?php
/**
 * BotDoc_BotDoc extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       BotDoc
 * @package        BotDoc_BotDoc
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * BotDoc module install script
 *
 * @category    BotDoc
 * @package     BotDoc_BotDoc
 * @author      BotDoc
 */
/*
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('botdoc_botdoc/documentrequest'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Document Request ID'
    )
    ->addColumn(
        'request_id',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Request Code'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Document Request Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Document Request Creation Time'
    ) 
    ->setComment('Document Request Table');
$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('botdoc_botdoc/documentrequest_store'))
    ->addColumn(
        'documentrequest_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'nullable'  => false,
            'primary'   => true,
        ),
        'Document Request ID'
    )
    ->addColumn(
        'store_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Store ID'
    )
    ->addIndex(
        $this->getIdxName(
            'botdoc_botdoc/documentrequest_store',
            array('store_id')
        ),
        array('store_id')
    )
    ->addForeignKey(
        $this->getFkName(
            'botdoc_botdoc/documentrequest_store',
            'documentrequest_id',
            'botdoc_botdoc/documentrequest',
            'entity_id'
        ),
        'documentrequest_id',
        $this->getTable('botdoc_botdoc/documentrequest'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $this->getFkName(
            'botdoc_botdoc/documentrequest_store',
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id',
        $this->getTable('core/store'),
        'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Document Requests To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();

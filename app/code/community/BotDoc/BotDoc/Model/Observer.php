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
 * BotDoc default helper
 *
 * @category    BotDoc
 * @package     BotDoc_BotDoc
 * @author      BotDoc
 */
class BotDoc_BotDoc_Model_Observer extends Mage_Core_Helper_Abstract {
	 /**
     * Include Button to send a new BotDoc Requst
     *
     * @access public
     * @param $event
     * @return void
     * @author BotDoc
     */
	public function adminhtmlWidgetContainerHtmlBefore($event) {
        $block = $event->getBlock();
        $helper = Mage::helper('botdoc_botdoc');
        if ($helper->getEnabled() && $block instanceof Mage_Adminhtml_Block_Sales_Order_View) {
            $orderId              = $block->getOrder()->getId();
			
			$block->addButton('send_botdoc_request', array(
                'label' => 'BotDoc Request Documents',
                'onclick' => 'openBotDocPopup(\'' . Mage::helper("adminhtml")->getUrl('botdoc/request/files/') . '\')',
            ), 0, 100, 'header', 'header');
        }
    }
}
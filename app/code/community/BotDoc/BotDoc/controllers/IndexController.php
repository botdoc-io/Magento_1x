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
 * BotDoc requst controller
 *
 * @category    BotDoc
 * @package     BotDoc_BotDoc
 * @author      BotDoc
 */
require_once(Mage::getBaseDir('lib')."/botdoc/autoload.php");


class BotDoc_BotDoc_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$this->callbackurlAction();
	}
	public function callbackurlAction()
	{
		Mage::log("Calling Callback");
		Mage::log($this->getRequest()->getParams());
		echo 'OK';
	}
}
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
	const FOLDER_TO_SAVE               = 'botdocfiles';


	protected function _construct()
    {
        $configuration = new BotDoc\Client\Configuration([
            'email'=>Mage::helper('botdoc_botdoc')->getEmail(),
            'apiKey'=>Mage::helper('botdoc_botdoc')->getApiKey(),
            'accessToken'=>Mage::helper('botdoc_botdoc')->getToken(),
            'isSandbox'=>Mage::helper('botdoc_botdoc')->getSandbox()
        ]);
    }

	public function indexAction()
	{
		$this->callbackurlAction();
	}
	public function callbackurlAction()
	{	
		$order_id = $this->getRequest()->getParam('order_id');
		$id = $this->getRequest()->getParam('id');

		if(!empty($id) && !empty($order_id)){
			if($this->getRequest()->getParam('complete') == true){
				$apiInstance = new BotDoc\Client\Api\RequestApi();
				$request = $apiInstance->requestRead($id);
				if(!empty($request->getMedia())){
					foreach ($request->getMedia() as $key => $media) {
						$path_to_save = Mage::getBaseDir('media') . DS . self::FOLDER_TO_SAVE . DS . $order_id;
						if (!file_exists($path_to_save)) {
						    mkdir($path_to_save, 0777, true);
						}
					    $link_to_view = Mage::getBaseUrl() . "media/" . self::FOLDER_TO_SAVE . "/" . $order_id . "/".$media->getName();
						$media->downloadAsync($path_to_save)->then(
					                function($reponse){
					                }
					            )
					            ->wait();
					    $order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
                	    $order
		                ->addStatusHistoryComment(
		                	"BotDoc Automated Message - File request complete " . 
		                	$request->getIdentifier() . 
		                	" Download at: <a href='$link_to_view' target='_NEW'> ".$media->getName()."</a>" )
		                ->setIsCustomerNotified(false)
		                ->save();
					}
				}	
			}
		}


	}
}
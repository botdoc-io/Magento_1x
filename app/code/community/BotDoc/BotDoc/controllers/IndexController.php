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
			$apiInstance = new BotDoc\Client\Api\RequestApi();
			$request = $apiInstance->requestRead($id);
			if(!empty($request->getMedia())){
				$message = "TESTE BotDoc Automated Message - File request complete Identifier:" . $request->getIdentifier() . "<br/>Files:";
				foreach ($request->getMedia() as $key => $media) {
					$path_to_save = Mage::getBaseDir('media') . DS . self::FOLDER_TO_SAVE . DS . $order_id;
					if (!file_exists($path_to_save)) {
					    mkdir($path_to_save, 0777, true);
					}
					$fileName = $media->getId().$media->getName();
					//Slugfying The FileName
					$fileName = trim(preg_replace('/[^A-Za-z0-9-.5]+/', '-', $fileName));
					if(is_file($path_to_save . DS . $fileName)) {
						//If this File got downloaded for some reason in the past... Remove it!
						unlink($path_to_save . DS . $fileName);
					}

					$link_to_view = Mage::getBaseUrl() . "media/" . self::FOLDER_TO_SAVE . "/" . $order_id . "/".$fileName;
					// TODO: Imporvement Make The Download Async with a Quee 
					$media->downloadAsync($path_to_save,$fileName)->then( 
						// $onFulfilled
					    function ($value) {
					    },
					    // $onRejected
					    function ($reason) {
					    	// TODO Try to Download Again a few more times
					    }
					)->wait(false); 
				    $message .= " <a href='" . $link_to_view . "' target='_BLANK'> ".$media->getName()."</a>,";

            	    
				}
				$message = trim($message,",");
				if($request->getReceiverMessage() ){
					$message .= "<br/>User Message:<br/>".$request->getReceiverMessage();		
				}

				$order = Mage::getModel('sales/order')->loadByIncrementId($order_id);
				$order
	                ->addStatusHistoryComment($message)
	                ->setIsCustomerNotified(false)
	                ->save();
			}
		}


	}
}
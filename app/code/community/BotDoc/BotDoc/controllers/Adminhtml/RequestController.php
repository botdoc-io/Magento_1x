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


class BotDoc_BotDoc_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{

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
        $this->loadLayout();
        $this->_title($this->__("BoDoc"));
        $this->renderLayout();
    }
    
    public function filesAction($orderId = null)
    {

        $this->loadLayout();
        $this->_title($this->__("BoDoc"));
        $this->renderLayout();
        #Zend_Debug::dump($this->getLayout()->getUpdate()->getHandles()); 
    }

    /**
     * Submit Request, get post data, connect with botdoc and submit the request
     * Save the message on the Order History
     * Redirect to the order page
     * @return void
     */
    public function submitAction($oderId = null){
        $postParams = $this->getRequest()->getParam('request');
        $helper = Mage::helper('botdoc_botdoc');
        if(!empty($postParams) && !empty($postParams['order_id']) && !empty($postParams['comment'])){
           // In Case of success add the message to the order history (dont send email to the client because he will receive anyways)
            $order = Mage::getModel('sales/order')->load($postParams['order_id']);
            //$countryCode = $order->getBillingAddress()->getCountryModel()->getCode();

            $message = $helper->__('BotDoc Request sent to %s and %s',$postParams['email'],$postParams['phone']);
            if(empty($postParams['enable_email'])){
                unset($postParams['email']);
                $message = $helper->__('BotDoc Request sent to phone: %s',$postParams['phone']);
            }

            if(empty($postParams['enable_phone'])){
                unset($postParams['phone']);
                $message = $helper->__('BotDoc Request sent to email: %s',$postParams['email']);
            }
            if(empty($postParams['phone']) && empty($postParams['email'])){
                Mage::getSingleton('core/session')->addError($helper->__('Please fill or select an email or phone number'));
                return $this->_redirectReferer();
            }
           
            // Creating the Contact Methods based on the user choise
            if($postParams['email']){
                $emailMethod = new BotDoc\Client\Model\ContactMethod([
                    'interface_class' =>'email',
                    'value'=>$postParams['email']
                ]);    
            }
            if($postParams['phone']){
                $smsMethod = new BotDoc\Client\Model\ContactMethod([
                    'interface_class' =>'sms',
                    'value'=>$postParams['phone']
                ]);    
            }
            $contactMethods = array();
            if($smsMethod){
                $contactMethods[] = $smsMethod;    
            }
            if($emailMethod){
                $contactMethods[] = $emailMethod;    
            }
            // Creating Contact
            $botdocContact = new BotDoc\Client\Model\Contact([
                'first_name'=>$order->getBillingAddress()->getFirstname(),
                'last_name'=>$order->getBillingAddress()->getLastName(),
                'contact_method'=> $contactMethods,
            ]);
            $botdocRequest = new BotDoc\Client\Model\Request([
                'long_message_subject' => $postParams['subject'],
                'message'=>$message." - ".$postParams['comment'],
                'requestor_privatenotes'=>'Message sent from Magento Store, Order #'.$order->getIncrementId(),
                'is_sending'=>false,
                'short_message'=>$postParams['comment'],
                'long_message'=>$postParams['comment'],
                'contact'=>array($botdocContact),
                'callback_url'=>$helper->getCallBackUrl($order->getStoreId())."?&order_id=".$order->getIncrementId(),
            ]); // \BotDoc\Client\Model\Request |
            $apiInstance = new BotDoc\Client\Api\RequestApi();
            try {
                // Sending Request
                $botdocRequest = $apiInstance->requestCreate($botdocRequest);
                $response = $botdocRequest->sendNotification();
                // Saving on messages

                $order = Mage::getModel('sales/order')->load($postParams['order_id']);
                $order
                ->addStatusHistoryComment($message.' | <br/> '.$postParams['comment'],false)
                ->setIsCustomerNotified(false)
                ->save();
                Mage::getSingleton('core/session')->addSuccess($helper->__('Request sent with success'));
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError('Exception when calling RequestApi->requestCreate: '. $e->getMessage());   
            }
        }else{
            Mage::getSingleton('core/session')->addError($helper->__('Please send a message to your customer')); 
        }
        //print_r($postParams);
        //die();
        $this->_redirectReferer();
    }

   
}
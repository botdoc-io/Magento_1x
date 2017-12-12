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
class BotDoc_BotDoc_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{
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
            $order = Mage::getModel('sales/order')->load($lastOrderId);
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
            // Add the comment and save the order (last parameter will determine if comment will be sent to customer)
            try {
                $order = Mage::getModel('sales/order')->load($postParams['order_id']);
                $order
                ->addStatusHistoryComment($message.' | <br/> '.$postParams['comment'],false)
                ->setIsCustomerNotified(false)
                ->save();
                Mage::getSingleton('core/session')->addSuccess($helper->__('Request sent with success'));         
            } catch (Exception $e) {
                Mage::getSingleton('core/session')->addError($e->getMessage());        
            }

            
        }else{
            Mage::getSingleton('core/session')->addError($helper->__('Please send a message to your customer')); 
        }
        //print_r($postParams);
        //die();
        $this->_redirectReferer();
    }

   
}
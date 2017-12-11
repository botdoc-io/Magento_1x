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


    protected function _prepareForm() {
 
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save'),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
                )
        );
 
        $base_fieldset = $form->addFieldset(
                'base', array(
            'legend' => Mage::helper('botdoc_botdoc')->__('Test data'),
                )
        );
 
 
        $base_fieldset->addField(
                'authorize_btn', 'button', array(
                'name' => 'authorize_btn',
                'label' => Mage::helper('botdoc_botdoc')->__(
                        'Click on folowing link to test popup Dialog:'
                ),
                'value' => $this->helper('botdoc_botdoc')->__('Test popup dialog >>'),
                'class' => 'form-button',
                'onclick' => 'javascript:openMyPopup()'
            )
        );
 
        $form->setUseContainer(true);
        $this->setForm($form);
 
        parent::_prepareForm();
    }
}
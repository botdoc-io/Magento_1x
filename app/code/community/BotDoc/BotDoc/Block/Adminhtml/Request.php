<?php  

class BotDoc_BotDoc_Block_Adminhtml_Request extends Mage_Adminhtml_Block_Template {
	/**
     * Entity for BotDoc Request
     *
     * @var Mage_Eav_Model_Entity_Abstract
     */
    protected $_entity;

	/**
     * Retrieve order model instance
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('current_order');
    }

    protected function _beforeToHtml()
    {
        if ($this->getParentBlock() && ($order = $this->getOrder())) {
            $this->setEntity($order);
        }
        parent::_beforeToHtml();
    }
    /**
     * Set entity for form
     *
     * @param Varien_Object $entity
     * @return Mage_Adminhtml_Block_Sales_Order_View_Giftmessage
     */
    public function setEntity(Varien_Object $entity)
    {
        $this->_entity  = $entity;
        return $this;
    }
     /**
     * Retrive entity for form
     *
     * @return Varien_Object
     */
    public function getEntity()
    {
        if(is_null($this->_entity)) {
            $this->setEntity(Mage::getModel('giftmessage/message')->getEntityModelByType('order'));
            $this->getEntity()->load($this->getRequest()->getParam('entity'));
        }
        return $this->_entity;
    }
    /**
     * Prepares layout of block
     *
     * @return Mage_Adminhtml_Block_Sales_Order_View_Giftmessage
     */
    protected function _prepareLayout()
    {
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   => Mage::helper('giftmessage')->__('Send Request'),
                    'class'   => 'save',
                    'type'	  => 'submit'
                ))
        );

        return $this;
    }

    /**
     * Retrive save button html
     *
     * @return string
     */
    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }
    public function getSaveUrl()
    {
        return $this->getUrl('adminhtml/request/send_request',
            array(
                'entity'=>$this->getEntity()->getId(),
                'type'  =>'order',
                'reload' => 1
            )
        );
    }
    /**
     * Retrive field html id prefix
     *
     * @return string
     */
    public function botdoc()
    {
        return 'giftmessage_order_' . $this->getEntity()->getId() . '_';
    }
    /**
     * Retrive block html id
     *
     * @return string
     */
    public function getHtmlId()
    {
        return substr($this->getFieldIdPrefix(), 0, -1);
    }
    /**
     * Retrive real html id for field
     *
     * @param string $name
     * @return string
     */
    public function getFieldId($id)
    {
        return $this->getFieldIdPrefix() . $id;
    }
    /**
     * Indicates that block can display giftmessages form
     *
     * @return boolean
     */
    public function canDisplayBotDoc()
    {
        return $this->helper('botdoc_botdoc')->getEnabled();
    }
    /**
     * Get the Default Message for the account or use ours
     *
     * @return boolean
     */
    public function getDefaultMessage()
    {
    	return Mage::helper('botdoc_botdoc')->getDefaultMessage();
    }
    /**
     * Get customer email
     *
     * @return boolean
     */
    public function getEmail()
    {
    	return $this->getOrder()->getCustomerEmail();
    }

    /**
     * Get customer Phone number
     *
     * @return boolean
     */
    public function getPhoneNumber()
    {
    	return  $this->getOrder()->getShippingAddress()->getTelephone();
    }
}

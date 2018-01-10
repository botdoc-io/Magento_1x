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
        return $this->getUrl('adminhtml/request/submit',
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
    private function changeMessageText($message = null){
    	$params = array(
    		'{{customer.name}}' 		=> $this->getCustomerName(),
    		'{{customer.email}}' 		=> $this->getCustomerEmail(),
    		'{{customer.phone}}' 		=> $this->getCustomerPhoneNumber(),
    		'{{store.name}}' 			=> $this->getStoreName(),
    		'{{store.phone}}' 			=> $this->getStorePhone(),
    		'{{order.number}}' 			=> $this->getOrderNumber(),
    	);
    	foreach ($params as $key => $value) {
    		$message = str_replace($key, $value, $message);
    	}
    	return $message;
    }

    /**
     * Get the Default Message for the account or use ours
     *
     * @return boolean
     */
    public function getDefaultMessage()
    {
    	/*
    	{{customer.name}}
    	{{customer.email}}
    	{{store.name}}
    	{{store.phone}}
    	{{order.number}}
		*/
    	return $this->changeMessageText(Mage::helper('botdoc_botdoc')->getDefaultMessage());
    }
    /**
     * Get the Default Message for the account or use ours
     *
     * @return boolean
     */
    public function getDefaultSubject()
    {
        /*
        {{customer.name}}
        {{customer.email}}
        {{store.name}}
        {{store.phone}}
        {{order.number}}
        */
        return $this->changeMessageText(Mage::helper('botdoc_botdoc')->getDefaultSubject());
    }

    /**
     * Get The order Number
     *
     * @return string
     */
    public function getOrderNumber(){
    	return $this->getOrder()->getIncrementId();
    }
    /**
     * Get Order Id
     *
     * @return string
     */
    public function getOrderId(){
    	return $this->getOrder()->getId();
    }
    /**
     * Get customer name
     *
     * @return string
     */
    public function getCustomerName()
    {
    	return $this->getOrder()->getCustomerName();
    }
    /**
     * Get customer email
     *
     * @return string
     */
    public function getCustomerEmail()
    {
    	return $this->getOrder()->getCustomerEmail();
    }

    /**
     * Get customer Phone number
     *
     * @return string
     */
    public function getCustomerPhoneNumber()
    {
    	return  $this->getOrder()->getShippingAddress()->getTelephone();
    }

    /**
     * Get Store Name
     *
     * @return string
     */
    public function getStoreName()
    {
    	return Mage::getStoreConfig('general/store_information/name');
    }

    /**
     * Get Store Phone
     *
     * @return string
     */
    public function getStorePhone()
    {
		return Mage::getStoreConfig('general/store_information/phone');
	}
}
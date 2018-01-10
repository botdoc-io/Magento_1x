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
class BotDoc_BotDoc_Helper_Data extends Mage_Core_Helper_Abstract {
    const SETTINGS_BOTDOC_ENABLED               = 'botdoc/settings/enabled';
    const SETTINGS_BOTDOC_SANDBOX               = 'botdoc/settings/sandbox';
    const SETTINGS_BOTDOC_EMAIL                 = 'botdoc/settings/email';
    const SETTINGS_BOTDOC_API_KEY               = 'botdoc/settings/api_key';
    const SETTINGS_BOTDOC_TOKEN                 = 'botdoc/settings/token';
    const SETTINGS_BOTDOC_DEFAULT_SUBJECT       = 'botdoc/settings/default_subject';
    const SETTINGS_BOTDOC_DEFAULT_MESSAGE       = 'botdoc/settings/default_message';
    const CALL_BACK_URL                         = 'botdoc/index/callbackurl';
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author BotDoc
     */
    public function convertOptions($options) {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
    /**
     * get call Back Url
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getCallBackUrl($store_id) {
        if($store_id){
            return Mage::app()->getStore($storeId)->getBaseUrl().self::CALL_BACK_URL;
        }else{
            return Mage::getBaseUrl().self::CALL_BACK_URL;
        }
    }

    /**
     * get if the module is enabled
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getEnabled() {
        return Mage::getStoreConfigFlag(self::SETTINGS_BOTDOC_ENABLED);
    }
    /**
     * get Sandbox
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getSandbox() {
        return Mage::getStoreConfigFlag(self::SETTINGS_BOTDOC_SANDBOX);
    }
    /**
     * get the default message set buy the user
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getDefaultMessage() {
        $default_message = $this->__('Hi {{customer.name}}, we from {{store.name}} need a picture of your id to verify your order #{{order.number}}!');
        if(empty(Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_MESSAGE))){
            return $default_message;
        }else{
            return Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_MESSAGE);
        }
    }
    /**
     * get the default subject set buy the user
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getDefaultSubject() {
        $default_message = $this->__('{{store.name}} need a documents regarding #{{order.number}}');
        if(empty(Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_SUBJECT))){
            return $default_message;
        }else{
            return Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_SUBJECT);
        }
    }


    /**
     * get Botdoc account username/email
     *
     * @access public
     * @return string
     * @author BotDoc
     */
    public function getEmail() {
        return Mage::getStoreConfig(self::SETTINGS_BOTDOC_EMAIL);
    }

    /**
     * get Botdoc account API KEY
     *
     * @access public
     * @return string
     * @author BotDoc
     */
    public function getApiKey() {
        return Mage::getStoreConfig(self::SETTINGS_BOTDOC_API_KEY);
    }

    /**
     * get Botdoc Token
     *
     * @access public
     * @return string
     * @author BotDoc
     */
    public function getToken() {
        return Mage::getStoreConfig(self::SETTINGS_BOTDOC_TOKEN);
    }
    /**
     * set Botdoc Token
     *
     * @access public
     * @param $token
     * @return string
     * @author BotDoc
     */
    public function setToken($token = null) {
        return Mage::setStoreConfig(self::SETTINGS_BOTDOC_TOKEN,$token);
    }
}

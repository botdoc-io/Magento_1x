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
    const SETTINGS_BOTDOC_EMAIL                 = 'botdoc/settings/email';
    const SETTINGS_BOTDOC_API_KEY               = 'botdoc/settings/api_key';
    const SETTINGS_BOTDOC_TOKEN                 = 'botdoc/settings/token';
    const SETTINGS_BOTDOC_DEFAULT_MESSAGE       = 'botdoc/settings/default_message';
    
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
     * get the default message set buy the user
     *
     * @access public
     * @return boolean
     * @author BotDoc
     */
    public function getDefaultMessage() {
        $default_message = $this->__('Please, we need a picture of your id to verify your purchase!');
        if(empty(Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_MESSAGE))){
            return $default_message;
        }else{
            return Mage::getStoreConfig(self::SETTINGS_BOTDOC_DEFAULT_MESSAGE);
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

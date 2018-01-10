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
require_once(Mage::getBaseDir('lib')."/botdoc/autoload.php");

class BotDoc_BotDoc_Helper_Api extends Mage_Core_Helper_Abstract {
	private $dataHelper;

	/**
     * Refresh Token
     *
     * @param string $token 
     *
     * @return $this
     */
	public function getToken(){
		// First Get Token saved
		//Mage::helper('botdoc_botdoc')::SETTINGS_BOTDOC_ENABLED
		//Mage::helper('botdoc_botdoc')::SETTINGS_BOTDOC_EMAIL
		//Mage::helper('botdoc_botdoc')::SETTINGS_BOTDOC_API_KEY
		//Mage::helper('botdoc_botdoc')::SETTINGS_BOTDOC_TOKEN


		BotDoc\Client\Configuration(
			Mage::helper('botdoc_botdoc')->getEmail(),
			Mage::helper('botdoc_botdoc')->getApiKey(),
			Mage::helper('botdoc_botdoc')->getToken(),
		);

		$apiInstance = new BotDoc\Client\Api\RequestApi();
		try {
		    $apiInstance->requestList(1, 20);
		} catch (Exception $e) {
		    echo 'Exception when calling RequestApi->requestList: ', $e->getMessage(), PHP_EOL;
		}

		/*
		$token = new BotDoc\Client\Token();
		if(!empty(Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_TOKEN)){
			$token->setToken($Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_TOKEN);
			if($token->isExpired()){
				$token->refresh();
			}
		}else{
			// Token is Invalid we need to generate a new on
			$authApi = new BotDoc\Client\Api\AuthApi();

			Mage::log("Email: ".Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_EMAIL);
			Mage::log("API_KEY: ".Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_API_KEY);

			$token_auth = new \BotDoc\Client\Model\getToken(array(
					'email'=>Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_EMAIL, 
					'api_key'=>Mage::helper('botdoc_botdoc')->SETTINGS_BOTDOC_API_KEY
				)
			);

			
			Mage::log("Gettin Email ".$token_auth->getEmail());
			Mage::log("Gettin Email ". $token_auth->getAuthApi());

			try {
			    $token = $authApi->authGetTokenCreate($token_auth);
			} catch (Exception $e) {
			    echo 'Exception when calling AuthApi->authGetTokenCreate: ', $e->getMessage(), PHP_EOL;
			}

		}
		
		return $token;

	}
}
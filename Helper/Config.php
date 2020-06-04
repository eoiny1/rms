<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Framework\UrlInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Encryption\EncryptorInterface;

use Magento\Framework\App\Helper\AbstractHelper;



/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class Config extends AbstractHelper
{
  
  
  const SECRET_KEY = "rms/api_settings/secret_key";
  const ACCESS_IDENTIFIER = "rms/api_settings/access_identifier";
  const DATABASE = "rms/api_settings/database_name";
  const DATABASE_SERVER = "rms/api_settings/database_server";
  const DATABASE_LOGIN_NAME = "rms/api_settings/database_login_name";
  const DATABASE_LOGIN_PASSWORD = "rms/api_settings/database_login_password";
  const RMS_TYPE = "rms/api_settings/rms_type";
  const INSATNCE_NAME = "rms/api_settings/instance_name";
  const API_ENDPOINT = "rms/api_settings/api_endpoint";
  const POST_URL = "rms/api_settings/post_url";
  const PEEK_URL = "rms/api_settings/peek_url";
  
  const FTP_SERVER = "rms/ftp_settings/ftp_server";
  const FTP_USERNAME = "rms/ftp_settings/ftp_user_name";
  const FTP_PWD = "rms/ftp_settings/ftp_pwd";
  const FTP_STORE_CODE = "rms/ftp_settings/store_code";
 
  
  const LAST_ORDER_LIMIT = "rms/download_settings/last_order_limit";
  
  
  
    /**
    **/
    protected $serializer;
  
      
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * Module manager
     *
     * @var ModuleManager
     */
    protected $moduleManager;
    
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
  
  
    /**
    *
    */
    protected $encryptor;
  
  
   /**
     * @param ScopeConfigInterface $scopeConfig
     * @param ModuleManager $moduleManager
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ModuleManager $moduleManager,
        UrlInterface $urlBuilder,
        SerializerInterface $serializer,
        EncryptorInterface $encryptor,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->moduleManager = $moduleManager;
        $this->urlBuilder = $urlBuilder;
        $this->serializer = $serializer;
        $this->encryptor = $encryptor;
      
        
        parent::__construct($context);
    }


   /**
    *
    */
    public function getSecretKey($storeId = null) {
      
       return $this->encryptor->decrypt($this->scopeConfig->getValue(
            self::SECRET_KEY,
            ScopeInterface::SCOPE_STORE,
            $storeId
         ));

    }
  
  
    /**
    *
    */
    public function getAccessIdentifier($storeId = null) {
      
       return $this->encryptor->decrypt($this->scopeConfig->getValue(
            self::ACCESS_IDENTIFIER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));

    }
  
    /**
    *
    */
    public function getDatabaseName($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::DATABASE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
      /**
    *
    */
    public function getDatabaseServer($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::DATABASE_SERVER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
      /**
    *
    */
    public function getDatabaseLoginName($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::DATABASE_LOGIN_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
    /**
    *
    */
    public function getDatabaseLoginPassword($storeId = null) {
      
       return $this->encryptor->decrypt($this->scopeConfig->getValue(
            self::DATABASE_LOGIN_PASSWORD,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));

    }
  
      /**
    *
    */
    public function getRmsType($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::RMS_TYPE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
      /**
    *
    */
    public function getInstanceName($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::INSATNCE_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
    /**
    *
    */
    public function getApiEndpoint($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::API_ENDPOINT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
    /**
    *
    */
    public function getPostUrl($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::POST_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
    
  /**
    *
    */
    public function getPeekUrl($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::PEEK_URL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
  
    /**
    *
    */
    public function getFtpServer($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::FTP_SERVER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
    /**
    *
    */
    public function getFtpUserName($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::FTP_USERNAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }
  
  
    /**
    *
    */
    public function getFtpPwd($storeId = null) {
      
      
       return $this->encryptor->decrypt($this->scopeConfig->getValue(
            self::FTP_PWD,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));
      
      

    }
  
    /*
      public function getAccessIdentifier($storeId = null) {
      
       return $this->encryptor->decrypt($this->scopeConfig->getValue(
            self::ACCESS_IDENTIFIER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        ));

    }*/
  
  
    /**
    *
    */
    public function getFtpStoreCode($storeId = null) {
      
       return $this->scopeConfig->getValue(
            self::FTP_STORE_CODE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

    }


  
  

  
  
  
  
  
  
  
  /**
  *
  **/
  public function getLastOrderLimit($storeId = null) {
    
       return $this->scopeConfig->getValue(
            self::LAST_ORDER_LIMIT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
   
  }
    
  
  
  
  
  


}


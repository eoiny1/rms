<?php


namespace Neon\Rms\Model;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class ApiRequest extends \Magento\Framework\Model\AbstractModel {
  
  
    /**
    *
    */
    protected $config;
  
    
    /**
    *
    */
   protected $postData;
    
  
    /**
    *
    */
    protected $_request;
  
  
  

     /**
     * @param \Neon\Rms\Helper\Config $config
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    protected function __construct(
      \Neon\Rms\Helper\Config $config,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
      
        $this->config = $config;
       
        parent::__construct($context, $registry);

    }
  
  
  /**
  *
  */
  
  public function setPostData() {
   
   $this->_postData  =  array(
      "database_name" => $this->config->getDatabaseName(),
      "rms_type" => $this->config->getRmsType(),
      "request" => $this->_request,
      "database_login_password"=> $this->config->getDatabaseLoginPassword(),
      "api_endpoint" =>  $this->config->getApiEndpoint(),
      "instance_name" => $this->config->getInstanceName(),
      "database_server" => $this->config->getDatabaseServer(),
      "database_login_name" => $this->config->getDatabaseName()
    );
 
 }
  
  
 /**
 *
 */ 
  public function getPostData() {
    
    return $this->_postData;
  }
  
  
  
 /**
 *
 */
 public function getPayload() {
   
   return json_encode($this->getPostData());
   
 }
  

public function getPostUrl() {
  
  return $this->config->getPostUrl();
  
}
  
  
  
 /**
 *
 **/ 
 public function getHeader() {
   
  $payload =  $this->getPayload();
  $access_identifier = $this->config->getAccessIdentifier();
  $secret_key = $this->config->getSecretKey();
   
  $x_payload_signature = md5($secret_key.$access_identifier.$payload); 
   
  return array("User-Agent: runscope/0.1","X-Access-Identifier: $access_identifier","X-Payload-Signature: $x_payload_signature");
   
 }  
  
  
  
  
  
  
}




?>
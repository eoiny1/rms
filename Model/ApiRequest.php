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
    protected $curlRequest;
  
    
    /**
    *
    */
   protected $postData;
    
  
    /**
    *
    */
    protected $_request;
  
  
  
    /**
    *
    */
    protected $_millis = 24576;
    
  
  

     /**
     * @param \Neon\Rms\Helper\Config $config
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Neon\Rms\Helper\Config $config,
      \Neon\Rms\Helper\Curl $curl, 
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
      
        $this->config = $config;
        $this->curlRequest = $curl;
       
        parent::__construct($context, $registry);

    }
  
  
  /**
  *
  */
  
  public function setPostData($extra_payload_array = array()) {
   
    $deafult_payload =  array(
      "database_name" => $this->config->getDatabaseName(),
      "rms_type" => $this->config->getRmsType(),
      "request" => $this->_request,
      "database_login_password"=> $this->config->getDatabaseLoginPassword(),
      "api_endpoint" =>  $this->config->getApiEndpoint(),
      "instance_name" => $this->config->getInstanceName(),
      "database_server" => $this->config->getDatabaseServer(),
      "database_login_name" => $this->config->getDatabaseLoginName()
    );
    
    
    $this->_postData = array_merge($deafult_payload,$extra_payload_array);
 
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
 public function getHeader($payload) {
   
  $access_identifier = $this->config->getAccessIdentifier();
  $secret_key = $this->config->getSecretKey();
   
  $x_payload_signature = md5($secret_key.$access_identifier.$payload); 
   
  return array("User-Agent: runscope/0.1","X-Access-Identifier: $access_identifier","X-Payload-Signature: $x_payload_signature");
   
 } 
  
  
/**
*
**/  
public function sendRequest($config = array()) {
  
  $postUrl = (isset($config["post_url"]))?$config["post_url"]:$this->getPostUrl();
  $payload = (isset($config["payload"]))?$config["payload"]:$this->getPayload();
    
  $reponse = $this->curlRequest->curlAction($postUrl,$payload,$this->getHeader($payload));
  
  return $reponse;
  
} 
  
  

/**
*
**/
public function getInteraction($postResponse) {
  
      if(array_key_exists("interaction",$postResponse))
          return $postResponse["interaction"];
  
} 
  

 /**
 *
 **/
 protected function getPeekPayLoad($interaction) {
  
  $postData = array(
	  "interaction" =>$interaction,
	  "timeout_millis" => $this->getMillis()
  );
  
  $payload = json_encode($postData); 
  
  return $payload;
  
}  
  
  
/**
*
*/ 
protected function getMillis() {
  
  return $this->_millis;
  
}  
  
  
  
/**
*
*/ 
protected function setMillis($millis) {
  
  $this->_millis = $millis;
  
}  
  
  
  
  
  
  
  
}




?>
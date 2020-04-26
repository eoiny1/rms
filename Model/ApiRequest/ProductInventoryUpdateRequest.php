<?php

namespace Neon\Rms\Model\ApiRequest;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class ProductInventoryUpdateRequest extends \Neon\Rms\Model\ApiRequest {
  
  
  
    protected $_request = "ProductInventoryUpdate";
  
    protected $_success = 0;
  
    protected $_message = "";
  
    protected $_interaction = "";
  

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
        parent::__construct($config,$curl,$context,$registry);

        $this->setPostData();

    }
  
  
  /**
  *
  */
  public function addExtraPayload($extra_payload_array) {
    
     printf("extra_payload_array:%s \n",print_r($extra_payload_array,1));
    
     $this->setPostData($extra_payload_array);
    
  }
  
  
    
    /**
    *
    */
    public function call() {
      
      
      $response = $this->sendRequest();
      $interaction = $this->getInteraction($response);
      
      if($interaction) {
      
       $finalResponse =  $this->getResponse($interaction);
       $this->setSuccessAndMessage($finalResponse);
      
      }
      
      return $this;
      
      
    }
  
  
   /**
   *
   */
    protected function getResponse($interaction) {
      
       $this->setRmsTicket($interaction);
      
       printf("interaction:%s \n\n",$interaction);
      
        //TAKE SMALL BREAK 
        #$sleeptime = 60 * 4;
      
        $sleeptime = 20;
      
        sleep($sleeptime);
   
        
       $peekyPayload = $this->getPeekPayLoad($interaction);
       
        printf("payload:%s \n",print_r($peekyPayload,1));
       
       $response = $this->sendRequest(array("post_url"=>$this->config->getPeekUrl(),"payload"=>$peekyPayload));
       
       printf("reposnse:%s \n",print_r($response,1));
      
      
        return $response;

    }
  
  
    /**
    *
    */
   protected function setSuccessAndMessage($response) {
     
     if(array_key_exists("response_message_unavailable",$response)) {
       
       if($response["response_message_unavailable"] == 1) {
         $this->setSuccess($response["success"]);
       }
       
       
     } else {
       
      if(array_key_exists("message",$response)) {
      if($response["message"]["payload"]["success"] == 1) {
				$this->setSuccess(1);
      }else{
        if(isset($response["message"]["payload"]["exception_reason"])) {
          $this->setMessage($response["message"]["payload"]["exception_reason"]);
        }
			}
     }
       
    }
     
   }
  
  
  /**
  *
  */
  protected function setSuccess($success) {
    
    $this->_success = $success;
        
  }
  
  /**
  *
  */
  public function getSuccess() {
    
    return $this->_success;
    
  }
  
   
  /**
  *
  */
  protected function setMessage($message) {
    
    $this->_message = $message;
        
  }
  
  /**
  *
  */
  public function getMessage() {
    
    return $this->_message;
    
  }
  
  
  /**
  *
  */
  protected function setRmsTicket($interaction) {
    
    $this->_interaction = $interaction;
    
  }
  
  
  /**
  *
  */
  public function getRmsTicket() {
    
    return $this->_interaction;
    
  }
  
  
  
  
  
  
}




?>
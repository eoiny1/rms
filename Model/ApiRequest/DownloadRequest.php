<?php

namespace Neon\Rms\Model\ApiRequest;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class DownloadRequest extends \Neon\Rms\Model\ApiRequest {
  

  
  
   protected $_request = "ProductMetadataFetch";

  
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
    public function call() {
      
      $response = $this->sendRequest();
      $interaction = $this->getInteraction($response);
      
      $finalResponse =  $this->loopToGetDownloadResponse($interaction);
      
      
    }
  
  
    /**
    *
    */
    protected function loopToGetDownloadResponse($interaction) {
      
      printf("interaction:%s \n\n",$interaction);
      
      //TAKE SMALL BREAK 
      $sleeptime = 60 * 4;
      
      sleep($sleeptime);
    
     for($x = 0; $x <= 5; $x++) {
       
      
        
       $peekyPayload = $this->getPeekPayLoad($interaction);
       
        printf("payload:%s \n",print_r($peekyPayload,1));
       
       $response = $this->sendRequest(array("post_url"=>$this->config->getPeekUrl(),"payload"=>$peekyPayload));
       
       printf("reposnse:%s \n",print_r($response,1));
      
       if(isset($response["asset_url"]))
          return $response["asset_url"];
      
        sleep(30);
      }
      
      
    }
  
  
  
  
  
  
  
  
}




?>
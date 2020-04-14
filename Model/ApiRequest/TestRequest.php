<?php

namespace Neon\Rms\Model\ApiRequest;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class TestRequest extends \Neon\Rms\Model\ApiRequest {
  

  
  
   protected $_request = "ping";

  
     /**
     * @param \Neon\Rms\Helper\Config $config 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Neon\Rms\Helper\Config $config,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
        parent::__construct($config,$context, $registry);
      
       $this->setPostData();

    }
  
  
  
  
}




?>
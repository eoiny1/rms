<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class Curl extends AbstractHelper
{
  

  

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
      
        parent::__construct($context);
    }
  
  
  /**
  *
  */
  public function curlAction($url,$payload,$headers) {
	
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_POST,true);
    curl_setopt($curl, CURLOPT_POSTFIELDS,$payload);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);

    #curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    #curl_setopt($curl, CURLOPT_TIMEOUT, 1000);

    $output = curl_exec($curl);

    if ($output === FALSE) {

      return  'An error has occurred: ' . curl_error($curl) . PHP_EOL;

    }
    else {

      return json_decode($output,true);

    }
	
}
  
  
 
  
  

  
  
}


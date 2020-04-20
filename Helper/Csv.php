<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;




/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class Csv extends AbstractHelper
{
  
    protected $csvProcessor;
	  protected $directoryList;

  

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Helper\Context $context,
       \Magento\Framework\Registry $registry,
       \Magento\Framework\File\Csv $csvProcessor,
       \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
      
        parent::__construct($context);
    
        $this->csvProcessor = $csvProcessor;
    	  $this->directoryList = $directoryList;
      
    }
  
  
  
  
  
    /**
    *
    */
    public function writeToCsv($csvArray,$filePath){ 
      
        $this->csvProcessor
        ->setEnclosure('"')
        ->setDelimiter(',')
        ->saveData($filePath,$csvArray);
   
   }
  
  
  
  
 

  
  
 
  
  

  
  
}


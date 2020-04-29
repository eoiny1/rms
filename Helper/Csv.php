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

    protected $_file_helper;
  
    protected $_csv_dir;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
       \Magento\Framework\App\Helper\Context $context,
       \Magento\Framework\Registry $registry,
       \Magento\Framework\File\Csv $csvProcessor,
       \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
       \Neon\Rms\Helper\File $file
    ) {
      
        parent::__construct($context);
    
        $this->csvProcessor = $csvProcessor;
    	  $this->directoryList = $directoryList;
      
        $this->_file_helper = $file;
      
        $this->setCsvDir($this->_file_helper->getCsvBaseDir());
      
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
  
  
  
  
  /**
  *
  */
  public function writeToCsvWithName($csvArray,$name) {
    
    $header = array_keys($csvArray[0]); 
    array_unshift($csvArray, $header);
    
    
    $date = date('mdY_His');
    $new_file_path = $this->getCsvDir().$name.$date.".csv";
     
    $this->csvProcessor
        ->setEnclosure('"')
        ->setDelimiter(',')
        ->saveData($new_file_path,$csvArray);
    
  }
    
   
 

  
  
  public function  getCsvDir() {
    
    return $this->_csv_dir;
  }
  
 
  
   public function  setCsvDir($dir) {
    
     $this->_csv_dir = $dir;
  }
  
  

  
  
}


<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;




/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class File extends AbstractHelper
{
  
    const UPLOAD_DIR = "rms";
    const UPLOAD_ARCHIVE_DIR = "archive";

    protected $_csvBaseDir;
  
    protected $_csvArchive;
  
    protected $_directoryList;

  

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
      \Magento\Framework\Filesystem\DirectoryList $directory_list,
        \Magento\Framework\App\Helper\Context $context
    ) {
      
        parent::__construct($context);
    
        $this->_directoryList = $directory_list;
      
        $this->setCsvBaseDir();
      
      
        $this->setCsvArchiveDir();
      
    }
  
  
  
  /**
	* GET CSV FOLDER
	*/
	protected function setCsvBaseDir() {
		$base_path = $this->_directoryList->getPath('var');
    $path = "/export/".self::UPLOAD_DIR."/";
    
    $full_path = $base_path.$path;
    
    $this->createdFolder($full_path);
    
		$this->_csvBaseDir = $full_path;
    
	}
  
  /**
  *
  */
  public function getCsvBaseDir() {
    
    return $this->_csvBaseDir;
    
  }
  
  
    /**
	* GET CSV FOLDER
	*/
	protected function setCsvArchiveDir() {
		$base_path = $this->_directoryList->getPath('var');
    $path = "/export/".self::UPLOAD_DIR."/".self::UPLOAD_ARCHIVE_DIR."/";
    
    $full_path = $base_path.$path;
    
    $this->createdFolder($full_path);
    
		$this->_csvArchive = $full_path;
    
	}
  
  /**
  *
  */
  public function getCsvArchiveDir() {
    
    return $this->_csvArchive;
    
  }
  

  
  
  
  /**
  * Create Folder
  */
  protected function createdFolder($dst) {
    if(!file_exists($dst))  {
       mkdir($dst,0775,true);
     }
  }

  
  
  
 

  
  
 
  
  

  
  
}


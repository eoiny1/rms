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
  
  
  /**
  * LIST ALL FILES IN UPLOAD DIR AND MOVE TO ARCHVE
	*/
  public function moveMassFilesToArchive() {

		$csv_path =  $this->getRmsUploadFolder();
		$archive_dir = $this->getRmsArchiveFolder();

		$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($csv_path,\RecursiveDirectoryIterator::SKIP_DOTS),
                                              \RecursiveIteratorIterator::CHILD_FIRST);

		foreach ($objects as $key => $obj) {

			if (($obj->isDir()) || ( preg_match("/archive/",$obj->getPathName()) ) )
				  continue;

			$this->moveToArchiveFolder($obj->getPathName());

		}

	}
  
  	//MOVE TO ARCHIVE FOLDER
	public function moveToArchiveFolder($fullPathFileName, $newFileName = null) {
		
		if(!$newFileName)
			$newFileName = basename($fullPathFileName);
		
		$archivePath = $this->getRmsArchiveFolder();

	  $this->createdFolder($this->getRmsArchiveFolder());


		return rename($fullPathFileName,$archivePath.$newFileName);
	}
  
  
  
  /**
  * Get RMS Upload folder
	*/
  public function getRmsUploadFolder() {
    
    $base_path = $this->_directoryList->getPath('var');
    $path = "/export/".self::UPLOAD_DIR."/";
    
    return $base_path.$path;
    
  }
  
  
  
  /**
  * Get RMS Archive folder
	*/
  public function getRmsArchiveFolder() {
    
    $base_path = $this->_directoryList->getPath('var');
    $path = "/export/".self::UPLOAD_DIR."/".self::UPLOAD_ARCHIVE_DIR."/";
    
    return $base_path.$path;
    
  }


  
  
  
 

  
  
 
  
  

  
  
}


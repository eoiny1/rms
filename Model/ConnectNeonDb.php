<?php


namespace Neon\Rms\Model;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class ConnectNeonDb extends \Magento\Framework\Model\AbstractModel {
  
  
    /**
    *
    */
    protected $config;  
  
    protected $_ftp_server;
    
    protected $_ftp_user_name;
    
    protected $_ftp_user_pass;
    
    protected $_ftp_store_code;
          
    protected $_conn_id;
  
    protected $_downloadedCsv;
  
    protected $_inventoryUpdateArray;
  
    protected $_csv_helper;
  
    protected $_updateInventory;
 
    protected $_file_helper;
  
    protected $_timer;
  
    protected $_rmsDownloadRepositoryInterface;
  
    protected $_rmsDownloadInterface;
  

     /**
     * @param \Neon\Rms\Helper\Config $config
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Neon\Rms\Helper\Config $config,
      \Neon\Rms\Helper\Csv $csv,
      \Neon\Rms\Helper\File $file,
      \Neon\Rms\Model\UpdateInventory $updateInventory,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry,
        \Neon\Rms\Helper\Timer $timer,
        \Neon\Rms\Api\RmsDownloadRepositoryInterface $rmsDownloadRepositoryInterface,
        \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownloadInterface
    ) {
      
        $this->config = $config;
      
        $this->_ftp_server = $config->getFtpServer(); 
		    $this->_ftp_user_name = $config->getFtpUserName();  
		    $this->_ftp_user_pass = $config->getFtpPwd();
        $this->_ftp_store_code = $config->getFtpStoreCode();
      
        $this->_rmsDownloadInterface = $rmsDownloadInterface;
      
        $this->_rmsDownloadRepositoryInterface = $rmsDownloadRepositoryInterface;
      
        $this->_timer = $timer;
        $this->_timer->start();
      
        $this->_csv_helper = $csv;
        $this->_updateInventory = $updateInventory;
      
        $this->_file_helper = $file;
       
        parent::__construct($context, $registry);

    }
 
  
  
  /**
  *
  **/
  public function getLatestFile() {
    
    //Clear everything in foler before download
    $this->_file_helper->moveMassFilesToArchive();
    
    if($this->conntectedToServer()) {
      
       $server_file = $this->getLatestFileName();
       
       $local_file = $this->getLocalFileName();
      
       ftp_pasv($this->_conn_id, true);
      
        try {

           // try to download $server_file and save to $local_file
          if (ftp_get($this->_conn_id,$local_file,$server_file,FTP_BINARY)) {

            chmod($local_file, 0777); 

            $new_server_file = $this->getNewServerFileName();
            #ftp_rename($this->_conn_id,$server_file,$new_server_file);
            
            $this->_rmsDownloadInterface->setSuccess("1");
            
            $this->_rmsDownloadInterface->setCsvName(basename($local_file));

            $this->setDownloadedCsv($local_file);

          } 
        
        }catch(Exception $e) {
	        
        }
     
      
    }

    return $this;
    
  }
  
  /**
  *
  **/
  public function createInventoryArray() {
    
     $raw_array  = $this->_csv_helper->readCsv($this->getDownloadedCsv());
    
   
     if(!empty($raw_array)) {
       
       $inventoryUpdateArray = array();
       
       foreach($raw_array as $data) {
         
           $inventoryUpdateArray[$data["sku"]] = array(
              "sku"=>$data["sku"],
              "qty"=>$data["qty"],
              "price"=>$data["product_price"],
              "cost"=>$data["product_cost"]
            );
         
       }
       
       
        #print_r($inventoryUpdateArray);
       
       
       $this->setInventoryUpdateArray($inventoryUpdateArray);
      
       
     }
     
      
    return $this;
    
  } 
  
  
  /**
  *
  **/
  public function updateInventory() {
    
    $inventoryArray = $this->getInventoryUpdateArray();
    
    if($inventoryArray) {
      
       echo "\n\n gotten this far \n\n";
      
       $this->_updateInventory->importQty($inventoryArray);
      
          $this->_rmsDownloadInterface->setSkuAdded($this->_updateInventory->getSkuAmountUploaded());
       
    $this->_rmsDownloadInterface->setSkuExcluded($this->_updateInventory->getSkuAmountExcluded());
      
      $this->registerDownload();
      
      #print_r($this->_updateInventory->getSkuAmountUploaded());
      
    }
    
    
  }
  
  
  /**
  *
  */
  protected function registerDownload() {
    
    $this->_timer->stop();
    
    $this->_rmsDownloadInterface->setStatus(1);
    
    $this->_rmsDownloadInterface->setDownloadType(2);
    
    $this->_rmsDownloadInterface->setDownloadTime($this->_timer->getElapsedTime());
     
    $this->_rmsDownloadRepositoryInterface->save($this->_rmsDownloadInterface);
    
    
  }
  
  
  
  
  /**
  *
  **/
  public function conntectedToServer() {
    
    // set up basic connection
		$conn_id = ftp_connect($this->_ftp_server);
    
		// login with username and password
		$login_result = ftp_login($conn_id,$this->_ftp_user_name,$this->_ftp_user_pass);
    
		if($login_result) {
      $this->_conn_id = $conn_id;
      return true;
    }
		
  }
  
  

 
  
  /**
  *
  **/
  public function getLatestFileName() {
    
     $storecode = $this->_ftp_store_code;
		 return "out"."/".$storecode."/".$storecode."_test.csv";
    
  }
  
  
  /**
  *
  **/
  protected function getLocalFileName() {
    
    $downloadDir = $this->_file_helper->getCsvBaseDir();
    $storecode = $this->_ftp_store_code;
    $time = date('m-d-Y-His');
    $local_file =  $downloadDir.$storecode."_".$time.".csv"; 
    
    return  $local_file;
    
  }
  
  
  
  /**
	* 
	**/
	protected function getNewServerFileName() {

		$time = date('m-d-Y-His');

		$storecode = $this->_ftp_store_code;

		return "out"."/".$storecode."/".$storecode."-".$time."-test-downloaded.csv";

	}
  
  
  
  
  
  
  /**
  *
  **/
  public function getInventoryUpdateArray() {
    
    return  $this->_inventoryUpdateArray;
  }
 
 /**
 *
 **/
 protected function setInventoryUpdateArray($qty_array) {
   
   $this->_inventoryUpdateArray = $qty_array;
   
 }
   
  
  /**
  *
  **/
  protected function setDownloadedCsv($localfile) {
    $this->_downloadedCsv = $localfile;
  }
  
  
  
  /**
  *
  **/
  public function getDownloadedCsv() {
    
     return $this->_downloadedCsv;
    
  }
  
  
  
  
  
  
  
  
  
}




?>
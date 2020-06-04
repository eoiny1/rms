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
  

     /**
     * @param \Neon\Rms\Helper\Config $config
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Neon\Rms\Helper\Config $config,
      \Neon\Rms\Helper\Csv $csv,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
      
        $this->config = $config;
      
        $this->_ftp_server = $config->getFtpServer(); 
		    $this->_ftp_user_name = $config->getFtpUserName();  
		    $this->_ftp_user_pass = $config->getFtpPwd();
        $this->_ftp_store_code = $config->getFtpStoreCode();
      
      $this->_csv_helper = $csv;
       
        parent::__construct($context, $registry);

    }
 
  
  
  /**
  *
  **/
  public function getLatestFile() {
    
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
    
    $storecode = $this->_ftp_store_code;
    $time = date('m-d-Y-His');
    $local_file =  $storecode."_".$time.".csv"; 
    
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
  public function createInventoryArray() {
    
     $raw_array  = $this->_csv_helper->readCsv($this->getDownloadedCsv());
      
     if(!empty($raw_array)) {
       
       $inventoryUpdateArray = array();
       
       foreach($raw_array as $data) {
         
           $inventoryUpdateArray[$data["sku"]] = array(
              "sku"=>$data["qty"],
              "qty"=>$data["mhsws_uid"],
              "price"=>$data["product_price"],
              "cost"=>$data["product_cost"]
            );
         
       }
       
       
       $this->setInventoryUpdateArray($inventoryUpdateArray);
       
     }
     
    return $this;
    
  } 
  
  
  /**
  *
  **/
  protected function getInventoryUpdateArray() {
    
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
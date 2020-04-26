<?php

namespace Neon\Rms\Model\ApiRequest;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class DownloadRequest extends \Neon\Rms\Model\ApiRequest {
  

  
  
    protected $_request = "ProductMetadataFetch";
  
    protected $_asseturl = "";
  
    protected $_file_helper;
  
    protected $_csv_helper;
  
    protected  $_updateInventory;
  
    protected $_inventoryUpdateArray = array();
  
    protected $_rmsDownloadInterface;
  

  
     /**
     * @param \Neon\Rms\Helper\Config $config 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Neon\Rms\Helper\Config $config,
       \Neon\Rms\Helper\Curl $curl,
       \Neon\Rms\Helper\File $file,
       \Neon\Rms\Helper\Csv $csv,
       \Neon\Rms\Model\UpdateInventory $updateInventory,
       \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownloadInterface,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
        parent::__construct($config,$curl,$context,$registry);
      
        $this->_file_helper = $file;
      
        $this->_csv_helper = $csv;
      
        $this->_updateInventory = $updateInventory; 
      
        $this->_rmsDownloadInterface = $rmsDownloadInterface;
      
        $this->setPostData();

    }
  
  
    
    /**
    *
    */
    public function call() {
      
      
      $response = $this->sendRequest();
      $interaction = $this->getInteraction($response);
      
      $finalResponse =  $this->loopToGetDownloadResponse($interaction);
      
      
      return $this;
      
      
    }
  
  
    /**
    *
    */
    protected function loopToGetDownloadResponse($interaction) {
      
      printf("interaction:%s \n\n",$interaction);
      
      //TAKE SMALL BREAK 
      $sleeptime = 60 * 2;
      
      sleep($sleeptime);
    
     for($x = 0; $x <= 5; $x++) {
        
       $peekyPayload = $this->getPeekPayLoad($interaction);
       
        printf("payload:%s \n",print_r($peekyPayload,1));
       
       $response = $this->sendRequest(array("post_url"=>$this->config->getPeekUrl(),"payload"=>$peekyPayload));
       
       printf("reposnse:%s \n",print_r($response,1));
      
       if(isset($response["asset_url"])) {
         $this->_rmsDownloadInterface->setGzUrl($response["asset_url"]);
         return $this->_asseturl = $response["asset_url"];
       }
        
       sleep(20);
       
      }
      
      
    }
  
  
  /**
  *
  */
  public function downloadGz() {
    
     if($this->_asseturl !='') {
      
        $date = date('mdY_His');
		    $downloadDir = $this->_file_helper->getCsvBaseDir();
		    $fileName = "product_inventory_fetch.".$date;
		    $filePathGZ = $downloadDir.$fileName.".json.gz";
      
        $gzFile = file_get_contents($this->_asseturl);

			  file_put_contents($filePathGZ,$gzFile);

        $this->createCSVFromGz($filePathGZ);
    }
    
    
    return $this;
    
  }
  
  
  /**
  *
  */
  protected function createCSVFromGz($filePathGZ) {
    
    	$lines = gzfile($filePathGZ);
			$jsonStr = "";
			foreach ($lines as $line) {
					$jsonStr .= $line;
			}
    
     $inventoryArray = json_decode($jsonStr,true);
    
     $inventoryCSVArray = array(array("sku","qty","price","cost"));
    
     $inventoryUpdateArray = array();
        
      foreach($inventoryArray["variant"] as $key => $item) {
        
          $price = $item["retail_price"];
          $cost = $item["cost"];
          $qty = (int)$item["provider"]["available_qty"];
          $qty = ($qty < 0)?"0":$qty;
          $sku = $item["sku"];
			
          $inventoryCSVArray[] = array($sku,$qty,$price,$cost);
        
          $inventoryUpdateArray[$sku] = array(
              "sku"=>$sku,
              "qty"=>$qty,
              "price"=> $price,
              "cost"=> $cost 
            );
        
			}
    
     $this->setInventoryUpdate($inventoryUpdateArray);
    
     $filePathCsv = preg_replace("/\.json\.gz/",".csv",$filePathGZ);
    
     $this->_csv_helper->writeToCsv($inventoryCSVArray,$filePathCsv);

  }
  
  
  /**
  *
  */
  public function setInventoryUpdate($inventoryUpdateArray) {
    $this->_inventoryUpdateArray = $inventoryUpdateArray;
    
  }
  
  /**
  *
  */
  public function getInventoryUpdate() {
    
    return $this->_inventoryUpdateArray;
    
  }
  
  
  /**
  *
  */
  public function updateInventory() {
    
    $inventoryArray =  $this->getInventoryUpdate();
    
    echo "\n\n gotten this far \n\n";
    
    $this->_rmsDownloadInterface->setSuccess("1");
    
    $this->_updateInventory->importQty($inventoryArray);
    
    return $this;
    
  }
  
  
  
  /**
  *
  */
  public function getRmsDownloadInterface() {
    
    return $this->_rmsDownloadInterface;
    
  }
  
  
  
  
}




?>
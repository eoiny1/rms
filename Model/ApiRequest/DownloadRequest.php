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
  
    protected $_rmsDownloadRepositoryInterface;
  

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
       \Neon\Rms\Api\RmsDownloadRepositoryInterface $rmsDownloadRepositoryInterface,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
        parent::__construct($config,$curl,$context,$registry);
      
        $this->_file_helper = $file;
      
        $this->_csv_helper = $csv;
      
        $this->_updateInventory = $updateInventory; 
      
        $this->_rmsDownloadInterface = $rmsDownloadInterface;
      
        $this->_rmsDownloadRepositoryInterface = $rmsDownloadRepositoryInterface;
      
        $this->setPostData();

    }
  
  
    
    /**
    *
    */
    public function call() {
      
      $this->_rmsDownloadInterface->setSuccess("0");
      
      $response = $this->sendRequest();
      $interaction = $this->getInteraction($response);
      
      $finalResponse =  $this->loopToGetDownloadResponse($interaction);
      
      
      return $this;
      
      
    }
  
  
  
    /**
    * @des Just making a quick request for interaction id and not full download
    */
    public function makeRequest() {
      
       $this->_rmsDownloadInterface->setSuccess("0");
       $response = $this->sendRequest();
      
       $interaction = $this->getInteraction($response);
      
       if($interaction) {
         $this->_rmsDownloadInterface->setRmsInteraction($interaction);
         $this->_rmsDownloadRepositoryInterface->save($this->_rmsDownloadInterface);   
       }
       
      
       return $this;
      
    }
  
  
    /**
    *
    */
    public function getDownloadResponse() {
      
      //update times this has been tried
      $old_download_attempts = $this->_rmsDownloadInterface->getDownloadAttempts();  
      $new_download_attempts = 1 + $old_download_attempts;
      $this->_rmsDownloadInterface->setDownloadAttempts($new_download_attempts);
      

      $interaction = $this->_rmsDownloadInterface->getRmsInteraction();
      
        if($interaction) {
                
            $peekyPayload = $this->getPeekPayLoad($interaction);
            printf("payload:%s \n",print_r($peekyPayload,1));

           $response = $this->sendRequest(array("post_url"=>$this->config->getPeekUrl(),"payload"=>$peekyPayload));

            printf("response:%s <br/>",print_r( $response,1));

           if(isset($response["asset_url"])) {
              $this->_rmsDownloadInterface->setGzUrl($response["asset_url"]);
              $this->_rmsDownloadInterface->setSuccess("1");
              $this->_asseturl = $response["asset_url"];

              return true;
           }
        
        }
       
       #printf("reposnse:%s \n",print_r($response,1));
      
       return false;
      
    }
  
  
  
    /**
    *
    */
    protected function loopToGetDownloadResponse($interaction) {
      
      printf("interaction:%s \n\n",$interaction);
      
      //TAKE SMALL BREAK 
      $sleeptime = 60 * 1;
      sleep($sleeptime);
    
     for($x = 0; $x <= 5; $x++) {
        
       $peekyPayload = $this->getPeekPayLoad($interaction);
       
        printf("payload:%s \n",print_r($peekyPayload,1));
       
        $response = $this->sendRequest(array("post_url"=>$this->config->getPeekUrl(),"payload"=>$peekyPayload));
       
       printf("reposnse:%s \n",print_r($response,1));
      
       if(isset($response["asset_url"])) {
         $this->_rmsDownloadInterface->setGzUrl($response["asset_url"]);
         $this->_rmsDownloadInterface->setSuccess("1");
         return $this->_asseturl = $response["asset_url"];
       }
        
       sleep(10);
       
      }
      
  
    }
  
  
  /**
  *
  */
  public function downloadGz() {
    
     if($this->_asseturl !='') {
       
        //Clear everything in foler before download
        $this->_file_helper->moveMassFilesToArchive();
      
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
    
     $this->_rmsDownloadInterface->setCsvName(basename($filePathCsv));
    
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
    
    $this->_updateInventory->importQty($inventoryArray);
    
    $this->_rmsDownloadInterface->setSkuAdded($this->_updateInventory->getSkuAmountUploaded());
       
    $this->_rmsDownloadInterface->setSkuExcluded($this->_updateInventory->getSkuAmountExcluded());   
    
    return $this;
    
  }
  
  
  
  /**
  *
  */
  public function getRmsDownloadInterface() {
    
    return $this->_rmsDownloadInterface;
    
  }
  
  
  
 /**
  *
  */
  public function setRmsDownloadInterface($request) {
    
     $this->_rmsDownloadInterface = $request;
    
     return $this;
    
  }
  
  
  
  
}




?>
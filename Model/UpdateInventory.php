<?php


namespace Neon\Rms\Model;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class UpdateInventory extends \Magento\Framework\Model\AbstractModel {
  

    protected $_defaultSourceProvider;
  
    protected $_sourceItemRepository;
  
    protected $_searchCriteriaBuilderFactory;
  
    protected $_importer;
  
    protected $_productIdBySku;
  
    protected $_lastorders;
  
    protected $_csv_helper;
  
    protected $_getSalableQuantityDataBySku;
  
    protected $_sku_amount_uploaded = 0;
  
    protected $_sku_amount_excluded = 0;
  

  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider,
      \Magento\InventoryApi\Api\SourceItemRepositoryInterface $sourceItemRepository,
      \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
      \Magento\CatalogImportExport\Model\StockItemImporterInterface $importer,
      \Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface $productIdBySku,
      \Neon\Rms\Model\UpdateInventory\LastOrders $lastorders,
      \Neon\Rms\Helper\Csv $csv,
      \Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $getSalableQuantityDataBySku
    ) {
       
        parent::__construct($context, $registry);
      
        $this->_defaultSourceProvider = $defaultSourceProvider;
        $this->_sourceItemRepository =  $sourceItemRepository;
        $this->_searchCriteriaBuilderFactory  = $searchCriteriaBuilderFactory;
        $this->_importer = $importer;
        $this->_productIdBySku = $productIdBySku;
        $this->_lastorders = $lastorders;
        $this->_getSalableQuantityDataBySku = $getSalableQuantityDataBySku;
      
        $this->_csv_helper = $csv;
      

    }
  
  
  /**
  *
  */
  public function importQty($inventoryArray = array()) {
    
   $inventoryArray = $this->getListOfSourceItems($inventoryArray);

    echo "\n FUCK YEAH! \n";
    
    if($inventoryArray) {
      
      print_r($inventoryArray);
      
      try {
       $result = $this->_importer->import($inventoryArray);
       echo "\n yo! \n";
       print_r( $result);
       echo "\n";
      }
      catch(Exception $e) {
        #$e->getMessage();
      }
      

    }  

  }
  
  
  
  /**
  *
  */
  protected function getListOfSourceItems($inventoryArray = array()) {
    
    $sourceItems = $this->getAllSourceItems();
    
    $sku_to_exclude_array = $this->getSkusToExclude();
    $this->setSkuAmountExcluded(count($sku_to_exclude_array));
    
    $stockUpdateArray = []; 
    
    $stockUpdateflatArray = [];
    
    $backupOfPerviousArray = [];
    
    foreach ($sourceItems as $sourceItem) { 
      
      $sku = $sourceItem->getSku();
      $qty = $sourceItem->getQuantity();
      
      $backupOfPerviousArray[] = array('sku'=>$sku,'qty'=>$qty); 
      
      
      if(isset($sku_to_exclude_array[$sku]))
          continue;
      
      if(isset($inventoryArray[$sku])) {
        
        $current_qty = $sourceItem->getQuantity();
        $salable_qty = $this->getSaleAbleQty($sku);
        $update_qty = $inventoryArray[$sku]["qty"];
        $is_in_stock = ($update_qty > 0)?1:0;
        
                
         //Only if change in QTY 
         if((int)$current_qty != (int)$update_qty) {
          
            if((int)$salable_qty != (int)$update_qty) {

                 $stockUpdateflatArray[] = [
                  'sku'=>$sku,
                  'qty'=> $update_qty,
                   'is_in_stock'=> $is_in_stock,
                   'website_id' => 0,
                   'stock_id' => 1,
                   'current_qty'=> $current_qty,
                   'salable_qty' => $salable_qty
                  ];

                 $stockUpdateArray[$sku] = [
                  'qty'=> $update_qty,
                   'is_in_stock'=> $is_in_stock,
                   'product_id' => "",
                   'website_id' => 0,
                   'stock_id' => 1,
                  ];
            
            }

         }

      }
      
    }
    
    //CSV FOR Products Updated
    if($stockUpdateflatArray)
      $this->_csv_helper->writeToCsvWithName($stockUpdateflatArray,"list_products_updated");
    
    if($backupOfPerviousArray)
      $this->_csv_helper->writeToCsvWithName($backupOfPerviousArray,"backup_of_stock");
     
    
    $this->setSkuAmountUploaded(count($stockUpdateArray));
    $stockUpdateArray = $this->addProductId($stockUpdateArray);
    
    
    
    return $stockUpdateArray;

  }
  
  
  /**
  *
  */
  protected function addProductId($stockUpdateArray) {
    
    $skus_to_find = array_keys($stockUpdateArray);
    
    $sku_to_id_array = $this->_productIdBySku->execute($skus_to_find);
    
    foreach($stockUpdateArray as $sku => $data ){
        $stockUpdateArray[$sku]['product_id'] =  $sku_to_id_array[$sku];
      
    }
    
    return $stockUpdateArray; 
    
    
  }

  
  
 /**
 *
 */
  protected function getAllSourceItems() {
    
     $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
 
     $searchCriteriaBuilder->addFilter('source_code', $this->_defaultSourceProvider->getCode());
  
     $searchCriteria = $searchCriteriaBuilder->create();
  
     $sourceItems = $this->_sourceItemRepository->getList($searchCriteria)->getItems();
    
     return $sourceItems;
   
    
  }
  
  /**
  *
  */
  protected function getSaleAbleQty($sku) {

    $qty = null;  
    
    try{
    
      $data = $this->_getSalableQuantityDataBySku->execute($sku);
      $qty =  $data[0]["qty"];
    
    } catch (Exception $e) {
        #echo $e->getMessage();
    }
    
     return $qty;
      
  }
  
  
  
  /**
  *
  */
  protected function getSkusToExclude() {
    
    return $this->_lastorders->getSkuToExclude();
    
    
  }
  
  
  
  /**
  *
  */
  public function getSkuAmountUploaded() {
    
    return $this->_sku_amount_uploaded;
    
  }
  
  
  /**
  *
  */
  public function setSkuAmountUploaded($amount) {
    
       $this->_sku_amount_uploaded = $amount;
    
  }
  


  /**
  *
  */
  public function getSkuAmountExcluded() {
    
      return $this->_sku_amount_excluded;
    
  }
  
  /**
  *
  */
  protected function setSkuAmountExcluded($amount) {
    
     $this->_sku_amount_excluded = $amount;
  
  }
  
  
  
  
  
  
}




?>
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
      \Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface $productIdBySku
    ) {
       
        parent::__construct($context, $registry);
      
        $this->_defaultSourceProvider = $defaultSourceProvider;
        $this->_sourceItemRepository =  $sourceItemRepository;
        $this->_searchCriteriaBuilderFactory  = $searchCriteriaBuilderFactory;
        $this->_importer = $importer;
        $this->_productIdBySku = $productIdBySku;
      

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
    
    
    
    
    $stockUpdateArray = []; 
    
    foreach ($sourceItems as $sourceItem) { 
      
      $sku = $sourceItem->getSku();
      
      if(isset($inventoryArray[$sku])) {
        
        $current_qty = $sourceItem->getQuantity();
        $update_qty = $inventoryArray[$sku]["qty"];
        $is_in_stock = ($update_qty > 0)?1:0;
                
         //Only if change in QTY 
         if((int)$current_qty != (int)$update_qty) {
          
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
    
    $stockUpdateArray = $this->addProductId($stockUpdateArray);
    
    //
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
  
  

  

  
  
  
  
  
  
}




?>
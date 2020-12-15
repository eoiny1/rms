<?php


namespace Neon\Rms\Model;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class UpdatePriceCost extends \Magento\Framework\Model\AbstractModel {
  

      protected $_basePriceStorageInterface;
      protected $_costStorageInterface;
      protected $_basePriceInterfaceFactory;
      protected $_costInterfaceFactory;
      protected $_productFactory;
      protected $_allMageSimpleSku = null;
  
  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Magento\Catalog\Api\BasePriceStorageInterface $basePriceStorageInterface,
      \Magento\Catalog\Api\CostStorageInterface $costStorageInterface,
      \Magento\Catalog\Api\Data\BasePriceInterfaceFactory $basePriceInterfaceFactory,
      \Magento\Catalog\Api\Data\CostInterfaceFactory $costInterfaceFactory,
      \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
       
        parent::__construct($context, $registry);
      
        $this->_basePriceStorageInterface  = $basePriceStorageInterface;
        $this->_costStorageInterface  = $costStorageInterface;
        $this->_basePriceInterfaceFactory  = $basePriceInterfaceFactory;
        $this->_costInterfaceFactory  = $costInterfaceFactory;
        $this->_productFactory = $productFactory;
      
      

    }
  
  
  /**
  * Update Price 
  */
  public function updatePrice($inventoryArray = array()) {
    
      $simples_we_have = $this->whichSkusWehave($inventoryArray);

      $priceDataObj_array = array();

      foreach($simples_we_have as $simple_info) {

        $priceDataObj = $this->_basePriceInterfaceFactory->create();
        
        $priceDataObj->setSku($simple_info["sku"]);
        $priceDataObj->setPrice($simple_info["price"]);
        $priceDataObj->setStoreId(0);
        $priceDataObj_array[] = $priceDataObj;

      }

     if($priceDataObj_array){
        $this->_basePriceStorageInterface->update($priceDataObj_array);
      }
      
      

      return $this;

  }


    /**
  * Update cost 
  */
  public function updateCost($inventoryArray = array()) {
    
    $simples_we_have = $this->whichSkusWehave($inventoryArray);

    $costDataObj_array = array();

    foreach($simples_we_have as $simple_info) {

      $costDataObj = $this->_costInterfaceFactory->create();
      
      $costDataObj->setSku($simple_info["sku"]);
      $costDataObj->setCost($simple_info["cost"]);
      $costDataObj->setStoreId(0);
      $costDataObj_array[] = $costDataObj;

    }

   if($costDataObj_array){
      $this->_costStorageInterface->update($costDataObj_array);
    }
    
    

    return $this;

}

  
  
  /**
  *
  */
  protected function whichSkusWehave($inventoryArray) {
    
        $sku_index_array = array_keys($inventoryArray);
    
         if($this->_allMageSimpleSku){
           return $this->_allMageSimpleSku;
         }
      
      $simple_sku_price_cost_list = array();
    
        
    
        $simples_products = $this->_productFactory->create()
        ->getCollection()
        ->addAttributeToSelect(array("price","cost","sku"))
        ->addFieldTofilter('type_id','simple')
        ->addFieldToFilter('sku', ['in' => $sku_index_array])
        ->setFlag('has_stock_status_filter', false);
        
        
          foreach($simples_products as $simple) {
            
             $sku = $simple->getSku();
             $price = floatval($simple->getPrice());
             $cost = floatval($simple->getCost());
            
             $rms_cost = floatval($inventoryArray[$sku]["cost"]);
             $rms_price = floatval($inventoryArray[$sku]["price"]);
            
            
            if(($rms_cost!=$cost)||($rms_price!=$price)) {

              echo $rms_cost;
              echo $rms_price;

               $simple_sku_price_cost_list[$sku] = [
                  "sku"=>$sku,
                  "price"=>$rms_price,
                  "cost"=>$rms_cost
                ];
              
            }

          
          }
        
          if($simple_sku_price_cost_list) {
            
            $this->_allMageSimpleSku = $simple_sku_price_cost_list;
            
            return $simple_sku_price_cost_list;
 
          }

    
  }
  
  
 
  
  
  
  
  
  
}




?>
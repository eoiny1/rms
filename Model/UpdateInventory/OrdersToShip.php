<?php


namespace Neon\Rms\Model\UpdateInventory;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class OrdersToShip extends \Magento\Framework\Model\AbstractModel {
  

    protected $orderRepository;
  
    protected $searchCriteriaBuilder;
  
    protected $itemsToBeShip = array();
    
  
  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Magento\Sales\Api\OrderRepositoryInterface  $orderRepository,
      \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
      
        $this->orderRepository = $orderRepository;
         
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
      
        $this->setItemsToBeShip();
       
        parent::__construct($context, $registry);

    }
  
  
  
  /**
  *
  **/
  public function isRmsQtyGood($sku,$qty) {
    
     $items_ship_array = $this->getItemsToBeShip();
      
      if($items_ship_array) {
        
        if(isset($items_ship_array[$sku])) {
          
            $qty_to_ship = $items_ship_array[$sku];
          
            if($qty < $qty_to_ship)
              return false;
          
        }
        
      }
     
      return true;
    
  } 
  
  
  /**
  *
  **/
  public function getItemsToBeShip() {
    
    return $this->itemsToBeShip;
    
  }
  
  
  
  /**
  *
  **/
  protected function setItemsToBeShip() {
    
      $this->itemsToBeShip = $this->getItems();
    
  }
  
  
  
  
    /**
    *
    **/
    protected function getItems() {
      
      
          $order_status_array = ["processing","pending"];
        
           $searchCriteria =   $this->searchCriteriaBuilder
                    ->addFilter(
                      'status',$order_status_array, 'in'
                    )
            ->create();
      
           $orderCollection  = $this->orderRepository->getList($searchCriteria)->getItems();
    
          
          return $this->createOrderItemsArray($orderCollection);
          
      
    }
  
  
  /**
  *
  **/
  protected function createOrderItemsArray($orderCollection) {
    
    $items_array = array();
    
    
    if($orderCollection) {
          
      foreach ($orderCollection as $order) {
        
        $items = $order->getItems();

         foreach($items as $item) {
      
          if(!$item->getParentItemId())
            if($item->getQtyShipped() == 0)
                $items_array[$item->getSku()][] = $item->getQtyOrdered(); 
         
          
         }
 
    }
      
    
    if($items_array)  {
        $items_array = array_map(function ($array) {
          return array_sum($array);
        }, $items_array);
    }
      
  }
    
    return $items_array;
  
 }
  
  
 
  

  
  
}




?>
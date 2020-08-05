<?php


namespace Neon\Rms\Model\Package;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class PackageOrder extends \Magento\Framework\Model\AbstractModel {
  
      protected $_rmsSendRepository;
      
      protected $_searchCriteriaBuilderFactory;
  
      protected $_rmsSendOrderRepository;
  
      protected $_timer;
  
      protected $_productInventoryUpdateRequest;
  
      protected $_rms_send_ids_arrays;
  
  
  
      /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Neon\Rms\Model\RmsSendRepository $rmsSendRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param \Neon\Rms\Model\RmsSendOrderRepository  $rmsSendOrderRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param \Neon\Rms\Helper\Timer $timer
     * @param \Neon\Rms\Model\ApiRequest\ProductInventoryUpdateRequest $ProductInventoryUpdateRequest
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Neon\Rms\Model\RmsSendRepository $rmsSendRepository,
        \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        \Neon\Rms\Model\RmsSendOrderRepository $rmsSendOrderRepository,
        \Neon\Rms\Helper\Timer $timer,
        \Neon\Rms\Model\ApiRequest\ProductInventoryUpdateRequest $productInventoryUpdateRequest
    ) {
       
        parent::__construct($context,$registry);
      
        $this->_rmsSendRepository = $rmsSendRepository;
        
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        
        $this->_rmsSendOrderRepository = $rmsSendOrderRepository;
        
        $this->_timer = $timer;
        
        $this->_productInventoryUpdateRequest = $productInventoryUpdateRequest;

    }
  
  
  
  
  /**
  *
  */  
  public function getOrdersToSend() {
    
    $rmsSend =  $this->_rmsSendRepository->getList($this->buildRmsSendSearchCriteria())->getItems();
    
    $rms_send_ids_arrays = array(); 
    
     foreach ($rmsSend as $sourceItem) {
  
        print_r($sourceItem->getRmssendId());
  
        $rms_send_ids_arrays[] = $sourceItem->getRmssendId();
      
     } 
    
    $this->setRmsSendIdsArrays($rms_send_ids_arrays);
    
    return $this;

  }
  
  
  /**
  *
  */
  protected function  buildRmsSendSearchCriteria() {
    
    $searchCriteriaBuilder =  $this->_searchCriteriaBuilderFactory->create();
    
     $searchCriteriaBuilder->addFilter(
       "sent_type",
       1
      );
  
     $searchCriteriaBuilder->addFilter(
       "sent_status",
       0
      );
    
    
      $searchCriteria = $searchCriteriaBuilder->create();
      $searchCriteria->setPageSize(1);
    
      return $searchCriteria;
    
  }
  
  
  
  /**
  *
  */
  public function sendOrderItems() {
    
    $rmsSendOrders =  $this->_rmsSendOrderRepository->getList($this->buildRmsOrderSendSearchCriteria())->getItems();    
    
    foreach ($rmsSendOrders as $orderItem) {
      
       $rms_send_id = $orderItem->getRmsSendId();
      
       $this->getPackageItem($orderItem);
      
       $this->_timer->start();
      
       $this->_productInventoryUpdateRequest->call();
            
       $this->_timer->stop();
      
       $this->registerSentItem($rms_send_id);
        
    }
    
  }
  
  
 /**
 *
 */ 
 protected function getPackageItem($orderItem) {
   
  $sku = $orderItem->getSentSku();
  $qty = $orderItem->getQty();
  $rms_send_id = $orderItem->getRmsSendId();
  $order_increment = $orderItem->getOrderIncrement();
  $order_item_id = $orderItem->getOrderItemId();
  
  $short_increment = substr($order_increment, 3); 
   
  $notes =  $short_increment.$sku.$order_item_id.$rms_send_id;
  
  $this->_productInventoryUpdateRequest->addExtraPayload(array(
   "payload"=>
    array(
      "action"=> array(array(
        "new_value"=>$qty,
        "status"=>"sold",
        "action"=>"change_qty",
        "notes"=>$notes
      )),
	    "sku"=> $sku
    )
   )
  );
   
 } 
  
 /**
 *
 */
  protected function registerSentItem($rms_send_id) {
    
    $rmsSedObj = $this->_rmsSendRepository->get($rms_send_id);
  
    if($this->_productInventoryUpdateRequest->getSuccess() == 0)
        $new_send_status = 3;
    else 
       $new_send_status = 2; 
    
    $rmsSedObj->setSentStatus($new_send_status)
    ->setErrorMessage($this->_productInventoryUpdateRequest->getMessage())
    ->setSuccess($this->_productInventoryUpdateRequest->getSuccess())
    ->setPrevStatus($rmsSedObj->getSentStatus())
    ->setLocked(0)
    ->setSendAttempt(1)
    ->setRmsTicket($this->_productInventoryUpdateRequest->getRmsTicket())
    ->setCallTime($this->_timer->getElapsedTime());
  
    $this->_rmsSendRepository->save($rmsSedObj);
       
    
  }
  
  
  
  
  /**
  *
  */
  protected function  buildRmsOrderSendSearchCriteria() {
    
    $rms_send_ids_arrays = $this->getRmsSendIdsArrays(); 
    
    $searchCriteriaBuilder =  $this->_searchCriteriaBuilderFactory->create();
  
      $searchCriteriaBuilder->addFilter(
       "rms_send_id",
        $rms_send_ids_arrays,
        'in'
        );
  

      $searchCriteria = $searchCriteriaBuilder->create();
    
      return $searchCriteria;
    
    
  }
  
  
  
  
  
  /**
  *
  */
  protected function setRmsSendIdsArrays($rms_send_ids_arrays) {
    
    $this->_rms_send_ids_arrays = $rms_send_ids_arrays;
    
  }
  
  
  
  /**
  *
  */
  public function getRmsSendIdsArrays() {
    
    return $this->_rms_send_ids_arrays;
    
  }
  
  
  
  
  
  
  
}




?>
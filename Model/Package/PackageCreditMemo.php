<?php


namespace Neon\Rms\Model\Package;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class PackageCreditMemo extends \Magento\Framework\Model\AbstractModel {
  
      
      protected $_rmsSendRepository;
      
      protected $_searchCriteriaBuilderFactory;
  
      protected $_rmsSendCrRepository;
  
      protected $_timer;
  
      protected $_productInventoryUpdateRequest;
  
      protected $_rms_send_ids_arrays;
  
      protected $_sent_status_array;
  
  
  
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
        \Neon\Rms\Model\RmsSendCrRepository $rmsSendCrRepository,
        \Neon\Rms\Helper\Timer $timer,
        \Neon\Rms\Model\ApiRequest\ProductInventoryUpdateRequest $productInventoryUpdateRequest
    ) {
       
        parent::__construct($context,$registry);
      
        $this->_rmsSendRepository = $rmsSendRepository;
        
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        
        $this->_rmsSendCrRepository = $rmsSendCrRepository;
        
        $this->_timer = $timer;
        
        $this->_productInventoryUpdateRequest = $productInventoryUpdateRequest;

    }
  
  
  
  
  /**
  *
  */  
  public function getCreditMemoToSend() {
    
    $rmsSend =  $this->_rmsSendRepository->getList($this->buildRmsSendSearchCriteria())->getItems();
    
    $rms_send_ids_arrays = array(); 
    
    $sent_status_array = array();
    
     foreach ($rmsSend as $sourceItem) {
  
        print_r($sourceItem->getRmssendId());
  
        $rms_send_ids_arrays[] = $sourceItem->getRmssendId();
       
        $sent_status_array[$sourceItem->getRmssendId()] = $sourceItem->getSentStatus();
      
     } 
    
    print_r($rms_send_ids_arrays);
    
    print_r($sent_status_array);
    
    $this->setRmsSendIdsArrays($rms_send_ids_arrays);
    
    $this->setSentStatusArray($sent_status_array);
    
    return $this;

  }
  
  
  /**
  *
  */
  protected function  buildRmsSendSearchCriteria() {
    
    $searchCriteriaBuilder =  $this->_searchCriteriaBuilderFactory->create();
    
     $searchCriteriaBuilder->addFilter(
       "sent_type",
       2
      );
  
     $searchCriteriaBuilder->addFilter(
       "sent_status",
        array(0,1),
        "in"
      );
    
    
      $searchCriteria = $searchCriteriaBuilder->create();
      $searchCriteria->setPageSize(1);
    
      return $searchCriteria;
    
  }
  
  
  
  /**
  *
  */
  public function sendCreditMemo() {
    
    $rmsSendOrders =  $this->_rmsSendCrRepository->getList($this->buildRmsOrderSendSearchCriteria())->getItems();    
    
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
  $rms_send_id = $orderItem->getRmsSendId();
  $qty = $this->getQtyForCreditMemo($orderItem->getQty(),$rms_send_id);
  $cr_increment = $orderItem->getCrIncrement();
  $cr_item_id = $orderItem->getCrItemId();
  $sent_status_type = $this->getSentStatusType($rms_send_id);
   
  $status = ($sent_status_type==1)?"cancelonhold":"sold";
   
  $short_increment = substr($cr_increment, 3); 
   
  $notes =  $short_increment.$sku.$sent_status_type.$cr_item_id.$rms_send_id;

  $this->_productInventoryUpdateRequest->addExtraPayload(array(
   "payload"=>
    array(
      "action"=> array(array(
        "new_value"=>$qty,
        "status"=>$status,
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
protected function getQtyForCreditMemo($qty,$rms_send_id) {
  
   $sent_status_array = $this->getSentStatusArray();
  
   $qtyMul = ($sent_status_array[$rms_send_id] == 0)?-1:1;
  
   $qty = (string)($qty*$qtyMul);
  
   return $qty;
 
} 
  
/**
*
*/  
protected function getSentStatusType($rms_send_id) {
  
  $sent_status_array = $this->getSentStatusArray();
  
  return $sent_status_array[$rms_send_id];
  
}  
  
 
  
  
  
 /**
 *
 */
  protected function registerSentItem($rms_send_id) {
    
    $rmsSedObj = $this->_rmsSendRepository->get($rms_send_id);
  
    if($this->_productInventoryUpdateRequest->getSuccess() == 0){
       $new_send_status = 3;
    }else {
       $new_send_status = ($rmsSedObj->getSentStatus()==0)?1:2;  
    }
      
    
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
  
  
  /**
  *
  */
  protected function setSentStatusArray($sent_status_array) {
    
    $this->_sent_status_array = $sent_status_array;
    
  }
  
  
  /**
  *
  */
  public function getSentStatusArray() {
    
    return $this->_sent_status_array;
    
  }
  
    
  
  
  
  
  
  
}




?>
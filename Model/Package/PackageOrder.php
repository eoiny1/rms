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
       print_r($orderItem->getSentSku());
     }
    
    
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
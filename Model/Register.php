<?php


namespace Neon\Rms\Model;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class Register extends \Magento\Framework\Model\AbstractModel {
  
  
     protected $rmsSendRepository;
    
     protected $rmsSendInterface;
  
     protected $rmsSendOrderRepository;
  
     protected $rmsSendOrderInterface;
  
     protected $rmsSendCrRepository;
  
     protected $rmsSendCrInterface;
  
     protected $orderRepository;
     
  
      /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Neon\Rms\Api\RmsSendRepositoryInterface $rmsSendRepository
     * @param \Neon\Rms\Api\Data\RmsSendInterface $rmsSendInterface
     * @param \Neon\Rms\Api\RmsSendOrderRepositoryInterface $rmsSendOrderRepository
     * @param \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrderInterface
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Neon\Rms\Api\RmsSendRepositoryInterface $rmsSendRepository,
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSendInterface,
        \Neon\Rms\Api\RmsSendOrderRepositoryInterface $rmsSendOrderRepository,
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrderInterface,
        \Neon\Rms\Api\RmsSendCrRepositoryInterface $rmsSendCrRepository,
        \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCrInterface,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
    ) {
       
        parent::__construct($context, $registry);
      
      
        $this->rmsSendRepository = $rmsSendRepository;
        $this->rmsSendInterface = $rmsSendInterface;
      
        $this->rmsSendOrderRepository = $rmsSendOrderRepository;
        $this->rmsSendOrderInterface = $rmsSendOrderInterface;
      
        $this->rmsSendCrRepository = $rmsSendCrRepository;
        $this->rmsSendCrInterface = $rmsSendCrInterface;
      
    }
  
  
  
  
    /**
    *
    */
    public function saveItem(int $type) {
      
        $rmsSendInterface = $this->rmsSendInterface;
        $rmsSend = $rmsSendInterface->setSentType($type)->setSentStatus(0);
        $newItem  = $this->rmsSendRepository->save($rmsSend); 
        $rms_send_id = $newItem->getRmssendId();
      
        return $rms_send_id;
        
    }
  
  
  
}




?>
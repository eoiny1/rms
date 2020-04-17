<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class Test extends AbstractHelper
{
  
    protected $rmsSendRepository;
    
    protected $rmsSendInterface;
  
    protected $rmsSendOrderRepository;
  
    protected $rmsSendOrderInterface;
  
    protected $orderRepository;
  

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Neon\Rms\Api\RmsSendRepositoryInterface $rmsSendRepository,
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSendInterface,
        \Neon\Rms\Api\RmsSendOrderRepositoryInterface $rmsSendOrderRepository,
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrderInterface,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\App\Helper\Context $context
    ) {
      
      
        $this->rmsSendRepository = $rmsSendRepository;
        $this->rmsSendInterface = $rmsSendInterface;
      
        $this->rmsSendOrderRepository = $rmsSendOrderRepository;
        $this->rmsSendOrderInterface = $rmsSendOrderInterface;
      
        
        $this->orderRepository = $orderRepository;
      
      
        $orderId = 53;
        $order = $this->orderRepository->get($orderId);
        $item_data = [];
        $count = 0;
          
      
        $orderId = $order->getId();
        $orderNumber = $order->getIncrementId();
        
        foreach ($order->getAllVisibleItems() as $item) {
          
          $item_data[$count]['order_id'] = $orderId;
          $item_data[$count]['increment_id'] = $orderNumber;  
          $item_data[$count]['item_id'] =   $item->getItemId();
          $item_data[$count]['product_id'] = $item->getProductId(); //for product Id
          $item_data[$count]['sku'] = $item->getSku();
          $item_data[$count]['qty'] = $item->getQtyOrdered();
          
          $count++;
        }
      


        foreach($item_data as $item) {
          
          $rms_send_id =  $this->saveItem(1);
          $this->saveOrderItem($rms_send_id,$item);
          print_r($rms_send_id);
          echo "\n";
          
        }   
      
        parent::__construct($context);
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
  
  
    /**
    *
    */
    protected function saveOrderItem(int $rms_send_id,array $item_data) {
      
       $rmsSendOrderInterface = $this->rmsSendOrderInterface;
       $rmsSendOrderInterface->setRmsSendId($rms_send_id)->setOrderId($item_data["order_id"])->setOrderItemId($item_data["item_id"])->setOrderIncrement($item_data["increment_id"]);
       $this->rmsSendOrderRepository->save($rmsSendOrderInterface); 
      
      
    }
  

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }
  
  

  
  
}


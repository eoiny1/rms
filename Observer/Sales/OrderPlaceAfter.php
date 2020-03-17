<?php


namespace Neon\Rms\Observer\Sales;

use Psr\Log\LoggerInterface as PsrLoggerInterface;


/**
 * Class OrderPlaceAfter
 *
 * @package Neon\Rms\Observer\Sales
 */
class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface
{
  
  
 /**
 * @var PsrLoggerInterface
 */
 private $logger;
  
  
  protected $registerOrder;

  
   public function __construct(
     \Neon\Rms\Model\Register\RegisterOrder $registerOrder,
      PsrLoggerInterface $logger
    ) {
     
        $this->registerOrder = $registerOrder;
        $this->logger = $logger;
     
    }

  
  

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        
        $order = $observer->getEvent()->getOrder();
      
        #$this->logger->info("order_info",$order->getData());
      
        $item_data = $this->packageOrderDetails($order);
      
        #$this->logger->info("item_data",$item_data);
      
        foreach($item_data as $item) {
          
          $rms_send_id = $this->registerOrder->saveItem(1);
          $this->registerOrder->saveOrderItem($rms_send_id,$item);
          
       }
      
      
    }
  
  
  
  /**
  *
  */
  protected function packageOrderDetails(\Magento\Sales\Model\Order $order) {
    
     $item_data = [];

    
     $orderId = $order->getId();
     $orderNumber = $order->getIncrementId();
    
        
     foreach ($order->getAllItems() as $item) {
       
        #$this->logger->info("get_all_visiable_items",$item->getData());
       
        if($item->getProductType() == "simple") {
       
            $sku = $item->getSku();

            $item_data[$sku]['order_id'] = $orderId;
            $item_data[$sku]['increment_id'] = $orderNumber;  
            $item_data[$sku]['item_id'] =   $item->getQuoteItemId();
            $item_data[$sku]['product_id'] = $item->getProductId(); //for product Id
            $item_data[$sku]['sku'] = $item->getSku();
            $item_data[$sku]['qty'] = $item->getQtyOrdered();
          
        }

    
     }
    
    return $item_data;
    
  }
  
  
  
  
  
}

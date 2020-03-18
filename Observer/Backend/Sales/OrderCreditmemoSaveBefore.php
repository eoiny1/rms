<?php


namespace Neon\Rms\Observer\Backend\Sales;

use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * Class OrderCreditmemoSaveBefore
 *
 * @package Neon\Rms\Observer\Backend\Sales
 */
class OrderCreditmemoSaveBefore implements \Magento\Framework\Event\ObserverInterface
{
  
  
  /**
  * @var PsrLoggerInterface
  */
  private $logger;
  

  
   public function __construct(
      PsrLoggerInterface $logger
    ) {
     
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
      
      
          $creditMemo = $observer->getEvent()->getCreditmemo();
          
          $order = $creditMemo->getOrder();
      
          $this->logger->info("credit_info",$creditMemo->getData());
      
          $this->logger->info("order_info",$order->getData());
      
          $items = $creditMemo->getItemsCollection();
      
          foreach ($items as $item) {
               $this->logger->info("credit_info_item",$item->getData());
          }
      
      
      
        #https://github.com/belchiorneto/mercadopagoMagento/blob/754394f6d1e33e090e6df439c396f709253390f4/Observer/RefundObserverBeforeSave.php
      
        //Your observer code
    }
}
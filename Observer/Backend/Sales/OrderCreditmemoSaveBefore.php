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
  
  
  protected $registerCreditMemo;
  
  
  protected $_config; 
  

   public function __construct(
     \Neon\Rms\Model\Register\RegisterCrMemo $registerCr,
      PsrLoggerInterface $logger,
     \Neon\Rms\Helper\Config $config
    ) {
     
        $this->registerCreditMemo = $registerCr;
     
        $this->logger = $logger;
     
        $this->_config = $config;
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
      
          if($this->_config->isRmsSendCredit()) {
                 
              $creditMemo = $observer->getEvent()->getCreditmemo();

              $item_data = $this->packageCrMemoDetails($creditMemo);

              #$this->logger->info("item_data",$item_data);

              foreach($item_data as $item) {

                $rms_send_id = $this->registerCreditMemo->saveItem(2);
                $this->logger->info("send_id",array($rms_send_id));
                $this->registerCreditMemo->saveCrItem($rms_send_id,$item);

              }
            
          }
         
        #https://github.com/belchiorneto/mercadopagoMagento/blob/754394f6d1e33e090e6df439c396f709253390f4/Observer/RefundObserverBeforeSave.php

    }
  
  
  
  /**
  *
  */
  protected function packageCrMemoDetails($creditMemo) {
    
     $item_data = [];

     $order = $creditMemo->getOrder();
     $orderId =  $order->getId();
    
     $crMemoId = $creditMemo->getId();
     $crMemoNumber = $creditMemo->getIncrementId();
        
     foreach ($creditMemo->getAllItems() as $item) {
       
            #$this->logger->info("all_item_types",$item->getData());
       
            //Only return if back to stock is checked
            if($item->getBackToStock()) {
       
                $sku = $item->getSku();

                $item_data[$sku]['cr_id'] = $crMemoId;
                $item_data[$sku]['cr_increment'] = $crMemoNumber;  
                $item_data[$sku]['cr_item_id'] = $item->getOrderItemId();
                $item_data[$sku]['order_id'] =  $orderId;
                $item_data[$sku]['product_id'] = $item->getProductId(); //for product Id
                $item_data[$sku]['sku'] = $item->getSku();
                $item_data[$sku]['qty'] = $item->getQty();
              
            }
          
        }

    
    return $item_data;
    
  }
  

  
  
  
}
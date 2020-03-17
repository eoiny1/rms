<?php

namespace Neon\Rms\Model\Register;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class RegisterOrder extends \Neon\Rms\Model\Register {
  
  
  
    /**
    *
    */
    public function saveOrderItem(int $rms_send_id,array $item_data) {
      
       $rmsSendOrderInterface = $this->rmsSendOrderInterface;
       $rmsSendOrderInterface->setRmsSendId($rms_send_id)->setOrderId($item_data["order_id"])->setOrderItemId($item_data["item_id"])->setOrderIncrement($item_data["increment_id"])->setSentSku($item_data["sku"])->setQty($item_data["qty"])->setProductId($item_data["product_id"]);
       $this->rmsSendOrderRepository->save($rmsSendOrderInterface); 
      
      
    }
  
  
  
}




?>
<?php

namespace Neon\Rms\Model\Register;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class RegisterCrMemo extends \Neon\Rms\Model\Register {
  
  
    /**
    *
    */
    public function saveCrItem(int $rms_send_id,array $item_data) {
      
      $rmsSendOrderInterface = $this->rmsSendCrInterface;
       
      $rmsSendOrderInterface->setRmsSendId($rms_send_id)
        ->setCrId($item_data["cr_id"])
        ->setOrderId($item_data["order_id"])
        ->setCrItemId($item_data["cr_item_id"])
        ->setCrIncrement($item_data["cr_increment"])
        ->setSentSku($item_data["sku"])
        ->setQty($item_data["qty"])
        ->setProductId($item_data["product_id"]);
       
        $this->rmsSendCrRepository->save($rmsSendOrderInterface); 
      
      
    }
    
  
}



?>
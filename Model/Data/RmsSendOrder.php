<?php


namespace Neon\Rms\Model\Data;

use Neon\Rms\Api\Data\RmsSendOrderInterface;

/**
 * Class RmsSendOrder
 *
 * @package Neon\Rms\Model\Data
 */
class RmsSendOrder extends \Magento\Framework\Api\AbstractExtensibleObject implements RmsSendOrderInterface
{

    /**
     * Get rmssendorder_id
     * @return string|null
     */
    public function getRmssendorderId()
    {
        return $this->_get(self::RMSSENDORDER_ID);
    }

    /**
     * Set rmssendorder_id
     * @param string $rmssendorderId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setRmssendorderId($rmssendorderId)
    {
        return $this->setData(self::RMSSENDORDER_ID, $rmssendorderId);
    }

    /**
     * Get rms_send_id
     * @return string|null
     */
    public function getRmsSendId()
    {
        return $this->_get(self::RMS_SEND_ID);
    }

    /**
     * Set rms_send_id
     * @param string $rmsSendId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setRmsSendId($rmsSendId)
    {
        return $this->setData(self::RMS_SEND_ID, $rmsSendId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     * @param string $orderId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get order_item_id
     * @return string|null
     */
    public function getOrderItemId()
    {
        return $this->_get(self::ORDER_ITEM_ID);
    }

    /**
     * Set order_item_id
     * @param string $orderItemId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * Get order_increment
     * @return string|null
     */
    public function getOrderIncrement()
    {
        return $this->_get(self::ORDER_INCREMENT);
    }

    /**
     * Set order_increment
     * @param string $orderIncrement
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderIncrement($orderIncrement)
    {
        return $this->setData(self::ORDER_INCREMENT, $orderIncrement);
    }

    /**
     * Get sent_sku
     * @return string|null
     */
    public function getSentSku()
    {
        return $this->_get(self::SENT_SKU);
    }

    /**
     * Set sent_sku
     * @param string $sentSku
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setSentSku($sentSku)
    {
        return $this->setData(self::SENT_SKU, $sentSku);
    }
}


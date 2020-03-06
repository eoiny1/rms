<?php


namespace Neon\Rms\Model\Data;

use Neon\Rms\Api\Data\RmsSendCrInterface;

/**
 * Class RmsSendCr
 *
 * @package Neon\Rms\Model\Data
 */
class RmsSendCr extends \Magento\Framework\Api\AbstractExtensibleObject implements RmsSendCrInterface
{

    /**
     * Get rmssendcr_id
     * @return string|null
     */
    public function getRmssendcrId()
    {
        return $this->_get(self::RMSSENDCR_ID);
    }

    /**
     * Set rmssendcr_id
     * @param string $rmssendcrId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setRmssendcrId($rmssendcrId)
    {
        return $this->setData(self::RMSSENDCR_ID, $rmssendcrId);
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
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setRmsSendId($rmsSendId)
    {
        return $this->setData(self::RMS_SEND_ID, $rmsSendId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendCrExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendCrExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendCrExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get cr_id
     * @return string|null
     */
    public function getCrId()
    {
        return $this->_get(self::CR_ID);
    }

    /**
     * Set cr_id
     * @param string $crId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setCrId($crId)
    {
        return $this->setData(self::CR_ID, $crId);
    }

    /**
     * Get cr_item_id
     * @return string|null
     */
    public function getCrItemId()
    {
        return $this->_get(self::CR_ITEM_ID);
    }

    /**
     * Set cr_item_id
     * @param string $crItemId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setCrItemId($crItemId)
    {
        return $this->setData(self::CR_ITEM_ID, $crItemId);
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
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
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
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
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
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setSentSku($sentSku)
    {
        return $this->setData(self::SENT_SKU, $sentSku);
    }
}


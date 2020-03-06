<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendOrderInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendOrderInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ORDER_ID = 'order_id';
    const SENT_SKU = 'sent_sku';
    const RMS_SEND_ID = 'rms_send_id';
    const ORDER_ITEM_ID = 'order_item_id';
    const RMSSENDORDER_ID = 'rmssendorder_id';
    const ORDER_INCREMENT = 'order_increment';

    /**
     * Get rmssendorder_id
     * @return string|null
     */
    public function getRmssendorderId();

    /**
     * Set rmssendorder_id
     * @param string $rmssendorderId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setRmssendorderId($rmssendorderId);

    /**
     * Get rms_send_id
     * @return string|null
     */
    public function getRmsSendId();

    /**
     * Set rms_send_id
     * @param string $rmsSendId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setRmsSendId($rmsSendId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendOrderExtensionInterface $extensionAttributes
    );

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderId($orderId);

    /**
     * Get order_item_id
     * @return string|null
     */
    public function getOrderItemId();

    /**
     * Set order_item_id
     * @param string $orderItemId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderItemId($orderItemId);

    /**
     * Get order_increment
     * @return string|null
     */
    public function getOrderIncrement();

    /**
     * Set order_increment
     * @param string $orderIncrement
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setOrderIncrement($orderIncrement);

    /**
     * Get sent_sku
     * @return string|null
     */
    public function getSentSku();

    /**
     * Set sent_sku
     * @param string $sentSku
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     */
    public function setSentSku($sentSku);
}


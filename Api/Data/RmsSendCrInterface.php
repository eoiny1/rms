<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendCrInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendCrInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ORDER_ID = 'order_id';
    const SENT_SKU = 'sent_sku';
    const RMS_SEND_ID = 'rms_send_id';
    const CR_ITEM_ID = 'cr_item_id';
    const RMSSENDCR_ID = 'rmssendcr_id';
    const CR_ID = 'cr_id';
    const ORDER_INCREMENT = 'order_increment';

    /**
     * Get rmssendcr_id
     * @return string|null
     */
    public function getRmssendcrId();

    /**
     * Set rmssendcr_id
     * @param string $rmssendcrId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setRmssendcrId($rmssendcrId);

    /**
     * Get rms_send_id
     * @return string|null
     */
    public function getRmsSendId();

    /**
     * Set rms_send_id
     * @param string $rmsSendId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setRmsSendId($rmsSendId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendCrExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendCrExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendCrExtensionInterface $extensionAttributes
    );

    /**
     * Get cr_id
     * @return string|null
     */
    public function getCrId();

    /**
     * Set cr_id
     * @param string $crId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setCrId($crId);

    /**
     * Get cr_item_id
     * @return string|null
     */
    public function getCrItemId();

    /**
     * Set cr_item_id
     * @param string $crItemId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setCrItemId($crItemId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setOrderId($orderId);

    /**
     * Get order_increment
     * @return string|null
     */
    public function getOrderIncrement();

    /**
     * Set order_increment
     * @param string $orderIncrement
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
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
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     */
    public function setSentSku($sentSku);
}


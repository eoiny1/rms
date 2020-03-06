<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendOrderSearchResultsInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendOrderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get RmsSendOrder list.
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface[]
     */
    public function getItems();

    /**
     * Set rms_send_id list.
     * @param \Neon\Rms\Api\Data\RmsSendOrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


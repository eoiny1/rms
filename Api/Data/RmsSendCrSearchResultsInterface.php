<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendCrSearchResultsInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendCrSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get RmsSendCr list.
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface[]
     */
    public function getItems();

    /**
     * Set rms_send_id list.
     * @param \Neon\Rms\Api\Data\RmsSendCrInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


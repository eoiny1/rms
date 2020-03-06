<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendSearchResultsInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get RmsSend list.
     * @return \Neon\Rms\Api\Data\RmsSendInterface[]
     */
    public function getItems();

    /**
     * Set sent_type list.
     * @param \Neon\Rms\Api\Data\RmsSendInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


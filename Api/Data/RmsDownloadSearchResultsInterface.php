<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsDownloadSearchResultsInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsDownloadSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get RmsDownload list.
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface[]
     */
    public function getItems();

    /**
     * Set created_at list.
     * @param \Neon\Rms\Api\Data\RmsDownloadInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


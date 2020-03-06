<?php


namespace Neon\Rms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RmsDownloadRepositoryInterface
 *
 * @package Neon\Rms\Api
 */
interface RmsDownloadRepositoryInterface
{

    /**
     * Save RmsDownload
     * @param \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
    );

    /**
     * Retrieve RmsDownload
     * @param string $rmsdownloadId
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($rmsdownloadId);

    /**
     * Retrieve RmsDownload matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Neon\Rms\Api\Data\RmsDownloadSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete RmsDownload
     * @param \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
    );

    /**
     * Delete RmsDownload by ID
     * @param string $rmsdownloadId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($rmsdownloadId);
}


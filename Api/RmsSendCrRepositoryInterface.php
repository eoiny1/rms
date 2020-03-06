<?php


namespace Neon\Rms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RmsSendCrRepositoryInterface
 *
 * @package Neon\Rms\Api
 */
interface RmsSendCrRepositoryInterface
{

    /**
     * Save RmsSendCr
     * @param \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
    );

    /**
     * Retrieve RmsSendCr
     * @param string $rmssendcrId
     * @return \Neon\Rms\Api\Data\RmsSendCrInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($rmssendcrId);

    /**
     * Retrieve RmsSendCr matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Neon\Rms\Api\Data\RmsSendCrSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete RmsSendCr
     * @param \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
    );

    /**
     * Delete RmsSendCr by ID
     * @param string $rmssendcrId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($rmssendcrId);
}


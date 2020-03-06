<?php


namespace Neon\Rms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RmsSendRepositoryInterface
 *
 * @package Neon\Rms\Api
 */
interface RmsSendRepositoryInterface
{

    /**
     * Save RmsSend
     * @param \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
    );

    /**
     * Retrieve RmsSend
     * @param string $rmssendId
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($rmssendId);

    /**
     * Retrieve RmsSend matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Neon\Rms\Api\Data\RmsSendSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete RmsSend
     * @param \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
    );

    /**
     * Delete RmsSend by ID
     * @param string $rmssendId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($rmssendId);
}


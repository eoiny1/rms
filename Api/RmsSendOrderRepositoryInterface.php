<?php


namespace Neon\Rms\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RmsSendOrderRepositoryInterface
 *
 * @package Neon\Rms\Api
 */
interface RmsSendOrderRepositoryInterface
{

    /**
     * Save RmsSendOrder
     * @param \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
    );

    /**
     * Retrieve RmsSendOrder
     * @param string $rmssendorderId
     * @return \Neon\Rms\Api\Data\RmsSendOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($rmssendorderId);

    /**
     * Retrieve RmsSendOrder matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Neon\Rms\Api\Data\RmsSendOrderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete RmsSendOrder
     * @param \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
    );

    /**
     * Delete RmsSendOrder by ID
     * @param string $rmssendorderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($rmssendorderId);
}


<?php


namespace Neon\Rms\Model;

use Neon\Rms\Api\Data\RmsSendCrInterface;
use Magento\Framework\Api\DataObjectHelper;
use Neon\Rms\Api\Data\RmsSendCrInterfaceFactory;

/**
 * Class RmsSendCr
 *
 * @package Neon\Rms\Model
 */
class RmsSendCr extends \Magento\Framework\Model\AbstractModel
{

    protected $rmssendcrDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'neon_rms_rmssendcr';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param RmsSendCrInterfaceFactory $rmssendcrDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Neon\Rms\Model\ResourceModel\RmsSendCr $resource
     * @param \Neon\Rms\Model\ResourceModel\RmsSendCr\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        RmsSendCrInterfaceFactory $rmssendcrDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Neon\Rms\Model\ResourceModel\RmsSendCr $resource,
        \Neon\Rms\Model\ResourceModel\RmsSendCr\Collection $resourceCollection,
        array $data = []
    ) {
        $this->rmssendcrDataFactory = $rmssendcrDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve rmssendcr model with rmssendcr data
     * @return RmsSendCrInterface
     */
    public function getDataModel()
    {
        $rmssendcrData = $this->getData();
        
        $rmssendcrDataObject = $this->rmssendcrDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $rmssendcrDataObject,
            $rmssendcrData,
            RmsSendCrInterface::class
        );
        
        return $rmssendcrDataObject;
    }
}


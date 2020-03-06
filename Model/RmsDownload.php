<?php


namespace Neon\Rms\Model;

use Magento\Framework\Api\DataObjectHelper;
use Neon\Rms\Api\Data\RmsDownloadInterfaceFactory;
use Neon\Rms\Api\Data\RmsDownloadInterface;

/**
 * Class RmsDownload
 *
 * @package Neon\Rms\Model
 */
class RmsDownload extends \Magento\Framework\Model\AbstractModel
{

    protected $rmsdownloadDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'neon_rms_rmsdownload';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param RmsDownloadInterfaceFactory $rmsdownloadDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Neon\Rms\Model\ResourceModel\RmsDownload $resource
     * @param \Neon\Rms\Model\ResourceModel\RmsDownload\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        RmsDownloadInterfaceFactory $rmsdownloadDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Neon\Rms\Model\ResourceModel\RmsDownload $resource,
        \Neon\Rms\Model\ResourceModel\RmsDownload\Collection $resourceCollection,
        array $data = []
    ) {
        $this->rmsdownloadDataFactory = $rmsdownloadDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve rmsdownload model with rmsdownload data
     * @return RmsDownloadInterface
     */
    public function getDataModel()
    {
        $rmsdownloadData = $this->getData();
        
        $rmsdownloadDataObject = $this->rmsdownloadDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $rmsdownloadDataObject,
            $rmsdownloadData,
            RmsDownloadInterface::class
        );
        
        return $rmsdownloadDataObject;
    }
}


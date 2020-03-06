<?php


namespace Neon\Rms\Model;

use Neon\Rms\Api\Data\RmsSendInterfaceFactory;
use Neon\Rms\Api\Data\RmsSendInterface;
use Magento\Framework\Api\DataObjectHelper;

/**
 * Class RmsSend
 *
 * @package Neon\Rms\Model
 */
class RmsSend extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'neon_rms_rmssend';
    protected $dataObjectHelper;

    protected $rmssendDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param RmsSendInterfaceFactory $rmssendDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Neon\Rms\Model\ResourceModel\RmsSend $resource
     * @param \Neon\Rms\Model\ResourceModel\RmsSend\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        RmsSendInterfaceFactory $rmssendDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Neon\Rms\Model\ResourceModel\RmsSend $resource,
        \Neon\Rms\Model\ResourceModel\RmsSend\Collection $resourceCollection,
        array $data = []
    ) {
        $this->rmssendDataFactory = $rmssendDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve rmssend model with rmssend data
     * @return RmsSendInterface
     */
    public function getDataModel()
    {
        $rmssendData = $this->getData();
        
        $rmssendDataObject = $this->rmssendDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $rmssendDataObject,
            $rmssendData,
            RmsSendInterface::class
        );
        
        return $rmssendDataObject;
    }
}


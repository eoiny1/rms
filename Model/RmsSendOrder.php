<?php


namespace Neon\Rms\Model;

use Neon\Rms\Api\Data\RmsSendOrderInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Neon\Rms\Api\Data\RmsSendOrderInterface;

/**
 * Class RmsSendOrder
 *
 * @package Neon\Rms\Model
 */
class RmsSendOrder extends \Magento\Framework\Model\AbstractModel
{

    protected $dataObjectHelper;

    protected $rmssendorderDataFactory;

    protected $_eventPrefix = 'neon_rms_rmssendorder';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param RmsSendOrderInterfaceFactory $rmssendorderDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Neon\Rms\Model\ResourceModel\RmsSendOrder $resource
     * @param \Neon\Rms\Model\ResourceModel\RmsSendOrder\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        RmsSendOrderInterfaceFactory $rmssendorderDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Neon\Rms\Model\ResourceModel\RmsSendOrder $resource,
        \Neon\Rms\Model\ResourceModel\RmsSendOrder\Collection $resourceCollection,
        array $data = []
    ) {
        $this->rmssendorderDataFactory = $rmssendorderDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve rmssendorder model with rmssendorder data
     * @return RmsSendOrderInterface
     */
    public function getDataModel()
    {
        $rmssendorderData = $this->getData();
        
        $rmssendorderDataObject = $this->rmssendorderDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $rmssendorderDataObject,
            $rmssendorderData,
            RmsSendOrderInterface::class
        );
        
        return $rmssendorderDataObject;
    }
}


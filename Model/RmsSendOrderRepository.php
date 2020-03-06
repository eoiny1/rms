<?php


namespace Neon\Rms\Model;

use Neon\Rms\Api\Data\RmsSendOrderInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Neon\Rms\Api\Data\RmsSendOrderSearchResultsInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Neon\Rms\Model\ResourceModel\RmsSendOrder as ResourceRmsSendOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Neon\Rms\Api\RmsSendOrderRepositoryInterface;
use Neon\Rms\Model\ResourceModel\RmsSendOrder\CollectionFactory as RmsSendOrderCollectionFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;

/**
 * Class RmsSendOrderRepository
 *
 * @package Neon\Rms\Model
 */
class RmsSendOrderRepository implements RmsSendOrderRepositoryInterface
{

    protected $rmsSendOrderFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $rmsSendOrderCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataRmsSendOrderFactory;

    private $collectionProcessor;

    protected $resource;

    private $storeManager;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceRmsSendOrder $resource
     * @param RmsSendOrderFactory $rmsSendOrderFactory
     * @param RmsSendOrderInterfaceFactory $dataRmsSendOrderFactory
     * @param RmsSendOrderCollectionFactory $rmsSendOrderCollectionFactory
     * @param RmsSendOrderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceRmsSendOrder $resource,
        RmsSendOrderFactory $rmsSendOrderFactory,
        RmsSendOrderInterfaceFactory $dataRmsSendOrderFactory,
        RmsSendOrderCollectionFactory $rmsSendOrderCollectionFactory,
        RmsSendOrderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->rmsSendOrderFactory = $rmsSendOrderFactory;
        $this->rmsSendOrderCollectionFactory = $rmsSendOrderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRmsSendOrderFactory = $dataRmsSendOrderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
    ) {
        /* if (empty($rmsSendOrder->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $rmsSendOrder->setStoreId($storeId);
        } */
        
        $rmsSendOrderData = $this->extensibleDataObjectConverter->toNestedArray(
            $rmsSendOrder,
            [],
            \Neon\Rms\Api\Data\RmsSendOrderInterface::class
        );
        
        $rmsSendOrderModel = $this->rmsSendOrderFactory->create()->setData($rmsSendOrderData);
        
        try {
            $this->resource->save($rmsSendOrderModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rmsSendOrder: %1',
                $exception->getMessage()
            ));
        }
        return $rmsSendOrderModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($rmsSendOrderId)
    {
        $rmsSendOrder = $this->rmsSendOrderFactory->create();
        $this->resource->load($rmsSendOrder, $rmsSendOrderId);
        if (!$rmsSendOrder->getId()) {
            throw new NoSuchEntityException(__('RmsSendOrder with id "%1" does not exist.', $rmsSendOrderId));
        }
        return $rmsSendOrder->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->rmsSendOrderCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Neon\Rms\Api\Data\RmsSendOrderInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Neon\Rms\Api\Data\RmsSendOrderInterface $rmsSendOrder
    ) {
        try {
            $rmsSendOrderModel = $this->rmsSendOrderFactory->create();
            $this->resource->load($rmsSendOrderModel, $rmsSendOrder->getRmssendorderId());
            $this->resource->delete($rmsSendOrderModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the RmsSendOrder: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($rmsSendOrderId)
    {
        return $this->delete($this->get($rmsSendOrderId));
    }
}


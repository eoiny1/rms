<?php


namespace Neon\Rms\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Neon\Rms\Model\ResourceModel\RmsSend\CollectionFactory as RmsSendCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Neon\Rms\Api\RmsSendRepositoryInterface;
use Neon\Rms\Api\Data\RmsSendInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Neon\Rms\Api\Data\RmsSendSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Neon\Rms\Model\ResourceModel\RmsSend as ResourceRmsSend;

/**
 * Class RmsSendRepository
 *
 * @package Neon\Rms\Model
 */
class RmsSendRepository implements RmsSendRepositoryInterface
{

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $rmsSendCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataRmsSendFactory;

    private $collectionProcessor;

    protected $resource;

    private $storeManager;

    protected $extensibleDataObjectConverter;
    protected $rmsSendFactory;


    /**
     * @param ResourceRmsSend $resource
     * @param RmsSendFactory $rmsSendFactory
     * @param RmsSendInterfaceFactory $dataRmsSendFactory
     * @param RmsSendCollectionFactory $rmsSendCollectionFactory
     * @param RmsSendSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceRmsSend $resource,
        RmsSendFactory $rmsSendFactory,
        RmsSendInterfaceFactory $dataRmsSendFactory,
        RmsSendCollectionFactory $rmsSendCollectionFactory,
        RmsSendSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->rmsSendFactory = $rmsSendFactory;
        $this->rmsSendCollectionFactory = $rmsSendCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRmsSendFactory = $dataRmsSendFactory;
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
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
    ) {
        /* if (empty($rmsSend->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $rmsSend->setStoreId($storeId);
        } */
        
        $rmsSendData = $this->extensibleDataObjectConverter->toNestedArray(
            $rmsSend,
            [],
            \Neon\Rms\Api\Data\RmsSendInterface::class
        );
        
        $rmsSendModel = $this->rmsSendFactory->create()->setData($rmsSendData);
        
        try {
            $this->resource->save($rmsSendModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rmsSend: %1',
                $exception->getMessage()
            ));
        }
        return $rmsSendModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($rmsSendId)
    {
        $rmsSend = $this->rmsSendFactory->create();
        $this->resource->load($rmsSend, $rmsSendId);
        if (!$rmsSend->getId()) {
            throw new NoSuchEntityException(__('RmsSend with id "%1" does not exist.', $rmsSendId));
        }
        return $rmsSend->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->rmsSendCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Neon\Rms\Api\Data\RmsSendInterface::class
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
        \Neon\Rms\Api\Data\RmsSendInterface $rmsSend
    ) {
        try {
            $rmsSendModel = $this->rmsSendFactory->create();
            $this->resource->load($rmsSendModel, $rmsSend->getRmssendId());
            $this->resource->delete($rmsSendModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the RmsSend: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($rmsSendId)
    {
        return $this->delete($this->get($rmsSendId));
    }
}


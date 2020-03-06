<?php


namespace Neon\Rms\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Exception\CouldNotSaveException;
use Neon\Rms\Api\Data\RmsSendCrInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Neon\Rms\Model\ResourceModel\RmsSendCr\CollectionFactory as RmsSendCrCollectionFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Neon\Rms\Api\RmsSendCrRepositoryInterface;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Neon\Rms\Api\Data\RmsSendCrSearchResultsInterfaceFactory;
use Neon\Rms\Model\ResourceModel\RmsSendCr as ResourceRmsSendCr;

/**
 * Class RmsSendCrRepository
 *
 * @package Neon\Rms\Model
 */
class RmsSendCrRepository implements RmsSendCrRepositoryInterface
{

    protected $rmsSendCrFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $rmsSendCrCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $dataRmsSendCrFactory;

    private $collectionProcessor;

    protected $resource;

    private $storeManager;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceRmsSendCr $resource
     * @param RmsSendCrFactory $rmsSendCrFactory
     * @param RmsSendCrInterfaceFactory $dataRmsSendCrFactory
     * @param RmsSendCrCollectionFactory $rmsSendCrCollectionFactory
     * @param RmsSendCrSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceRmsSendCr $resource,
        RmsSendCrFactory $rmsSendCrFactory,
        RmsSendCrInterfaceFactory $dataRmsSendCrFactory,
        RmsSendCrCollectionFactory $rmsSendCrCollectionFactory,
        RmsSendCrSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->rmsSendCrFactory = $rmsSendCrFactory;
        $this->rmsSendCrCollectionFactory = $rmsSendCrCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRmsSendCrFactory = $dataRmsSendCrFactory;
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
        \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
    ) {
        /* if (empty($rmsSendCr->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $rmsSendCr->setStoreId($storeId);
        } */
        
        $rmsSendCrData = $this->extensibleDataObjectConverter->toNestedArray(
            $rmsSendCr,
            [],
            \Neon\Rms\Api\Data\RmsSendCrInterface::class
        );
        
        $rmsSendCrModel = $this->rmsSendCrFactory->create()->setData($rmsSendCrData);
        
        try {
            $this->resource->save($rmsSendCrModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rmsSendCr: %1',
                $exception->getMessage()
            ));
        }
        return $rmsSendCrModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($rmsSendCrId)
    {
        $rmsSendCr = $this->rmsSendCrFactory->create();
        $this->resource->load($rmsSendCr, $rmsSendCrId);
        if (!$rmsSendCr->getId()) {
            throw new NoSuchEntityException(__('RmsSendCr with id "%1" does not exist.', $rmsSendCrId));
        }
        return $rmsSendCr->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->rmsSendCrCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Neon\Rms\Api\Data\RmsSendCrInterface::class
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
        \Neon\Rms\Api\Data\RmsSendCrInterface $rmsSendCr
    ) {
        try {
            $rmsSendCrModel = $this->rmsSendCrFactory->create();
            $this->resource->load($rmsSendCrModel, $rmsSendCr->getRmssendcrId());
            $this->resource->delete($rmsSendCrModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the RmsSendCr: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($rmsSendCrId)
    {
        return $this->delete($this->get($rmsSendCrId));
    }
}


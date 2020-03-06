<?php


namespace Neon\Rms\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Neon\Rms\Model\ResourceModel\RmsDownload\CollectionFactory as RmsDownloadCollectionFactory;
use Neon\Rms\Api\Data\RmsDownloadSearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;
use Neon\Rms\Api\RmsDownloadRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Neon\Rms\Api\Data\RmsDownloadInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Neon\Rms\Model\ResourceModel\RmsDownload as ResourceRmsDownload;

/**
 * Class RmsDownloadRepository
 *
 * @package Neon\Rms\Model
 */
class RmsDownloadRepository implements RmsDownloadRepositoryInterface
{

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $rmsDownloadCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $rmsDownloadFactory;

    protected $dataRmsDownloadFactory;

    private $collectionProcessor;

    protected $resource;

    private $storeManager;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceRmsDownload $resource
     * @param RmsDownloadFactory $rmsDownloadFactory
     * @param RmsDownloadInterfaceFactory $dataRmsDownloadFactory
     * @param RmsDownloadCollectionFactory $rmsDownloadCollectionFactory
     * @param RmsDownloadSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceRmsDownload $resource,
        RmsDownloadFactory $rmsDownloadFactory,
        RmsDownloadInterfaceFactory $dataRmsDownloadFactory,
        RmsDownloadCollectionFactory $rmsDownloadCollectionFactory,
        RmsDownloadSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->rmsDownloadFactory = $rmsDownloadFactory;
        $this->rmsDownloadCollectionFactory = $rmsDownloadCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRmsDownloadFactory = $dataRmsDownloadFactory;
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
        \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
    ) {
        /* if (empty($rmsDownload->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $rmsDownload->setStoreId($storeId);
        } */
        
        $rmsDownloadData = $this->extensibleDataObjectConverter->toNestedArray(
            $rmsDownload,
            [],
            \Neon\Rms\Api\Data\RmsDownloadInterface::class
        );
        
        $rmsDownloadModel = $this->rmsDownloadFactory->create()->setData($rmsDownloadData);
        
        try {
            $this->resource->save($rmsDownloadModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the rmsDownload: %1',
                $exception->getMessage()
            ));
        }
        return $rmsDownloadModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($rmsDownloadId)
    {
        $rmsDownload = $this->rmsDownloadFactory->create();
        $this->resource->load($rmsDownload, $rmsDownloadId);
        if (!$rmsDownload->getId()) {
            throw new NoSuchEntityException(__('RmsDownload with id "%1" does not exist.', $rmsDownloadId));
        }
        return $rmsDownload->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->rmsDownloadCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Neon\Rms\Api\Data\RmsDownloadInterface::class
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
        \Neon\Rms\Api\Data\RmsDownloadInterface $rmsDownload
    ) {
        try {
            $rmsDownloadModel = $this->rmsDownloadFactory->create();
            $this->resource->load($rmsDownloadModel, $rmsDownload->getRmsdownloadId());
            $this->resource->delete($rmsDownloadModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the RmsDownload: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($rmsDownloadId)
    {
        return $this->delete($this->get($rmsDownloadId));
    }
}


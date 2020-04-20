<?php


namespace Neon\Rms\Model;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class UpdateInventory extends \Magento\Framework\Model\AbstractModel {
  
     protected $defaultSourceProvider;
  
     protected $sourceItemRepository;
  
     protected $searchCriteriaBuilderFactory;
  
     protected $searchCriteriaBuilder;
  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    protected function __construct(
      \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider,
      \Magento\InventoryApi\Api\SourceItemRepositoryInterface $sourceItemRepository, 
      \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
       \Magento\Framework\Model\Context $context,
       \Magento\Framework\Registry $registry
    ) {
      

        $this->defaultSourceProvider = $defaultSourceProvider;
        
        $this->sourceItemRepository = $sourceItemRepository;
            
        $this->searchCriteriaBuilderFactory  =  $searchCriteriaBuilderFactory;
          
        $this->searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
       
        parent::__construct($context, $registry);

    }
  
  
  
  
  
  
  
  
  
}




?>
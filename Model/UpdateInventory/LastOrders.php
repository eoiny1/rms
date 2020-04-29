<?php


namespace Neon\Rms\Model\UpdateInventory;

/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class LastOrders extends \Magento\Framework\Model\AbstractModel {
  

    protected $_orderItemRepository;
  
    protected $_searchCriteriaBuilderFactory;
    
    protected $_date;
  
    protected $_config;
  
    protected $_csv_helper;
  
  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
      \Magento\Framework\Model\Context $context,
      \Magento\Framework\Registry $registry,
      \Magento\Sales\Api\OrderItemRepositoryInterface $orderItemRepository,
      \Magento\Framework\Api\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
      \Magento\Framework\Stdlib\DateTime\DateTime $date,
      \Neon\Rms\Helper\Csv $csv,
      \Neon\Rms\Helper\Config $config
    ) {
       
        parent::__construct($context, $registry);
      
        $this->_orderItemRepository = $orderItemRepository;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_date  = $date;
        $this->_config = $config;
      
        $this->_csv_helper = $csv;

    }
  
  
  public function getSkuToExclude() {
    
    return $this->getLastOrderItems(); 
    
  }
  
  
  

  
  /**
  *
  */
  protected  function getLastOrderItems() {
    
    $orderItems = $this->_orderItemRepository->getList($this->buildSearchCriteria())->getItems();
    
    $sku_exclude_array = [];
    
    $sku_exclude_flat_array = [];
    
    foreach ($orderItems as $item) {
      
      $sku_exclude_array[$item->getSku()] = $item->getSku();
      $sku_exclude_flat_array[] = ["sku"=>$item->getSku()];

    }
    
    if($sku_exclude_flat_array)
      $this->_csv_helper->writeToCsvWithName($sku_exclude_flat_array,"excluded_skus");
    
    return $sku_exclude_array;
    
  }
  
  /**
  *
  */ 
  protected function buildSearchCriteria() {
    
   $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
  
   $searchCriteriaBuilder->addFilter(
         "created_at",
          $this->getFromTime(),
        "gteq"
     );
  
    $searchCriteria = $searchCriteriaBuilder->create();
    
    return $searchCriteria;
    
    
  }
  
  
  /**
  *
  */
  protected function getFromTime() {
    
    $hour = (!$this->_config->getLastOrderLimit())?6:$this->_config->getLastOrderLimit();
    
    $lasthour = 60*60*$hour;

    $lastTime = $this->_date->timestamp() - $lasthour; 
    
    $from = $this->_date->gmtDate('Y-m-d H:i:s',$lastTime);
    
    return $from;
    
  }
  
  
 
  
  
  

  
  

  
  

  

  
  
  
  
  
  
}




?>
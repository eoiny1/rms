<?php


namespace Neon\Rms\Model;

use Neon\Rms\Api\RmsDownloadRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Neon\Rms\Model\ApiRequest\DownloadRequest;
use Neon\Rms\Helper\Timer;


/**
 * Class Register
 *
 * @package Neon\Rms\Model
 */
class GetLatestDownloadRequest extends \Magento\Framework\Model\AbstractModel {
  

     /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
  
  
    private $sortOrderBuilder;
  
  
    protected $_rmsDownloadRepositoryInterface;
  
  
    protected $_apiRequest;
  
  
    protected $_timer;

  
     /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        RmsDownloadRepositoryInterface $rmsDownloadRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortBuilder,
        DownloadRequest $apiRequest,
        Timer $timer
    ) {
       
        parent::__construct($context, $registry);
      
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortBuilder;
      
        $this->_rmsDownloadRepositoryInterface = $rmsDownloadRepositoryInterface;
      
        $this->_apiRequest = $apiRequest;
      
        $this->_timer = $timer;
        $this->_timer->start();

    }
  
  
  /**
  *
  **/
  
    public function updateFromLatestRequest() {
      
         $download_request = $this->getLatestRequest();
      
        foreach($download_request as $request) {
    
          $hasListComplied = $this->_apiRequest
            ->setRmsDownloadInterface($request)
            ->getDownloadResponse();
      
           if($hasListComplied) {
              $this->_apiRequest->downloadGz()->updateInventory();
              $this->registerDownload();
              echo "yo!";
          }
    
        }
      
    }
  
  
  /**
  *
  */
  protected function registerDownload() {
    
    $this->_timer->stop();
    
    $rmsDownloadInterface = $this->_apiRequest->getRmsDownloadInterface();
    
     $rmsDownloadInterface->setStatus(1);
     $rmsDownloadInterface->setDownloadTime($this->_timer->getElapsedTime());
     
    $this->_rmsDownloadRepositoryInterface->save($rmsDownloadInterface);
    
    
  }
  
  
  
  
  
    /**
    *
    **/
    public function getLatestRequest() {
      
        $searchCriteria = $this->latestRequestSearchCriteria();
      
         return $this->_rmsDownloadRepositoryInterface->getList($searchCriteria)
            ->getItems();
      
    }
  
  
  /**
  *
  **/
  public function latestRequestSearchCriteria() { 
    
          return   $this->searchCriteriaBuilder
          ->addFilter('status',0,'eq')
          ->addSortOrder($this->sortOrderBuilder->setField('rmsdownload_id')
          ->setDescendingDirection()->create())
          ->setPageSize(1)->setCurrentPage(1)->create();
  
  }
  
  
  
  
  
  
  
  
}




?>
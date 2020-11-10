<?php


namespace Neon\Rms\Controller\Adminhtml\RmsDownload;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Shell;
use Symfony\Component\Process\PhpExecutableFinder;


/**
 * Class Index
 *
 * @package Neon\Rms\Controller\Adminhtml\RmsDownload
 */
class CheckRequest extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
  
    protected $redirectUrl = 'neon_rms/rmsdownload/index';
  
  
    /**
    * @var \Magento\Framework\App\Request\Http
    */
    protected $request;
  
  
    /**
    *
    **/
    protected $_rmsDownloadRepository;
  
    /**
    *
    **/
    protected $_apiRequest;
  
  

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Neon\Rms\Model\RmsDownloadRepository $rmsDownloadRepository,
        \Neon\Rms\Model\ApiRequest\DownloadRequest $apiRequest
    ) {
        
        parent::__construct($context);
      
                  
        $this->request = $request;

      
        $this->resultPageFactory = $resultPageFactory;
      
      
        $this->_rmsDownloadRepository = $rmsDownloadRepository;
      
      
        $this->_apiRequest = $apiRequest;
      
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
      
         //WHERE WE ARE AT....CHECK OUT HERE....
      
         $id = $this->request->getParam('rmsdownload_id');
         
         $download_request  = $this->_rmsDownloadRepository->get($id);
          
         #print_r($download_request->getRmsInteraction());
      
        $hasListComplied = $this->_apiRequest->getDownloadResponse($download_request->getRmsInteraction());
      
        if($hasListComplied) {
              
              $this->_apiRequest->downloadGz()->updateInventory();
          
        }
           
         #$faq = $this->faqsRepository->getById($id);

        #$this->_redirect($this->redirectUrl);
      
      /* 
      # Put in redirect with message
      # update download with infomation based on ID
      #   - Load Donwload Result Module and Update class
      # Check on time of 
      */
      
      
      
    }
}


<?php


namespace Neon\Rms\Controller\Adminhtml\RmsDownload;

use Magento\Framework\Exception\LocalizedException;


/**
 * Class Index
 *
 * @package Neon\Rms\Controller\Adminhtml\RmsDownload
 */
class DownloadRequest extends \Magento\Backend\App\Action
{

    protected $_downloadRequest;
  
    protected $resultPageFactory;
  
    protected $redirectUrl = 'neon_rms/rmsdownload/index';
  

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
       \Neon\Rms\Model\ApiRequest\DownloadRequest $downloadRequest,
      \Neon\Rms\Model\GetLatestDownloadRequest $getLatestRequests
    ) {
        
        parent::__construct($context);
      
        $this->resultPageFactory = $resultPageFactory;
      
        $this->_downloadRequest = $downloadRequest;
      
        $this->_getLatestRequests  = $getLatestRequests;
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
      
      /*
      * $this->_downloadRequest->call() 
      * BUT NEED ANOTHER FUNCTION THAT DOSE NOT DO ALL THAT CALL IS DOING
      * SEE \Neon\Rms\Model\ApiRequest\DownloadRequest $downloadRequest
      */
      
        $this->_getLatestRequests->cleanUpOldRequest();
      
        $this->_downloadRequest->makeRequest();
      
        $this->messageManager->addSuccess(__('Download Request was sent to RMS. Please come back in 5-10 mintues for full response and update.'));
     
       $this->_redirect($this->redirectUrl);
      
    }
}


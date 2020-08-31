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
       \Neon\Rms\Model\ApiRequest\DownloadRequest $downloadRequest
    ) {
        
        parent::__construct($context);
      
        $this->resultPageFactory = $resultPageFactory;
      
        $this->_downloadRequest = $downloadRequest;
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
      
        $this->_downloadRequest->makeRequest();
     
       $this->_redirect($this->redirectUrl);
      
    }
}


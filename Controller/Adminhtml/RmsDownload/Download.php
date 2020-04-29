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
class Download extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
  
    protected $redirectUrl = 'neon_rms/rmsdownload/index';
  
    /**
     * @var Shell
     */
    private $shell;

    /**
     * @var PhpExecutableFinder
     */
    private $phpExecutableFinder;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Shell $shell,
        PhpExecutableFinder $phpExecutableFinder,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        
        parent::__construct($context);
      
        $this->resultPageFactory = $resultPageFactory;
        $this->phpExecutableFinder = $phpExecutableFinder;
        $this->shell = $shell;
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
      
        $phpPath = $this->phpExecutableFinder->find() ?: 'php';
      
        try {
            $this->shell->execute($phpPath . ' %s neon_rms:downloadrms &', [BP . '/bin/magento']);
            $this->messageManager->addSuccessMessage(__('Download is Finshed'));
        } catch (LocalizedException $e) {
            $this->messageManager->addNoticeMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
      
  
       $this->_redirect($this->redirectUrl);
      
    }
}


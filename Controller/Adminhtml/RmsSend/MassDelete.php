<?php


namespace Neon\Rms\Controller\Adminhtml\RmsSend;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\Result\JsonFactory;
use Neon\Rms\Model\ResourceModel\RmsSend\CollectionFactory;




class MassDelete extends \Magento\Backend\App\Action
{
  
  
    const ADMIN_RESOURCE = 'Neon_Rms::top_level';
  
  
  
     /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
  
  
  
 public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }
  
  

    public function execute()
    {
        $this->filter->applySelectionOnTargetProvider();

        /** @var Collection $collection */
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $deletedJobs = 0;
      
      
       if ($collection->count() > 0) {
            try {
                foreach ($collection->getItems() as $job) {
                    $job->delete();
                    $deletedJobs++;
                }

                $this->messageManager->addSuccessMessage(
                    __('%1 task(s) has been successfully deleted', $deletedJobs)
                );

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error has occurred'));
                
            }
        }

        $this->_redirect($this->_redirect->getRefererUrl());
      

    }
  
  
    /**
   * @return bool
    */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Neon_Rms::mass_delete');
    }
  
  
      
}

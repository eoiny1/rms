<?php 

namespace Neon\Rms\Ui\Component\Listing\Column;


use Magento\Ui\Component\Listing\Columns\Column;


class Downloadstatus extends Column
{
   
   /**
     * Frequencies
     */
    const STATUS_PENDING  =  0;
    const STATUS_FINISHED  =  1;
    const STATUS_ERROR = 2;
    const STATUS_FAILED =  3;
  
  
   
 
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

  
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                             
                $item['status'] = $this->getStatus($item['status']);
            }
        }
 
        return $dataSource;

    }



    /**
     * Prepare frequency options.
     *
     * 
     */
    public function getStatus($num) {
       
        if(self::STATUS_PENDING == $num) 
            return 'Pending';
            
          if(self::STATUS_FINISHED == $num)
              return 'Finished';
           
          if(self::STATUS_FAILED == $num) 
              return 'Failed';
           
          if(self::STATUS_ERROR == $num)
              return 'Error';
      
      
        return $num;
       
    }
 
  
  
  
}
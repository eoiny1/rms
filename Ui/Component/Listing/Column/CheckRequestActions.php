<?php 

namespace Neon\Rms\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;


class CheckRequestActions extends Column {
  
  
   public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
  
  
   /**
     * Add edit action to grid.
     *
     * @param mixed[] $dataSource
     * @return mixed[]
     */
    public function prepareDataSource(array $dataSource)
    {
       
       if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

       foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['rmsdownload_id'])) {
                $name = $this->getData('name');
                $item[$name]['checkrequest'] = [
                    'href' => $this->context->getUrl('neon_rms/rmsdownload/checkrequest', ['rmsdownload_id' => $item['rmsdownload_id']]),
                    'label' => __('Check Request')
                ];
            }
        }

        return $dataSource;
      
      
      

        return parent::prepareDataSource($dataSource);
    }
  
  

  
}





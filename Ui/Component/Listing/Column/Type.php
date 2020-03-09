<?php 

namespace Neon\Rms\Ui\Component\Listing\Column;

use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;


class Type implements SourceInterface, OptionSourceInterface
{
   
   /**
     * Frequencies
     */
    const SENDTYPE_ORDER     =  1;
    const SENDTYPE_CREDITMEMO     =  2;



    /**
     * Prepare frequency options.
     *
     * @return array
     */
    public function getSendType()
    {
        return [
            self::SENDTYPE_ORDER     => __('Order'),
            self::SENDTYPE_CREDITMEMO  => __('Credit Memo'),
        ];
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions() {
        $result = [];

        foreach ($this->getSendType() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * Retrieve Option value text
     *
     * @param string $value
     * @return mixed
     */
    public function getOptionText($value) {
        $options = $this->getSendType();

        return isset($options[$value]) ? $options[$value] : null;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray() {
        return $this->getAllOptions();
    }
  
  
  
  
}
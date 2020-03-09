<?php 

namespace Neon\Rms\Ui\Component\Listing\Column;

use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;


class Status implements SourceInterface, OptionSourceInterface
{
   
   /**
     * Frequencies
     */
    const STATUS_NOTSENT  =  0;
    const STATUS_PARTIAL_SENT  =  1;
    const STATUS_SENT =  2;
    const STATUS_ERROR =  3;


    /**
     * Prepare frequency options.
     *
     * @return array
     */
    public function getSendStatus()
    {
        return [
            self::STATUS_NOTSENT     => __('Not Sent'),
            self::STATUS_PARTIAL_SENT  => __('Partially Sent'),
            self::STATUS_SENT     => __('Sent'),
            self::STATUS_ERROR  => __('Error Sending'),
        ];
      
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions() {
        $result = [];

        foreach ($this->getSendStatus() as $index => $value) {
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
        $options = $this->getSendStatus();

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
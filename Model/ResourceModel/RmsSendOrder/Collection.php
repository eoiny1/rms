<?php


namespace Neon\Rms\Model\ResourceModel\RmsSendOrder;

/**
 * Class Collection
 *
 * @package Neon\Rms\Model\ResourceModel\RmsSendOrder
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'rmssendorder_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Neon\Rms\Model\RmsSendOrder::class,
            \Neon\Rms\Model\ResourceModel\RmsSendOrder::class
        );
    }
}


<?php


namespace Neon\Rms\Model\ResourceModel\RmsSend;

/**
 * Class Collection
 *
 * @package Neon\Rms\Model\ResourceModel\RmsSend
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'rmssend_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Neon\Rms\Model\RmsSend::class,
            \Neon\Rms\Model\ResourceModel\RmsSend::class
        );
    }
}


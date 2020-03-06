<?php


namespace Neon\Rms\Model\ResourceModel\RmsSendCr;

/**
 * Class Collection
 *
 * @package Neon\Rms\Model\ResourceModel\RmsSendCr
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'rmssendcr_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Neon\Rms\Model\RmsSendCr::class,
            \Neon\Rms\Model\ResourceModel\RmsSendCr::class
        );
    }
}


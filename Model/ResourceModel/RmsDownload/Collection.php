<?php


namespace Neon\Rms\Model\ResourceModel\RmsDownload;

/**
 * Class Collection
 *
 * @package Neon\Rms\Model\ResourceModel\RmsDownload
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'rmsdownload_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Neon\Rms\Model\RmsDownload::class,
            \Neon\Rms\Model\ResourceModel\RmsDownload::class
        );
    }
}


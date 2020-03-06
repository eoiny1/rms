<?php


namespace Neon\Rms\Model\ResourceModel;

/**
 * Class RmsDownload
 *
 * @package Neon\Rms\Model\ResourceModel
 */
class RmsDownload extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('neon_rms_rmsdownload', 'rmsdownload_id');
    }
}


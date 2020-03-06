<?php


namespace Neon\Rms\Model\ResourceModel;

/**
 * Class RmsSendCr
 *
 * @package Neon\Rms\Model\ResourceModel
 */
class RmsSendCr extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('neon_rms_rmssendcr', 'rmssendcr_id');
    }
}


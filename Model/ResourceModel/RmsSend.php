<?php


namespace Neon\Rms\Model\ResourceModel;

/**
 * Class RmsSend
 *
 * @package Neon\Rms\Model\ResourceModel
 */
class RmsSend extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('neon_rms_rmssend', 'rmssend_id');
    }
}


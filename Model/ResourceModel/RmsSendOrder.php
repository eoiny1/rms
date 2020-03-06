<?php


namespace Neon\Rms\Model\ResourceModel;

/**
 * Class RmsSendOrder
 *
 * @package Neon\Rms\Model\ResourceModel
 */
class RmsSendOrder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('neon_rms_rmssendorder', 'rmssendorder_id');
    }
}


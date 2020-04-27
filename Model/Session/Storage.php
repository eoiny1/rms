<?php
namespace Neon\Rms\Model\Session;

class Storage extends \Magento\Framework\Session\Storage
{
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $namespace
     * @param array $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $namespace = 'sessionname',
        array $data = []
    ) {
        parent::__construct($namespace, $data);
    }
}
<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class SendOrder
{

    protected $logger;

    protected $_packageOrder;

    protected $_config;  
  
  
    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Model\Package\PackageOrder $packageOrder,
      \Neon\Rms\Helper\Config $config
      )
    {
        $this->logger = $logger;
        $this->_packageOrder = $packageOrder;
        $this->_config = $config;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
       #$this->logger->addInfo("Cronjob SendOrder is executed.");
      
      if($this->_config->isRmsSendOrder()) {
        $this->_packageOrder->getOrdersToSend()
        ->sendOrderItems();
      }
      
    }
}

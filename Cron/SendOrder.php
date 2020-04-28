<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class SendOrder
{

    protected $logger;

   protected $_packageOrder;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Model\Package\PackageOrder $packageOrder
      )
    {
        $this->logger = $logger;
        $this->_packageOrder = $packageOrder;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
       #$this->logger->addInfo("Cronjob SendOrder is executed.");
      
      $this->_packageOrder->getOrdersToSend()
      ->sendOrderItems();
      
    }
}

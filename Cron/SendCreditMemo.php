<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class SendCreditMemo
{

    protected $logger;
  
    protected $_packageCreditMemo;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Model\Package\PackageCreditMemo $packageCreditMemo
      )
    {
        $this->logger = $logger;
        $this->_packageCreditMemo = $packageCreditMemo;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
       #$this->logger->addInfo("Cronjob SendCreditMemo is executed.");
      
      $this->_packageCreditMemo->getCreditMemoToSend()
      ->sendCreditMemo();
      
    }
}

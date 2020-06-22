<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class SendCreditMemo
{

    protected $logger;
  
    protected $_packageCreditMemo;
  
    protected $_config;  

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Model\Package\PackageCreditMemo $packageCreditMemo,
       \Neon\Rms\Helper\Config $config
      )
    {
        $this->logger = $logger;
        $this->_packageCreditMemo = $packageCreditMemo;
        $this->_config = $config;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
       #$this->logger->addInfo("Cronjob SendCreditMemo is executed.");
      
      if($this->_config->isRmsSendCredit()) {
        $this->_packageCreditMemo->getCreditMemoToSend()
        ->sendCreditMemo();
      }
      
    }
}

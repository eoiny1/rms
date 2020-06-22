<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class FtpDownload
{

    protected $logger;
 
    protected $_config;
  
    protected $_connectNeonDb;
  

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Helper\Config $config,
       \Neon\Rms\Model\ConnectNeonDb $downloadRequest
      )
    {
        $this->_connectNeonDb = $downloadRequest;
        $this->logger = $logger;
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
      
      if($this->_config->getEnableFtpCron()) {
        $this->_connectNeonDb->getLatestFile()->createInventoryArray()->updateInventory();
      }
      
    }
}

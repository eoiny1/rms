<?php declare(strict_types=1);


namespace Neon\Rms\Cron;


class GetDownloadRequest
{

    protected $logger;
 
    protected $_config;
  
    protected $_getLatestDownloadRequest;
  

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
      \Psr\Log\LoggerInterface $logger,
       \Neon\Rms\Helper\Config $config,
       \Neon\Rms\Model\GetLatestDownloadRequest $getLatestDownloadRequest
      )
    {

        $this->_getLatestDownloadRequest = $getLatestDownloadRequest;
        $this->logger = $logger;
        $this->_config = $config;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute() {
      
      #$this->logger->addInfo("Download Request Asked For...");
      
      $this->_getLatestDownloadRequest->updateFromLatestRequest();
    
      
    }
}

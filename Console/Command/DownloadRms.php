<?php declare(strict_types=1);


namespace Neon\Rms\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class DownloadRms extends Command
{

    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";
    
    protected $_downloadRequest;
  
    protected $_timer;
  
    protected $_rmsDownloadRepositoryInterface;
  
    protected $_session;
 
  
  /**
     * Delete constructor.
     * @param null $name
     */
    public function __construct(
        \Neon\Rms\Model\ApiRequest\DownloadRequest $downloadRequest,
        \Neon\Rms\Helper\Timer $timer,
        \Neon\Rms\Api\RmsDownloadRepositoryInterface $rmsDownloadRepositoryInterface,
        \Neon\Rms\Model\Session $session,
        $name = null
    ) {
      
        $this->_session = $session;

        $this->_downloadRequest = $downloadRequest;
        $this->_rmsDownloadRepositoryInterface = $rmsDownloadRepositoryInterface;
        $this->_timer = $timer;

        //TRUN ON LOCK
        $this->_session->setData('download_lock',true);
      
        $this->_timer->start();
        
        parent::__construct($name);
    }
  

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $name = $input->getArgument(self::NAME_ARGUMENT);
        $option = $input->getOption(self::NAME_OPTION);
        #$output->writeln("Hello " . $name);
        $output->writeln("Started \n ");
        
        $this->_downloadRequest->call()
           ->downloadGz()
           ->updateInventory()
           ->updatePriceAndCost();
           #->getRmsDownloadInterface();
      
      
        $this->registerDownload();
      
        //TRUN OFF LOCK
        $this->_session->setData('download_lock');
      
        
       $output->writeln("ended \n ");

    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("neon_rms:downloadrms");
        $this->setDescription("Download From RMS");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }
  
  
  
  /**
  *
  */
  protected function registerDownload() {
    
    $this->_timer->stop();
    
    $rmsDownloadInterface = $this->_downloadRequest->getRmsDownloadInterface();
    
     $rmsDownloadInterface->setStatus(1);
     $rmsDownloadInterface->setDownloadTime($this->_timer->getElapsedTime());
     
    $this->_rmsDownloadRepositoryInterface->save($rmsDownloadInterface);
    
    
  }
  
  
  
}
<?php declare(strict_types=1);


namespace Neon\Rms\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class DownloadFtp extends Command
{

    const NAME_ARGUMENT = "name";
    const NAME_OPTION = "option";
    
    protected $_connectNeonDb;
 
  
  /**
     * Delete constructor.
     * @param null $name
     */
    public function __construct(
        \Neon\Rms\Model\ConnectNeonDb $downloadRequest,
        $name = null
    ) {
      


        $this->_connectNeonDb = $downloadRequest;


        
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
        
        $this->_connectNeonDb->getLatestFile()->createInventoryArray()->updateInventory();
           #->getRmsDownloadInterface();
      
    
        
       $output->writeln("ended \n ");

    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("neon_rms:downloadftp");
        $this->setDescription("Download From FTP");
        $this->setDefinition([
            new InputArgument(self::NAME_ARGUMENT, InputArgument::OPTIONAL, "Name"),
            new InputOption(self::NAME_OPTION, "-a", InputOption::VALUE_NONE, "Option functionality")
        ]);
        parent::configure();
    }
  
  
  

  
  
}
<?php


namespace Neon\Rms\Helper;

use Magento\Framework\App\Helper\AbstractHelper;




/**
 * Class Config
 *
 * @package Neon\Rms\Helper
 */
class Timer extends AbstractHelper
{
  
  	private $start_time;
		private $stop_time;	

  

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
      
        parent::__construct($context);
      
        date_default_timezone_set('UTC');
    }
  
  
  	// Set start time
		public function start() {
			$this->start_time = microtime(true);
		}
 
		// Set stop/end time
		public function stop() {
			$this->stop_time = microtime(true);
		}
	
	
	 // Returns time elapsed from start
		public function getElapsedTime() {
			return $this->getExecutionTime(microtime(true));
		}
		
	
		// Get execution time by timestamp
		private function getExecutionTime($time) {
			return $time - $this->start_time;
		}
  
  
  
 
  
}


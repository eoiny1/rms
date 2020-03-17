<?php
/**
 * @author Vendor
 * @copyright Copyright (c) 2019 Vendor (https://www.vendor.com/)
 */
namespace Neon\Rms\Logger\Handler;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger as MonologLogger;

/**
 * Class InfoHandler
 */
class InfoHandler extends BaseHandler
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = MonologLogger::INFO;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/rms_info.log';
}
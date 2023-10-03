<?php
namespace drilonnikci\PhpSalesforceApi\traits;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

trait LoggerTrait
{
    public function getLogger(): Logger
    {
        static $logger;
        if (!$logger) {
            $logger = new Logger('SalesforceLogger');
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/salesforce.log', Level::Info));
            $logger->pushHandler(new FirePHPHandler());
        }

        return $logger;
    }
}

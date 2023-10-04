<?php
namespace drilonnikci\PhpSalesforceApi\traits;

use Monolog\Formatter\LineFormatter;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

trait LoggerTrait
{
    public function getLogger(): Logger
    {
        static $logger;

        if (!$logger) {
            $logger = new Logger('SalesforceLogger');
            $stream = new StreamHandler(__DIR__.'/../logs/salesforce.log', Level::Debug);

            $dateFormat = "d/m/Y, h:i:s A"; // Change the date format
            $output = "%datetime% > %level_name%: %message% %context% %extra%\n";
            $formatter = new LineFormatter($output, $dateFormat);

            $stream->setFormatter($formatter);
            $logger->pushHandler($stream);
        }

        return $logger;
    }
}

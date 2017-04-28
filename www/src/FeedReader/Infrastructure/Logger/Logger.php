<?php

namespace FeedReader\Infrastructure\Logger;

use Monolog\Logger as BaseLogger;

/**
 * Class Logger
 * @package FeedReader\Infrastructure\Logger
 */
class Logger extends BaseLogger implements LoggerInterface
{
    public function __construct($name, $handlers, $processors)
    {
        parent::__construct($name, $handlers, $processors);
    }
}
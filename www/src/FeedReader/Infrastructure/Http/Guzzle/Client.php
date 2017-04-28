<?php

namespace FeedReader\Infrastructure\Http\Guzzle;

use GuzzleHttp\Client as BaseClient;

/**
 * Class Client
 * @package FeedReader\Infrastructure\HTTPClient
 */
class Client extends BaseClient implements ClientInterface
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }
}
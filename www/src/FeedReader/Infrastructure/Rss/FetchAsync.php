<?php

namespace FeedReader\Infrastructure\Rss;

use FeedReader\Infrastructure\Http\Guzzle\ClientInterface
    , FeedReader\Infrastructure\Logger\LoggerInterface
    , GuzzleHttp\Pool
    , GuzzleHttp\Psr7\Request;

/**
 * Class FetchAsync
 * @package FeedReader\Infrastructure\Rss
 */
class FetchAsync implements FetchAsyncInterface
{
    const DEFAULT_CONCURRENCY = 5;

    /**
     * @var ClientInterface
     */
    protected $client;

    protected $logger;

    /**
     * @var array
     */
    protected $listUrl;

    /**
     * @var integer
     */
    protected $concurrency;

    public function __construct(
        ClientInterface $client
        ,  $logger
        , $listUrl
        , array $options = []
    )
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->setListUrl($listUrl);
        $this->setConcurrency($options);
    }

    /**
     * @return array
     */
    public function fetch()
    {
        $logger = $this->logger;
        $listUrl = $this->listUrl;
        $results = [];
        $pool = new Pool(
            $this->client
            , $this->urlGenerator()
            , [
                'concurrency' => $this->concurrency
                , 'fulfilled' => function ($v, $k) use ($logger, $listUrl, &$results) {
                    $url = $listUrl[$k];
                    $results[$url] = $v;
                    $logger->info("Retrieved content from url: $url");
                }
                , 'rejected' => function ($v, $k) use ($logger, $listUrl, &$results) {
                    $url = $listUrl[$k];
                    $results[$url] = $v;
                    $reason = $v->getMessage();
                    $logger->info("Can't retrieve content from $url with error: {$reason}");
                }
            ]
        );
        $pool->promise()->wait();

        return $results;
    }

    /**
     * @return \Generator
     */
    protected function urlGenerator()
    {
        for ($i = 0; $i < count($this->listUrl); $i++) {
            $url = $this->listUrl[$i];
            yield new Request(
                'GET'
                , $url
            );
        }
    }

    /**
     * @param $listUrl
     */
    protected function setListUrl($listUrl)
    {
        $this->listUrl = $listUrl;
    }

    /**
     * @param array $options
     */
    protected function setConcurrency(array $options)
    {
        $this->concurrency = isset($options['concurrency']) ? $options['concurrency'] : self::DEFAULT_CONCURRENCY;
    }
}
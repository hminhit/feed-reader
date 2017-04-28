<?php
namespace FeedReader\Application\CommandHandler;

use FeedReader\Domain\Exception\ParserException;
use FeedReader\Domain\Model\Feed\FeedChannelRepository
    , FeedReader\Infrastructure\Http\Guzzle\ClientInterface
    , FeedReader\Infrastructure\Logger\Monolog\RetrieveFeedFromUrlLogger
    , FeedReader\Application\Command\RetrieveFeedFromUrlCommand
    , FeedReader\Infrastructure\Rss\FetchAsync
    , FeedReader\Infrastructure\Rss\Parser\SimpleXMLElementParser
    , FeedReader\Domain\Exception\ChannelInsertBulkException;
use FeedReader\Infrastructure\Logger\LoggerInterface;

class RetrieveFeedFromUrlCommandHandler
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var RetrieveFeedFromUrlLogger
     */
    protected $logger;

    /**
     * @var FeedChannelRepository
     */
    protected $feedChannelRepository;

    /**
     * RetrieveFeedFromUrlCommandHandler constructor.
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     * @param FeedChannelRepository $feedChannelRepository
     */
    public function __construct(
        ClientInterface $client
        , LoggerInterface  $logger
        , FeedChannelRepository $feedChannelRepository
    )
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->feedChannelRepository = $feedChannelRepository;
    }

    /**
     * @param RetrieveFeedFromUrlCommand $command
     * @throws ChannelInsertBulkException
     * @throws ParserException
     */
    public function handle(RetrieveFeedFromUrlCommand $command)
    {
        try {
            $rssParser = new SimpleXMLElementParser(
                new FetchAsync(
                    $this->client
                    , $this->logger
                    , $command->listUrl()
                )
                , $this->logger
            );
            $rssParser->parse();
        } catch (\Exception $e) {
            throw new ParserException($e->getMessage());
        }
        try {
            $this->feedChannelRepository->insertBulk($rssParser->feedChannel());
        } catch (\Exception $e) {
            throw new ChannelInsertBulkException($e->getMessage());
        }

    }
}
<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\RetrieveFeedFromUrlCommand
    , FeedReader\Application\CommandHandler\RetrieveFeedFromUrlCommandHandler;

class RetrieveFeedFromUrlCommandHandlerTest extends WebTestCase
{
    protected static $container;
    protected static $logger;
    protected static $client;
    protected static $feedChannelRepo;

    public static function setUpBeforeClass()
    {
        //start the symfony kernel
        $kernel = static::createKernel();
        $kernel->boot();
        //get the DI container
        self::$container = $kernel->getContainer();
        self::$client = new \FeedReader\Infrastructure\Http\Guzzle\Client([]);
        self::$logger = new \FeedReader\Infrastructure\Logger\Monolog\RetrieveFeedFromUrlLogger(
            self::$container->get('monolog.logger.retrieve_feed_from_url')->getName()
            , self::$container->get('monolog.logger.retrieve_feed_from_url')->getHandlers()
            , self::$container->get('monolog.logger.retrieve_feed_from_url')->getProcessors()
        );
        self::$feedChannelRepo = self::$container
            ->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository');
    }

    /**
     * Test Feed Url are missing or empty
     */
    public function testFeedUrlAreMissingOrEmpty()
    {
        $listUrlStr = '';
        try {
            $retrieveFeedFromUrlCommandHandler = $this->retrieveFeedFromUrlCommandHandler();
            $retrieveFeedFromUrlCommandHandler->handle(
                new RetrieveFeedFromUrlCommand($listUrlStr)
            );
        } catch (\InvalidArgumentException $e) {
            $this->assertContains('The list feed url cannot be empty.', $e->getMessage());
        }
    }

    /**
     * Test Feed Url are wrong url format
     */
    public function testFeedUrlAreWrongUrlFormat()
    {
        $listUrlStr = 'abc';
        try {
            $retrieveFeedFromUrlCommandHandler = $this->retrieveFeedFromUrlCommandHandler();
            $retrieveFeedFromUrlCommandHandler->handle(
                new RetrieveFeedFromUrlCommand($listUrlStr)
            );
        } catch (Assert\InvalidArgumentException $e) {
            $this->assertContains(
                'Value "abc" was expected to be a valid URL starting with http or https'
                , $e->getMessage()
            );
        }
    }

    /**
     * @return \FeedReader\Application\CommandHandler\RetrieveFeedFromUrlCommandHandler
     */
    protected function retrieveFeedFromUrlCommandHandler()
    {
        $retrieveFeedFromUrlCommandHandler = new RetrieveFeedFromUrlCommandHandler(
            self::$client
            , self::$logger
            , self::$feedChannelRepo
        );

        return $retrieveFeedFromUrlCommandHandler;
    }


}
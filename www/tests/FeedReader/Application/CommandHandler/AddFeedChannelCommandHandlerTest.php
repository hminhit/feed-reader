<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\AddFeedChannelCommand
    , FeedReader\Application\CommandHandler\AddFeedChannelCommandHandler;

class AddFeedChannelCommandHandlerTest extends WebTestCase
{
    protected static $container;
    protected static $feedChannelRepo;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        self::$container = $kernel->getContainer();
        self::$feedChannelRepo = self::$container
            ->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository');
    }

    /**
     * Test handle of AddFeedChannelCommandHandler
     */
    public function testHandle()
    {
        $addFeedChannelCommandHandler = $this->addFeedChannelCommandHandler();
        $feedChannelAdded = $addFeedChannelCommandHandler->handle(
            new AddFeedChannelCommand(
                'Test handle of AddFeedChannelCommandHandler'
                , 'https://validator.w3.org/feed/docs/rss2.html'
                , 'Test handle of AddFeedChannelCommandHandler'
                , []
                , []
            )
        );
        $feedChannel = self::$feedChannelRepo->byId($feedChannelAdded->id());
        $this->assertTrue($feedChannelAdded->id()->equals($feedChannel->id()));

    }

    /**
     * @return AddFeedChannelCommandHandler
     */
    protected function addFeedChannelCommandHandler()
    {
        $addFeedChannelCommandHandlerTest = new AddFeedChannelCommandHandler(
            self::$feedChannelRepo
        );

        return $addFeedChannelCommandHandlerTest;
    }

    /**
     * Add a channel for testing
     *
     * @return \FeedReader\Domain\Model\Feed\FeedChannel
     */
    protected function addChannel()
    {
        $feedChannel = new FeedReader\Domain\Model\Feed\FeedChannel(
            new \FeedReader\Domain\Model\Feed\FeedChannelId()
        );
        $feedChannel->compose(
            'channel title test'
            , 'https://validator.w3.org/feed/docs/rss2.html'
            , 'channel description test'
            , new \Doctrine\Common\Collections\ArrayCollection()
            , new \Doctrine\Common\Collections\ArrayCollection()
        );
        self::$feedChannelRepo->save($feedChannel);

        return $feedChannel;
    }
}
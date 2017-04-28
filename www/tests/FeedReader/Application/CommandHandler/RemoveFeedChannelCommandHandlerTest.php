<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\RemoveFeedChannelCommand
    , FeedReader\Application\CommandHandler\RemoveFeedChannelCommandHandler
    , FeedReader\Domain\Exception\FeedChannelDoesNotExistException;

class RemoveFeedChannelCommandHandlerTest extends WebTestCase
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
     * Test Channel Does not Empty
     */
    public function testChannelDoestNotEmpty()
    {
        try {
            $removeFeedChannelCommandHandlerTest = $this->removeFeedChannelCommandHandler();
            $removeFeedChannelCommandHandlerTest->handle(
                new RemoveFeedChannelCommand('id-not-exist-in-db')
            );
        } catch (FeedChannelDoesNotExistException $e) {
            $this->assertContains('The channel does not exist.', $e->getMessage());
        }
    }

    /**
     * Test handle of RemoveFeedChannelCommandHandler
     */
    public function testHandle()
    {
        $feedChannelAdded = $this->addChannel();
        $removeFeedChannelCommandHandler = $this->removeFeedChannelCommandHandler();
        $removeFeedChannelCommandHandler->handle(
            new RemoveFeedChannelCommand($feedChannelAdded->id()->id())
        );
        $feedChannel = self::$feedChannelRepo->byId($feedChannelAdded->id());
        $this->assertNull($feedChannel);
    }

    /**
     * @return \FeedReader\Application\CommandHandler\RemoveFeedChannelCommandHandler
     */
    protected function removeFeedChannelCommandHandler()
    {
        $removeFeedChannelCommandHandlerTest = new RemoveFeedChannelCommandHandler(
            self::$feedChannelRepo
        );

        return $removeFeedChannelCommandHandlerTest;
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
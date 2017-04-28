<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\CheckFeedChannelExistCommand
    , FeedReader\Application\CommandHandler\CheckFeedChannelExistCommandHandler
    , FeedReader\Domain\Model\Feed\FeedChannelId;

class CheckFeedChannelExistCommandHandlerTest extends WebTestCase
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

    public function testCheckFeedChannelIfExist()
    {
        $feedChannelAdded = $this->addChannel();
        $checkFeedChannelExistCommandHandler = $this->checkFeedChannelExistCommandHandler();
        $feedChannel = $checkFeedChannelExistCommandHandler->handle(
            new CheckFeedChannelExistCommand($feedChannelAdded->id())
        );
        $this->assertTrue($feedChannelAdded->id()->equals($feedChannel->id()));

    }

    public function testCheckFeedChannelIfDoesNotExist()
    {
        try {
            $feedChannelId = new FeedChannelId();
            $checkFeedChannelExistCommandHandler = $this->checkFeedChannelExistCommandHandler();
            $feedChannel = $checkFeedChannelExistCommandHandler->handle(
                new CheckFeedChannelExistCommand($feedChannelId)
            );
        } catch (\FeedReader\Domain\Exception\FeedChannelDoesNotExistException $e) {
            $this->assertContains('The channel does not exist.', $e->getMessage());
        }
    }

    /**
     * @return CheckFeedChannelExistCommandHandler
     */
    protected function checkFeedChannelExistCommandHandler()
    {
        $checkFeedChannelExistCommandHandler = new CheckFeedChannelExistCommandHandler(
            self::$feedChannelRepo
        );

        return $checkFeedChannelExistCommandHandler;
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
<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditFeedChannelCommandHandlerTest extends WebTestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        //start the symfony kernel
        $kernel = static::createKernel();
        $kernel->boot();
        //get the DI container
        self::$container = $kernel->getContainer();
    }

    public function testHandle()
    {
        $feedChannelAdded = $this->addChannel();
        $editFeedChannelCommandHandler = $this->editFeedChannelCommandHandler();
        $feedChannelEdited = $editFeedChannelCommandHandler->handle(
            new \FeedReader\Application\Command\EditFeedChannelCommand(
                $feedChannelAdded->id()
                , $feedChannelAdded
                , 'channel title 2'
                , $feedChannelAdded->channelLink()
                , $feedChannelAdded->channelDescription()
                , []
                , []
            )
        );
        $this->assertContains($feedChannelEdited->channelTitle(), $feedChannelAdded->channelTitle());
    }

    protected function editFeedChannelCommandHandler()
    {
        $editFeedChannelCommandHandler = new \FeedReader\Application\CommandHandler\EditFeedChannelCommandHandler(
            self::$container->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')
        );

        return $editFeedChannelCommandHandler;
    }

    protected function addChannel()
    {
        $feedChannel = new FeedReader\Domain\Model\Feed\FeedChannel(
            new \FeedReader\Domain\Model\Feed\FeedChannelId()
        );
        $feedChannel->compose(
            'channel title 1'
            , 'https://validator.w3.org/feed/docs/rss2.html'
            , 'channel description 1'
            , new \Doctrine\Common\Collections\ArrayCollection()
            , new \Doctrine\Common\Collections\ArrayCollection()
        );
        self::$container->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')->save($feedChannel);

        return $feedChannel;
    }
}
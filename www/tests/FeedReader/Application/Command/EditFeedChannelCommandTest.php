<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\EditFeedChannelCommand
    , FeedReader\Domain\Model\Feed\FeedChannelId
    , FeedReader\Domain\Model\Feed\FeedChannel;

class EditFeedChannelCommandTest extends WebTestCase
{
    public function testGetter()
    {
        $feedChannelId = new FeedChannelId();
        $existingFeedChannel = new FeedChannel($feedChannelId);
        $channelTitle = 'test channel title';
        $channelDescription = 'test channel description';
        $channelLink = 'https://validator.w3.org/feed/docs/rss2.html';
        $channelCategory = [];
        $channelItem = [];
        $editFeedChannelCommand = new EditFeedChannelCommand(
            $feedChannelId
            , $existingFeedChannel
            , $channelTitle
            , $channelLink
            , $channelDescription
            , $channelCategory
            , $channelItem
        );
        $this->assertTrue($feedChannelId->equals($editFeedChannelCommand->feedChannelId()));
        $this->assertEquals($existingFeedChannel, $editFeedChannelCommand->existingFeedChannel());
        $this->assertContains($channelTitle, $editFeedChannelCommand->channelTitle());
        $this->assertContains($channelDescription, $editFeedChannelCommand->channelDescription());
        $this->assertContains($channelLink, $editFeedChannelCommand->channelLink());
        $this->assertEquals($channelCategory, $editFeedChannelCommand->channelCategory());
        $this->assertEquals($channelItem, $editFeedChannelCommand->channelItem());

    }
}
<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\AddFeedChannelCommand;

class AddFeedChannelCommandTest extends WebTestCase
{
    public function testGetter()
    {
        $channelTitle = 'test channel title';
        $channelDescription = 'test channel description';
        $channelLink = 'https://validator.w3.org/feed/docs/rss2.html';
        $channelCategory = [];
        $channelItem = [];
        $addFeedChannelCommand = new AddFeedChannelCommand(
            $channelTitle
            , $channelLink
            , $channelDescription
            , $channelCategory
            , $channelItem
        );
        $this->assertContains($channelTitle, $addFeedChannelCommand->channelTitle());
        $this->assertContains($channelDescription, $addFeedChannelCommand->channelDescription());
        $this->assertContains($channelLink, $addFeedChannelCommand->channelLink());
        $this->assertEquals($channelCategory, $addFeedChannelCommand->channelCategory());
        $this->assertEquals($channelItem, $addFeedChannelCommand->channelItem());

    }
}
<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\RemoveFeedChannelCommand;

class CheckFeedChannelExistCommandTest extends WebTestCase
{
    public function testSetFeedChannelIdIfEmpty()
    {
        try {
            $retrieveFeedFromUrlCommand = new RemoveFeedChannelCommand('');
        } catch (Assert\InvalidArgumentException $e) {
            $this->assertContains(
                'Value "" is blank, but was expected to contain a value'
                , $e->getMessage()
            );
        }
    }

    public function testGetter()
    {
        $feedChannelId = 'feed-channel-id-test';
        $retrieveFeedFromUrlCommand = new RemoveFeedChannelCommand($feedChannelId);
        $this->assertContains($feedChannelId, $retrieveFeedFromUrlCommand->feedChannelId());
    }
}
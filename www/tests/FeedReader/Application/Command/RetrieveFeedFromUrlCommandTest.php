<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase
    , FeedReader\Application\Command\RetrieveFeedFromUrlCommand;

class RetrieveFeedFromUrlCommandTest extends WebTestCase
{
    public function testSetListUrlIfEmpty()
    {
        $listUrl = '';
        try {
            $retrieveFeedFromUrlCommand = new RetrieveFeedFromUrlCommand($listUrl);
        } catch (\InvalidArgumentException $e) {
            $this->assertContains('The list feed url cannot be empty.', $e->getMessage());
        }
    }

    public function testSetListUrlIfWrongUrlFormat()
    {
        $listUrl = 'abc';
        try {
            $retrieveFeedFromUrlCommand = new RetrieveFeedFromUrlCommand($listUrl);
        } catch (Assert\InvalidArgumentException $e) {
            $this->assertContains(
                'Value "abc" was expected to be a valid URL starting with http or https'
                , $e->getMessage()
            );
        }
    }

    public function testGetListUrl()
    {
        $listUrl = 'https://validator.w3.org/feed/docs/rss2.html';
        $retrieveFeedFromUrlCommand = new RetrieveFeedFromUrlCommand($listUrl);
        $this->assertContains($listUrl, $retrieveFeedFromUrlCommand->listUrl());
    }
}
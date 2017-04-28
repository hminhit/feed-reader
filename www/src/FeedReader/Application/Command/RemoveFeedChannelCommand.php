<?php
namespace FeedReader\Application\Command;

use Assert\Assertion;

/**
 * Class RemoveFeedChannelCommand
 * @package FeedReader\Application\Command
 */
class RemoveFeedChannelCommand
{
    /**
     * @var string
     */
    protected $feedChannelId;

    /**
     * RemoveFeedChannelCommand constructor.
     * @param $feedChannelId
     */
    public function __construct(
        $feedChannelId
    )
    {
        $this->setFeedChannelId($feedChannelId);
    }

    /**
     * @param $feedChannelId
     */
    protected function setFeedChannelId($feedChannelId)
    {
        Assertion::notBlank($feedChannelId);
        $this->feedChannelId = $feedChannelId;
    }

    /**
     * @return string
     */
    public function feedChannelId()
    {
        return $this->feedChannelId;
    }
}
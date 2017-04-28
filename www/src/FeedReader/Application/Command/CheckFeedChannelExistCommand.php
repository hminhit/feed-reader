<?php
namespace FeedReader\Application\Command;

use Assert\Assertion;

/**
 * Class CheckFeedChannelExistCommand
 * @package FeedReader\Application\Command
 */
class CheckFeedChannelExistCommand
{
    /**
     * @var string
     */
    protected $feedChannelId;

    /**
     * CheckFeedChannelExistCommand constructor.
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
<?php
namespace FeedReader\Application\Command;

use FeedReader\Domain\Model\Feed\FeedChannel
    , FeedReader\Domain\Model\Feed\FeedChannelId;

/**
 * Class EditFeedChannelCommand
 * @package FeedReader\Application\Command
 */
class EditFeedChannelCommand
{
    /**
     * @var FeedChannel
     */
    protected $existingFeedChannel;
    /**
     * @var FeedChannelId
     */
    protected $feedChannelId;

    /**
     * @var string
     */
    protected $channelTitle;

    /**
     * @var string
     */
    protected $channelDescription;

    /**
     * @var string
     */
    protected $channelLink;

    /**
     * @var array
     */
    protected $channelCategory;

    /**
     * @var array
     */
    protected $channelItem;

    public function __construct(
        FeedChannelId $feedChannelId
        , FeedChannel $existingFeedChannel
        , $channelTitle
        , $channelLink
        , $channelDescription
        , array $channelCategory
        , array $channelItem
    )
    {
        $this->feedChannelId = $feedChannelId;
        $this->existingFeedChannel = $existingFeedChannel;
        $this->channelTitle = $channelTitle;
        $this->channelDescription = $channelDescription;
        $this->channelLink = $channelLink;
        $this->channelCategory = $channelCategory;
        $this->channelItem = $channelItem;
    }

    /**
     * @return FeedChannelId
     */
    public function feedChannelId()
    {
        return $this->feedChannelId;
    }

    /**
     * @return string
     */
    public function channelTitle()
    {
        return $this->channelTitle;
    }

    /**
     * @return string
     */
    public function channelLink()
    {
        return $this->channelLink;
    }

    /**
     * @return string
     */
    public function channelDescription()
    {
        return $this->channelDescription;
    }

    /**
     * @return ArrayCollection
     */
    public function channelCategory()
    {
        return $this->channelCategory;
    }

    /*
     * FeedChannel
     */
    public function existingFeedChannel()
    {
        return $this->existingFeedChannel;
    }

    /**
     * @return ArrayCollection
     */
    public function channelItem()
    {
        return $this->channelItem;
    }
}
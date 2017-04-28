<?php
namespace FeedReader\Application\Command;

use Assert\Assertion;

/**
 * Class AddFeedChannelCommand
 * @package FeedReader\Application\Command
 */
class AddFeedChannelCommand
{
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

    /**
     * AddFeedChannelCommand constructor.
     * @param $channelTitle
     * @param $channelLink
     * @param $channelDescription
     * @param $channelCategory
     * @param $channelItem
     */
    public function __construct(
        $channelTitle
        , $channelLink
        , $channelDescription
        , array $channelCategory
        , array $channelItem
    )
    {
        $this->channelTitle = $channelTitle;
        $this->channelDescription = $channelDescription;
        $this->channelLink = $channelLink;
        $this->channelCategory = $channelCategory;
        $this->channelItem = $channelItem;
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

    /**
     * @return ArrayCollection
     */
    public function channelItem()
    {
        return $this->channelItem;
    }
}
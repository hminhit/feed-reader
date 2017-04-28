<?php
namespace FeedReader\Domain\Model\Feed;

use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class FeedChannelItem
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannelItem
{
    /**
     * @var FeedChannelItemId
     */
    protected $feedChannelItemId;
    /**
     * @var string
     */
    protected $itemTitle;

    /**
     * @var string
     */
    protected $itemDescription;

    /**
     * @var FeedChannel
     */
    protected $feedChannel;


    public function __construct(
        FeedChannelItemId $feedChannelItemId
        , FeedChannel $feedChannel
    )
    {
        $this->feedChannelItemId = $feedChannelItemId;
        $this->feedChannel = $feedChannel;
    }

    /**
     * @param $itemTitle
     */
    protected function setItemTitle($itemTitle)
    {
        $this->itemTitle = $itemTitle;
    }

    /**
     * @param $itemDescription
     */
    protected function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }

    /**
     * @return \FeedReader\Domain\Model\Feed\FeedChannelItemId
     */
    public function id()
    {
        return $this->feedChannelItemId;
    }

    public function feedChannelId()
    {
        return $this->feedChannelId;
    }

    /**
     * @return string
     */
    public function itemTitle()
    {
        return $this->itemTitle;
    }

    /**
     * @return string
     */
    public function itemDescription()
    {
        return $this->itemDescription;
    }

    public function compose(
        $itemTitle
        , $itemDescription
    )
    {
        $this->setItemTitle($itemTitle);
        $this->setItemDescription($itemDescription);
    }
}
<?php

namespace FeedReader\Domain\Model\Feed;

use Doctrine\Common\Collections\ArrayCollection
    , Assert\Assertion;

/**
 * Class FeedChannel
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannel
{
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
     * @var ArrayCollection
     */
    protected $channelCategory;

    /**
     * @var ArrayCollection
     */
    protected $channelItem;

    /**
     * FeedChannel constructor.
     * @param FeedChannelId $feedChannelId
     */
    public function __construct(
        FeedChannelId $feedChannelId
    )
    {
        $this->feedChannelId = $feedChannelId;
        $this->channelCategory = new ArrayCollection();
        $this->channelItem = new ArrayCollection();
    }

    /**
     * @param $channelTitle
     */
    protected function setChannelTitle($channelTitle)
    {
        Assertion::notBlank($channelTitle);
        $this->channelTitle = $channelTitle;
    }

    /**
     * @param $channelDescription
     */
    protected function setChannelDescription($channelDescription)
    {
        Assertion::notBlank($channelDescription);
        $this->channelDescription = $channelDescription;
    }

    /**
     * @param $channelLink
     */
    protected function setChannelLink($channelLink)
    {
        Assertion::notBlank($channelLink);
        $this->channelLink = $channelLink;
    }

    /**
     * @return \FeedReader\Domain\Model\Feed\FeedChannelId
     */
    public function id()
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
    public function channelDescription()
    {
        return $this->channelDescription;
    }

    /**
     * @return string
     */
    public function channelLink()
    {
        return $this->channelLink;
    }

    /**
     * @return ArrayCollection
     */
    public function channelItem()
    {
        return $this->channelItem;
    }

    /**
     * @return ArrayCollection
     */
    public function channelCategory()
    {
        return $this->channelCategory;
    }

    /**
     * @param $channelCategory
     */
    protected function setChannelCategory(ArrayCollection $channelCategory)
    {
        // for remove
        $channelCategoryDelete = clone $this->channelCategory;
        foreach ($channelCategory as $chc) {
            foreach ($channelCategoryDelete as $idx => $chcd) {
                if ($chc->id()->equals($chcd->id())) {
                    $channelCategoryDelete->removeElement($chcd);
                }
            }
        }
        if (!$channelCategoryDelete->isEmpty()) {
            foreach ($channelCategoryDelete as $chcd) {
                foreach ($this->channelCategory as $idx => $chc) {
                    if ($chcd->id()->equals($chc->id())) {
                        $this->channelCategory->removeElement($chc);
                        $channelCategory->removeElement($chc);
                    }
                }
            }
        }
        // for add
        $channelCategoryAdd = clone $channelCategory;
        foreach ($channelCategoryAdd as $chca) {
            foreach ($this->channelCategory as $idx => $chc) {
                if ($chc->id()->equals($chca->id())) {
                    $channelCategoryAdd->removeElement($chca);
                }
            }
        }
        if (!$channelCategoryAdd->isEmpty()) {
            foreach ($channelCategoryAdd as $chc) {
                $this->channelCategory->add($chc);
            }
        }
        // for edit
        $channelCategoryEdit = clone $this->channelCategory;
        if (!$channelCategoryEdit->isEmpty()) {
            foreach ($channelCategoryEdit as $idx => $chce) {
                foreach ($channelCategory as $chc) {
                    if ($chce->id()->equals($chc->id())) {
                        $chce->compose(
                            $chc->categoryName()
                            , $chc->categoryDomain()
                        );
                        $this->channelCategory->offsetSet($idx, $chce);
                    }
                }
            }
        }
    }

    /**
     * @param ArrayCollection $channelItem
     */
    protected function setChannelItem(ArrayCollection $channelItem)
    {
        // for remove
        $channelItemDelete = clone $this->channelItem;
        foreach ($channelItem as $chi) {
            foreach ($channelItemDelete as $idx => $chid) {
                if ($chi->id()->equals($chid->id())) {
                    $channelItemDelete->removeElement($chid);
                }
            }
        }
        if (!$channelItemDelete->isEmpty()) {
            foreach ($channelItemDelete as $chid) {
                foreach ($this->channelItem as $idx => $chi) {
                    if ($chid->id()->equals($chi->id())) {
                        $this->channelItem->removeElement($chi);
                        $channelItem->removeElement($chi);
                    }
                }
            }
        }
        // for add
        $channelItemAdd = clone $channelItem;
        foreach ($channelItemAdd as $chi) {
            foreach ($this->channelItem as $idx => $chia) {
                if ($chi->id()->equals($chia->id())) {
                    $channelItemAdd->removeElement($chi);
                }
            }
        }
        if (!$channelItemAdd->isEmpty()) {
            foreach ($channelItemAdd as $chi) {
                $this->channelItem->add($chi);
            }
        }
        // for edit
        $channelItemEdit = clone $this->channelItem;
        if (!$channelItemEdit->isEmpty()) {
            foreach ($channelItemEdit as $idx => $chie) {
                foreach ($channelItem as $chi) {
                    if ($chie->id()->equals($chi->id())) {
                        $chie->compose(
                            $chi->itemTitle()
                            , $chi->itemDescription()
                        );
                        $this->channelItem->offsetSet($idx, $chie);
                    }
                }
            }
        }

    }

    /**
     * @param $channelTitle
     * @param $channelLink
     * @param $channelDescription
     * @param ArrayCollection $channelCategory
     * @param ArrayCollection $channelItem
     */
    public function compose(
        $channelTitle
        , $channelLink
        , $channelDescription
        , ArrayCollection $channelCategory
        , ArrayCollection $channelItem
    )
    {
        $this->setChannelTitle($channelTitle);
        $this->setChannelLink($channelLink);
        $this->setChannelDescription($channelDescription);
        $this->setChannelCategory($channelCategory);
        $this->setChannelItem($channelItem);
    }
}
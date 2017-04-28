<?php
namespace FeedReader\Domain\Model\Feed;

use Assert\Assertion;

/**
 * Class FeedChannelCategory
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannelCategory
{
    /**
     * @var FeedChannelCategoryId
     */
    protected $feedChannelCategoryId;
    /**
     * @var string
     */
    protected $categoryName;

    /**
     * @var string
     */
    protected $categoryDomain;

    /**
     * @var FeedChannel
     */
    protected $feedChannel;

    /**
     * FeedChannelCategory constructor.
     * @param FeedChannelCategoryId $feedChannelCategoryId
     * @param FeedChannel $feedChannel
     */
    public function __construct(
        FeedChannelCategoryId $feedChannelCategoryId
        , FeedChannel $feedChannel
    )
    {
        $this->feedChannelCategoryId = $feedChannelCategoryId;
        $this->feedChannel = $feedChannel;
    }

    /**
     * @return FeedChannelCategoryId
     */
    public function id()
    {
        return $this->feedChannelCategoryId;
    }

    /**
     * @param $categoryName
     */
    protected function setCategoryName($categoryName)
    {
        Assertion::notBlank($categoryName);
        $this->categoryName = $categoryName;
    }

    /**
     * @param $categoryDomain
     */
    protected function setCategoryDomain($categoryDomain)
    {
        $this->categoryDomain = $categoryDomain;
    }

    /**
     * @return string
     */
    public function categoryName()
    {
        return $this->categoryName;
    }

    /**
     * @return string
     */
    public function categoryDomain()
    {
        return $this->categoryDomain;
    }

    /**
     * @return FeedChannel
     */
    public function feedChannel()
    {
        return $this->feedChannel;
    }

    /**
     * @param $categoryName
     * @param $categoryDomain
     */
    public function compose(
        $categoryName
        , $categoryDomain
    )
    {
        $this->setCategoryName($categoryName);
        $this->setCategoryDomain($categoryDomain);
    }
}
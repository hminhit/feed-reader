<?php
namespace FeedReader\Domain\Model\Feed;

/**
 * Interface FeedChannelCategoryRepository
 * @package FeedReader\Domain\Model\Feed
 */
interface FeedChannelCategoryRepository
{
    public function byId(FeedChannelCategoryId $feedChannelCategoryId);

    public function fetchAll();
}
<?php
namespace FeedReader\Domain\Model\Feed;
/**
 * Interface FeedChannelRepository
 * @package FeedReader\Domain\Model\Feed
 */
interface FeedChannelRepository
{
    public function byId(FeedChannelId $feedChannelId);
    public function remove(FeedChannel $feedChannel);
    public function save(FeedChannel $feedChannel);
    public function update(FeedChannel $feedChannel);
    public function paginate($pageNumber, $perPageNumber, $channelCategoryId, $sort, $direction);
}
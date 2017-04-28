<?php
namespace FeedReader\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityRepository
    , FeedReader\Domain\Model\Feed\FeedChannelItemRepository
    , FeedReader\Domain\Model\Feed\FeedChannelItem
    , FeedReader\Domain\Model\Feed\FeedChannelItemId;
use FeedReader\Application\Command\FilterListFeedChannelItemCommand;

/**
 * Class DoctrineFeedChannelItemRepository
 * @package FeedReader\Infrastructure\Persistence\Doctrine\Repository
 */
class DoctrineFeedChannelItemRepository
    extends EntityRepository
    implements FeedChannelItemRepository
{
    /**
     * @param FeedChannelItemId $feedChannelItemId
     * @return null|object
     */
    public function byId(FeedChannelItemId $feedChannelItemId)
    {
        return $this->find($feedChannelItemId);
    }

    /**
     * @param FeedChannelItem $feedChannelItem
     */
    public function remove(FeedChannelItem $feedChannelItem)
    {
        $this->getEntityManager()->remove($feedChannelItem);
        $this->getEntityManager()->flush();
    }

    /**
     * @param FeedChannelItem $feedChannelItem
     * @return FeedChannelItem
     */
    public function save(FeedChannelItem $feedChannelItem)
    {
        $this->getEntityManager()->persist($feedChannelItem);
        $this->getEntityManager()->flush();

        return $feedChannelItem;
    }

    public function update(FeedChannelItem $feedChannelItem)
    {
        $this->getEntityManager()->merge($feedChannelItem);
        $this->getEntityManager()->flush();

        return $feedChannelItem;
    }

}
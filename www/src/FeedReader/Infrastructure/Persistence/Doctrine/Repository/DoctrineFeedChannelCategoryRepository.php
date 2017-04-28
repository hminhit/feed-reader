<?php
namespace FeedReader\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository
    , FeedReader\Domain\Model\Feed\FeedChannelCategoryRepository;
use Doctrine\ORM\Mapping;
use FeedReader\Domain\Model\Feed\FeedChannelCategoryId;

/**
 * Class DoctrineFeedChannelCategoryRepository
 * @package FeedReader\Infrastructure\Persistence\Doctrine\Repository
 */
class DoctrineFeedChannelCategoryRepository
    extends EntityRepository
    implements FeedChannelCategoryRepository
{
    /**
     * @param FeedChannelCategoryId $feedChannelCategoryId
     * @return null|object
     */
    public function byId(FeedChannelCategoryId $feedChannelCategoryId)
    {
        return $this->find($feedChannelCategoryId);
    }

    /**
     * @return array
     */
    public function fetchAll()
    {
        return $this->findAll();
    }
}
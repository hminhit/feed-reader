<?php
namespace FeedReader\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Common\Collections\ArrayCollection
    , Doctrine\ORM\EntityRepository
    , FeedReader\Domain\Model\Feed\FeedChannelRepository
    , FeedReader\Domain\Model\Feed\FeedChannelId
    , FeedReader\Domain\Model\Feed\FeedChannel
    , FeedReader\Domain\Model\Feed\FeedChannelCategoryId;

/**
 * Class DoctrineFeedChannelRepository
 * @package FeedReader\Infrastructure\Persistence\Doctrine\Repository
 */
class DoctrineFeedChannelRepository
    extends EntityRepository
    implements FeedChannelRepository
{
    /**
     * @param FeedChannelId $feedChannelId
     * @return null|object
     */
    public function byId(FeedChannelId $feedChannelId)
    {
        return $this->find($feedChannelId);
    }

    public function remove(FeedChannel $feedChannel)
    {
        $this->getEntityManager()->remove($feedChannel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param FeedChannel $feedChannel
     */
    public function save(FeedChannel $feedChannel)
    {
        $this->getEntityManager()->persist($feedChannel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param FeedChannel $feedChannel
     * @return FeedChannel
     */
    public function update(FeedChannel $feedChannel)
    {
        $this->getEntityManager()->merge($feedChannel);
        $this->getEntityManager()->flush();

        return $feedChannel;
    }

    /**
     * @param ArrayCollection $feedChannel
     * @param int $batchSize
     * @return \Exception
     */
    public function insertBulk(
        ArrayCollection $feedChannel
        , $batchSize = 2
    )
    {
        try {
            if (!$feedChannel->isEmpty()) {
                foreach ($feedChannel as $i => $ch) {
                    $this->getEntityManager()->persist($ch);
                    if (($i % $batchSize) === 0) {
                        $this->getEntityManager()->flush();
                        $this->getEntityManager()->clear();
                    }
                }
                $this->getEntityManager()->flush();
                $this->getEntityManager()->clear();
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param $pageNumber
     * @param $perPageNumber
     * @param $channelCategoryId
     * @param string $sort
     * @param string $direction
     * @return array
     */
    public function paginate(
        $pageNumber
        , $perPageNumber
        , $channelCategoryId
        , $sort = ''
        , $direction = 'ASC'
    )
    {
        $offset = $perPageNumber * ($pageNumber - 1);
        $qb = $this->createQueryBuilder('fc')
            ->select('fc');
        if ($sort) {
            $qb->orderBy($sort, strtoupper($direction));
        }
        if ($channelCategoryId) {
            $qb->innerJoin('FeedReader\Domain\Model\Feed\FeedChannelCategory', 'fcc', 'WITH', 'fcc.feedChannel = fc.feedChannelId');
            $qb->where('fcc.feedChannelCategoryId = :feedChannelCategoryId')
                ->setParameter('feedChannelCategoryId', new FeedChannelCategoryId($channelCategoryId));

        }
        $qbTotal = clone $qb;
        $qb->setFirstResult($offset)
            ->setMaxResults($perPageNumber);
        $rows = $qb->getQuery()
            ->getArrayResult();

        $qbTotal->select('COUNT(fc.feedChannelId)');
        $totalRows = $qbTotal->getQuery()
            ->getSingleScalarResult();

        return array(
            'rows' => $rows,
            'total' => $totalRows
        );
    }
}
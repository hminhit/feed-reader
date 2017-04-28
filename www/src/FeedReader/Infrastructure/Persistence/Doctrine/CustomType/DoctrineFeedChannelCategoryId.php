<?php

namespace FeedReader\Infrastructure\Persistence\Doctrine\CustomType;

/**
 * Class DoctrineFeedChannelCategoryId
 * @package FeedReader\Infrastructure\Persistence\Doctrine\CustomType
 */
class DoctrineFeedChannelCategoryId extends DoctrineEntityId
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'FeedChannelCategoryId';
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return 'FeedReader\Domain\Model\Feed';
    }
}
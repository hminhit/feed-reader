<?php

namespace FeedReader\Infrastructure\Persistence\Doctrine\CustomType;

/**
 * Class DoctrineFeedChannelId
 * @package FeedReader\Infrastructure\Persistence\Doctrine\CustomType
 */
class DoctrineFeedChannelId extends DoctrineEntityId
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'FeedChannelId';
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return 'FeedReader\Domain\Model\Feed';
    }
}
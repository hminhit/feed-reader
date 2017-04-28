<?php

namespace FeedReader\Infrastructure\Persistence\Doctrine\CustomType;

/**
 * Class DoctrineFeedChannelItemId
 * @package FeedReader\Infrastructure\Persistence\Doctrine\CustomType
 */
class DoctrineFeedChannelItemId extends DoctrineEntityId
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'FeedChannelItemId';
    }

    /**
     * @return string
     */
    protected function getNamespace()
    {
        return 'FeedReader\Domain\Model\Feed';
    }
}
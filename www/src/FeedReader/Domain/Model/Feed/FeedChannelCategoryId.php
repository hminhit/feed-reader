<?php
namespace FeedReader\Domain\Model\Feed;

use Ramsey\Uuid\Uuid;

/**
 * Class FeedChannelCategoryId
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannelCategoryId
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param FeedChannelCategoryId $feedChannelCategoryId
     *
     * @return bool
     */
    public function equals(FeedChannelCategoryId $feedChannelCategoryId)
    {
        return $this->id() === $feedChannelCategoryId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
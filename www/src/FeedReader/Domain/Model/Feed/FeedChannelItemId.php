<?php
namespace FeedReader\Domain\Model\Feed;

use Ramsey\Uuid\Uuid;

/**
 * Class FeedChannelItemId
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannelItemId
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
     * @param FeedChannelItemId $feedChannelItemId
     *
     * @return bool
     */
    public function equals(FeedChannelItemId $feedChannelItemId)
    {
        return $this->id() === $feedChannelItemId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
<?php
namespace FeedReader\Domain\Model\Feed;

use Ramsey\Uuid\Uuid;

/**
 * Class FeedChannelId
 * @package FeedReader\Domain\Model\Feed
 */
class FeedChannelId
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
     * @param FeedChannelId $feedChannelId
     *
     * @return bool
     */
    public function equals(FeedChannelId $feedChannelId)
    {
        return $this->id() === $feedChannelId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
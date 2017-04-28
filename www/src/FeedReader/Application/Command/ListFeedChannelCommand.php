<?php
namespace FeedReader\Application\Command;

use Assert\Assertion;
use FeedReader\Domain\Model\Feed\FeedChannelCategoryId;

/**
 * Class ListFeedChannelCommand
 * @package FeedReader\Application\Command
 */
class ListFeedChannelCommand
{
    const PER_PAGE_NUMBER = 10;
    /**
     * @var int
     */
    protected $pageNumber;

    /**
     * @var string
     */
    protected $channelCategoryId;

    /**
     * ListFeedChannelCommand constructor.
     * @param $pageNumber
     * @param $channelCategoryId
     */
    public function __construct(
        $pageNumber
        , $channelCategoryId
    )
    {
        $this->setPageNumber($pageNumber);
        $this->setChannelCategoryId($channelCategoryId);
    }

    /**
     * @param $pageNumber
     */
    protected function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }

    /**
     * @param $channelCategoryId
     */
    protected function setChannelCategoryId($channelCategoryId)
    {
        $this->channelCategoryId = $channelCategoryId;
    }

    /**
     * @return int
     */
    public function pageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @return int
     */
    public function perPageNumber()
    {
        return self::PER_PAGE_NUMBER;
    }

    /**
     * @return string
     */
    public function channelCategoryId()
    {
        return $this->channelCategoryId;
    }
}
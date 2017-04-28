<?php
namespace FeedReader\Application\CommandHandler;

use FeedReader\Application\Command\ListFeedChannelCommand
    , FeedReader\Domain\Model\Feed\FeedChannelRepository
    , Knp\Component\Pager\Paginator;

/**
 * Class ListFeedChannelCommandHandler
 * @package FeedReader\Application\CommandHandler
 */
class ListFeedChannelCommandHandler
{
    /**
     * @var FeedChannelRepository
     */
    protected $feedChannelItemRepository;
    /**
     * @var Paginator
     */
    protected $paginator;

    protected $feedChannelCategoryId;

    /**
     * ListFeedChannelCommandHandler constructor.
     * @param FeedChannelRepository $feedChannelRepository
     */
    public function __construct(
        FeedChannelRepository $feedChannelRepository
        , Paginator $paginator
    )
    {
        $this->feedChannelRepository = $feedChannelRepository;
        $this->paginator = $paginator;
    }

    /**
     * @param ListFeedChannelCommand $command
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function handle(ListFeedChannelCommand $command)
    {
        $paginateData = $this->feedChannelRepository->paginate(
            $command->pageNumber()
            , $command->perPageNumber()
            , $command->channelCategoryId()
        );
        $paginator = $this->paginator->paginate(
            []
            , $command->pageNumber()
            , $command->perPageNumber()
        );
        $paginator->setItems($paginateData['rows']);
        $paginator->setTotalItemCount($paginateData['total']);


        return $paginator;
    }
}
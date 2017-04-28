<?php
namespace FeedReader\Application\CommandHandler;

use FeedReader\Application\Command\RemoveFeedChannelCommand
    , FeedReader\Domain\Model\Feed\FeedChannelRepository
    , FeedReader\Domain\Exception\FeedChannelDoesNotExistException
    , FeedReader\Domain\Exception\RepositoryNotAvailableException
    , FeedReader\Domain\Model\Feed\FeedChannel
    , FeedReader\Domain\Model\Feed\FeedChannelId;

/**
 * Class RemoveFeedChannelCommandHandler
 * @package FeedReader\Application\CommandHandler
 */
class RemoveFeedChannelCommandHandler
{
    /**
     * @var FeedChannelRepository
     */
    protected $feedChannelRepository;

    /**
     * ListFeedChannelCommandHandler constructor.
     * @param FeedChannelRepository $feedChannelRepository
     */
    public function __construct(
        FeedChannelRepository $feedChannelRepository
    )
    {
        $this->feedChannelRepository = $feedChannelRepository;
    }

    /**
     * @param RemoveFeedChannelCommand $command
     * @throws FeedChannelDoesNotExistException
     * @throws RepositoryNotAvailableException
     */
    public function handle(RemoveFeedChannelCommand $command)
    {
        try {
            $feedChannel = $this->feedChannelRepository->byId(
                new FeedChannelId($command->feedChannelId())
            );
        } catch (\Exception $e) {
            throw new RepositoryNotAvailableException('The repository not available.');
        }
        if (!$feedChannel instanceof FeedChannel) {
            throw new FeedChannelDoesNotExistException('The channel does not exist.');
        }
        $this->feedChannelRepository->remove($feedChannel);

        return $feedChannel;
    }
}
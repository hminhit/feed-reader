<?php
namespace FeedReader\Application\CommandHandler;

use FeedReader\Application\Command\CheckFeedChannelExistCommand
    , FeedReader\Domain\Model\Feed\FeedChannelRepository
    , FeedReader\Domain\Exception\FeedChannelDoesNotExistException
    , FeedReader\Domain\Exception\RepositoryNotAvailableException
    , FeedReader\Domain\Model\Feed\FeedChannel;

/**
 * Class CheckFeedChannelExistCommandHandler
 * @package FeedReader\Application\CommandHandler
 */
class CheckFeedChannelExistCommandHandler
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
     * @param CheckFeedChannelExistCommand $command
     * @throws FeedChannelDoesNotExistException
     * @throws RepositoryNotAvailableException
     */
    public function handle(CheckFeedChannelExistCommand $command)
    {
        try {
            $feedChannel = $this->feedChannelRepository->byId(
                $command->feedChannelId()
            );
        } catch (\Exception $e) {
            throw new RepositoryNotAvailableException('The repository not available.');
        }
        if (!$feedChannel instanceof FeedChannel) {
            throw new FeedChannelDoesNotExistException('The channel does not exist.');
        }

        return $feedChannel;
    }
}
<?php
namespace FeedReader\Application\CommandHandler;

use Doctrine\Common\Collections\ArrayCollection;
use FeedReader\Application\Command\EditFeedChannelCommand
    , FeedReader\Domain\Model\Feed\FeedChannelRepository
    , FeedReader\Domain\Exception\RepositoryNotAvailableException
    , FeedReader\Domain\Model\Feed\FeedChannel;
use FeedReader\Domain\Model\Feed\FeedChannelCategory;
use FeedReader\Domain\Model\Feed\FeedChannelCategoryId;
use FeedReader\Domain\Model\Feed\FeedChannelItem;
use FeedReader\Domain\Model\Feed\FeedChannelItemId;

/**
 * Class EditFeedChannelCommandHandler
 * @package FeedReader\Application\CommandHandler
 */
class EditFeedChannelCommandHandler
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
     * @param EditFeedChannelCommand $command
     * @return FeedChannel
     * @throws RepositoryNotAvailableException|FeedChannel
     */
    public function handle(EditFeedChannelCommand $command)
    {
        $existingFeedChannel = $command->existingFeedChannel();
        $channelCategory = new ArrayCollection();
        foreach ($command->channelCategory() as $chc) {
            $feedChannelCategory = new FeedChannelCategory(
                new FeedChannelCategoryId($chc['categoryId'])
                , $existingFeedChannel
            );
            $feedChannelCategory->compose(
                $chc['categoryName']
                , $chc['categoryDomain']
            );
            $channelCategory->add($feedChannelCategory);
        }

        $channelItem = new ArrayCollection();
        foreach ($command->channelItem() as $chi) {
            $feedChannelItem = new FeedChannelItem(
                new FeedChannelItemId($chi['itemId'])
                , $existingFeedChannel
            );
            $feedChannelItem->compose(
                $chi['itemTitle']
                , $chi['itemDescription']
            );
            $channelItem->add($feedChannelItem);
        }
        $existingFeedChannel->compose(
            $command->channelTitle()
            , $command->channelLink()
            , $command->channelDescription()
            , $channelCategory
            , $channelItem
        );
        try {
            $feedChannel = $this->feedChannelRepository->update($existingFeedChannel);
        } catch (\Exception $e) {
            throw new RepositoryNotAvailableException('The repository not available.');
        }

        return $feedChannel;
    }
}
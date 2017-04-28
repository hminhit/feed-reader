<?php
namespace FeedReader\Application\CommandHandler;

use Doctrine\Common\Collections\ArrayCollection;
use FeedReader\Application\Command\AddFeedChannelCommand
    , FeedReader\Domain\Exception\RepositoryNotAvailableException
    , FeedReader\Domain\Model\Feed\FeedChannelItem
    , FeedReader\Domain\Model\Feed\FeedChannel
    , FeedReader\Domain\Model\Feed\FeedChannelCategory
    , FeedReader\Domain\Model\Feed\FeedChannelCategoryId
    , FeedReader\Domain\Model\Feed\FeedChannelId
    , FeedReader\Domain\Model\Feed\FeedChannelRepository;
use FeedReader\Domain\Model\Feed\FeedChannelItemId;

/**
 * Class AddFeedChannelCommandHandler
 * @package FeedReader\Application\CommandHandler
 */
class AddFeedChannelCommandHandler
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
     * @param AddFeedChannelCommand $command
     * @return FeedChannel
     * @throws RepositoryNotAvailableException|FeedChannelItem
     */
    public function handle(AddFeedChannelCommand $command)
    {
        $feedChannel = new FeedChannel(
            new FeedChannelId()
        );
        $channelCategory = new ArrayCollection();
        foreach ($command->channelCategory() as $chc) {
            $channelCategory->add(
                new FeedChannelCategory(
                    new FeedChannelCategoryId($chc['categoryId'])
                    , $feedChannel
                    , $chc['categoryName']
                    , $chc['categoryDomain']
                )
            );
        }

        $channelItem = new ArrayCollection();
        foreach ($command->channelItem() as $chi) {
            $feedChannelItem = new FeedChannelItem(
                new FeedChannelItemId($chi['itemId'])
                , $feedChannel
            );
            $feedChannelItem->compose(
                $chi['itemTitle']
                , $chi['itemDescription']
            );
            $channelItem->add($feedChannelItem);
        }
        $feedChannel->compose(
            $command->channelTitle()
            , $command->channelLink()
            , $command->channelDescription()
            , $channelCategory
            , $channelItem
        );
        foreach ($command->channelCategory() as $channelCategory) {
            $feedChannel->makeChannelCategory(
                new FeedChannelCategory(
                    new FeedChannelCategoryId($channelCategory['categoryId'])
                    , $feedChannel
                    , $channelCategory['categoryName']
                    , $channelCategory['categoryDomain']
                )
            );
        }
        try {
            $this->feedChannelRepository->save($feedChannel);
        } catch (\Exception $e) {
            throw new RepositoryNotAvailableException('The repository not available.');
        }

        return $feedChannel;
    }
}
<?php

namespace FeedReader\UI\FeedReaderBundle\Controller\Feed;

use FeedReader\Domain\Exception\RepositoryNotAvailableException
    , Symfony\Bundle\FrameworkBundle\Controller\Controller
    , Symfony\Component\HttpFoundation\Request
    , FeedReader\Application\Command\RemoveFeedChannelCommand
    , FeedReader\Domain\Exception\FeedChannelDoesNotExistException
    , FeedReader\Application\CommandHandler\RemoveFeedChannelCommandHandler;

/**
 * Class RemoveFeedChannelController
 * @package FeedReader\UI\FeedReaderBundle\Controller\Feed
 */
class RemoveFeedChannelController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws RepositoryNotAvailableException
     * @throws \Exception
     */
    public function indexAction(Request $request)
    {
        try {
            $removeFeedChannelCommand = new RemoveFeedChannelCommand(
                $request->attributes->get('channel_id')
            );
            $removeFeedChannelCommandHandler = new RemoveFeedChannelCommandHandler(
                $this->container->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')
            );
            $feedChannelRemoved = $removeFeedChannelCommandHandler->handle($removeFeedChannelCommand);
            $channelTitle = $feedChannelRemoved->channelTitle();
            $this->get('session')->getFlashBag()->add('notice', array(
                'status' => 'success',
                'msg' => "Removed a channel {$channelTitle} successfully."
            ));
            return $this->redirectToRoute('feed_reader_feed_list_feed_channel');
        } catch (FeedChannelDoesNotExistException $e) {
            throw $e;
        } catch (RepositoryNotAvailableException $e) {
            throw $e;
        }

    }
}

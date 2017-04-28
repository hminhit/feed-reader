<?php

namespace FeedReader\UI\FeedReaderBundle\Controller\Feed;

use FeedReader\Application\Command\CheckFeedChannelExistCommand;
use FeedReader\Application\Command\EditFeedChannelCommand;
use FeedReader\Application\Command\EditFeedChannelItemCommand
    , FeedReader\Application\CommandHandler\EditFeedChannelCommandHandler
    , FeedReader\UI\FeedReaderBundle\Form\Type\EditFeedChannelItemType
    , Symfony\Bundle\FrameworkBundle\Controller\Controller
    , Symfony\Component\HttpFoundation\Request
    , FeedReader\Domain\Exception\RepositoryNotAvailableException
    , Symfony\Component\Form\FormError
    , FeedReader\Domain\Model\Feed\FeedChannelItemId;
use FeedReader\Application\CommandHandler\CheckFeedChannelExistCommandHandler;
use FeedReader\Domain\Exception\ChannelEmptyException;
use FeedReader\Domain\Model\Feed\FeedChannel;
use FeedReader\Domain\Model\Feed\FeedChannelId;
use FeedReader\UI\FeedReaderBundle\Form\Type\AddFeedChannelType;
use FeedReader\UI\FeedReaderBundle\Form\Type\EditFeedChannelType;

class EditFeedChannelController extends Controller
{
    public function indexAction(Request $request)
    {
        $feedChannelId = new FeedChannelId($request->attributes->get('channel_id'));
        $feedChannelRepository = $this->container
            ->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository');
        try {
            $checkFeedChannelExistCommandHandler = new CheckFeedChannelExistCommandHandler(
                $feedChannelRepository
            );
            $feedChannel = $checkFeedChannelExistCommandHandler->handle(
                new CheckFeedChannelExistCommand($feedChannelId)
            );
        } catch (\Exception $e) {
            throw $e;
        }

        $editFeedChannelCommand = new EditFeedChannelCommand(
            $feedChannelId
            , $feedChannel
            , ''
            , ''
            , ''
            , []
            , []
        );
        $editFeedChannelForm = $this->createForm(
            EditFeedChannelType::class
            , null
            , [
                'editFeedChannelCommand' => $editFeedChannelCommand
            ]
        );
        if ($request->isMethod('POST')) {
            $editFeedChannelForm->handleRequest($request);
            if ($editFeedChannelForm->isValid()) {
                $editFeedChannelCommand = $editFeedChannelForm->getData();
                $editFeedChannelCommandHandler = new EditFeedChannelCommandHandler(
                    $feedChannelRepository
                );
                $feedChannel = $editFeedChannelCommandHandler->handle($editFeedChannelCommand);
                $feedChannelTitle = $feedChannel->channelTitle();
                $this->get('session')->getFlashBag()->add('notice', array(
                    'status' => 'success',
                    'msg' => "Edited a channel {$feedChannelTitle} successfully."
                ));
                return $this->redirectToRoute('feed_reader_feed_list_feed_channel');
            }
        }

        return $this->render(
            'FeedReaderBundle:Feed:form_feed_channel.html.twig'
            , [
                'feedChannelForm' => $editFeedChannelForm->createView()
                , 'feedChannelId' => $feedChannelId
            ]
        );
    }
}

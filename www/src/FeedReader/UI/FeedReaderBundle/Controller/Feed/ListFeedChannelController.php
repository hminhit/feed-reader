<?php

namespace FeedReader\UI\FeedReaderBundle\Controller\Feed;

use FeedReader\Application\CommandHandler\ListFeedChannelCommandHandler
    , Symfony\Bundle\FrameworkBundle\Controller\Controller
    , Symfony\Component\HttpFoundation\Request
    , FeedReader\Application\Command\ListFeedChannelCommand
    , FeedReader\UI\FeedReaderBundle\Form\Type\FilterListChannelType;

/**
 * Class ListFeedChannelController
 * @package FeedReader\UI\FeedReaderBundle\Controller\Feed
 */
class ListFeedChannelController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $listFeedChannelCommand = new ListFeedChannelCommand(
            $request->query->get('page', 1)
            , $request->query->get('filter_list_channel')['feedChannelCategory']
        );
        $filterListFeedChannelForm = $this->createForm(
            FilterListChannelType::class
            , null
            , [
                'listFeedChannelCommand' => $listFeedChannelCommand
            ]
        );
        $filterListFeedChannelForm->handleRequest($request);
        $listFeedCommandHandler = new ListFeedChannelCommandHandler(
            $this->container->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')
            , $this->container->get('knp_paginator')
        );

        $listFeedChannelIterator = $listFeedCommandHandler->handle(
            $listFeedChannelCommand
        );

        return $this->render(
            'FeedReaderBundle:Feed:list_feed_channel.html.twig'
            , [
                'listFeedChannelIterator' => $listFeedChannelIterator
                , 'filterListFeedChannelForm' => $filterListFeedChannelForm->createView()
            ]
        );
    }
}

<?php

namespace FeedReader\UI\FeedReaderBundle\Controller\Feed;

use FeedReader\Application\CommandHandler\AddFeedChannelCommandHandler
    , FeedReader\UI\FeedReaderBundle\Form\Type\AddFeedChannelType
    , Symfony\Bundle\FrameworkBundle\Controller\Controller
    , Symfony\Component\HttpFoundation\Request
    , FeedReader\Domain\Exception\RepositoryNotAvailableException;

class AddFeedChannelController extends Controller
{
    public function indexAction(Request $request)
    {
        $addFeedChannelForm = $this->createForm(
            AddFeedChannelType::class
            , null
        );
        if ($request->isMethod('POST')) {
            $addFeedChannelForm->handleRequest($request);
            if ($addFeedChannelForm->isValid()) {
                $addFeedChannelCommand = $addFeedChannelForm->getData();
                try {
                    $addFeedChannelCommandHandler = new AddFeedChannelCommandHandler(
                        $this->container->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')
                    );
                    $feedChannel = $addFeedChannelCommandHandler->handle($addFeedChannelCommand);
                    $feedChannelId = $feedChannel->id()->id();
                    $this->get('session')->getFlashBag()->add('notice', array(
                        'status' => 'success',
                        'msg' => "Added a new channel item #{$feedChannelId} successfully."
                    ));
                    return $this->redirectToRoute('feed_reader_feed_list_feed_channel');
                } catch (ItemTitleOrItemDescriptionNotEmptyException $e) {
                    //$addFeedChannelItemForm->addError(new FormError('Item title or Item description one of two fields is required.'));
                } catch (RepositoryNotAvailableException $e) {
                    throw $e;
                }
            }
        }

        return $this->render(
            'FeedReaderBundle:Feed:form_feed_channel.html.twig'
            , [
                'feedChannelForm' => $addFeedChannelForm->createView()
            ]
        );
    }
}

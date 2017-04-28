<?php
namespace FeedReader\UI\FeedReaderBundle\Console;

use FeedReader\Infrastructure\Logger\Monolog\RetrieveFeedFromUrlLogger;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
    , Symfony\Component\Console\Input\InputInterface
    , Symfony\Component\Console\Output\OutputInterface
    , FeedReader\Infrastructure\Http\Guzzle\Client
    , FeedReader\Application\Command\RetrieveFeedFromUrlCommand
    , FeedReader\Application\CommandHandler\RetrieveFeedFromUrlCommandHandler;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RetrieveFeedFromMultiUrConsole
 * @package FeedReader\UI\FeedReaderBundle\Console
 */
class RetrieveFeedFromMultiUrlConsole extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('feed_reader:retrieve_feed_from_multi_url')
            ->addArgument(
                'list_url'
                , InputArgument::REQUIRED
                , 'the feed urls (separated by comma) to grab items'
            )
            ->setDescription('A console to retrieve feed from multiple url given.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $listUrlStr = $input->getArgument('list_url');
        $retrieveFeedFromUrlCommandHandler = new RetrieveFeedFromUrlCommandHandler(
            new Client([])
            , new RetrieveFeedFromUrlLogger(
                $this->getContainer()->get('monolog.logger.retrieve_feed_from_url')->getName()
                , $this->getContainer()->get('monolog.logger.retrieve_feed_from_url')->getHandlers()
                , $this->getContainer()->get('monolog.logger.retrieve_feed_from_url')->getProcessors()
            )
            , $this->getContainer()->get('feed_reader.infrastructure.persistence.doctrine.feed_channel_repository')
        );
        $retrieveFeedFromUrlCommandHandler->handle(
            new RetrieveFeedFromUrlCommand($listUrlStr)
        );
    }
}

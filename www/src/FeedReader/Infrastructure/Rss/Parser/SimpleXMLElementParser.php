<?php

namespace FeedReader\Infrastructure\Rss\Parser;

use Doctrine\Common\Collections\ArrayCollection
    , FeedReader\Infrastructure\Rss\FetchAsyncInterface
    , FeedReader\Domain\Model\Feed\FeedChannel
    , FeedReader\Domain\Model\Feed\FeedChannelCategory
    , FeedReader\Domain\Model\Feed\FeedChannelCategoryId
    , FeedReader\Domain\Model\Feed\FeedChannelId
    , FeedReader\Domain\Model\Feed\FeedChannelItem
    , FeedReader\Domain\Model\Feed\FeedChannelItemId
    , FeedReader\Infrastructure\Logger\LoggerInterface
    , FeedReader\Domain\Exception\ChannelEmptyException;

/**
 * Class SimpleXMLElementParser
 * @package FeedReader\Infrastructure\Rss
 */
class SimpleXMLElementParser implements ParserInterface
{
    /**
     * @var FetchAsyncInterface
     */
    protected $fetchAsync;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ArrayCollection
     */
    protected $channel;

    /**
     * @var ArrayCollection
     */
    protected $xml;

    /**
     * SimpleXMLElementParser constructor.
     * @param FetchAsyncInterface $fetchAsync
     * @param LoggerInterface $logger
     */
    public function __construct(
        FetchAsyncInterface $fetchAsync
        ,  $logger
    )
    {
        $this->fetchAsync = $fetchAsync;
        $this->logger = $logger;
        $this->channel = new ArrayCollection();
    }

    /**
     *  Parse
     */
    public function parse()
    {
        foreach ($this->fetchAsync->fetch() as $url => $response) {
            if (!$this->filterResponseSuccessful($response)) {
                continue;
            }
            try {
                $xml = $this->convertResponseToXMLObject($response);
                $this->logger->info("Converted content to xml object from {$url}");
            } catch (\Exception $e) {
                $reason = $e->getMessage();
                $this->logger->info("Can't convert content to xml object from {$url} with error: $reason");
            }
            try {
                if (empty($xml->channel)) {
                    throw new ChannelEmptyException();
                }
                $feedChannel = new FeedChannel(
                    new FeedChannelId()
                );
                $channelCategoryCollection = new ArrayCollection();
                if ($xml->channel->category) {
                    foreach ($xml->channel->category as $channelCategory) {
                        $feedChannelCategory = new FeedChannelCategory(
                            new FeedChannelCategoryId()
                            , $feedChannel
                        );
                        $feedChannelCategory->compose(
                            (string)$channelCategory
                            , (string)$channelCategory['domain']
                        );
                        $channelCategoryCollection->add($feedChannelCategory);
                    }
                }
                $channelItemCollection = new ArrayCollection();
                if (!empty($xml->channel->item)) {
                    foreach ($xml->channel->item as $channelItem) {
                        $feedChannelItem = new FeedChannelItem(
                            new FeedChannelItemId()
                            , $feedChannel

                        );
                        $feedChannelItem->compose(
                            (string)$channelItem->title
                            , (string)$channelItem->description
                        );
                        $channelItemCollection->add($feedChannelItem);
                    }
                }
                $feedChannel->compose(
                    (string)$xml->channel->title
                    , (string)$xml->channel->link
                    , (string)$xml->channel->description
                    , $channelCategoryCollection
                    , $channelItemCollection
                );
                $this->channel->add($feedChannel);
                $this->logger->info("Converted the feed from {$url} ");
            } catch (ChannelEmptyException $e) {
                $this->logger->info("Can't insert feed from {$url} with error: channel empty");
                continue;
            } catch (\Exception $e) {
                $reason = $e->getMessage();
                $this->logger->info("Can't convert the feed from {$url} with error: $reason");
                continue;
            }
        }
    }

    /**
     * @param $response
     * @return bool
     */
    public function filterResponseSuccessful($response)
    {
        $success = true;
        if ($response instanceof \Exception) {
            $success = false;
        }

        return $success;
    }

    /**
     * @param $response
     * @return \SimpleXMLElement
     */
    public function convertResponseToXMLObject($response)
    {
        $xml = new \SimpleXMLElement($response->getBody()->getContents());

        return $xml;
    }

    /**
     * @return ArrayCollection
     */
    public function feedChannel()
    {
        return $this->channel;
    }
}
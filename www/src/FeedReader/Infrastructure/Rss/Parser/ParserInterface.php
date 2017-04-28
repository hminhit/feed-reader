<?php

namespace FeedReader\Infrastructure\Rss\Parser;

/**
 * Interface ParserInterface
 * @package FeedReader\Infrastructure\Rss
 */
interface ParserInterface
{
    public function parse();
    public function filterResponseSuccessful($response);
    public function convertResponseToXMLObject($response);
}
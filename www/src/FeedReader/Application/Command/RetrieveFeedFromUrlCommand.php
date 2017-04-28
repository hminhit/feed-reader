<?php
namespace FeedReader\Application\Command;

use Assert\Assertion;

/**
 * Class RetrieveFeedFromUrlCommand
 * @package FeedReader\Application\Command
 */
class RetrieveFeedFromUrlCommand
{
    const URL_SEPARATED = ',';
    /**
     * @var array
     */
    protected $listUrl;

    public function __construct($listUrlStr)
    {
        $this->setListUrl($listUrlStr);
    }

    /**
     * @param $listUrlStr
     */
    protected function setListUrl($listUrlStr)
    {
        if (empty($listUrlStr)) {
            throw new \InvalidArgumentException('The list feed url cannot be empty.');
        }
        $listUrl = explode(self::URL_SEPARATED, $listUrlStr);
        foreach ($listUrl as $url) {
            $urlTrim = trim($url);
            Assertion::url($urlTrim);
            $this->listUrl[] = $urlTrim;
        }
    }

    /**
     * @return array
     */
    public function listUrl()
    {
        return $this->listUrl;
    }
}
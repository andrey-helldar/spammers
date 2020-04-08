<?php

namespace Helldar\Spammers\Rules;

class IsCrawler
{
    /**
     * @var string|null
     */
    protected $ip;

    /**
     * IsCrawler constructor.
     *
     * @param null $ip
     */
    public function __construct($ip = null)
    {
        $this->ip = $ip;
    }

    /**
     * @return array|null
     */
    public function check()
    {
        if (\Crawler::isCrawler()) {
            return ["The IP-address {$this->ip} belongs to the bot"];
        }

        return null;
    }
}

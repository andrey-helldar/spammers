<?php

namespace Helldar\Spammers\Rules;

use Helldar\Spammers\Models\Spammer;

class IpAddressExists
{
    /**
     * @var null|string
     */
    protected $ip = null;

    /**
     * @var bool
     */
    protected $with_trashed = false;

    /**
     * IpAddressExists constructor.
     *
     * @param null $ip
     */
    public function __construct($ip = null)
    {
        $this->ip = $ip;
    }

    /**
     * @return bool
     */
    public function check()
    {
        if ($this->with_trashed) {
            $spammer = Spammer::withTrashed()
                ->whereIp($this->ip)
                ->first();
        }
        else {
            $spammer = Spammer::whereIp($this->ip)
                ->first();
        }

        return !is_null($spammer);
    }

    /**
     * @return $this
     */
    public function withTrashed()
    {
        $this->with_trashed = true;

        return $this;
    }
}

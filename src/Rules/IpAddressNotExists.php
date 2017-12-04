<?php

namespace Helldar\Spammers\Rules;

use Helldar\Spammers\Models\Spammer;

class IpAddressNotExists
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
     * @var bool
     */
    protected $only_trashed = false;

    /**
     * IpAddressNotExists constructor.
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
        } elseif ($this->only_trashed) {
            $spammer = Spammer::onlyTrashed()
                ->whereIp($this->ip)
                ->first();
        } else {
            $spammer = Spammer::whereIp($this->ip)
                ->first();
        }

        return is_null($spammer);
    }

    /**
     * @return $this
     */
    public function withTrashed()
    {
        $this->with_trashed = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function onlyTrashed()
    {
        $this->only_trashed = true;

        return $this;
    }
}

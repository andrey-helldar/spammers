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
        $builder = Spammer::query()->where('ip', $this->ip);

        if ($this->with_trashed) {
            $builder->withTrashed();
        }

        return $builder->exists();
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

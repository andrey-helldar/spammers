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
    protected $only_trashed = false;

    /**
     * @var bool
     */
    protected $with_trashed = false;

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
        $builder = Spammer::query()->where('ip', $this->ip);

        if ($this->with_trashed) {
            $builder->withTrashed();
        }
        elseif ($this->only_trashed) {
            $builder->onlyTrashed();
        }

        return !$builder->exists();
    }

    /**
     * @return $this
     */
    public function onlyTrashed()
    {
        $this->only_trashed = true;

        return $this;
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

<?php

namespace Helldar\Spammers\Facade;

use Carbon\Carbon;
use Helldar\Spammers\Models\Spammer as SpammerModel;
use Helldar\Spammers\Rules\IpAddressExists;
use Helldar\Spammers\Rules\IpAddressNotExists;
use Helldar\Spammers\Traits\ValidateIP;

class Spammer
{
    use ValidateIP;

    /**
     * @var null|string
     */
    protected $expired_at = null;

    /**
     * Spammer constructor.
     *
     * @param null $ip
     */
    public function __construct($ip = null)
    {
        $this->ip($ip);
    }

    /**
     * Delete IP-address from a spam-table.
     *
     * @return null|array|string|\Helldar\Spammers\Models\Spammer
     */
    public function delete()
    {
        if ($this->errors) {
            return $this->errors;
        }

        if ((new IpAddressNotExists($this->ip))->check()) {
            return "IP-address {$this->ip} is not exists!";
        }

        return SpammerModel::query()
            ->withTrashed()
            ->whereIp($this->ip)
            ->delete();
    }

    /**
     * Check exists IP-address in a spam-table.
     *
     * @return bool
     */
    public function exists()
    {
        return (new IpAddressExists($this->ip))->check();
    }

    /**
     * Store expired time to current IP-address.
     *
     * @param null $hours
     *
     * @return $this
     */
    public function expire($hours = null)
    {
        if ($hours) {
            $hours = abs((int) $hours);

            $this->expired_at = Carbon::now()->addHours($hours);
        }

        return $this;
    }

    /**
     * Get a IP-address.
     *
     * @param null $ip
     *
     * @return mixed
     */
    public function ip($ip = null)
    {
        $this->ip = $ip;

        $this->errors = $this->isIpValidateError();

        return $this;
    }

    /**
     * Restore IP-address from a spam-table.
     *
     * @return null|array|string|\Helldar\Spammers\Models\Spammer
     */
    public function restore()
    {
        if ($this->errors) {
            return $this->errors;
        }

        $is_not_exists = (new IpAddressNotExists($this->ip))
            ->onlyTrashed()
            ->check();

        if ($is_not_exists) {
            return "IP-address {$this->ip} is not exists!";
        }

        return SpammerModel::query()
            ->onlyTrashed()
            ->whereIp($this->ip)
            ->restore();
    }

    /**
     * Store IP-address in a spam-table.
     *
     * @return null|array|\Helldar\Spammers\Models\Spammer|\Illuminate\Support\MessageBag
     */
    public function store()
    {
        if ($this->errors) {
            return $this->errors;
        }

        $ip         = $this->ip;
        $expired_at = $this->expired_at;

        return SpammerModel::query()
            ->withTrashed()
            ->firstOrCreate(compact('ip'), compact('expired_at'));
    }

    /**
     * @return \Helldar\Spammers\Facade\SpammerAccess
     */
    public function access()
    {
        return (new SpammerAccess($this->ip));
    }
}

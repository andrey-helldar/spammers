<?php

namespace Helldar\Spammers\Facade;

use Carbon\Carbon;
use Helldar\Spammers\Models\Spammer as SpammerModel;
use Helldar\Spammers\Rules\IpAddressExists;
use Helldar\Spammers\Rules\IpAddressNotExists;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class Spammer
{
    /**
     * @var null|string
     */
    protected $ip = null;

    /**
     * @var null|string|array
     */
    protected $errors = null;

    /**
     * @var null|timestamp
     */
    protected $expired_at = null;

    /**
     * Spammer constructor.
     *
     * @param string $ip
     */
    public function __construct($ip = null)
    {
        $this->ip     = $ip;
        $this->errors = $this->isErrorValidation();
    }

    /**
     * Store expiered time to current IP-address.
     *
     * @param null $hours
     *
     * @return $this
     */
    public function expire($hours = null)
    {
        if ($hours) {
            $this->expired_at = Carbon::now()->addHours((int)$hours);
        }

        return $this;
    }

    /**
     * Store IP-address in a spam-table.
     *
     * @return array|null|string
     */
    public function store()
    {
        if ($this->errors) {
            return $this->errors;
        }

        return SpammerModel::withTrashed()
            ->firstOrCreate(['ip' => $this->ip], ['expired_at' => $this->expired_at]);
    }

    /**
     * Delete IP-address from a spam-table.
     *
     * @return array|null|string
     */
    public function delete()
    {
        if ($this->errors) {
            return $this->errors;
        }

        if ((new IpAddressNotExists($this->ip))->check()) {
            return "IP-address {$this->ip} is not exists!";
        }

        return SpammerModel::withTrashed()
            ->whereIp($this->ip)
            ->delete();
    }

    /**
     * Restore IP-address from a spam-table.
     *
     * @return array|null|string
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

        return SpammerModel::onlyTrashed()
            ->whereIp($this->ip)
            ->restore();
    }

    /**
     * Check exists IP-address in a spam-table.
     *
     * @return \Helldar\Spammers\Rules\IpAddressExists
     */
    public function exists()
    {
        if ($time = config('spammers.use_cache', false)) {
            $key = str_slug('spammers_exists_' . $this->ip);

            return Cache::remember($key, (int)$time, function() {
                return (new IpAddressExists($this->ip))->check();
            });
        }

        return (new IpAddressExists($this->ip))->check();
    }

    /**
     * Validate a IP-address.
     *
     * @return null|string|array
     */
    private function isErrorValidation()
    {
        $validator = Validator::make(['ip' => $this->ip], [
            'ip' => 'required|ipv4',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        if ($this->isExcludedIp()) {
            return "IP-address {$this->ip} founded in a excluded settings!";
        }

        return null;
    }

    /**
     * Check in excluded IP-addresses.
     *
     * @return bool
     */
    private function isExcludedIp()
    {
        return in_array($this->ip, config('spammers.exclude_ips'));
    }
}

<?php

namespace Helldar\Spammers\Facade;

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
     * Spammer constructor.
     *
     * @param string $ip
     */
    public function __construct($ip = null)
    {
        $this->errors = $this->isErrorValidation();
        $this->ip     = $ip;
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
            ->firstOrCreate(['ip' => $this->ip]);
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

        if (new IpAddressNotExists($this->ip)) {
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

        if (new IpAddressNotExists($this->ip)) {
            return "IP-address {$this->ip} is not exists!";
        }

        return SpammerModel::withTrashed()
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
                return (new IpAddressExists($this->ip));
            });
        }

        return (new IpAddressExists($this->ip));
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

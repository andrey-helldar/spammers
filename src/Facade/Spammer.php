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
     * @var string|null
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
     * @return \Helldar\Spammers\Facade\SpammerAccess
     */
    public function access()
    {
        return new SpammerAccess($this->ip);
    }

    /**
     * Delete IP-address from a spam-table.
     *
     * @return array|\Helldar\Spammers\Models\Spammer|string|null
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
     * Restore IP-address from a spam-table.
     *
     * @return array|\Helldar\Spammers\Models\Spammer|string|null
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
     * @return array|\Helldar\Spammers\Models\Spammer|\Illuminate\Support\MessageBag|null
     */
    public function store()
    {
        if ($this->errors) {
            return $this->errors;
        }

        $item = SpammerModel::query()
            ->withTrashed()
            ->firstOrNew(['ip' => $this->ip]);

        $item->expired_at = $this->expired_at;
        $item->deleted_at = null;

        $item->save();

        return $item;
    }

    /**
     * Amnesty for IP-address.
     *
     * @return array|string|null
     */
    public function amnesty()
    {
        return SpammerModel::query()
            ->where('expired_at', '<', Carbon::now())
            ->whereNotNull('expired_at')
            ->get()
            ->each(function (SpammerModel $item) {
                $item->increment('attempts');
                $item->delete();
            });
    }
}

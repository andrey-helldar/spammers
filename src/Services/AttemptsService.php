<?php

namespace Helldar\Spammers\Services;

use Carbon\Carbon;
use Helldar\Spammers\Models\Spammer;
use Helldar\Spammers\Models\SpammerAccess;

class AttemptsService
{
    /**
     * @var null|string
     */
    private $ip;

    /**
     * @var int
     */
    private $period;

    /**
     * @var int
     */
    private $attempts = 0;

    /**
     * AttemptsService constructor.
     *
     * @param null|string $ip
     */
    public function __construct($ip = null)
    {
        $this->ip = $ip;
        $this->period = (int) config('spammers.period', 24);
    }

    /**
     * Verify the IP address.
     *
     * @return bool
     */
    public function check()
    {
        if ($count = $this->count()) {
            $attempts = $this->attempts();

            foreach ($attempts as $attempt_count => $hours) {
                if ((int) $count >= (int) $attempt_count) {
                    return $this->ban($hours);
                }
            }
        }

        return false;
    }

    /**
     * Getting the count of errors.
     *
     * @return int
     */
    private function count()
    {
        $days = -1 * abs($this->period);

        return SpammerAccess::query()
            ->where('ip', $this->ip)
            ->where('created_at', '>=', Carbon::now()->addDays($days))
            ->count();
    }

    /**
     * Adding the user's IP address to the banlist.
     *
     * @param null $hours
     *
     * @return bool
     */
    private function ban($hours = null)
    {
        return (bool) spammer($this->ip)
            ->expire($hours)
            ->store();
    }

    /**
     * Ban when attempts to get pages with errors exceed a given number.
     *
     * @return mixed
     */
    private function attempts()
    {
        $items = config('spammers.attempts', [1 => null]);

        ksort($items);

        if ($attempts = $this->attemptsDb()) {
            $result = [];
            $i = -1;

            foreach ($items as $key => $value) {
                $i++;

                if ($attempts > $i) {
                    continue;
                }

                $result[$key] = $value;
            }

            return $result;
        }

        return $items;
    }

    /**
     * Get attempts count for IP-address.
     *
     * @return int
     */
    private function attemptsDb()
    {
        $item = Spammer::query()
            ->withTrashed()
            ->where('ip', $this->ip)
            ->first();

        if (is_null($item)) {
            return 0;
        }

        return (int) $item->attempts;
    }
}

<?php

namespace Helldar\Spammers\Rules;

use Helldar\Spammers\Models\Spammer;

class IpAddressNotExists
{
    public function __construct($ip = null)
    {
        return $this->handle($ip);
    }

    private function handle($ip = null)
    {
        $spammer = Spammer::withTrashed()
            ->whereIp($ip)
            ->first();

        return is_null($spammer);
    }
}

<?php

if (!function_exists('spammer')) {
    /**
     * @param null $ip
     *
     * @return \Helldar\Spammers\Facade\Spammer
     */
    function spammer($ip = null)
    {
        return new \Helldar\Spammers\Facade\Spammer($ip);
    }
}

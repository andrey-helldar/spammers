<?php

if (!function_exists('spammer')) {
    /**
     * @param null|string $ip
     *
     * @return \Helldar\Spammers\Facade\Spammer
     */
    function spammer($ip = null)
    {
        return new \Helldar\Spammers\Facade\Spammer($ip);
    }
}

if (!function_exists('spammer_access')) {
    /**
     * @return \Helldar\Spammers\Facade\SpammerAccess
     */
    function spammer_access()
    {
        return new \Helldar\Spammers\Facade\SpammerAccess();
    }
}

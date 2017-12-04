<?php

if (!function_exists('spammer')) {
    /**
     * @return \Helldar\Spammers\Facade\Spammer
     */
    function spammer()
    {
        return new \Helldar\Spammers\Facade\Spammer();
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

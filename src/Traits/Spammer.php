<?php

namespace Helldar\Spammers\Traits;

use Helldar\Spammers\Facade\Spammer as SpammerFacade;

trait Spammer
{
    /**
     * @var null|string
     */
    protected $ip = null;

    /**
     * @return \Helldar\Spammers\Facade\Spammer
     */
    public function spammer()
    {
        return new SpammerFacade($this->ip);
    }
}

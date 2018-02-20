<?php

namespace Helldar\Spammers\Facade;

use Helldar\Spammers\Models\SpammerAccess as SpammerAccessModel;
use Helldar\Spammers\Traits\ValidateIP;

class SpammerAccess
{
    use ValidateIP;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @param null $ip
     *
     * @return $this
     */
    public function ip($ip = null)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Store URL-address into database.
     *
     * @return null|\Illuminate\Support\MessageBag|SpammerAccess
     */
    public function store()
    {
        if ($this->errors = $this->isIpValidateError()) {
            return $this->errors;
        }

        return SpammerAccessModel::create(['ip' => $this->ip], ['url' => $this->url]);
    }

    /**
     * Validate URL-address.
     *
     * @param null $url
     *
     * @return $this
     */
    public function url($url = null)
    {
        $validator = \Validator::make(compact('url'), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return $this;
        }

        $this->url = $url;

        return $this;
    }
}

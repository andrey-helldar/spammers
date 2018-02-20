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
     * SpammerAccess constructor.
     *
     * @param null $ip
     */
    public function __construct($ip = null)
    {
        $this->ip($ip);
    }

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
     * @return $this|array|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\MessageBag|null|string
     */
    public function store()
    {
        if ($this->errors = $this->isIpValidateError()) {
            return $this->errors;
        }

        $ip = $this->ip;
        $url = $this->url;

        return SpammerAccessModel::query()
            ->firstOrCreate(compact('ip'), compact('url'));
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
            $this->errors = $validator->errors()->all();

            return $this;
        }

        $this->url = $url;

        return $this;
    }
}

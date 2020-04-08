<?php

namespace Helldar\Spammers\Traits;

use Helldar\Spammers\Rules\IpAddressNotInMask;
use Helldar\Spammers\Rules\IsCrawler;
use Illuminate\Validation\Rule;

trait ValidateIP
{
    /**
     * @var array|string|null
     */
    protected $errors = null;

    /**
     * @var string|null
     */
    protected $ip = null;

    /**
     * @param array|string|null $errors
     */
    public function errorsInConsole($errors = null)
    {
        if (!is_array($errors) && !is_object($errors)) {
            $this->error($errors);

            return;
        }

        foreach (array_values((array) $errors) as $error) {
            $this->errorsInConsole($error);
        }
    }

    /**
     * Validation IP-address.
     *
     * @return \Illuminate\Support\MessageBag|null
     */
    public function isIpValidateError()
    {
        $ip        = $this->ip;
        $validator = \Validator::make(compact('ip'), [
            'url' => 'url',
            'ip'  => [
                'required',
                'ipv4',
                Rule::notIn(config('spammers_settings.protected_ips', [])),
                //Rule::notIn(config('spammers.exclude_ips', [])),
            ],
        ], $this->messages());

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        if ($errors = $this->additionalRules()) {
            return $errors;
        }

        return null;
    }

    /**
     * @return array
     */
    private function additionalRules()
    {
        $errors = [];

        if ($is_founded = $this->isFounded()) {
            $errors[] = $is_founded;
        }

        if ($is_crawler = $this->isCrawler()) {
            $errors[] = $is_crawler;
        }

        return $errors;
    }

    /**
     * @return array|null
     */
    private function isFounded()
    {
        $ips        = config('spammers.exclude_ips', []);
        $is_founded = (new IpAddressNotInMask($this->ip, $ips))->check();

        if ($is_founded) {
            return (array) $this->messages()['is_founded'];
        }

        return null;
    }

    /**
     * @return array|null
     */
    private function isCrawler()
    {
        return (new IsCrawler($this->ip))->check();
    }

    /**
     * Messages for validation.
     *
     * @return array
     */
    private function messages()
    {
        return [
            'not_in'     => "IP-address {$this->ip} is protected!",
            'is_founded' => "The IP-address {$this->ip} is found in the exclusion list!",
        ];
    }
}

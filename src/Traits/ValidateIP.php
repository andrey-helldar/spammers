<?php

namespace Helldar\Spammers\Traits;

use Illuminate\Validation\Rule;

trait ValidateIP
{
    /**
     * @var null|string|array
     */
    protected $errors = null;

    /**
     * @var null|string
     */
    protected $ip = null;

    /**
     * @param null|string|array $errors
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
                Rule::notIn(config('spammers.exclude_ips', [])),

            ],
        ], $this->messages());

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        return null;
    }

    /**
     * Messages for validation.
     *
     * @return array
     */
    private function messages()
    {
        return [
            'not_in' => "IP-address {$this->ip} is protected!",
        ];
    }
}

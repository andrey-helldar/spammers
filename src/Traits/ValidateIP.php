<?php

namespace Helldar\Spammers\Traits;

use Illuminate\Validation\Rule;

trait ValidateIP
{
    /**
     * @var null|string
     */
    protected $ip = null;

    /**
     * Validation IP-address.
     *
     * @return \Illuminate\Support\MessageBag|null
     */
    public function isIpValidateError()
    {
        $validator = \Validator::make(['ip' => $this->ip], [
            'ip' => [
                'required',
                'ipv4',
                Rule::notIn(config('spammers_settings.protected_ips', [])),
                Rule::notIn(config('spammers.exclude_ips', [])),
            ],
        ], $this->messages());

        if ($validator->fails()) {
            return $validator->errors();
        }

        return null;
    }

    /**
     * @param array $errors
     */
    public function errorsInConsole($errors = [])
    {
        if (gettype($errors) !== 'array' && gettype($errors) !== 'object') {
            $this->error($errors);
            return;
        }

        foreach (array_values((array)$errors) as $error) {
            $this->errorsInConsole($error);
        }
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

<?php

namespace Helldar\Spammers\Traits;

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
            'ip' => 'required|ipv4',
        ]);

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
}

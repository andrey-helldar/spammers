<?php

namespace Helldar\Spammers\Rules;

class IpAddressNotInMask
{
    /**
     * @var string|null
     */
    protected $client_ip;

    /**
     * @var array
     */
    protected $ips = [];

    /**
     * IpAddressNotInMask constructor.
     *
     * @param string|null $client_ip
     * @param array       $ips
     */
    public function __construct($client_ip = null, $ips = [])
    {
        $this->client_ip = $client_ip;
        $this->ips       = $ips;
    }

    /**
     * @return bool
     */
    public function check()
    {
        foreach ((array) $this->ips as $ip) {
            if ($this->is($ip, $this->client_ip)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $pattern
     * @param $value
     *
     * @return bool
     */
    private function is($pattern, $value)
    {
        if ($pattern == $value) {
            return true;
        }

        $pattern = preg_quote($pattern, '#');
        $pattern = str_replace('\*', '.*', $pattern);

        return (bool) preg_match('#^' . $pattern . '\z#u', $value);
    }
}

<?php

return [
    /*
     * Connection name.
     *
     * Default, "mysql".
     */

    'connection' => null,

    /*
     * Base table name.
     *
     * Default, "spammers".
     */

    'table' => 'spammers',

    /*
     * Table name for store accessing when get error pages.
     *
     * Default, "spammer_accesses".
     */

    'table_access' => 'spammer_accesses',

    /*
     * The period of days during which you need to consider the number of errors for IP addresses.
     *
     * Default, 24.
     */

    'period' => 24,

    /*
     * Ban when attempts to get pages with errors exceed a given number.
     *
     * Example:
     *   When the number of attempts reaches 100 - ban for 24 hours.
     *   When the number of attempts reaches 300 - ban for 72 hours.
     *   When the number of attempts reaches 500 - permanent ban.
     *
     * Default, permanent ban.
     */

    'attempts' => [
        100 => 24,
        300 => 72,
        500 => null,
    ],

    /*
     * Excluded IP-addresses.
     *
     * Mask support.
     */

    'exclude_ips' => [
        // '1.2.3.4',
        // '1.2.3.*',
    ],

    /*
     * Banning the IP addresses of search bots and others?
     *
     * Default, false.
     */

    'ban_crawlers' => false,
];

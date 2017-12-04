<?php

return [
    /*
     * Connection name.
     */
    'connection' => null,

    /*
     * Base table name.
     */
    'table' => 'spammers',

    /*
     * Table name for store accessing when get error pages.
     */
    'table_access' => 'spammer_accesses',

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
    'ban_when_access' => [
        100 => 24,
        300 => 72,
        500 => null
    ],

    /*
     * To activate the cache, specify the number of minutes.
     *
     * Default, false.
     */
    'use_cache' => false,

    /*
     * Excluded IP-addresses.
     */
    'exclude_ips' => [],
];

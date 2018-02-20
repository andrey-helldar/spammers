<?php

return [
    /*
     * Connection name.
     *
     * Default, null.
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
     * Default, "spammer_access".
     */

    'table_access' => 'spammer_access',

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
        500 => null,
    ],

    /*
     * Excluded IP-addresses.
     */

    'exclude_ips' => [],
];

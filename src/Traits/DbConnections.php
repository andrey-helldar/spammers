<?php

namespace Helldar\Spammers\Traits;

trait DbConnections
{
    /**
     * @var null
     */
    protected $connection = null;

    /**
     * @var string
     */
    protected $table = null;

    /**
     * Set a connection name.
     */
    public function setConnection()
    {
        $this->connection = config('spammers.connection', config('database.default', 'mysql'));
    }

    /**
     * Set a table name.
     */
    public function setTable()
    {
        $this->table = config('spammers.table', 'spammers');
    }
}

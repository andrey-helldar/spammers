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
    public function setConnectionName()
    {
        $this->connection = config('spammers.connection', config('database.default', 'mysql'));
    }

    /**
     * Set a table name.
     */
    public function setTableName()
    {
        $this->table = config('spammers.table', 'spammers');
    }
}

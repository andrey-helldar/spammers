<?php

namespace Helldar\Spammers\Traits;

trait DbConnections
{
    /**
     * @var null
     */
    protected $table_access = null;

    /**
     * @var null
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
     * Set a table name for logging.
     */
    public function setTableAccessName()
    {
        $this->table_access = config('spammers.table_access', 'spammer_access');
    }

    /**
     * Set a table name.
     */
    public function setTableName()
    {
        $this->table = config('spammers.table', 'spammers');
    }
}

<?php

namespace Helldar\Spammers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spammer extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $casts = [
        'ip' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip'];

    /**
     * Spammer constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('spammers.table', 'spammers');

        $this->readConnection();

        parent::__construct($attributes);
    }

    /**
     * Reading a connection name from config file.
     */
    private function readConnection()
    {
        if ($connection = config('spammers.connection', null)) {
            $this->setConnection($connection);
        }
        else {
            $connection = config('database.default', 'mysql');
            $this->setConnection($connection);
        }
    }
}

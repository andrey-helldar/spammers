<?php

namespace Helldar\Spammers\Models;

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spammer extends Model
{
    use SoftDeletes, DbConnections;

    /**
     * @var array
     */
    protected $casts = [
        'ip' => 'string',
        'attempts' => 'int',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip', 'attempts', 'expired_at'];

    /**
     * Spammer constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setConnectionName();
        $this->setTableName();

        parent::__construct($attributes);
    }
}

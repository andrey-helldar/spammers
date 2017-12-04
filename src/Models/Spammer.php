<?php

namespace Helldar\Spammers\Models;

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spammer extends Model
{
    use SoftDeletes, DbConnections;

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
        $this->setConnection();
        $this->setTable();

        parent::__construct($attributes);
    }
}

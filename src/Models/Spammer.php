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

    protected $casts = [
        'ip' => 'string',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip'];

    public function __construct(array $attributes = [])
    {
        $this->connection = config('spammers.connection', null);
        $this->table      = config('spammers.table', 'spammers');

        parent::__construct($attributes);
    }
}

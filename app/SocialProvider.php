<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialProvider extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['provider_id', 'provider', 'token', 'token_secret', 'alias', 'error'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

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
    protected $fillable = [
        'text', 'post_time', 'account_id'
    ];

    public function images()
    {
        return $this->hasMany('App\ImagesPost');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }
}

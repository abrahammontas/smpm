<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
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

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesPost extends Model
{
    protected $table = 'images_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'image'
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}

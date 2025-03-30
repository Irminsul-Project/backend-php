<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ForumCommnet extends Model
{
    protected $connection = "mongodb";
    protected $collection = "commnet";
    protected $fillable = [
        "forum_id",
        "commnet_id",
        "create_user",
        "content"
    ];

    public function comments()
    {
        return $this->hasMany(ForumCommnet::class, 'commnet_id');
    }
}

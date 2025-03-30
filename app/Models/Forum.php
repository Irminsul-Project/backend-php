<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Forum extends Model
{
    protected $connection = "mongodb";
    protected $collection = "forum";
    protected $fillable = [
        "title",
        "create_user",
        "content",
        "comment",
        "tags"
    ];

    public function Comments() {
        return $this->hasMany(ForumCommnet::class, 'forum_id');
    }
}

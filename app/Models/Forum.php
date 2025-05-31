<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Forum extends Model
{
    protected $connection = "mongodb";
    protected $collection = "forum";
    protected $fillable = [
        "title",
        "create_user",
        "content"
    ];

    public function Comments(): MorphMany {
        return $this->morphMany(Comment::class, 'Commentable');
    }

    public function Tags() {
        return $this->hasMany(ForumTag::class, 'forum_id');
    }
}

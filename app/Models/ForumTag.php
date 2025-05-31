<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ForumTag extends Model
{
    protected $connection = "mongodb";
    protected $collection = "forum_tag";
    protected $fillable = [
        "forum_id",
        "tag"
    ];
}

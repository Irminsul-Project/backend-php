<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $connection = "mongodb";
    protected $collection = "comment";
    protected $fillable = [
        "create_user",
        "content"
    ];

    public function Commentable(): MorphTo {
        return $this->morphTo();
    }
}

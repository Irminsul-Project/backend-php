<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ResearchTargetHistory extends Model
{
    protected $connection = "mongodb";
    protected $collection = "research_target_history";
    protected $fillable = [
        "research_target_id",
        "user_id",
        "status_change"
    ];
}

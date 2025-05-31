<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ResearchTarget extends Model
{
    protected $connection = "mongodb";
    protected $collection = "research_target";
    protected $fillable = [
        "research_id",
        "user_id",
        "content",
        "status"
    ];

    public function TargetHistory() {
        return $this->hasMany(ResearchTargetHistory::class, 'research_target_id');
    }
}

<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Enum\ResearchTimeLineStatus;

class ResearchTimeLine extends Model
{
    protected $connection = "mongodb";
    protected $collection = "contiributor_research";
    protected $fillable = [
        "research_id",
        "user_id",
        "title",
        "content",
        "status"
    ];

    protected $casts = [
        'status' => ResearchTimeLineStatus::class,
    ];

    public function ResearchTarget () {
        return $this->hasOne(ResearchTargetHistory::class, 'research_target_id');
    }
}

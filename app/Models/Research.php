<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Enum\ResearchStatus;

class Research extends Model
{
    protected $connection = "mongodb";
    protected $collection = "research";
    protected $fillable = [
        "title",
        "content",
        "status"
    ];
    
    protected $casts = [
        'status' => ResearchStatus::class
    ];

    public function Contributor() {
        return $this->hasMany(ResearchContributor::class, 'research_id');
    }

    public function TimeLine(){
        return $this->hasMany(ResearchTimeLine::class, 'research_id');
    }

    public function Target(){
        return $this->hasMany(ResearchTarget::class, 'research_id');
    }
}

<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Enum\ContributorStatus;
use App\Enum\ContributorType;

class ResearchContributor extends Model
{
    protected $connection = "mongodb";
    protected $collection = "contiributor_research";
    protected $fillable = [
        "research_id",
        "user_id",
        "contributor_rule",
        "contributor_status"
    ];

    protected $casts = [
        'contributor_rule' => ContributorType::class,
        'contributor_status' => ContributorStatus::class
    ];

    public function User() {
        return $this->hasOne(User::class, 'user_id');
    }
}

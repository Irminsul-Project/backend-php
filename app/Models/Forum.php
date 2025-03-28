<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Forum extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum';
    protected $fillable = ['title', 'content'];
}

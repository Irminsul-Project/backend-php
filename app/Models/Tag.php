<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'description',
        'action_user',
        'reason',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowlageLavel extends Model
{
    protected $table = "knowlage_lavel";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        "code",
        "order",
        "description"
    ];
}

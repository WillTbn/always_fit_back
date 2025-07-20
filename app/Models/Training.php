<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $fillable = [
        'hash_id',
        'name',
        'description',
        'equipment',
        'meta_days',
        'level',
        'subname',
    ];
    protected $hidden = [
        'id',
    ];
}

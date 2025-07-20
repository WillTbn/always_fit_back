<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgressLog extends Model
{
    /** @use HasFactory<\Database\Factories\ProgressLogFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash_id',
        'user_id',
        'training_id',
        'completion_date',
        'status',
        'progress',
    ];
}

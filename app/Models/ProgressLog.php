<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function training():BelongsTo
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }
}

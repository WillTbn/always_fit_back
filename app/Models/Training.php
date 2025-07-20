<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function progressLogs(): HasMany
    {
        return $this->hasMany(ProgressLog::class, 'training_id', 'id');
    }
}

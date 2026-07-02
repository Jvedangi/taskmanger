<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'task_id',
        'old_values',
        'new_values',
        'deleted',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'deleted' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}

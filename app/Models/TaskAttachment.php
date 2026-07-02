<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    protected $fillable = [
        'task_id',
        'filename',
        'path'
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }


}

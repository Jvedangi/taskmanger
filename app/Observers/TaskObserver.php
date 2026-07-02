<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $this->logAction('created', $task);
        Log::info("Task created: ", ['task_id' => $task->id, 'user_id' => Auth::id()]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $this->logAction('Task updated', $task, $task->getOriginal());
        Log::info('Task updated: ', ['task_id' =>$task->id, 'user_id' => Auth::id()]);
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        $this->logAction('Task Deleted', $task, $task->getOriginal());
        Log::info('Task updated: ', ['task_id' =>$task->id, 'user_id' => Auth::id()]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }

    public function logAction($action, Task $task, $oldValues = null){
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'task_id' => $task->id,
            'old_values' => $oldValues,
            'new_values' => $task->toArray(),
        ]);

    }
}

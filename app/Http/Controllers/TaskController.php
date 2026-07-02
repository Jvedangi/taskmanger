<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskNotificationMail;
use App\Models\TaskAttachment;

class TaskController extends Controller
{
    // Display a listing of the dashboard.
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id()); // show only tasks of logged in user

        // search by title
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        //search by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status == 'pending') {
                $query->where('is_completed', false);
            }
        }
        $tasks = $query->latest()->paginate(10);

        return view('dashboard', compact('tasks'));
    }

    // Show the form for creating a new task.
    public function create()
    {
        return view('tasks.create');
    }

    // Store a newly created task in storage.
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed'
        ]);


        $task = auth()->user()->tasks()->create($validated);

        // handle file attachment if exists
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('task_attachments', 'public');
                    $task->attachments()->create([
                        'task_id' => $task->id,
                        'path' => $path,
                        'filename' => $file->getClientOriginalName()
                    ]);
                }
            }
        }

        // Send email notification
        Mail::to(auth()->user()->email)
            ->cc('pkemble@softcell.com')
            ->send(new TaskNotificationMail($task, 'New Task Created'));
        return redirect()->route('dashboard')->withSuccess('Task created successfully.');
    }

    // Mark the specified task as completed.
    public function complete(Task $task)
    {
        $task->update(['is_completed' => true]);
        return redirect()->route('dashboard')->withSuccess('Task marked as completed.');
    }

    // Show the form for editing the specified task.
    public function edit(Task $task)
    {

        $auditLogs = AuditLog::where('task_id', $task->id)->with('user')->latest()->paginate(10);
        $attachments = $task->attachments;
        return view('tasks.edit', compact('task', 'auditLogs', 'attachments'));
    }

    // Remove the specified task from storage.
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('dashboard')->withSuccess('Task deleted successfully.');
    }

    // Update the specified task in storage.
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'due_date' => 'nullable|date',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'attachments.*' => 'file|mimes:jpg,png,pdf,docx,txt|max:2048'
        ]);

        $task->update($validated);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('task_attachments', 'public');
                    $task->attachments()->create([
                        'path' => $path,
                        'filename' => $file->getClientOriginalName()
                    ]);
                }
            }
        }

        Mail::to(auth()->user()->email)
            ->cc('pkemble@softcell.com')
            ->send(new TaskNotificationMail($task, 'Task Updated'));

        return redirect()->route('dashboard')->withSuccess('Task updated successfully');
    }
}

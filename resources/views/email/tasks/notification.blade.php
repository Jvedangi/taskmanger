@component('mail::message')
# {{ $subjectLine }}

** Task:** {{ $task->title }}
** Description:** {{ $task->description }}
** Status:** {{ $task->is_completed ? '✅ Completed' : '⏳ Pending' }}
** Created At:** {{ $task->created_at->format('d M Y, h:i A') }}
** Due Date:** {{  $task->due_date ? $task->due_date->format('d M Y') : 'N/A' }}
@component('mail::button', ['url' => route('tasks.edit', $task->id)])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


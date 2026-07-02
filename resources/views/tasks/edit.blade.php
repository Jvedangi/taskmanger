<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Edit Task Form -->
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label font-medium">Task Title</label>
                        <input type="text" name="title" class="form-input w-full rounded border-gray-300"
                            value="{{ $task->title }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-medium">Description</label>
                        <textarea name="description" class="form-input w-full rounded border-gray-300">{{ $task->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-medium">Due Date</label>
                        <input type="date" name="due_date" class="form-input w-full rounded border-gray-300"
                            value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : date('Y-m-d') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label font-medium">Priority</label>
                        <select name="priority" class="form-input w-full rounded border-gray-300">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label font-medium">Status</label>
                        <select name="status" class="form-input w-full rounded border-gray-300">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                Progress</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label font-medium">Attachments</label>
                        <input type="file" name="attachments[]" class="form-input w-full rounded border-gray-300" multiple>
                    </div>


                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Update Task
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="mt-8 bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Audit Log History</h3>

        @if ($auditLogs->isEmpty())
            <p class="text-gray-500 text-sm">No audit logs available for this task.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border text-left">#</th>
                            <th class="px-4 py-2 border text-left">Action</th>
                            <th class="px-4 py-2 border text-left">Changes</th>
                            <th class="px-4 py-2 border text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auditLogs as $index => $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $log->action }}</td>
                                <td class="px-4 py-2 border text-gray-600 text-xs">
                                    @if ($log->old_values)
                                        <div><strong>Old:</strong>
                                            <ul class="list-disc list-inside">
                                                @foreach ($log->old_values as $key => $value)
                                                    <li>{{ $key }}: {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if ($log->new_values)
                                        <div class="mt-1"><strong>New:</strong>
                                            <ul class="list-disc list-inside">
                                                @foreach ($log->new_values as $key => $value)
                                                    <li>{{ $key }}: {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-gray-500">
                                    {{ $log->created_at->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="mt-4">
        {{ $auditLogs->links() }}
    </div>
</x-app-layout>
<!-- Audit Logs Section -->

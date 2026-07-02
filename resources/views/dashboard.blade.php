<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tasks Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Add Task Button -->
                <div class="mb-4 flex justify-between items-center">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        ➕ Add Task
                    </a>

                    <!-- Optional: Search & Filter -->
                    <form action="{{ route('tasks.index') }}" method="GET" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title..." class="border rounded px-2 py-1 mr-2">
                        <select name="status" class="border rounded px-2 py-1 mr-2">
                            <option value="">All</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mr-2">
                            Filter
                        </button>

                        <a href="{{ route('tasks.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Clear
                        </a>

                    </form>
                </div>

                <!-- Tasks Table -->
                <table class="w-full border border-gray-200 text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Sr.No</th>
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Description</th>
                            <th class="px-4 py-2 border">Due Date</th>
                            <th class="px-4 py-2 border">Priority</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $key => $task)
                            <tr>
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $task->title }}</td>
                                <td class="px-4 py-2 border">{{ $task->description }}</td>
                                <td class="px-4 py-2 border">{{ $task->due_date->format('d-m-Y') }}</td>
                                <td class="px-4 py-2 border">{{ $task->priority }}</td>
                                <td>
                                    <span class="px-4 py-2 border badge {{ $task->status == 'completed' ? 'bg-green-600' : ($task->status == 'in_progress' ? 'bg-blue-500' : 'bg-gray-500') }}">
                                        {{ ucfirst(str_replace('_',' ',$task->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 border flex gap-1">
                                    @if(!$task->is_completed)
                                    <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">Mark Done</button>
                                    </form>
                                    @endif
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this task?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-gray-500">No tasks found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                 <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Add Task Form -->
                <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" >
                    @csrf

                    <div class="mb-4">
                        <label class="form-label font-medium">Task Title</label>
                        <input type="text" name="title" class="form-input w-full rounded border-gray-300" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-medium">Description</label>
                        <textarea name="description" class="form-input w-full rounded border-gray-300" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label name="due_date" class="form-label font-medium">Due Date</label>
                        <input type="date" name="due_date" class="form-input w-full rounded border-gray-300" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-4">
                        <label name="priority" class="form-label font-medium">Priority</label>
                        <select name="priority" class="form-input w-full rounded border-gray-300" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label name="status" class="form-label font-medium">Status</label>
                        <select name="status" class="form-input w-full rounded border-gray-300" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label font-medium">Attachments</label>
                        <input type="file" name="attachments[]" class="form-input w-full rounded border-gray-300" multiple>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Save Task
                        </button>
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Back
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

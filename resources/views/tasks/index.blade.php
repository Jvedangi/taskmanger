@extends('tasks.layout')
@section('content')
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('tasks.create') }}" class="btn btn-success">Add Task</a>
        <form action="{{ route('tasks.index') }}" class="d-flex" method="GET" >
            <input type="text" name="title" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}">
            <select name="status" class="form-select me-2">
                <option value="">All</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SR.No</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th width="230">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $key => $task)
                <tr>
                    <td>{{ (int)$key+1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        @if ($task->is_completed)
                            Completed
                        @else
                            Pending
                        @endif
                    </td>
                    <td>
                        @if (!$task->is_completed)
                            <form action="{{ route('tasks.complete', $task->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">Mark Done</button>
                            </form>
                        @endif
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection

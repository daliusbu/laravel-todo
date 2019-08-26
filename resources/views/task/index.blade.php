@extends('crud.layouts.layout')

@section('content')
    <h2>My tasks</h2>

    <div>
        <form action="{{ route('task.index') }}" method="GET" id="filter-form">
            <select name="sf" id="list-filter">
                <option value="">{{ __('--All--') }}</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}"
                            @if ($status->id === intval(session('status_filter'))) selected @endif>{{ $status->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="my-3">
        <a href="{{ route('task.add') }}">ADD </a>
        <a href="#" id="button-trash">&nbsp; DELETE</a>
    </div>

    <div>
        <form id="selected-form" method="POST" action="{{ route('task.delete') }}">
            @csrf
            @method('DELETE')

            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="{{ $task->id }}">&nbsp;
                            <a href="{{ route('task.edit', ['id' => $task->id]) }}">{{ 'Edit' }}</a>
                        </td>
                        <td>
                            <a href="{{ route('task.view', ['id' => $task->id] )}}">{{ $task->status->name }} </a>
                        </td>
{{--                                        {{ dump($tasks->lecture, die()) }}--}}

                        <td>{{ $task->status->name }}</td>
                        <td>{{ $task->grade }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>

        <div class="pagination pagination-sm justify-content-center">
            {{ $tasks->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trash form submit
            document.getElementById('button-trash').addEventListener('click', function () {
                document.getElementById('selected-form').submit();
            });
            // Select all checkbox
            document.getElementById('select-all').addEventListener('click', function () {
                check = this.checked;
                boxes = document.querySelectorAll('input[name="selected[]"]:not(:disabled)');
                boxes.forEach(function (item) {
                    item.checked = check;
                });
            });
            // Filter form submit on select change
            document.getElementById('list-filter').addEventListener('change', function () {
                document.getElementById('filter-form').submit();
            });
        }, false);
    </script>
@endsection

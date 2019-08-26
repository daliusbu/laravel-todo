@extends('crud.layouts.layout')

@section('content')
    <h1>Task add</h1>
    @include('partials.form-errors')
    <div>
        <form action="{{ route('task.add.save') }}" method="POST">
            @csrf
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Task</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input class="col-sm-5 input-group-sm" type="text" name="task_name"
                               value="{{ request()->old('task_name') }}">
                    </td>
                    <td>
                        <input class="col-sm-5 input-group-sm" type="text" name="task_description"
                               value="{{ request()->old('task_description') }}">
                    </td>
                    <td>
                        <select name="status_id" id="student-filter">
                            <option value="">--All--</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                        @if ($status->id == request()->old('status_id')) selected @endif>{{ $status->name }} </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <div>
            </div>
            <div>
                <button type="submit">Add Task</button>&nbsp;<a href="{{ route('task.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.ck-editor')
@endsection
@extends('layout.dashboard')

@section('content')
    <h1 class="text-start my-5">Create New Task</h1>
    <form class="row g-3" method="post" action="{{ route('task.store') }}">
        @csrf
        <div class="col-4">
            <label for="assigned_by" class="form-label">Admin Name</label>
            <select id="assigned_by" class="form-select" name="assigned_by">
                <option value="">Choose...</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ old('assigned_by') == $admin->id ? "selected" : "" }}>{{ $admin->name }}</option>
                @endforeach
            </select>
            @error('assigned_by')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ old('title') }}">
            @error('title')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-4">
            <label for="assigned_to" class="form-label">Assigned User</label>
            <select id="assigned_to" class="form-select" name="assigned_to">
                <option value="">Choose...</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('assigned_to')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-12">
            <label for="description" class="form-label">description</label>
            <textarea class="form-control" placeholder="Leave a description here" id="description"
                      name="description">{{ old('description') }}</textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
@endsection



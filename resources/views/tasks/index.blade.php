@extends('layout.dashboard')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <h1 class="text-start my-5">Tasks</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col">description</th>
            <th scope="col">assigned name</th>
            <th scope="col">admin name</th>
        </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->user->name ?? null }}</td>
                <td>{{ $task->admin->name ?? null }}</td>
            </tr>
        @empty
            <tr>
                <th colspan="5" class="text-center">no tasks found</th>
            </tr>
        @endforelse

        </tbody>

        {{ $tasks->links() }}
    </table>
@endsection



@extends('layout.dashboard')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <h1 class="text-start my-5">Statistics</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User Name</th>
            <th scope="col">Tasks Count</th>
        </tr>
        </thead>
        <tbody>
        @forelse($statistics as $statistic)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $statistic->user->name ?? null }}</td>
                <td>{{ $statistic->count }}</td>
            </tr>
        @empty
            <tr>
                <th colspan="5" class="text-center">no data found</th>
            </tr>
        @endforelse

        </tbody>
    </table>
@endsection



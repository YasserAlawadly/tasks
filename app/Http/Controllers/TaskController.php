<?php

namespace App\Http\Controllers;

use App\Http\Requests\createTaskRequest;
use App\Jobs\UpdateStatisticsJob;
use App\Models\Statistic;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('admin' , 'user')->paginate(10);
        return view('tasks.index' , compact('tasks'));
    }

    public function create()
    {
        $admins = Cache::remember('admins', 60 * 60 * 24, function () {
            return User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get();
        });

        $users = Cache::remember('users', 60 * 60 * 24, function () {
           return User::whereHas("roles", function($q){ $q->where("name", "user"); })->get();
        });

        return view('tasks.create' , compact('admins' , 'users'));
    }

    public function store(createTaskRequest $request)
    {
        $validated = $request->validated();

        Task::create([
            'title' => $validated['title'],
            'assigned_to_id' => $validated['assigned_to'],
            'assigned_by_id' => $validated['assigned_by'],
            'description' => $validated['description'],
        ]);

        $user = User::findOrfail($validated['assigned_to']);
        dispatch(new UpdateStatisticsJob($user));

        session()->flash('success', 'Added Successfully');

        return redirect()->route('task.index');
    }


    public function statistics()
    {

    }
}

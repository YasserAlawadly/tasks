<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\createTaskRequest;
use App\Http\Requests\updateTaskRequest;
use App\Http\Resources\Api\TaskResource;
use App\Jobs\UpdateStatisticsJob;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = TaskResource::collection(Task::with('admin' , 'user')->paginate(10));
        return api_response(true, null ,  $tasks);
    }

    public function show(Task $task)
    {
        return api_response(true, null ,  new TaskResource($task));
    }

    public function store(createTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'title' => $validated['title'],
            'assigned_to_id' => $validated['assigned_to'],
            'assigned_by_id' => $validated['assigned_by'],
            'description' => $validated['description'],
        ]);

        $user = User::findOrfail($validated['assigned_to']);
        dispatch(new UpdateStatisticsJob($user));

        return api_response(true, 'added successfully' , new TaskResource($task));
    }

    public function update(updateTaskRequest $request , Task $task)
    {
        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
            'assigned_to_id' => $validated['assigned_to'],
            'assigned_by_id' => $validated['assigned_by'],
            'description' => $validated['description'],
        ]);

        dispatch(new UpdateStatisticsJob($task->user));

        return api_response(true, 'updated successfully' , new TaskResource($task));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        dispatch(new UpdateStatisticsJob($task->user));

        return api_response(true, 'deleted successfully' , new TaskResource($task));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
        return response()->json(Task::latest()->get());
    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'is_done' => ['sometimes', 'boolean'],
        ]);
        
        $task = Task::create($validated);
        return response()->json($task, 201);

    }

    // PUT /api/task/{id}
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3'],
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    // PUT /api/task/{id}/complete
    public function complete(Task $task)
    {
        $task->update([
            'is_done' => true,
        ]);

        return response()->json($task);
    }

    // DELETE /api/task/{id}
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }

    // GET /api/task/complete
    public function completed()
    {
        return response()->json(
            Task::where('is_done', true)->latest()->get()
        );
    }
}

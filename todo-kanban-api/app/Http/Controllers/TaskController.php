<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Make sure this is present


class TaskController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task = auth()->user()->tasks()->create($validated);
        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:todo,in_progress,done',
        ]);
        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $task->delete();
        return response()->json(null, 204);
    }
}

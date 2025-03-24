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

        $user = auth()->user();

        if (!$user ) {
            return response()->json(['error' => 'User not authenticated'], 401); // UNAUTHORIZED
        }

        return response()->json(auth()->user()->tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        // Manually fetch the first user for testing
        $user = User::first();

        if (!$user) {
            return response()->json(['error' => 'No users found'], 400);
        }
        // $task = $user->tasks()->create($validated); //TEMPORARY

        $task = auth()->user()->tasks()->create( $validated);
        return response()->json($task, 201); //HTTP: Successful Insert
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
        return response()->json($task, 200); // HTTP: OK
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $task->delete();
        return response()->json(null, 204); //HTTP: Successful but No Content
    }
}

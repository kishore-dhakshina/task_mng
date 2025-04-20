<?php

namespace App\Http\Controllers;

use App\Services\AdminTaskService;
use App\Services\UserTaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $taskService;

    // Constructor to inject the appropriate task service based on the user's role
    public function __construct()
    {
        $role = Auth::user()->role; // Assuming 'role' field exists on the User model and can be either 'admin' or 'user'

        if ($role === 'admin') {
            $this->taskService = new AdminTaskService(); // Admin can perform all actions
        } else {
            $this->taskService = new UserTaskService(); // Regular user has limited access
        }
    }

    // Create a new task
    public function create(Request $request)  // verified
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $task = $this->taskService->create($validatedData);
        return response()->json($task, 201);
    }

    // List all tasks with pagination
    public function index(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());exit;
        $user = JWTAuth::parseToken()->authenticate();
        $tasks = $this->taskService->list($user->id, $request->get('limit', 10));
        return response()->json($tasks);
    }

    // Get a specific task by ID
    public function show($id)
    {
        $task = $this->taskService->getById($id);
        return response()->json($task);
    }

    // Update a task
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_completed' => 'nullable|boolean'
        ]);

        $task = $this->taskService->update($id, $validatedData);
        return response()->json($task);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = $this->taskService->delete($id);
        return response()->json($task);
    }

    // Assign a task to another user
    public function assign(Request $request, $taskId)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $task = $this->taskService->assignTask($taskId, $validatedData['user_id']);
        return response()->json($task);
    }

    // Mark a task as complete
    public function markComplete($id)
    {
        $task = $this->taskService->markComplete($id);
        return response()->json($task);
    }
}

<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskService
{
    // Create a new task
    public function create(array $data)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = new Task();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->category_id = $data['category_id'];
        $task->user_id = $user->id; // Assign task to the logged-in user
        $task->save();

        return $task;
    }

    public function list(int $userId, int $limit = 10)
    {
        return Task::where('user_id', $userId)
            ->paginate($limit);
    }

    // Get a specific task by ID
    public function getById(int $id)
    {
        return Task::findOrFail($id);
    }

    // Update a task
    public function update(int $id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);

        return $task;
    }

    // Delete a task
    public function delete(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

    // Assign a task to another user
    public function assignTask(int $taskId, int $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->user_id = $userId;
        $task->save();

        return $task;
    }

    // Mark a task as completed
    public function markComplete(int $id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = true;
        $task->save();

        return $task;
    }
}

?>
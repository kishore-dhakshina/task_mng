<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminTaskService extends TaskService
{
    // Override delete method to allow admins to delete any task
    public function delete(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully by admin']);
    }

    // Admins can create tasks for any user, not just themselves
    public function create(array $data)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = new Task();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->category_id = $data['category_id'];
        $task->user_id =$user->id; // Admin can specify user
        $task->save();

        return $task;
    }

    // Admins can assign tasks to other users
    public function assignTask(int $taskId, int $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->user_id = $userId;
        $task->save();

        return $task;
    }
}

?>
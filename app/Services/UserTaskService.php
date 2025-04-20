<?php
namespace App\Services;

use App\Models\Task;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTaskService extends TaskService
{
    // Override delete method to restrict users from deleting other users' tasks
    public function delete(int $id)
    {
        $task = Task::findOrFail($id);
        
        // Ensure the task belongs to the authenticated user
        if ($task->user_id !== JWTAuth::user()->id()) {
            return response()->json(['message' => 'You can only delete your own tasks'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

}

?>
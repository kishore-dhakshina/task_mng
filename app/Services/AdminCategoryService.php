<?php
namespace App\Services;

use App\Models\Category;

class AdminCategoryService extends CategoryService
{
    // Admins can delete categories even if they have tasks
    public function delete(int $id)
    {
        $category = Category::findOrFail($id);
        
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully by admin']);
    }
}

?>
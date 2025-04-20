<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    // Create a new category
    public function create(array $data)
    {
        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        return $category;
    }

    // List all categories
    public function list()
    {
        return Category::all();
    }

    // Update a category
    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);

        return $category;
    }

    // Delete a category (only if no tasks are associated)
    public function delete(int $id)
    {
        $category = Category::findOrFail($id);

        // Check if any tasks are associated with the category
        if ($category->tasks()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with, this category is used in the one of the tasks'], 400);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}

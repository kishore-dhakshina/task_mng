<?php

namespace App\Http\Controllers;

use App\Services\AdminCategoryService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryService;

    // Constructor to inject the appropriate category service based on the user's role
    public function __construct()
    {
        $role = Auth::user()->role; // Assuming 'role' field exists on the User model and can be either 'admin' or 'user'

        if ($role === 'admin') {
            $this->categoryService = new AdminCategoryService(); // Admin can perform all actions
        } else {
            $this->categoryService = new CategoryService(); // Regular user can only create, update, and list categories
        }
    }

    // Create a new category
    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = $this->categoryService->create($validatedData);
        return response()->json($category, 201);
    }

    // List all categories
    public function index()
    {
        $categories = $this->categoryService->list();
        return response()->json($categories);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = $this->categoryService->update($id, $validatedData);
        return response()->json($category);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = $this->categoryService->delete($id);
        return response()->json($category);
    }
}

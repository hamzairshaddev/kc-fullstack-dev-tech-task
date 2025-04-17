<?php

namespace App\Controllers;

use App\Models\Category;
use App\Services\Database;
use App\Services\Response;

class CategoryController
{
    protected $database;
    protected $responseService;

    public function __construct()
    {
        // Instantiate the Database service directly in the constructor
        $this->database = new Database();
        $this->responseService = new Response();
    }

    public function getAllCategories()
    {
        try {
            // Use the instantiated Database service
            $categories = Category::getAll($this->database);

            return $this->responseService->success($categories);
        } catch (\Exception $e) {
            return $this->responseService->error($e->getMessage(), 500);
        }
    }

    public function getCategoryById($id)
    {
        try {
            // Use the instantiated Database service
            $category = Category::getById($this->database, $id);
            if ($category) {
                return $this->responseService->success($category);
            } else {
                return $this->responseService->error("Category not found", 404);
            }
        } catch (\Exception $e) {
            return $this->responseService->error($e->getMessage(), 500);
        }
    }
}
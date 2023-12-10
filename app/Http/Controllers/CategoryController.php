<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Services\FoodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
    public function __construct(
        protected FoodService $categoryService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryService->getFilteredData();
            return response()->json($categories);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $eventCategory = $this->categoryService->createCategory($validatedData);
            return response()->json($eventCategory);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}

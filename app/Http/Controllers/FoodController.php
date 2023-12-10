<?php

namespace App\Http\Controllers;

use App\Services\FoodService;
use Illuminate\Http\Request;
use App\Models\Foods;

class FoodController extends Controller
{
    public function __construct(
        protected FoodService $foodService,
    ) {}

    public function index(): \Illuminate\Http\JsonResponse
    {
        $foods = Foods::all();
        return response()->json($foods);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $food = new Foods;
        $food->name = $request->name;
        $food->price = $request->price;
        $food->description = $request->description;
        $food->vegan = $request->vegan;
        $food->image_path = $request->image_path;
        $food->available = 0;
        $food->save();
        return response()->json($food);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $food = Foods::findOrFail($id);
        return response()->json($food);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $food = Foods::findOrFail($id);
        $food->name = is_null($request->name) ? $food->name : $request->name;
        $food->price = is_null($request->price) ? $food->price : $request->price;
        $food->description = is_null($request->description) ? $food->description : $request->description;
        $food->available = is_null($request->available) ? $food->available : $request->available;
        $food->save();
        return response()->json($food);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $food = Foods::findOrFail($id);
        $food->delete();
        return response()->json(["message" => "Food deleted successfully"]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StroreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
     /**
     * Display a listing of products
     * GET /api/v1/products
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        
        $products = Category::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->when($request->filled('description'), function ($query) use ($request) {
                $query->where('description', 'like', "%{$request->description}%");
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->is_active);
            })
            ->active()
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'data' => CategoryResource::collection($products),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    public function store(StroreCategoryRequest $request)
    {
        $data = $request->validated();

        // auto generate slug dari name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // pastikan slug tetap unix
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        }
        // Data sudah tervalidasi oleh StroreCategoryRequest
        $category = Category::create($request->validated());

        return response()->json([
            'message' => 'Kategori berhasil dibuat',
            'data' => new CategoryResource($category)
        ], 201);
    }
}

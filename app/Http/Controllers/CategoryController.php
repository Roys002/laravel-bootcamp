<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StroreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
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

<?php

// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{

    // // Constructor injection (seperti DI di Go)
    // public function __construct(
    //     private ProductService $productService // akan dibuat nanti
    // ) {}

    /**
     * Display a listing of products
     * GET /api/v1/products
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $query->where('is_active', $request->is_active);
            })
            ->active()
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created product
     * POST /api/v1/products
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        // Data sudah auto-validated oleh StoreProductRequest
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified product
     * GET /api/v1/products/{product}
     */
    public function show(Product $product): JsonResponse
    {
        // $product sudah auto-resolved dari ID (implicit model binding)
        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified product
     * PUT /api/v1/products/{product}
     */
    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified product
     * DELETE /api/v1/products/{product}
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ], 204);
    }

    /**
     * Restore soft deleted product
     * POST /api/v1/products/{id}/restore
     */
    public function restore(int $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json([
            'message' => 'Produk berhasil direstore',
            'data' => new ProductResource($product)
        ]);
    }
}

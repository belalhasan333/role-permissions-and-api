<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSend;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // filtering for params
       $query = Product::query();

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        //Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Keyword search
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $order  = $request->get('order', 'desc');

        $products = $query->orderBy($sortBy, $order)->paginate(10);

        return response()->json($products);


        $products = Product::latest()->get();

        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request): JsonResponse
    {

        // validation for store
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'status'      => 'nullable|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $medias = [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                $path = $file->store('products', 'public');

                $medias[] = [
                    'type' => 'image',
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'status'      => $request->status ?? 'active',
            'medias'      => $medias,
        ]);

        return $this->sendResponse($product, 'Product created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'status'      => 'nullable|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $medias = $product->medias ?? [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                $path = $file->store('products', 'public');

                $medias[] = [
                    'type' => 'image',
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'status'      => $request->status,
            'medias'      => $medias,
        ]);

        return $this->sendResponse($product, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}

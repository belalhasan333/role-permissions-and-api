<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::latest()->get();

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias'      => 'nullable|array',
            'medias.*'    => 'file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $medias = [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                $path = $file->store('categories', 'public');

                $medias[] = [
                    'type' => 'image',
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $category = Category::create([
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'medias'      => $medias,
        ]);

        return $this->sendResponse($category, 'Category created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return $this->sendResponse($category, 'Category retrieved successfully.');
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias'      => 'nullable|array',
            'medias.*'    => 'file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $medias = $category->medias ?? [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                $path = $file->store('categories', 'public');

                $medias[] = [
                    'type' => 'image',
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $category->update([
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'medias'      => $medias,
        ]);

        return $this->sendResponse($category, 'Category updated successfully.');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Category $category): JsonResponse
    {
        if (!empty($category->medias)) {
            foreach ($category->medias as $media) {
                if (isset($media['url'])) {
                    $path = str_replace('/storage/', '', $media['url']);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Notifications\NotifyUser;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $categories = Category::where('status', 'active')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::role('subscriber')->get();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $medias = [];
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                if (!$file) continue;
                $medias[] = [
                    'type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'file',
                    'url'  => Storage::url($file->store('products', 'public')),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

            $product=Product::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'price'       => $request->price,
            'status'      => $request->status,
            'medias'      => $medias,
        ]);
    //         $response = Http::post(route('api.notify-subscribers'), [
    //     'product_id' => $product->id,
    // ]);
        Notification::send($user, new NotifyUser($product));
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('status', 'active')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $user = User::role('subscriber')->get();
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
            'existing_medias' => 'nullable|array',
        ]);

        $medias = $product->medias ?? [];
        if ($request->hasFile('medias')) {
            $medias = [];
            foreach ($request->file('medias') as $file) {
                if (!$file) continue;
                $medias[] = [
                    'type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'file',
                    'url'  => Storage::url($file->store('products', 'public')),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'price'       => $request->price,
            'status'      => $request->status,
            'medias'      => $medias,
        ]);
        Notification::send($user, new NotifyUser($product));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\NotifyUser;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
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

    // DataTables AJAX
    public function data()
    {
        $products = Product::with('category')->latest();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category_name', function ($product) {
                return $product->category ? $product->category->title : '<span class="text-muted">N/A</span>';
            })
            ->addColumn('description', function ($product) {
                return Str::limit(strip_tags($product->description), 60, '...');
            })
            ->addColumn('price', function ($product) {
                return number_format($product->price, 2);
            })
            ->addColumn('status', function ($product) {
                $badge = $product->status === 'active' ? 'bg-success' : 'bg-danger';
                return '<span class="badge ' . $badge . '">' . ucfirst($product->status) . '</span>';
            })
            ->addColumn('media', function ($product) {
                if (!empty($product->medias) && is_array($product->medias)) {
                    $first = $product->medias[0] ?? null;
                    if ($first && !empty($first['url'])) {
                        $url = str_starts_with($first['url'], '/storage')
                            ? asset($first['url'])
                            : asset('storage/' . $first['url']);
                        return '<img src="' . $url . '" style="height:50px;width:70px;object-fit:cover;border-radius:6px">';
                    }
                }
                return '<span class="text-muted">No image</span>';
            })
            ->addColumn('action', function ($product) {
                $btn = '<a href="' . route('products.show', $product->id) . '" class="btn btn-info btn-sm me-1">
                            <i class="fa-solid fa-list"></i> Show
                        </a>';
                if (auth()->user()->can('product-edit')) {
                    $btn .= '<a href="' . route('products.edit', $product->id) . '" class="btn btn-primary btn-sm me-1">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                             </a>';
                }
                if (auth()->user()->can('product-delete')) {
                    $btn .= '<form action="' . route('products.destroy', $product->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to delete this product?\')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                             </form>';
                }
                return $btn;
            })
            ->rawColumns(['media', 'action', 'status', 'category_name', 'description'])
            ->make(true);
    }

    public function index(): View
    {
        return view('products.index');
    }

    public function create(): View
    {
        $categories = Category::where('status', 'active')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::all();

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
                $medias[] = [
                    'type' => str_starts_with($file->getMimeType(), 'image') ? 'image' : 'file',
                    'url'  => Storage::url($file->store('products', 'public')),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'price'       => $request->price,
            'status'      => $request->status,
            'medias'      => $medias,
        ]);

        Notification::send($user, new \App\Notifications\NotifyUser($product));

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
        $user = User::all();

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

        // Start with existing medias
        $medias = $request->existing_medias ?? $product->medias ?? [];

        // Add new uploads if any
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
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

        Notification::send($user, new \App\Notifications\NotifyUser($product));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $users = User::all();
        Notification::send($users, new \App\Notifications\NotifyUser($product));
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\NotifyUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Return datatable data for categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $categories = Category::latest();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('description', function ($category) {
                return Str::limit($category->description, 50, '...');
            })
            ->addColumn('media', function ($category) {
                if (!empty($category->medias) && is_array($category->medias)) {
                    $firstMedia = $category->medias[0] ?? null;
                    if ($firstMedia && isset($firstMedia['url'])) {
                        return '<img src="' . asset($firstMedia['url']) . '" alt="media" style="max-width:80px; border-radius:4px;">';
                    }
                }
                return '<span class="text-muted">No media</span>';
            })
            ->addColumn('action', function ($category) {
                $btn = '';

                $btn .= '<a href="' . route('categories.show', $category->id) . '" class="btn btn-info btn-sm">
                            <i class="fa-solid fa-list"></i> Show
                         </a>';

                $authUser = auth()->user();

                if ($authUser && $authUser->can('category-edit')) {
                    $btn .= ' <a href="' . route('categories.edit', $category->id) . '" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                              </a>';
                }

                if ($authUser && $authUser->can('category-delete')) {
                    $btn .= '<form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                             </form>';
                }

                return $btn;
            })
            ->rawColumns(['media', 'action', 'description'])
            ->make(true);
    }

    /**
     * Show all categories view.
     */
    public function index(): View
    {
        return view('categories.index');
    }

    /**
     * Show category creation form.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $users = User::all();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);

        $medias = [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                if (!$file) continue;

                $type = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'file';
                $path = $file->store('categories', 'public');
                $medias[] = [
                    'type' => $type,
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $category = Category::create([
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'medias'      => $medias,
            'status'      => 'active',
        ]);

        Notification::send($users, new NotifyUser($category));

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Update a category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
            'existing_medias' => 'nullable|array',
        ]);

        // Only keep existing medias, then append new uploads
        $medias = $request->input('existing_medias', $category->medias ?? []);

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                if (!$file) continue;

                $type = str_starts_with($file->getMimeType(), 'image') ? 'image' : 'file';
                $path = $file->store('categories', 'public');
                $medias[] = [
                    'type' => $type,
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $category->update([
            'title'       => $request->title,
            'description' => $request->description ?? '',
            'status'      => $request->status,
            'medias'      => $medias,
        ]);

        $users = User::all();
        Notification::send($users, new NotifyUser($category));

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Show a category.
     */
    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Edit a category.
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $users = User::all();
        Notification::send($users, new NotifyUser($category));
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}

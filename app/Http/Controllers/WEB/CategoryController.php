<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use App\Models\Product;
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
     * Display a listing of the resource.
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
                        return '<img src="' . $firstMedia['url'] . '" alt="media" style="max-width:80px; border-radius:4px;">';
                    }
                }
                return '<span class="text-muted">No media</span>';
            })
            ->addColumn('action', function ($category) {
                $btn = '';

                $btn .= '<a href="' . route('categories.show', $category->id) . '" class="btn btn-info btn-sm">
                            <i class="fa-solid fa-list"></i> Show
                         </a>';

                if (auth()->user()->can('category-edit')) {
                    $btn .= ' <a href="' . route('categories.edit', $category->id) . '" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                              </a>';
                }

                if (auth()->user()->can('category-delete')) {
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

    public function index(): View
    {
        return view('categories.index');
    }
    public function create(): View
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::role('subscriber')->get();

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
        ]);
        $medias = [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                if (!$file) {
                    continue;
                }
                $mime = $file->getMimeType();

                if (str_starts_with($mime, 'image')) {
                    $type = 'image';
                }
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
        ]);
        Notification::send($user, new NotifyUser($category));

        return redirect()->route('categories.index')
            ->with('success', 'category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categories): RedirectResponse
    {

        $request->validate([

            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:active,inactive',
            'medias'      => 'nullable|array',
            'medias.*'    => 'nullable|file|mimes:jpg,jpeg,png,webp|max:20480',
            'existing_medias' => 'nullable|array',
        ]);
        $medias = [];

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                if (!$file) {
                    continue;
                }
                $mime = $file->getMimeType();

                if (str_starts_with($mime, 'image')) {
                    $type = 'image';
                }
                $path = $file->store('categories', 'public');

                $medias[] = [
                    'type' => $type,
                    'url'  => Storage::url($path),
                    'name' => $file->getClientOriginalName(),
                ];
            }
        }

        $categories->update([

            'title'       => $request->title,
            'description' => $request->description ?? '',
            'status'      => $request->status,
            'medias'      => empty($medias) ? $categories->medias : $medias,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'category deleted successfully');
    }
}

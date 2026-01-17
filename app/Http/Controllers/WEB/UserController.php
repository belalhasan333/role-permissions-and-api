<?php

namespace App\Http\Controllers\WEB;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display the Blade view with DataTable.
     */
    public function index(): View
    {
        return view('users.index');
    }

    /**
     * Fetch users data for DataTables.
     */
    public function getData(Request $request)
    {
        $users = User::with('roles')->select('users.*');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roles', function ($user) {
                $roles = '';
                foreach ($user->getRoleNames() as $role) {
                    $roles .= '<span class="badge bg-success me-1">' . $role . '</span>';
                }
                return $roles;
            })
            ->addColumn('action', function ($user) {
                $show = '<a class="btn btn-info btn-sm" href="' . route('users.show', $user->id) . '">Show</a>';
                $edit = '<a class="btn btn-primary btn-sm" href="' . route('users.edit', $user->id) . '">Edit</a>';
                $delete = '<form method="POST" action="' . route('users.destroy', $user->id) . '" style="display:inline-block">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm">Delete</button>'
                    . '</form>';
                return $show . ' ' . $edit . ' ' . $delete;
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $users = User::all();
        Notification::send($users, new \App\Notifications\NotifyUser($user));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Show the specified user.
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        $users = User::all();
        Notification::send($users, new \App\Notifications\NotifyUser($user));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Delete the specified user.
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
        $users = User::all();
        Notification::send($users, new \App\Notifications\NotifyUser($user));
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}

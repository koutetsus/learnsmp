<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function middleware(): array
    {
     return [
           new Middleware('permission:user-list', only: ['index', 'show']),
           new Middleware('permission:user-create', only: ['create', 'store']),
           new Middleware('permission:user-edit', only: ['edit', 'update']),
           new Middleware('permission:user-delete', only: ['destroy']),
       ];
    }


//       public static function middleware(): array
// // {
// //     return [
// //         // Middleware for admin role with full permissions
// //         new Middleware('role:admin|permission:materi-list|materi-create|materi-edit|materi-delete', only: ['index', 'show']),
// //         new Middleware('role:admin|permission:materi-create', only: ['create', 'store']),
// //         new Middleware('role:admin|permission:materi-edit', only: ['edit', 'update']),
// //         new Middleware('role:admin|permission:materi-delete', only: ['destroy']),


// //         new Middleware('role:guru|permission:materi-list|materi-create|materi-edit|materi-delete', only: ['index', 'show']),
// //         new Middleware('role:guru|permission:materi-create', only: ['create', 'store']),
// //         new Middleware('role:guru|permission:materi-edit', only: ['edit', 'update']),
// //         new Middleware('role:guru|permission:materi-delete', only: ['destroy']),

// //         // Middleware for siswa role with limited permissions
// //         new Middleware('role:siswa|permission:materi-list', only: ['index', 'show']),
// //     ];
// // }

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'roles' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}


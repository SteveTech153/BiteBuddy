<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('user.index', compact('users'));
    }
    
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
    
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $user->save();
    
        $role = Role::where('name', $request->input('role'))->firstOrFail();
        $user->assignRole($role);
    
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $id)
    {
    
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    
        $role = Role::where('name', $request->input('role'))->firstOrFail();
        $user->syncRoles([$role]);
    
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }
}

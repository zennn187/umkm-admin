<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hanya Super Admin dan Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin' && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $users = User::latest()->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,mitra,user', // Super Admin tidak bisa dibuat melalui form
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:super_admin,admin,mitra,user',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        // Hanya Super Admin yang bisa akses
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')
            ->with('success', "User berhasil $status.");
    }
}

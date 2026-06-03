<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $admins = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.admin-user.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'status_akun' => 'required|in:aktif,nonaktif,bermasalah',
        ]);

        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status_akun' => $request->status_akun,
        ]);

        return redirect()
            ->route('admin.admin-user.index')
            ->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(User $adminUser)
    {
        if ($adminUser->role !== 'admin') {
            abort(404);
        }

        return view('admin.admin-user.edit', compact('adminUser'));
    }

    public function update(Request $request, User $adminUser)
    {
        if ($adminUser->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'nik' => 'required|string|max:20|unique:users,nik,' . $adminUser->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $adminUser->id,
            'status_akun' => 'required|in:aktif,nonaktif,bermasalah',
        ]);

        $adminUser->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'status_akun' => $request->status_akun,
        ]);

        return redirect()
            ->route('admin.admin-user.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $adminUser)
    {
        if ($adminUser->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $adminUser->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password admin berhasil direset.');
    }

    public function destroy(User $adminUser)
    {
        if ($adminUser->role !== 'admin') {
            abort(404);
        }
        if (Auth::id() === $adminUser->id) {
            return back()->withErrors([
                'admin' => 'Kamu tidak bisa menghapus akun admin yang sedang login.',
            ]);
        }

        $adminUser->delete();

        return redirect()
            ->route('admin.admin-user.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}

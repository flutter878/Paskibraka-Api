<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSeleksi;
use App\Models\User;
use Illuminate\Http\Request;

class HasilSeleksiController extends Controller
{
    public function index(Request $request)
    {
        $query = HasilSeleksi::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('tahap', 'like', '%' . $search . '%')
                    ->orWhere('catatan', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', '%' . $search . '%')
                            ->orWhere('nik', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahap')) {
            $query->where('tahap', 'like', '%' . $request->tahap . '%');
        }

        $hasil = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.hasil.index', compact('hasil'));
    }

    public function create()
    {
        $peserta = User::where('role', 'peserta')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.hasil.create', compact('peserta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahap' => 'required|string|max:255',
            'nilai' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:menunggu,lulus,tidak_lulus,cadangan',
            'catatan' => 'nullable|string',
        ]);

        $peserta = User::where('id', $request->user_id)
            ->where('role', 'peserta')
            ->first();

        if (!$peserta) {
            return back()->withErrors([
                'user_id' => 'Peserta tidak ditemukan.',
            ])->withInput();
        }

        HasilSeleksi::create([
            'user_id' => $request->user_id,
            'tahap' => $request->tahap,
            'nilai' => $request->nilai,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('admin.hasil.index')
            ->with('success', 'Hasil seleksi berhasil ditambahkan.');
    }

    public function edit(HasilSeleksi $hasil)
    {
        $peserta = User::where('role', 'peserta')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.hasil.edit', compact('hasil', 'peserta'));
    }

    public function update(Request $request, HasilSeleksi $hasil)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tahap' => 'required|string|max:255',
            'nilai' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:menunggu,lulus,tidak_lulus,cadangan',
            'catatan' => 'nullable|string',
        ]);

        $peserta = User::where('id', $request->user_id)
            ->where('role', 'peserta')
            ->first();

        if (!$peserta) {
            return back()->withErrors([
                'user_id' => 'Peserta tidak ditemukan.',
            ])->withInput();
        }

        $hasil->update([
            'user_id' => $request->user_id,
            'tahap' => $request->tahap,
            'nilai' => $request->nilai,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()
            ->route('admin.hasil.index')
            ->with('success', 'Hasil seleksi berhasil diperbarui.');
    }

    public function destroy(HasilSeleksi $hasil)
    {
        $hasil->delete();

        return redirect()
            ->route('admin.hasil.index')
            ->with('success', 'Hasil seleksi berhasil dihapus.');
    }
}

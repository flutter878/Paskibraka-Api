<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HasilSeleksi;
use App\Models\User;
use Illuminate\Http\Request;

class HasilSeleksiController extends Controller
{
    public function index(Request $request)
    {
        $hasil = HasilSeleksi::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data hasil seleksi berhasil diambil',
            'data' => $hasil,
        ]);
    }

    public function adminIndex(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengakses data ini.',
            ], 403);
        }

        $hasil = HasilSeleksi::with('user')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data hasil seleksi admin berhasil diambil',
            'data' => $hasil,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menambah hasil seleksi.',
            ], 403);
        }

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
            return response()->json([
                'message' => 'Peserta tidak ditemukan.',
            ], 404);
        }

        $hasil = HasilSeleksi::create([
            'user_id' => $request->user_id,
            'tahap' => $request->tahap,
            'nilai' => $request->nilai,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return response()->json([
            'message' => 'Hasil seleksi berhasil ditambahkan',
            'data' => $hasil,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $hasil = HasilSeleksi::with('user')->find($id);

        if (!$hasil) {
            return response()->json([
                'message' => 'Hasil seleksi tidak ditemukan',
            ], 404);
        }

        if ($request->user()->role !== 'admin' && $hasil->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Akses ditolak.',
            ], 403);
        }

        return response()->json([
            'message' => 'Detail hasil seleksi berhasil diambil',
            'data' => $hasil,
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengubah hasil seleksi.',
            ], 403);
        }

        $hasil = HasilSeleksi::find($id);

        if (!$hasil) {
            return response()->json([
                'message' => 'Hasil seleksi tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'tahap' => 'required|string|max:255',
            'nilai' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:menunggu,lulus,tidak_lulus,cadangan',
            'catatan' => 'nullable|string',
        ]);

        $hasil->update([
            'tahap' => $request->tahap,
            'nilai' => $request->nilai,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return response()->json([
            'message' => 'Hasil seleksi berhasil diperbarui',
            'data' => $hasil,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus hasil seleksi.',
            ], 403);
        }

        $hasil = HasilSeleksi::find($id);

        if (!$hasil) {
            return response()->json([
                'message' => 'Hasil seleksi tidak ditemukan',
            ], 404);
        }

        $hasil->delete();

        return response()->json([
            'message' => 'Hasil seleksi berhasil dihapus',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('status', 'aktif')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data pengumuman berhasil diambil',
            'data' => $pengumuman,
        ]);
    }

    public function adminIndex(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengakses data ini.',
            ], 403);
        }

        $pengumuman = Pengumuman::latest()->get();

        return response()->json([
            'message' => 'Data pengumuman admin berhasil diambil',
            'data' => $pengumuman,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat membuat pengumuman.',
            ], 403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'status' => 'nullable|in:aktif,nonaktif',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $lampiranPath = null;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = time() . '_pengumuman_' . $file->getClientOriginalName();
            $lampiranPath = $file->storeAs('lampiran_pengumuman', $fileName, 'public');
        }

        $pengumuman = Pengumuman::create([
            'admin_id' => $request->user()->id,
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'lampiran' => $lampiranPath,
            'status' => $request->status ?? 'aktif',
        ]);

        return response()->json([
            'message' => 'Pengumuman berhasil dibuat',
            'data' => $pengumuman,
            'lampiran_url' => $lampiranPath ? asset('storage/' . $lampiranPath) : null,
        ], 201);
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);

        if (!$pengumuman) {
            return response()->json([
                'message' => 'Pengumuman tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail pengumuman berhasil diambil',
            'data' => $pengumuman,
            'lampiran_url' => $pengumuman->lampiran ? asset('storage/' . $pengumuman->lampiran) : null,
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengubah pengumuman.',
            ], 403);
        }

        $pengumuman = Pengumuman::find($id);

        if (!$pengumuman) {
            return response()->json([
                'message' => 'Pengumuman tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_konten' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $lampiranPath = $pengumuman->lampiran;

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }

            $file = $request->file('lampiran');
            $fileName = time() . '_pengumuman_' . $file->getClientOriginalName();
            $lampiranPath = $file->storeAs('lampiran_pengumuman', $fileName, 'public');
        }

        $pengumuman->update([
            'judul' => $request->judul,
            'isi_konten' => $request->isi_konten,
            'status' => $request->status,
            'lampiran' => $lampiranPath,
        ]);

        return response()->json([
            'message' => 'Pengumuman berhasil diperbarui',
            'data' => $pengumuman,
            'lampiran_url' => $lampiranPath ? asset('storage/' . $lampiranPath) : null,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus pengumuman.',
            ], 403);
        }

        $pengumuman = Pengumuman::find($id);

        if (!$pengumuman) {
            return response()->json([
                'message' => 'Pengumuman tidak ditemukan',
            ], 404);
        }

        if ($pengumuman->lampiran && Storage::disk('public')->exists($pengumuman->lampiran)) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }

        $pengumuman->delete();

        return response()->json([
            'message' => 'Pengumuman berhasil dihapus',
        ]);
    }
}

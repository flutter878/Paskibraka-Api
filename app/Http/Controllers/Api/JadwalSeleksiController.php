<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeleksi;
use Illuminate\Http\Request;

class JadwalSeleksiController extends Controller
{
    public function index()
    {
        $jadwal = JadwalSeleksi::where('status', 'aktif')
            ->orderBy('tanggal', 'asc')
            ->get();

        return response()->json([
            'message' => 'Data jadwal seleksi berhasil diambil',
            'data' => $jadwal,
        ]);
    }

    public function adminIndex(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengakses data ini.',
            ], 403);
        }

        $jadwal = JadwalSeleksi::orderBy('tanggal', 'asc')->get();

        return response()->json([
            'message' => 'Data jadwal seleksi admin berhasil diambil',
            'data' => $jadwal,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat membuat jadwal.',
            ], 403);
        }

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jadwal = JadwalSeleksi::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Jadwal seleksi berhasil dibuat',
            'data' => $jadwal,
        ], 201);
    }

    public function show($id)
    {
        $jadwal = JadwalSeleksi::find($id);

        if (!$jadwal) {
            return response()->json([
                'message' => 'Jadwal seleksi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail jadwal seleksi berhasil diambil',
            'data' => $jadwal,
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengubah jadwal.',
            ], 403);
        }

        $jadwal = JadwalSeleksi::find($id);

        if (!$jadwal) {
            return response()->json([
                'message' => 'Jadwal seleksi tidak ditemukan',
            ], 404);
        }

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jadwal->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Jadwal seleksi berhasil diperbarui',
            'data' => $jadwal,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat menghapus jadwal.',
            ], 403);
        }

        $jadwal = JadwalSeleksi::find($id);

        if (!$jadwal) {
            return response()->json([
                'message' => 'Jadwal seleksi tidak ditemukan',
            ], 404);
        }

        $jadwal->delete();

        return response()->json([
            'message' => 'Jadwal seleksi berhasil dihapus',
        ]);
    }
}

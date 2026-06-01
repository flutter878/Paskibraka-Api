<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalSeleksi;
use Illuminate\Http\Request;

class JadwalSeleksiController extends Controller
{
    public function index()
    {
        $jadwal = JadwalSeleksi::orderBy('tanggal', 'asc')->paginate(10);

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'nullable',
            'jam_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        JadwalSeleksi::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal seleksi berhasil ditambahkan.');
    }

    public function edit(JadwalSeleksi $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, JadwalSeleksi $jadwal)
    {
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

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal seleksi berhasil diperbarui.');
    }

    public function destroy(JadwalSeleksi $jadwal)
    {
        $jadwal->delete();

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal seleksi berhasil dihapus.');
    }
}

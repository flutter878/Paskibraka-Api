<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DokumenPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $dokumen = DokumenPeserta::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data dokumen berhasil diambil',
            'data' => $dokumen,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:surat_izin_orang_tua,surat_sehat,nilai_rapor',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = time() . '_' . $user->id . '_' . $request->jenis_dokumen . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('dokumen_peserta', $fileName, 'public');

            $dokumen = DokumenPeserta::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'jenis_dokumen' => $request->jenis_dokumen,
                ],
                [
                    'file_path' => $path,
                    'status_dokumen' => 'menunggu',
                    'catatan_admin' => null,
                    'waktu_unggah' => now(),
                ]
            );

            return response()->json([
                'message' => 'Berkas berhasil diunggah',
                'data' => $dokumen,
                'file_url' => asset('storage/' . $path),
            ], 201);
        }

        return response()->json([
            'message' => 'File tidak ditemukan',
        ], 400);
    }

    public function show(Request $request, $id)
    {
        $dokumen = DokumenPeserta::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$dokumen) {
            return response()->json([
                'message' => 'Dokumen tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail dokumen berhasil diambil',
            'data' => $dokumen,
            'file_url' => asset('storage/' . $dokumen->file_path),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $dokumen = DokumenPeserta::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$dokumen) {
            return response()->json([
                'message' => 'Dokumen tidak ditemukan',
            ], 404);
        }

        if ($dokumen->file_path && Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return response()->json([
            'message' => 'Dokumen berhasil dihapus',
        ]);
    }
}

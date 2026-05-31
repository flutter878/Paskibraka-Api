<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BiodataPeserta;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function show(Request $request)
    {
        $biodata = BiodataPeserta::where('user_id', $request->user()->id)->first();

        return response()->json([
            'message' => 'Data biodata berhasil diambil',
            'data' => $biodata,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tinggi_badan' => 'required|integer|min:1',
            'berat_badan' => 'required|integer|min:1',
            'golongan_darah' => 'nullable|string|max:5',
            'riwayat_penyakit' => 'nullable|string',
            'motivasi_esai' => 'nullable|string',
        ]);

        $biodata = BiodataPeserta::updateOrCreate(
            [
                'user_id' => $request->user()->id,
            ],
            [
                'nama_lengkap' => $request->nama_lengkap,
                'asal_sekolah' => $request->asal_sekolah,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tinggi_badan' => $request->tinggi_badan,
                'berat_badan' => $request->berat_badan,
                'golongan_darah' => $request->golongan_darah,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'motivasi_esai' => $request->motivasi_esai,
                'status_verifikasi' => 'menunggu_verifikasi',
            ]
        );

        return response()->json([
            'message' => 'Biodata berhasil disimpan',
            'data' => $biodata,
        ]);
    }
}

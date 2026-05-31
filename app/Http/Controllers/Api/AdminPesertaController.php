<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPesertaController extends Controller
{
    private function checkAdmin(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.',
            ], 403);
        }

        return null;
    }

    public function index(Request $request)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $peserta = User::with(['biodata', 'dokumen'])
            ->where('role', 'peserta')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data peserta berhasil diambil',
            'data' => $peserta,
        ]);
    }

    public function show(Request $request, $id)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $peserta = User::with(['biodata', 'dokumen'])
            ->where('role', 'peserta')
            ->find($id);

        if (!$peserta) {
            return response()->json([
                'message' => 'Peserta tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail peserta berhasil diambil',
            'data' => $peserta,
        ]);
    }

    public function updateStatusAkun(Request $request, $id)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $request->validate([
            'status_akun' => 'required|in:aktif,nonaktif,bermasalah',
        ]);

        $peserta = User::where('role', 'peserta')->find($id);

        if (!$peserta) {
            return response()->json([
                'message' => 'Peserta tidak ditemukan',
            ], 404);
        }

        $peserta->update([
            'status_akun' => $request->status_akun,
        ]);

        return response()->json([
            'message' => 'Status akun peserta berhasil diperbarui',
            'data' => $peserta,
        ]);
    }

    public function resetPassword(Request $request, $id)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $peserta = User::where('role', 'peserta')->find($id);

        if (!$peserta) {
            return response()->json([
                'message' => 'Peserta tidak ditemukan',
            ], 404);
        }

        $peserta->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Password peserta berhasil direset',
        ]);
    }

    public function verifikasiBiodata(Request $request, $id)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $request->validate([
            'status_verifikasi' => 'required|in:belum_lengkap,menunggu_verifikasi,lulus_verifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $biodata = BiodataPeserta::where('user_id', $id)->first();

        if (!$biodata) {
            return response()->json([
                'message' => 'Biodata peserta tidak ditemukan',
            ], 404);
        }

        $biodata->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return response()->json([
            'message' => 'Status verifikasi biodata berhasil diperbarui',
            'data' => $biodata,
        ]);
    }

    public function verifikasiDokumen(Request $request, $id)
    {
        if ($response = $this->checkAdmin($request)) {
            return $response;
        }

        $request->validate([
            'status_dokumen' => 'required|in:menunggu,diterima,ditolak,revisi',
            'catatan_admin' => 'nullable|string',
        ]);

        $dokumen = DokumenPeserta::find($id);

        if (!$dokumen) {
            return response()->json([
                'message' => 'Dokumen peserta tidak ditemukan',
            ], 404);
        }

        $dokumen->update([
            'status_dokumen' => $request->status_dokumen,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return response()->json([
            'message' => 'Status dokumen berhasil diperbarui',
            'data' => $dokumen,
        ]);
    }
}

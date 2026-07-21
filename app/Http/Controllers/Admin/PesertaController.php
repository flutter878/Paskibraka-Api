<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BiodataPeserta;
use App\Models\DokumenPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    public function index(Request $request)
{
    $query = User::with('biodata')
        ->where('role', 'peserta');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhereHas('biodata', function ($biodata) use ($search) {
                    $biodata->where('asal_sekolah', 'like', '%' . $search . '%');
                });
        });
    }

    if ($request->filled('status_verifikasi')) {
        $query->whereHas('biodata', function ($biodata) use ($request) {
            $biodata->where('status_verifikasi', $request->status_verifikasi);
        });
    }

    if ($request->filled('status_akun')) {
        $query->where('status_akun', $request->status_akun);
    }

    $peserta = $query->latest()->paginate(10)->withQueryString();

    return view('admin.peserta.index', compact('peserta'));
}

    public function show($id)
    {
        $peserta = User::with(['biodata', 'dokumen'])
            ->where('role', 'peserta')
            ->findOrFail($id);

        return view('admin.peserta.show', compact('peserta'));
    }

    public function verifikasiBiodata(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:belum_lengkap,menunggu_verifikasi,lulus_verifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $biodata = BiodataPeserta::where('user_id', $id)->firstOrFail();

        $biodata->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status verifikasi biodata berhasil diperbarui.');
    }

    public function verifikasiDokumen(Request $request, $id)
    {
        $request->validate([
            'status_dokumen' => 'required|in:menunggu,diterima,ditolak,revisi',
            'catatan_admin' => 'nullable|string',
        ]);

        $dokumen = DokumenPeserta::findOrFail($id);

        $dokumen->update([
            'status_dokumen' => $request->status_dokumen,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    public function resetPassword(Request $request, $id)
    {
        $peserta = User::where('role', 'peserta')->findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $peserta->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password peserta berhasil direset.');
    }

    public function destroy($id)
    {
        $peserta = User::where('role', 'peserta')->findOrFail($id);

        // Hapus dokumen fisik jika ada
        if ($peserta->dokumen) {
            foreach ($peserta->dokumen as $dokumen) {
                $filePath = storage_path('app/public/' . $dokumen->file_path);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $peserta->delete();

        return redirect()
            ->route('admin.peserta.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }
}

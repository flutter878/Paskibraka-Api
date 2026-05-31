<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuPesertaController extends Controller
{
    public function download(Request $request)
    {
        $user = $request->user()->load('biodata');

        if (!$user->biodata) {
            return response()->json([
                'message' => 'Biodata belum diisi.'
            ], 400);
        }

        if ($user->biodata->status_verifikasi !== 'lulus_verifikasi') {
            return response()->json([
                'message' => 'Kartu peserta belum tersedia. Harap tunggu sampai lulus verifikasi.'
            ], 403);
        }

        $pdf = Pdf::loadView('pdf.kartu-peserta', [
            'user' => $user,
            'biodata' => $user->biodata,
        ])->setPaper('A4', 'portrait');

        $fileName = 'kartu-peserta-' . $user->nik . '.pdf';

        return $pdf->download($fileName);
    }

    public function preview(Request $request)
    {
        $user = $request->user()->load('biodata');

        if (!$user->biodata) {
            return response()->json([
                'message' => 'Biodata belum diisi.'
            ], 400);
        }

        if ($user->biodata->status_verifikasi !== 'lulus_verifikasi') {
            return response()->json([
                'message' => 'Kartu peserta belum tersedia. Harap tunggu sampai lulus verifikasi.'
            ], 403);
        }

        $pdf = Pdf::loadView('pdf.kartu-peserta', [
            'user' => $user,
            'biodata' => $user->biodata,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-peserta-' . $user->nik . '.pdf');
    }
}

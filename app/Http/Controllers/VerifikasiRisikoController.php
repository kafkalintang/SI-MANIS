<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;

class VerifikasiRisikoController extends Controller
{
    public function index(Request $request)
    {
        $unitKerja = \App\Models\UnitKerja::all();

        $registrasi = Registrasi::where('status_registrasi', 'Belum Terverifikasi')->whereNull('komentar');

        if ($request->filled('unit_kerja_id')) {
            $registrasi = $registrasi->where('unit_kerja_id', $request->unit_kerja_id);
        }

        $registrasi = $registrasi->get();

        return view('pages.verifikasi_risiko', compact('registrasi', 'unitKerja'));
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'komentar' => 'required|string'
        ], [
            'komentar.required' => 'Komentar wajib diisi.'
        ]);

        $registrasi = Registrasi::findOrFail($id);

        $registrasi->update([
            'status_registrasi' => $request->status,
            'komentar' => $request->komentar, // simpan komentar ke tabel registrasi
        ]);

        return redirect()->route('verifikasi_risiko')
            ->with('success', 'Status dan komentar berhasil disimpan!');
    }
}
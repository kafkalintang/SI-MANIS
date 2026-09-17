<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitigasi;
use App\Models\Registrasi; 

class MitigasiController extends Controller
{
    public function store(Request $request)
    {
         $data = $request->validate([
            'registrasi_id' => 'required|exists:registrasi,id_registrasi',
            'isurisiko' => 'required|string',
            'rencana_aksi' => 'required|string',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);

        // Validasi status registrasi
        $registrasi = Registrasi::findOrFail($request->registrasi_id);

        if ($registrasi->status_registrasi !== 'Terverifikasi') {
            return back()->with('error', 'Registrasi belum diverifikasi. Tidak dapat menambah mitigasi.');
        }


        Mitigasi::create($data);

        return back()->with('success', 'Mitigasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $mitigasi = Mitigasi::findOrFail($id);

        $data = $request->validate([
            'isurisiko' => 'required|string',
            'rencana_aksi' => 'required|string',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);

        $mitigasi->update($data);

        return back()->with('success', 'Mitigasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mitigasi = Mitigasi::findOrFail($id);
        $mitigasi->delete();

        return back()->with('success', 'Mitigasi berhasil dihapus.');
    }
}

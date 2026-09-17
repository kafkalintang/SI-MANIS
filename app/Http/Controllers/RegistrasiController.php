<?php

namespace App\Http\Controllers;

use App\Models\IkuTerkait;
use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\UnitKerja;
use App\Models\ProsesAktivitas;
use App\Models\KategoriRisiko;
use App\Models\JenisRisiko;
use App\Imports\RegistrasiImport;
use App\Exports\RegistrasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // ambil id user yang sedang login
        $userUnit = Auth::user()->unit_kerja_id;

        $registrasi = Registrasi::with(['unitKerja', 'prosesAktivitas', 'kategoriRisiko', 'jenisRisiko', 'ikuterkait'])
            ->where('user_id', $userId) // filter berdasarkan user
            ->get();

        // Ambil data dropdown untuk form tambah/edit
        $unitKerja = UnitKerja::all();
        $proses = ProsesAktivitas::where('unit_kerja_id', $userUnit)->get();
        $kategori = KategoriRisiko::all();
        $jenis = JenisRisiko::all();
        $iku = IkuTerkait::all();

        return view('pages.registrasi', compact('registrasi', 'unitKerja', 'proses', 'kategori', 'jenis', 'iku'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_kerja_id' => 'required',
            'proses_aktivitas_id' => 'required',
            'proses_manual' => 'nullable|string|max:255', 
            'kategori_risiko_id' => 'required',
            'jenis_risiko_id' => 'required',
            'iku_terkait_id' => 'required',
            'isu_resiko' => 'required',
            'jenis_isu' => 'required',
            'akar_permasalahan' => 'required',
            'dampak' => 'required',
            'pihak_terkait' => 'required',
            'kontrol_pencegahan' => 'required',
            'keparahan' => 'required',
            'frekuensi' => 'required',
        ]);

          // Handle proses manual vs dropdown
          if ($request->proses_aktivitas_id === "manual") {

            // Buat proses baru
            $prosesBaru = ProsesAktivitas::create([
                'nama_proses' => $request->proses_manual,
                'unit_kerja_id' => Auth::user()->unit_kerja_id,
            ]);
            
            

            // Pakai ID proses baru
            $validated['proses_aktivitas_id'] = $prosesBaru->id;

        } else {
            // Dropdown normal
            $validated['proses_aktivitas_id'] = $request->proses_aktivitas_id;
        }

        // Matriks probabilitas
        $matrix = [
            'A' => [1 => 'Medium', 2 => 'High', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'B' => [1 => 'Low', 2 => 'Medium', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'C' => [1 => 'Low', 2 => 'Medium', 3 => 'Medium', 4 => 'Extreme', 5 => 'Extreme'],
            'D' => [1 => 'Low', 2 => 'Low', 3 => 'Medium', 4 => 'High', 5 => 'High'],
            'E' => [1 => 'Low', 2 => 'Low', 3 => 'Low', 4 => 'Medium', 5 => 'High'],
        ];

        $keparahan = (int) $request->keparahan;
        $frekuensi = $request->frekuensi;

        $validated['probabilitas'] = $matrix[$frekuensi][$keparahan] ?? 'Low';

        // Tambahkan default value untuk status_registrasi
        $validated['status_registrasi'] = 'Belum Terverifikasi';
        $validated['user_id'] = Auth::id();

        Registrasi::create($validated);

        return redirect()->route('registrasi.index')
            ->with('success', 'Data registrasi berhasil ditambahkan!');
    }

    // Mengupdate data registrasi
    public function update(Request $request, $id)
    {
        $registrasi = Registrasi::findOrFail($id);

        $validated = $request->validate([
            'proses_aktivitas_id' => 'required',
            'proses_manual' => 'nullable|string|max:255',
            'kategori_risiko_id' => 'required',
            'jenis_risiko_id' => 'required',
            'iku_terkait_id' => 'required',
            'isu_resiko' => 'required',
            'jenis_isu' => 'required',
            'akar_permasalahan' => 'required',
            'dampak' => 'required',
            'pihak_terkait' => 'required',
            'kontrol_pencegahan' => 'required',
            'keparahan' => 'required',
            'frekuensi' => 'required',
        ]);

        $validated['unit_kerja_id'] = Auth::user()->unit_kerja_id;
        if ($request->proses_aktivitas_id === "manual") {

            $prosesBaru = ProsesAktivitas::create([
                'nama_proses' => $request->proses_manual,
                'unit_kerja_id' => Auth::user()->unit_kerja_id,
            ]);
            
        
            $validated['proses_aktivitas_id'] = $prosesBaru->id;
        
        } else {
            $validated['proses_aktivitas_id'] = $request->proses_aktivitas_id;
        }


        // hitung ulang probabilitas 
        $matrix = [
            'A' => [1 => 'Medium', 2 => 'High', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'B' => [1 => 'Low', 2 => 'Medium', 3 => 'High', 4 => 'Extreme', 5 => 'Extreme'],
            'C' => [1 => 'Low', 2 => 'Medium', 3 => 'Medium', 4 => 'High', 5 => 'Extreme'],
            'D' => [1 => 'Low', 2 => 'Low', 3 => 'Medium', 4 => 'High', 5 => 'High'],
            'E' => [1 => 'Low', 2 => 'Low', 3 => 'Low', 4 => 'Medium', 5 => 'High'],
        ];

        $keparahan = (int) $request->keparahan;
        $frekuensi = $request->frekuensi;
        $validated['probabilitas'] = $matrix[$frekuensi][$keparahan] ?? 'Low';

        $registrasi->update($validated);

        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        $registrasi->delete();

        return redirect()->route('registrasi.index')->with('success', 'Data registrasi berhasil dihapus!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new \App\Imports\RegistrasiImport, $request->file('file'));
            return redirect()->route('registrasi.index')->with('success', 'Isu/Risiko Berhasil Diimport!');
        } catch (\Exception $e) {
            return redirect()->route('registrasi.index')->with('error', 'Isu/Risiko Gagal Diimport!: ' . $e->getMessage());
        }
    }
    
    public function export()
    {
    return Excel::download(new RegistrasiExport, 'template_registrasi.xlsx');
    }
}
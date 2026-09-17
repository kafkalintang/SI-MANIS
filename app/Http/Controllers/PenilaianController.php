<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\UnitKerja;
use App\Models\Mitigasi;
use App\Models\Evaluasi;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Status role
        $isAuditor = str_contains(strtolower($user->role), 'auditor');
        $isP4M = str_contains(strtolower($user->role), 'p4m');

        // Query awal
        $query = Registrasi::with([
            'unitKerja',
            'mitigasis.evaluasis.penilaian',
        ]);

        //   FILTER UNTUK AUDITOR
        if ($isAuditor) {

            $allowedUnits = $user->auditorUnits->pluck('id')->toArray();

            if (empty($allowedUnits)) {
                $query->whereNull('id_registrasi');
            } else {
                $query->whereIn('unit_kerja_id', $allowedUnits);
            }

            $unitKerja = $user->auditorUnits;
        }
        // P4M SAJA
        else if ($isP4M) {

            $unitKerja = UnitKerja::all();
        }
        // Role lain (manajemen/kepala unit)
        else {

            $unitKerja = collect(); // atau batasi
        }

        //   FILTER DARI DROPDOWN
        if ($request->unit_kerja_id) {
            $query->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->tahun) {
            $query->whereHas('mitigasis.evaluasis', function ($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        $registrasis = $query->get();

        //   DROPDOWN TAHUN
        if ($isAuditor) {

            $tahunList = Evaluasi::whereHas('mitigasi.registrasi', function ($q) use ($allowedUnits) {
                $q->whereIn('unit_kerja_id', $allowedUnits);
            })
                ->select('tahun')
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');

        } else {

            $tahunList = Evaluasi::select('tahun')
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');
        }


        return view('pages.penilaian', [
            'registrasis' => $registrasis,
            'unitKerja' => $unitKerja,
            'tahunList' => $tahunList,
            'unitDipilih' => $request->unit_kerja_id,
            'tahunDipilih' => $request->tahun,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'evaluasi_id' => 'required|exists:evaluasi,id_evaluasi',
            'uraian' => 'nullable|string'
        ]);

        $user = auth()->user();
        $isAuditor = str_contains(strtolower($user->role), 'auditor');
        $isP4M = str_contains(strtolower($user->role), 'p4m');

        $evaluasi = Evaluasi::findOrFail($request->evaluasi_id);

        $unitID = $evaluasi->mitigasi->registrasi->unit_kerja_id;

        // BLOKIR AUDITOR YANG TIDAK BERHAK 
        if ($isAuditor) {
            $allowedUnits = $user->auditorUnits->pluck('id')->toArray();

            if (!in_array($unitID, $allowedUnits)) {
                return back()->with('error', 'Anda tidak memiliki akses menilai unit ini.');
            }
        }

        // Buat nilai triwulan-tahun
        $triwulanTahun = $evaluasi->triwulan . '-' . $evaluasi->tahun;

        Penilaian::create([
            'evaluasi_id' => $evaluasi->id_evaluasi,
            'triwulan_tahun' => $triwulanTahun,
            'uraian' => $request->uraian
        ]);

        return redirect()->back()->with('success', 'Review auditor berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_penilaian' => 'required|exists:penilaian,id_penilaian',
            'uraian' => 'nullable|string'
        ]);

        $user = auth()->user();
        $isAuditor = str_contains(strtolower($user->role), 'auditor');
        $isP4M = str_contains(strtolower($user->role), 'p4m');

        // Ambil penilaian
        $penilaian = Penilaian::findOrFail($request->id_penilaian);

        // Ambil unit dari registrasi
        $unitID = $penilaian->evaluasi->mitigasi->registrasi->unit_kerja_id;

        // AUDITOR TIDAK BOLEH UPDATE UNIT YANG TIDAK MASUK PEMETAAN
        if ($isAuditor) {
            $allowed = $user->auditorUnits->pluck('id')->toArray();

            if (!in_array($unitID, $allowed)) {
                return back()->with('error', 'Anda tidak memiliki akses mengedit review ini.');
            }
        }

        $penilaian->update([
            'uraian' => $request->uraian
        ]);

        return redirect()->back()->with('success', 'Review auditor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $isAuditor = str_contains(strtolower($user->role), 'auditor');
        $isP4M = str_contains(strtolower($user->role), 'p4m');

        $penilaian = Penilaian::findOrFail($id);

        // Ambil unit dari registrasi
        $unitID = $penilaian->evaluasi->mitigasi->registrasi->unit_kerja_id;

        // AUDITOR TIDAK BOLEH DELETE UNIT YANG TIDAK MASUK PEMETAAN
        if ($isAuditor) {
            $allowed = $user->auditorUnits->pluck('id')->toArray();

            if (!in_array($unitID, $allowed)) {
                return back()->with('error', 'Anda tidak memiliki akses menghapus review ini.');
            }
        }

        $penilaian->delete();

        return redirect()->back()->with('success', 'Review auditor berhasil dihapus!');
    }

}

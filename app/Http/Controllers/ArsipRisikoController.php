<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\JenisRisiko;
use App\Models\KategoriRisiko;
use App\Models\Registrasi;
use App\Models\Evaluasi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipRisikoExport;

class ArsipRisikoController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua unit kerja dari tabel untuk dropdown
        $unitKerja = UnitKerja::all();
        $jenisRisiko = JenisRisiko::all();
        $kategoriRisiko = KategoriRisiko::all();

        // Ambil semua tahun unik dari tabel mitigasi untuk dropdown
        $tahunList = Evaluasi::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Ambil semua registrasi yang punya mitigasi
        $registrasi = Registrasi::with([
            'unitKerja',
            'prosesAktivitas',
            'kategoriRisiko',
            'jenisRisiko',
            'ikuTerkait',
            'mitigasis.evaluasis'
        ])->whereHas('mitigasis');

        if ($request->filled('probabilitas')) {
            $registrasi->where('probabilitas', $request->probabilitas);
        }

        // Tambahkan filter unit kerja kalau dipilih
        if ($request->filled('unit_kerja_id')) {
            $registrasi->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('jenis_risiko_id')) {
            $registrasi->where('jenis_risiko_id', $request->jenis_risiko_id);
        }

        if ($request->filled('kategori_risiko_id')) {
            $registrasi->where('kategori_risiko_id', $request->kategori_risiko_id);
        }

        $registrasi = $registrasi->get();
        $registrasi = $registrasi->filter(function ($item) {
            $evaluasiTerakhir = $item->mitigasis->flatMap->evaluasis
                ->sortByDesc('tahun')
                ->sortByDesc('triwulan')
                ->first();
            return $evaluasiTerakhir !== null;
        });

        // Filter berdasarkan tahun terakhir jika ada
        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $registrasi = $registrasi->filter(function ($item) use ($tahun) {
                $evaluasiTerakhir = $item->mitigasis->flatMap->evaluasis
                    ->sortByDesc('tahun')
                    ->sortByDesc('triwulan')
                    ->first();
                return $evaluasiTerakhir && $evaluasiTerakhir->tahun == $tahun;
            });
        }

        // Filter berdasarkan status evaluasi terakhir
        if ($request->filled('status')) {
            $status = strtolower(trim($request->status));
            $allowed = ['opened-meningkat', 'opened-menurun', 'closed'];

            if (in_array($status, $allowed)) {
                $registrasi = $registrasi->filter(function ($item) use ($status) {
                    $evaluasiTerakhir = $item->mitigasis->flatMap->evaluasis
                        ->sortByDesc('tahun')
                        ->sortByDesc('triwulan')
                        ->first();
                    return $evaluasiTerakhir && strtolower(trim($evaluasiTerakhir->status_pelaksanaan)) === $status;
                });
            }
        }

        // Kirim data ke view
        return view('pages.arsip_risiko', compact('unitKerja', 'tahunList', 'registrasi', 'jenisRisiko', 'kategoriRisiko'));
    }

    public function export(Request $request)
    {
        $registrasi = Registrasi::with([
            'unitKerja',
            'prosesAktivitas',
            'kategoriRisiko',
            'jenisRisiko',
            'ikuTerkait',
            'mitigasis.evaluasis'
        ])->whereHas('mitigasis');

        if ($request->filled('probabilitas')) {
            $registrasi->where('probabilitas', $request->probabilitas);
        }

        if ($request->filled('unit_kerja_id')) {
            $registrasi->where('unit_kerja_id', $request->unit_kerja_id);
        }

        if ($request->filled('kategori_risiko_id')) {
            $registrasi->where('kategori_risiko_id', $request->kategori_risiko_id);
        }

        $registrasi = $registrasi->get()->filter(function ($item) {
            $evaluasiTerakhir = $item->mitigasis->flatMap->evaluasis
                ->sortByDesc('tahun')
                ->sortByDesc('triwulan')
                ->first();
            return $evaluasiTerakhir !== null;
        });

        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $registrasi = $registrasi->filter(function ($item) use ($tahun) {
                $ev = $item->mitigasis->flatMap->evaluasis
                    ->sortByDesc('tahun')
                    ->sortByDesc('triwulan')
                    ->first();
                return $ev && $ev->tahun == $tahun;
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $registrasi = $registrasi->filter(function ($item) use ($status) {
                $ev = $item->mitigasis->flatMap->evaluasis
                    ->sortByDesc('tahun')
                    ->sortByDesc('triwulan')
                    ->first();
                return $ev && $ev->status_pelaksanaan == $status;
            });
        }

        // Download Excel
        return Excel::download(new ArsipRisikoExport($registrasi), 'arsip_risiko.xlsx');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\KontenBeranda;
use App\Models\HeatmapColor;
use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\Mitigasi;
use App\Models\Penilaian;
use App\Models\Evaluasi;
use App\Models\UnitKerja;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $unitUser = $user->unit_kerja_id;
        $roleFullAccess = ['p4m', 'manajemen', 'auditor'];
        $isFullAccess = $user->hasAnyRole($roleFullAccess);
        $isKepalaUnitOnly = !$isFullAccess && $user->hasAnyRole(['kepala_unit']);
        $evaluasiTahunQuery = Evaluasi::select('tahun')->distinct();

        if ($isKepalaUnitOnly) {
            $evaluasiTahunQuery->whereHas('mitigasi.registrasi', function ($q) use ($unitUser) {
                $q->where('unit_kerja_id', $unitUser);
            });
        }

        $daftarTahun = $evaluasiTahunQuery
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($isKepalaUnitOnly) {
            $maxTahun = Evaluasi::whereHas('mitigasi.registrasi', function ($q) use ($unitUser) {
                $q->where('unit_kerja_id', $unitUser);
            })->max('tahun');
        } else {
            $maxTahun = Evaluasi::max('tahun');
        }

        $tahun = $request->get('tahun', $maxTahun);

        // Ambil konten lain
        $konten = KontenBeranda::all();
        $colors = HeatmapColor::all();

        // Ambil mitigasi berdasarkan role + tahun
        $evaluasiQuery = Evaluasi::where('tahun', $tahun);

        if ($isKepalaUnitOnly) {
            $evaluasiQuery->whereHas('mitigasi.registrasi', function ($q) use ($unitUser) {
                $q->where('unit_kerja_id', $unitUser);
            });
        }

        $mitigasiIds = $evaluasiQuery
            ->pluck('mitigasi_id')
            ->unique()
            ->toArray();

        $probabilitasData = [
            'low' => 0,
            'medium' => 0,
            'high' => 0,
            'extreme' => 0,
        ];

        $evaluasi_closed = 0;
        $evaluasi_menurun = 0;
        $evaluasi_meningkat = 0;

        // Hitung probabilitas + status evaluasi
        if (!empty($mitigasiIds)) {

            // Mengambil registrasi berdasarkan mitigasi
            $registrasiIds = Mitigasi::whereIn('id_mitigasi', $mitigasiIds)
                ->pluck('registrasi_id')
                ->unique()
                ->toArray();

            // Hitung Probabilitas Risiko
            if (!empty($registrasiIds)) {
                $registrasiQuery = Registrasi::whereIn('id_registrasi', $registrasiIds);

                if ($isKepalaUnitOnly) {
                    $registrasiQuery->where('unit_kerja_id', $unitUser);
                }

                $registrasiFiltered = $registrasiQuery->get();

                $total = $registrasiFiltered->count();

                $low = $registrasiFiltered->where('probabilitas', 'Low')->count();
                $medium = $registrasiFiltered->where('probabilitas', 'Medium')->count();
                $high = $registrasiFiltered->where('probabilitas', 'High')->count();
                $extreme = $registrasiFiltered->where('probabilitas', 'Extreme')->count();

                $probabilitasData = [
                    'low' => $total ? round(($low / $total) * 100, 2) : 0,
                    'medium' => $total ? round(($medium / $total) * 100, 2) : 0,
                    'high' => $total ? round(($high / $total) * 100, 2) : 0,
                    'extreme' => $total ? round(($extreme / $total) * 100, 2) : 0,
                ];
            }

            // Hitung Status Evaluasi per Mitigasi (tahun terpilih)
            $mitigasiQuery = Mitigasi::with([
                'evaluasis' => function ($q) use ($tahun) {
                    $q->where('tahun', $tahun);
                }
            ])->whereIn('id_mitigasi', $mitigasiIds);

            if ($isKepalaUnitOnly) {
                $mitigasiQuery->whereHas('registrasi', function ($q) use ($unitUser) {
                    $q->where('unit_kerja_id', $unitUser);
                });
            }

            $mitigasiTahunIni = $mitigasiQuery->get();

            foreach ($mitigasiTahunIni as $m) {

                // Ambil evaluasi terbaru berdasarkan triwulan 
                $last = $m->evaluasis
                    ->sortByDesc(function ($row) {
                        return (int) $row->triwulan;
                    })
                    ->first();

                if ($last) {
                    $status = strtolower(trim($last->status_pelaksanaan));

                    if ($status === 'closed') {
                        $evaluasi_closed++;
                    } elseif ($status === 'opened-menurun') {
                        $evaluasi_menurun++;
                    } elseif ($status === 'opened-meningkat') {
                        $evaluasi_meningkat++;
                    }
                }
            }
        }

        $allUnits = UnitKerja::orderBy('nama_unit')->get();

        // DROPDOWN TAHUN UNTUK REGISTRASI
        $daftarTahunRegistrasi = Registrasi::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Default → tahun terbaru dari registrasi
        $tahunRegistrasi = $request->get('tahun_registrasi', $daftarTahunRegistrasi->first());

        // Ambil unit yang punya registrasi
        $unitsSudahIsi = UnitKerja::whereIn('id', function ($q) use ($tahunRegistrasi) {
            $q->select('unit_kerja_id')
                ->from('registrasi')
                ->whereYear('created_at', $tahunRegistrasi);
        })
            ->orderBy('nama_unit')
            ->get();

        // Unit yang belum isi = semua unit MINUS unit yang sudah isi
        $unitsBelumIsi = $allUnits
            ->whereNotIn('id', $unitsSudahIsi->pluck('id'))
            ->values();

        // Hitung jumlah
        $jumlahSudahIsi = $unitsSudahIsi->count();
        $jumlahBelumIsi = $unitsBelumIsi->count();

        return view('pages.beranda', compact(
            'konten',
            'colors',
            'probabilitasData',
            'tahun',
            'daftarTahun',
            'evaluasi_closed',
            'evaluasi_menurun',
            'evaluasi_meningkat',
            'jumlahSudahIsi',
            'jumlahBelumIsi',
            'unitsSudahIsi',
            'unitsBelumIsi',
            'daftarTahunRegistrasi',
            'tahunRegistrasi'
        ));
    }
}

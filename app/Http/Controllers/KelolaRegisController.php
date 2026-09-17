<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FormRegisImport;
use App\Models\UnitKerja;
use App\Models\ProsesAktivitas;
use App\Models\KategoriRisiko;
use App\Models\JenisRisiko;
use App\Models\IkuTerkait;
use App\Exports\ProsesAktivitasExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class KelolaRegisController extends Controller
{
    public function index(Request $request)
    {
        $searchUnit = $request->search_unit;
        $searchProses = $request->search_proses;
        $searchKategori = $request->search_kategori;
        $searchJenis = $request->search_jenis;
        $searchIku = $request->search_iku;

        $unitKerja = UnitKerja::when($searchUnit, function ($q) use ($searchUnit) {
            $q->where('nama_unit', 'like', "%$searchUnit%");
        })->paginate(10);

        $prosesAktivitas = ProsesAktivitas::when($searchProses, function ($q) use ($searchProses) {
            $q->where('nama_proses', 'like', "%$searchProses%");
        })->paginate(10);

        $kategoriRisiko = KategoriRisiko::when($searchKategori, function ($q) use ($searchKategori) {
            $q->where('nama_kategori', 'like', "%$searchKategori%");
        })->paginate(10);

        $jenisRisiko = JenisRisiko::when($searchJenis, function ($q) use ($searchJenis) {
            $q->where('nama_jenis', 'like', "%$searchJenis%");
        })->paginate(10);

        $ikuTerkait = IkuTerkait::when($searchIku, function ($q) use ($searchIku) {
            $q->where('nama_iku', 'like', "%$searchIku%");
        })->paginate(10);

        $allUnitKerja = UnitKerja::all();

        return view('pages.kelola_regis', compact(
            'unitKerja',
            'prosesAktivitas',
            'kategoriRisiko',
            'jenisRisiko',
            'ikuTerkait',
            'allUnitKerja'
        ));
    }

    public function store(Request $request)
    {
        $request->merge(['modal' => 'tambahUnit']);
        $validated = $request->validate([
            'unitkerja' => 'required|unique:unit_kerja,nama_unit',
        ], [
            'unitkerja.required' => 'Unit Kerja wajib diisi!',
            'unitkerja.unique' => 'Unit Kerja sudah ada!',
        ]);

        UnitKerja::create([
            'nama_unit' => $validated['unitkerja'],
        ]);
        return redirect()->route('kelola_regis')->with('success', 'Unit Kerja berhasil ditambahkan!');
    }


    public function update(Request $request, $id)
    {
        $request->merge([
            'modal' => 'editUnit',
            'edit_id' => $id,
        ]);

        $validated = $request->validate([
            'unitkerja' => 'required|unique:unit_kerja,nama_unit,' . $id,
        ], [
            'unitkerja.required' => 'Unit Kerja wajib diisi!',
            'unitkerja.unique' => 'Unit Kerja sudah ada!',
        ]);

        $unit = UnitKerja::findOrFail($id);
        $unit->update(['nama_unit' => $validated['unitkerja']]);

        return redirect()->route('kelola_regis')->with('success', 'Unit Kerja berhasil diubah!');
    }


    public function destroy($id)
    {
        $unit = UnitKerja::findOrFail($id);
        $unit->delete();
        return redirect()->route('kelola_regis')->with('success', 'Unit Kerja berhasil dihapus!');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        UnitKerja::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    public function storeProses(Request $request)
    {
        $request->merge(['modal' => 'tambahProses']);
    
        $request->validate([
            'proses' => [
                'required',
                Rule::unique('proses_aktivitas', 'nama_proses')
                    ->where('unit_kerja_id', $request->unit_kerja_id),
            ],
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
        ], [
            'proses.required' => 'Proses/Aktivitas wajib diisi!',
            'proses.unique' => 'Proses/Aktivitas sudah ada untuk unit kerja ini!',
            'unit_kerja_id.required' => 'Unit Kerja wajib dipilih!',
            'unit_kerja_id.exists' => 'Unit Kerja tidak valid!',
        ]);

    ProsesAktivitas::create([
        'nama_proses' => $request->proses,
        'unit_kerja_id' => $request->unit_kerja_id, 
    ]);

    return redirect()->route('kelola_regis')->with('success', 'Proses/Aktivitas berhasil ditambahkan!');
    }


    public function updateProses(Request $request, $id)
{
    $request->merge([
        'modal'   => 'editProses',
        'edit_id' => $id,
    ]);

    $validated = $request->validate([
        'proses' => [
            'required',
            Rule::unique('proses_aktivitas', 'nama_proses')
                ->where('unit_kerja_id', $request->unit_kerja_id)
                ->ignore($id),
        ],
        'unit_kerja_id' => 'required|exists:unit_kerja,id',
    ], [
        'proses.required' => 'Proses/Aktivitas wajib diisi!',
        'proses.unique' => 'Proses/Aktivitas sudah ada untuk unit kerja ini!',
        'unit_kerja_id.required' => 'Unit Kerja wajib dipilih!',
        'unit_kerja_id.exists' => 'Unit Kerja tidak valid!',
    ]);
    
        $proses = ProsesAktivitas::findOrFail($id);
        $proses->update([
            'nama_proses' => $validated['proses'],
            'unit_kerja_id' => $validated['unit_kerja_id'],
        ]);
    
        return redirect()->route('kelola_regis')->with('success', 'Proses/Aktivitas berhasil diubah!');
    }



    public function destroyProses($id)
    {
        $proses = ProsesAktivitas::findOrFail($id);
        $proses->delete();
        return redirect()->route('kelola_regis')->with('success', 'Proses/Aktivitas berhasil dihapus!');
    }

    public function deleteSelectedProses(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        ProsesAktivitas::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    public function storeKategori(Request $request)
    {
        $request->merge(['modal' => 'tambahKategori']);
        $request->validate([
            'kategori' => 'required|unique:kategori_risiko,nama_kategori',
        ], [
            'kategori.required' => 'Nama Kategori Risiko wajib diisi!',
            'kategori.unique' => 'Kategori Risiko sudah ada!',
        ]);

        KategoriRisiko::create(['nama_kategori' => $request->kategori]);
        return redirect()->route('kelola_regis')->with('success', 'Kategori Risiko berhasil ditambahkan!');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->merge([
            'modal' => 'editKategori',
            'edit_id' => $id,
        ]);

        $validated = $request->validate([
            'kategori' => 'required|unique:kategori_risiko,nama_kategori,' . $id,
        ], [
            'kategori.required' => 'Nama Kategori Risiko wajib diisi!',
            'kategori.unique' => 'Kategori Risiko sudah ada!',
        ]);

        $kategori = KategoriRisiko::findOrFail($id);
        $kategori->update(['nama_kategori' => $validated['kategori']]);

        return redirect()->route('kelola_regis')->with('success', 'Kategori Risiko berhasil diubah!');
    }
    public function destroyKategori($id)
    {
        $kategori = KategoriRisiko::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kelola_regis')->with('success', 'Kategori Risiko berhasil dihapus!');
    }

    public function deleteSelectedKategori(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        KategoriRisiko::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    public function storeJenis(Request $request)
    {
        $request->merge(['modal' => 'tambahJenis']);
        $request->validate([
            'jenis' => 'required|unique:jenis_risiko,nama_jenis',
        ], [
            'jenis.required' => 'Nama Jenis Risiko wajib diisi!',
            'jenis.unique' => 'Jenis Risiko sudah ada!',
        ]);

        JenisRisiko::create(['nama_jenis' => $request->jenis]);
        return redirect()->route('kelola_regis')->with('success', 'Jenis Risiko berhasil ditambahkan!');
    }

    public function updateJenis(Request $request, $id)
    {
        $request->merge([
            'modal' => 'editJenis',
            'edit_id' => $id,
        ]);

        $validated = $request->validate([
            'jenis' => 'required|unique:jenis_risiko,nama_jenis,' . $id,
        ], [
            'jenis.required' => 'Nama Jenis Risiko wajib diisi!',
            'jenis.unique' => 'Jenis Risiko sudah ada!',
        ]);

        $jenis = JenisRisiko::findOrFail($id);
        $jenis->update(['nama_jenis' => $validated['jenis']]);

        return redirect()->route('kelola_regis')->with('success', 'Jenis Risiko berhasil diubah!');
    }

    public function destroyJenis($id)
    {
        $jenis = JenisRisiko::findOrFail($id);
        $jenis->delete();
        return redirect()->route('kelola_regis')->with('success', 'Jenis Risiko berhasil dihapus!');
    }

    public function deleteSelectedJenis(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        JenisRisiko::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    public function storeIku(Request $request)
    {
        $request->merge(['modal' => 'tambahIku']);
        $request->validate([
            'iku' => 'required|unique:iku_terkait,nama_iku',
        ], [
            'iku.required' => 'Nama IKU wajib diisi!',
            'iku.unique' => 'IKU Terkait sudah ada!',
        ]);

        IkuTerkait::create(['nama_iku' => $request->iku]);
        return redirect()->route('kelola_regis')->with('success', 'IKU Terkait berhasil ditambahkan!');
    }

    public function updateIku(Request $request, $id)
    {
        $request->merge([
            'modal' => 'editIku',
            'edit_id' => $id,
        ]);

        $validated = $request->validate([
            'iku' => 'required|unique:iku_terkait,nama_iku,' . $id,
        ], [
            'iku.required' => 'Nama IKU wajib diisi!',
            'iku.unique' => 'IKU Terkait sudah ada!',
        ]);

        $iku = IkuTerkait::findOrFail($id);
        $iku->update(['nama_iku' => $validated['iku']]);

        return redirect()->route('kelola_regis')->with('success', 'IKU Terkait berhasil diubah!');
    }

    public function destroyIku($id)
    {
        $iku = IkuTerkait::findOrFail($id);
        $iku->delete();
        return redirect()->route('kelola_regis')->with('success', 'IKU Terkait berhasil dihapus!');
    }

    public function deleteSelectedIku(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        IkuTerkait::whereIn('id', $ids)->delete();

        return back()->with('success', 'Data terpilih berhasil dihapus!');
    }

    // Import Unit Kerja
    public function importUnitKerja(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        try {
            Excel::import(new \App\Imports\UnitKerjaImport, $request->file('file'));
            return redirect()->route('kelola_regis')->with('success', 'Data Unit Kerja berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('kelola_regis')->with('error', 'Gagal mengimpor Unit Kerja: ' . $e->getMessage());
        }
    }

    // Import Proses/Aktivitas
    public function importProses(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        try {
            Excel::import(new \App\Imports\ProsesAktivitasImport, $request->file('file'));
            return redirect()->route('kelola_regis')->with('success', 'Data Proses/Aktivitas berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('kelola_regis')->with('error', 'Gagal mengimpor Proses/Aktivitas: ' . $e->getMessage());
        }
    }

    //EXPORT Proses/Aktivitas
    public function exportTemplate()
    {
    return Excel::download(new ProsesAktivitasExport, 'template_proses_aktivitas.xlsx');
    }

    // Import Kategori Risiko
    public function importKategori(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        try {
            Excel::import(new \App\Imports\KategoriRisikoImport, $request->file('file'));
            return redirect()->route('kelola_regis')->with('success', 'Data Kategori Risiko berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('kelola_regis')->with('error', 'Gagal mengimpor Kategori Risiko: ' . $e->getMessage());
        }
    }

    // Import Jenis Risiko
    public function importJenis(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        try {
            Excel::import(new \App\Imports\JenisRisikoImport, $request->file('file'));
            return redirect()->route('kelola_regis')->with('success', 'Data Jenis Risiko berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('kelola_regis')->with('error', 'Gagal mengimpor Jenis Risiko: ' . $e->getMessage());
        }
    }

    // Import IKU Terkait
    public function importIku(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        try {
            Excel::import(new \App\Imports\IkuTerkaitImport, $request->file('file'));
            return redirect()->route('kelola_regis')->with('success', 'Data IKU Terkait berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('kelola_regis')->with('error', 'Gagal mengimpor IKU Terkait: ' . $e->getMessage());
        }
    }


}
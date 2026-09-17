<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeatmapColor;
use App\Models\KontenBeranda;

class KelolaBerandaController extends Controller
{
    public function index()
    {
        $konten = KontenBeranda::all();
        $colors = HeatmapColor::all();
        return view('pages.kelola_beranda', compact('konten', 'colors'));
    }

    public function saveColors(Request $request)
    {
        foreach ($request->colors as $cell) {
            HeatmapColor::updateOrCreate(
                ['row' => $cell['row'], 'col' => $cell['col']],
                ['color_level' => $cell['color']]
            );
        }

        return response()->json(['success' => true]);
    }

    public function storeKonten(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file' => 'nullable|file|max:5120',
        ]);

        $data = ['judul' => $request->judul];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konten/gambar', 'public');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('konten/file'), $namaFile);
            $data['file'] = 'konten/file/' . $namaFile;
        }

        KontenBeranda::create($data);

        return redirect()->back()->with('success', 'Konten berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $konten = KontenBeranda::findOrFail($id);

        $konten->judul = $request->judul;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('konten/gambar', 'public');
            $konten->gambar = $gambarPath;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('konten/file'), $namaFile);
            $konten->file = 'konten/file/' . $namaFile;
        }

        $konten->save();

        return redirect()->back()->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $konten = KontenBeranda::findOrFail($id);

        if ($konten->gambar && file_exists(public_path($konten->gambar))) {
            unlink(public_path($konten->gambar));
        }

        if ($konten->file && file_exists(public_path($konten->file))) {
            unlink(public_path($konten->file));
        }

        $konten->delete();

        return redirect()->back()->with('success', 'Konten berhasil dihapus.');
    }

}

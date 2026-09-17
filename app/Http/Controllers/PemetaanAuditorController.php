<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\DB;

class PemetaanAuditorController extends Controller
{
    public function index(Request $request)
    {
        $auditors = User::where('role', 'like', '%auditor%')->get();
        $unit = UnitKerja::all();

        // get mapping
        $mapping = DB::table('auditor_unit')
            ->join('users', 'auditor_unit.auditor_id', '=', 'users.id')
            ->join('unit_kerja', 'auditor_unit.unit_id', '=', 'unit_kerja.id')
            ->select(
                'auditor_unit.id',
                'users.name as auditor_name',
                'users.id as auditor_id',
                'unit_kerja.nama_unit',
                'unit_kerja.id as unit_id'
            )
            ->orderBy('auditor_name')
            ->get();

        return view('pages.pemetaan_auditor', compact('auditors', 'unit', 'mapping'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'auditor_id' => 'required|exists:users,id',
            'unit_ids' => 'array'
        ]);

        $auditor = User::findOrFail($request->auditor_id);

        // sync pivot table
        $auditor->auditorUnits()->sync($request->unit_ids ?? []);

        return redirect()->route('pemetaan_auditor')
            ->with('success', 'Pemetaan auditor berhasil diperbarui!');
    }


    public function deleteAll($auditor_id)
    {
        DB::table('auditor_unit')
            ->where('auditor_id', $auditor_id)
            ->delete();

        return redirect()->route('pemetaan_auditor')
            ->with('success', 'Seluruh pemetaan unit auditor berhasil dihapus!');
    }

}

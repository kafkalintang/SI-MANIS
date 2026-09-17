<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Hash;

class KelolaPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('unitKerja')
            ->when($search, function ($query, $search) {
                $query->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('unitKerja', function ($q) use ($search) {
                        $q->where('nama_unit', 'like', "%{$search}%");
                    })
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->get();

        $unitKerja = UnitKerja::all();

        return view('pages.kelola_pengguna', compact('users', 'unitKerja'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,username',
            'nama' => 'required',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string',
            'role1' => 'nullable|exists:unit_kerja,id'
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar!',
            'nama.required' => 'Nama wajib diisi.',
            'roles.required' => 'Role wajib dipilih.'
        ]);

        $unitId = $request->role1;
        $unitName = null;
        if ($unitId) {
            $unit = UnitKerja::find($unitId);
            $unitName = $unit ? strtolower($unit->nama_unit) : null;
        }

        $roles = $request->roles;
        $roleString = implode(',', array_map('trim', $roles));

        // Tambahan validasi khusus:
        if (in_array('kepala_unit', $roles) && !$unitId) {
            return back()->withInput()->withErrors([
                'role1' => 'Kepala Unit wajib memiliki Unit Kerja.'
            ]);
        }

        // Mapping rules 
        $valid = false;
        if (!$unitId) {
            $valid = ($roles === ['auditor'] || (count($roles) === 1 && in_array('auditor', $roles)));
        } elseif (strpos($unitName, 'p4m') !== false) {
            $allowed = ['p4m', 'auditor'];
            $valid = empty(array_diff($roles, $allowed));
        } elseif (strpos($unitName, 'manajemen') !== false) {
            $allowed = ['kepala_unit', 'auditor'];
            $valid = empty(array_diff($roles, $allowed));
        } else {
            if ($roles === ['auditor'] || (count($roles) === 1 && $roles[0] === 'auditor')) {
                $valid = false;
            } else {
                $allowed = ['kepala_unit', 'auditor'];
                $valid = empty(array_diff($roles, $allowed));
            }
        }

        if (!$valid) {
            return back()->withInput()->withErrors(['roles' => 'Kombinasi Unit Kerja dan Role tidak valid.']);
        }

        User::create([
            'username' => $request->nik,
            'name' => $request->nama,
            'role' => $roleString,
            'unit_kerja_id' => $unitId,
            'password' => Hash::make('123456') // default password
        ]);

        return redirect()->route('kelola_pengguna')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string'
        ]);

        $user = User::findOrFail($id);

        $unitId = $request->role1;
        $unitName = null;
        if ($unitId) {
            $unit = UnitKerja::find($unitId);
            $unitName = $unit ? strtolower($unit->nama_unit) : null;
        }

        $roles = $request->roles;
        $roleString = implode(',', array_map('trim', $roles));

        if (in_array('kepala_unit', $roles) && !$unitId) {
            return back()->withInput()->withErrors([
                'role1' => 'Kepala Unit wajib memiliki Unit Kerja.'
            ]);
        }

        $valid = false;
        if (!$unitId) {
            $valid = ($roles === ['auditor'] || (count($roles) === 1 && in_array('auditor', $roles)));
        } elseif (strpos($unitName, 'p4m') !== false) {
            $allowed = ['p4m', 'auditor'];
            $valid = empty(array_diff($roles, $allowed));
        } elseif (strpos($unitName, 'manajemen') !== false) {
            $allowed = ['kepala_unit', 'auditor'];
            $valid = empty(array_diff($roles, $allowed));
        } else {
            $allowed = ['kepala_unit', 'auditor'];
            $valid = empty(array_diff($roles, $allowed));
        }

        if (!$valid) {
            return back()->withInput()->withErrors(['roles' => 'Kombinasi Unit Kerja dan Role tidak valid.']);
        }

        // Update data
        $user->update([
            'username' => $request->nik,
            'name' => $request->nama,
            'role' => $roleString,
            'unit_kerja_id' => $request->role1
        ]);

        return redirect()->route('kelola_pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('kelola_pengguna')->with('success', 'Data pengguna berhasil dihapus!');
    }
}

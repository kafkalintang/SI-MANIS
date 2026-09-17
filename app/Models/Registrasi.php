<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;

    protected $table = 'registrasi';
    protected $primaryKey = 'id_registrasi';
    protected $fillable = [
        'unit_kerja_id',
        'proses_aktivitas_id',
        'kategori_risiko_id',
        'jenis_risiko_id',
        'iku_terkait_id',
        'isu_resiko',
        'jenis_isu',
        'akar_permasalahan',
        'dampak',
        'pihak_terkait',
        'kontrol_pencegahan',
        'keparahan',
        'frekuensi',
        'probabilitas',
        'status_registrasi',
        'komentar',
        'user_id',

    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }
    public function prosesAktivitas()
    {
        return $this->belongsTo(ProsesAktivitas::class, 'proses_aktivitas_id');
    }
    public function kategoriRisiko()
    {
        return $this->belongsTo(KategoriRisiko::class, 'kategori_risiko_id');
    }
    public function jenisRisiko()
    {
        return $this->belongsTo(JenisRisiko::class, 'jenis_risiko_id');
    }
    public function ikuTerkait()
    {
        return $this->belongsTo(IkuTerkait::class, 'iku_terkait_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitigasis()
    {
        return $this->hasMany(Mitigasi::class, 'registrasi_id', 'id_registrasi');
    }

    public function getFrekuensiDetailAttribute()
    {
        $map = [
            'A' => 'A. Hampir Pasti (Beberapa kali tiap peristiwa/ tiap hari terjadi)',
            'B' => 'B. Mungkin Sekali (>1 kali tiap bulan)',
            'C' => 'C. Mungkin (Dalam Setahun ada 1–5 kali)',
            'D' => 'D. Jarang (Dalam setahun hanya 1 kali)',
            'E' => 'E. Sangat Jarang (Hampir tidak pernah terjadi, dalam 5 tahun hanya 1 kali)',
        ];

        return $map[$this->frekuensi] ?? null;
    }

    public function getKeparahanDetailAttribute()
    {
        $map = [
            1 => '1. Tidak Signifikan (Dampaknya hanya di area tersebut)',
            2 => '2. Kecil (Dampaknya sampai satu bagian/departemen)',
            3 => '3. Sedang (Dampaknya sampai satu institusi)',
            4 => '4. Besar (Akibatnya sampai ke customer)',
            5 => '5. Bencana (Dampaknya sampai ke pemerintah dan atau customer)',
        ];

        return $map[$this->keparahan] ?? null;
    }

}

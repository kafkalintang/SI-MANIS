<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ArsipRisikoExport implements FromView
{
    protected $registrasi;

    public function __construct($registrasi)
    {
        $this->registrasi = $registrasi;
    }

    public function view(): View
    {
        return view('export.arsip_risiko_excel', [
            'registrasi' => $this->registrasi
        ]);
    }
}
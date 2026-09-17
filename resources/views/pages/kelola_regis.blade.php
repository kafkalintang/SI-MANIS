@extends('layouts.pengguna')

@section('title', 'Kelola Form Regis')

@push('modals')
    @include('components.kelolaformregis.modal-import-formregis')
    @include('components.kelolaformregis.modal-tambah-formregis')
    @include('components.kelolaformregis.modal-edit-formregis')
    @include('components.kelolaformregis.modal-hapus-formregis')
    @include('components.kelolaformregis.modal-tambah-formregis-prosesaktivitas')
    @include('components.kelolaformregis.modal-edit-formregis-prosesaktivitas')
@endpush

@section('content')
    {{-- Kelola Regis CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kelola_regis.css') }}">

    {{-- Header Judul + Tombol Import --}}
    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
        <h3 class="mb-0">Kelola Form Regis</h3>
    </div>

    <div class="card shadow-sm border-0 p-3">

        {{-- Tombol + Tabel (vertikal dan bisa tutup) --}}
        <div class="d-flex flex-column gap-3">

            @include('pages/tabel_kelola_regis/unitkerja')
            @include('pages/tabel_kelola_regis/prosesaktivitas')
            @include('pages/tabel_kelola_regis/kategoririsiko')
            @include('pages/tabel_kelola_regis/jenisrisiko')
            @include('pages/tabel_kelola_regis/iku')

        </div>
    </div>

    {{-- Script ganti tanda + / - --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-btn').forEach(button => {
                const collapseEl = document.querySelector(button.dataset.bsTarget);
                const bsCollapse = new bootstrap.Collapse(collapseEl, {
                    toggle: false
                }); 

                button.addEventListener('click', () => {
                    bsCollapse.toggle(); 
                });

                collapseEl.addEventListener('show.bs.collapse', () => {
                    button.textContent = button.textContent.replace('+', '−');
                });

                collapseEl.addEventListener('hide.bs.collapse', () => {
                    button.textContent = button.textContent.replace('−', '+');
                });
            });
        });
    </script>

    {{-- Script untuk alert CRUD --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @php
                $success = session()->pull('success');
                $error = session()->pull('error');
            @endphp

            @if ($success)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ $success }}',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            @endif

            @if ($error)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ $error }}',
                    showConfirmButton: true,
                });
            @endif
        });
    </script>


    {{-- Script Untuk Import --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importButtons = document.querySelectorAll('.btn-import');
            const form = document.getElementById('importForm');
            const templateLink = document.getElementById('templateLink');

            importButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const route = this.getAttribute('data-route');
                    const template = this.getAttribute('data-template');

                    form.setAttribute('action', route);
                    templateLink.setAttribute('href', template);
                });
            });
        });
    </script>

    {{-- Script Keep Open Collapse --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let opened = "{{ session('collapse_open') }}";

            if (opened) {
                let el = document.getElementById(opened);
                if (el) {
                    let collapse = new bootstrap.Collapse(el, {
                        show: true
                    });

                    //ubah tombol + jadi -
                    let btn = document.querySelector(`[data-bs-target="#${opened}"]`);
                    if (btn) btn.textContent = btn.textContent.replace('+', '−');
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.collapse').forEach(collapse => {

                collapse.addEventListener('show.bs.collapse', function() {
                    fetch("/save-collapse", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            open: collapse.id
                        })
                    });
                });

                collapse.addEventListener('hide.bs.collapse', function() {
                    fetch("/save-collapse", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            open: null
                        })
                    });
                });

            });
        });
    </script>

    {{-- Script untuk Multi-Select & Hapus Semua --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const configs = [{
                    name: 'Unit Kerja',
                    masterId: '#select-all-unit',
                    btnId: '#delete-selected-unit',
                    checkboxClass: '.check-unit',
                    route: "{{ route('unitkerja.delete-selected') }}"
                },
                {
                    name: 'Proses/Aktivitas',
                    masterId: '#select-all-proses',
                    btnId: '#delete-selected-proses',
                    checkboxClass: '.check-proses',
                    route: "{{ route('proses.delete-selected') }}"
                },
                {
                    name: 'Kategori Risiko',
                    masterId: '#select-all-kategori',
                    btnId: '#delete-selected-kategori',
                    checkboxClass: '.check-kategori',
                    route: "{{ route('kategori.delete-selected') }}"
                },
                {
                    name: 'Jenis Risiko',
                    masterId: '#select-all-jenis',
                    btnId: '#delete-selected-jenis',
                    checkboxClass: '.check-jenis',
                    route: "{{ route('jenis.delete-selected') }}"
                },
                {
                    name: 'IKU',
                    masterId: '#select-all-iku',
                    btnId: '#delete-selected-iku',
                    checkboxClass: '.check-iku',
                    route: "{{ route('iku.delete-selected') }}"
                }
            ];

            // Loop setiap konfigurasi
            configs.forEach(config => {
                const masterCheckbox = document.querySelector(config.masterId);
                const deleteBtn = document.querySelector(config.btnId);

                if (!masterCheckbox || !deleteBtn) return; // Skip jika elemen tidak ada

                masterCheckbox.addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll(config.checkboxClass);
                    checkboxes.forEach(cb => {
                        cb.checked = this.checked;
                    });
                });

                deleteBtn.addEventListener('click', function() {
                    // Ambil semua checkbox yang tercentang
                    const checkedBoxes = document.querySelectorAll(config.checkboxClass +
                        ':checked');

                    // Validasi jika kosong
                    if (checkedBoxes.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Silakan pilih data ' + config.name +
                                ' yang ingin dihapus terlebih dahulu.'
                        });
                        return;
                    }

                    // Konfirmasi User
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menghapus " + checkedBoxes.length + " data " +
                            config
                            .name + " terpilih.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kumpulkan ID
                            let ids = [];
                            checkedBoxes.forEach(cb => ids.push(cb.value));

                            // Submit Form Dinamis
                            submitForm(config.route, ids);
                        }
                    });
                });
            });

            // Fungsi Helper untuk Membuat dan Submit Form
            function submitForm(actionUrl, ids) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = actionUrl;

                // Input CSRF Token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = "{{ csrf_token() }}";
                form.appendChild(csrfToken);

                // Input Method DELETE
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                // Input Array IDs
                ids.forEach(id => {
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = 'ids[]';
                    inputId.value = id;
                    form.appendChild(inputId);
                });

                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>

@endsection

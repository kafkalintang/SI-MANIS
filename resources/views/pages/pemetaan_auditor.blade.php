@extends('layouts.pengguna')

@section('title', 'Pemetaan Auditor')

@push('modals')
    @include('components.pemetaanauditor.modal-edit-pemetaan')
    @include('components.pemetaanauditor.modal-hapus-pemetaan')
@endpush

@section('content')

    <h3 class="mt-3 mb-4">Pemetaan Auditor</h3>

    <div class="d-flex mb-4 justify-content-between">
        <div></div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>No</th>
                    <th>Auditor</th>
                    <th>Daftar Unit Yang Ditugaskan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($auditors as $index => $a)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $a->name }} ({{ $a->username }})</td>

                        <td>
                            @if ($a->auditorUnits->count() == 0)
                                <span class="text-muted">Belum ada unit</span>
                            @else
                                @foreach ($a->auditorUnits as $unit)
                                    <span class="badge bg-secondary">{{ $unit->nama_unit }}</span>
                                @endforeach
                            @endif
                        </td>

                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-primary edit-mapping" data-bs-toggle="modal"
                                data-bs-target="#editMappingModal" data-id="{{ $a->id }}" data-nama="{{ $a->name }}"
                                data-units="{{ $a->auditorUnits->pluck('id')->join(',') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- Tombol Delete -->
                            <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal"
                                data-bs-target="#hapusMappingModal" data-id="{{ $a->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
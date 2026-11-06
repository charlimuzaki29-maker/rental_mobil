@extends('layouts.admin')

@section('title', 'Manajemen Armada Supercar - Admin Cockpit')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-15">
    <div>
        <h3 class="fw-extrabold text-white mb-1">Manajemen Armada Supercar</h3>
        <p class="text-secondary small mb-0">Kelola master data supercar, tarif harian eksklusif, dan ketersediaan unit.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('admin.cars.create') }}" class="btn btn-luxury-red px-3 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Supercar Baru
        </a>
    </div>
</div>

<!-- Filter & Pencarian Dark -->
<div class="card card-custom p-3 mb-4">
    <form action="{{ route('admin.cars.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control form-control-dark" placeholder="Cari berdasarkan merek, model, atau plat nomor..." 
                       value="{{ $search ?? '' }}">
            </div>
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select form-select-dark">
                <option value="">Semua Kategori</option>
                <option value="Sedan" {{ ($category ?? '') == 'Sedan' ? 'selected' : '' }}>Sport Sedan & Coupe</option>
                <option value="SUV" {{ ($category ?? '') == 'SUV' ? 'selected' : '' }}>Super SUV</option>
                <option value="MPV" {{ ($category ?? '') == 'MPV' ? 'selected' : '' }}>VIP Lounge</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-secondary text-white fw-semibold">
                <i class="bi bi-filter me-1 text-danger"></i> Terapkan Filter
            </button>
            @if($search || $category)
                <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabel Daftar Mobil Dark Custom -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-dark-custom align-middle mb-0">
            <thead>
                <tr class="text-secondary small text-uppercase">
                    <th class="ps-4 py-3" style="width: 110px;">Foto Unit</th>
                    <th class="py-3">Merek & Model</th>
                    <th class="py-3">Kategori</th>
                    <th class="py-3">Nomor Plat</th>
                    <th class="py-3">Tarif / Hari</th>
                    <th class="py-3">Status Saat Ini</th>
                    <th class="text-end pe-4 py-3" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars as $car)
                    <tr>
                        <td class="ps-4 py-3">
                            <img src="{{ $car->image_url }}" alt="{{ $car->brand_model }}" 
                                 class="rounded-3 border border-secondary border-opacity-25 object-fit-cover shadow-sm" style="width: 85px; height: 55px; background: #030508;">
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-white fs-6">{{ $car->brand_model }}</div>
                            <small class="text-secondary font-monospace">ID Unit: #{{ $car->id }}</small>
                        </td>
                        <td class="py-3">
                            <span class="badge badge-category-luxury badge-{{ $car->category }}">
                                {{ $car->category }}
                            </span>
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-pill px-3 py-1 font-monospace" 
                                  style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.15); color: #fbbf24;">
                                {{ $car->plate_number }}
                            </span>
                        </td>
                        <td class="fw-extrabold text-white py-3">
                            {{ $car->formatted_rate }}
                        </td>
                        <td class="py-3">
                            @if($car->active_rentals_count > 0)
                                <span class="badge badge-status-disewa px-3 py-1">
                                    <i class="bi bi-clock-history me-1"></i> Sedang Mengaspal
                                </span>
                            @else
                                <span class="badge badge-status-selesai px-3 py-1">
                                    <i class="bi bi-check-circle me-1"></i> Siap Dipacu
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $car->id }}" title="Hapus Unit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Modal Konfirmasi Hapus Dark -->
                            <div class="modal fade text-start" id="deleteModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-dark">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Hapus Supercar dari Sistem
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus unit supercar <strong>{{ $car->brand_model }}</strong> (Plat: {{ $car->plate_number }})?
                                            <p class="text-secondary small mt-2 mb-0">Tindakan ini permanen dan akan menghapus data mobil dari katalog showroom.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus Unit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="bi bi-speedometer2 fs-2 d-block mb-2 text-secondary"></i>
                            Tidak ada data supercar yang sesuai dengan kriteria filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($cars->hasPages())
        <div class="card-footer bg-transparent py-3 border-top border-secondary border-opacity-10">
            {{ $cars->links() }}
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manajemen Transaksi Sewa - Admin Cockpit')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-15">
    <div>
        <h3 class="fw-extrabold text-white mb-1">Manajemen Transaksi Sewa Supercar</h3>
        <p class="text-secondary small mb-0">Pantau seluruh permohonan reservasi VIP, setujui status sewa, atau selesaikan pengembalian unit.</p>
    </div>
</div>

<!-- Filter Status Tabs & Pencarian Dark -->
<div class="card card-custom p-3 mb-4">
    <div class="row g-3 align-items-center">
        <!-- Filter Status Buttons -->
        <div class="col-md-7">
            <div class="btn-group flex-wrap" role="group">
                <a href="{{ route('admin.rentals.index', array_merge(request()->query(), ['status' => null])) }}" 
                   class="btn btn-sm {{ !request('status') ? 'btn-luxury-red text-white' : 'btn-outline-secondary text-white' }}">
                    Semua Transaksi
                </a>
                <a href="{{ route('admin.rentals.index', array_merge(request()->query(), ['status' => 'Disewa'])) }}" 
                   class="btn btn-sm {{ request('status') == 'Disewa' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary text-white' }}">
                    <i class="bi bi-clock-history me-1"></i> Disewa (Aktif)
                </a>
                <a href="{{ route('admin.rentals.index', array_merge(request()->query(), ['status' => 'Selesai'])) }}" 
                   class="btn btn-sm {{ request('status') == 'Selesai' ? 'btn-success text-white fw-bold' : 'btn-outline-secondary text-white' }}">
                    <i class="bi bi-check-circle me-1"></i> Selesai
                </a>
                <a href="{{ route('admin.rentals.index', array_merge(request()->query(), ['status' => 'Batal'])) }}" 
                   class="btn btn-sm {{ request('status') == 'Batal' ? 'btn-danger text-white fw-bold' : 'btn-outline-secondary text-white' }}">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>
        </div>

        <!-- Form Pencarian -->
        <div class="col-md-5">
            <form action="{{ route('admin.rentals.index') }}" method="GET">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="input-group">
                    <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control form-control-dark form-control-sm" 
                           placeholder="Cari nama penyewa, NIK, atau plat nomor..." value="{{ $search ?? '' }}">
                    @if($search)
                        <a href="{{ route('admin.rentals.index', ['status' => request('status')]) }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tabel Transaksi Rental Dark -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-dark-custom align-middle mb-0">
            <thead>
                <tr class="text-secondary small text-uppercase">
                    <th class="ps-4 py-3">No. Faktur</th>
                    <th class="py-3">Penyewa VIP & NIK</th>
                    <th class="py-3">Armada Supercar</th>
                    <th class="py-3">Periode Sewa</th>
                    <th class="py-3">Durasi</th>
                    <th class="py-3">Total Biaya</th>
                    <th class="py-3">Status</th>
                    <th class="text-end pe-4 py-3">Kelola Status & Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $rental)
                    <tr>
                        <td class="ps-4 py-3 fw-bold font-monospace text-warning">
                            {{ $rental->invoice_number }}
                            <small class="d-block text-secondary font-sans-serif" style="font-size: 0.7rem;">
                                {{ $rental->created_at->format('d/m/Y H:i') }}
                            </small>
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-white">{{ $rental->customer_name }}</div>
                            <small class="text-secondary"><i class="bi bi-card-text me-1"></i>{{ $rental->nik_number }}</small>
                        </td>
                        <td class="py-3">
                            @if($rental->rentalDetail && $rental->rentalDetail->car)
                                <div class="fw-bold text-white">{{ $rental->rentalDetail->car->brand_model }}</div>
                                <span class="badge rounded-pill px-2 py-0 font-monospace small" style="background: rgba(255,255,255,0.08); color: #fbbf24;">
                                    {{ $rental->rentalDetail->car->plate_number }}
                                </span>
                            @else
                                <span class="text-secondary fst-italic">Unit dihapus</span>
                            @endif
                        </td>
                        <td class="py-3">
                            <div class="small fw-semibold text-white">
                                {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-pill px-3 py-1 font-monospace" style="background: rgba(255,255,255,0.06); color: #e2e8f0;">
                                {{ $rental->rentalDetail->days_count ?? 1 }} Hari
                            </span>
                        </td>
                        <td class="py-3 fw-extrabold text-white">
                            {{ $rental->formatted_total_price }}
                        </td>
                        <td class="py-3">
                            @if($rental->status == 'Disewa')
                                <span class="badge badge-status-disewa px-3 py-1">
                                    <i class="bi bi-clock-history me-1"></i> Disewa
                                </span>
                            @elseif($rental->status == 'Selesai')
                                <span class="badge badge-status-selesai px-3 py-1">
                                    <i class="bi bi-check-circle me-1"></i> Selesai
                                </span>
                            @else
                                <span class="badge badge-status-batal px-3 py-1">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4 py-3">
                            <div class="d-inline-flex gap-1 align-items-center">
                                <!-- Trigger Modal Ubah Status -->
                                <button type="button" class="btn btn-sm btn-outline-warning fw-semibold px-2" 
                                        data-bs-toggle="modal" data-bs-target="#statusModal{{ $rental->id }}">
                                    <i class="bi bi-pencil-square me-1"></i> Status
                                </button>
                                <a href="{{ route('admin.rentals.show', $rental->id) }}" class="btn btn-sm btn-outline-secondary text-white" title="Lihat Faktur">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>

                            <!-- Modal Ubah Status Dark -->
                            <div class="modal fade text-start" id="statusModal{{ $rental->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-content-dark">
                                        <form action="{{ route('admin.rentals.status', $rental->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold text-white">Ubah Status: {{ $rental->invoice_number }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label text-secondary small fw-semibold">Penyewa VIP:</label>
                                                    <div class="fw-bold text-white">{{ $rental->customer_name }} (NIK: {{ $rental->nik_number }})</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-secondary small fw-semibold">Unit Supercar:</label>
                                                    <div class="text-white">{{ $rental->rentalDetail->car->brand_model ?? 'Mobil' }} - {{ $rental->rentalDetail->car->plate_number ?? '' }}</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="statusSelect{{ $rental->id }}" class="form-label text-white fw-bold small">Pilih Status Baru:</label>
                                                    <select class="form-select form-select-dark form-select-lg fs-6" id="statusSelect{{ $rental->id }}" name="status" required>
                                                        <option value="Disewa" {{ $rental->status == 'Disewa' ? 'selected' : '' }}>
                                                            🟡 Disewa (Sedang Aktif Dipacu di Lapangan)
                                                        </option>
                                                        <option value="Selesai" {{ $rental->status == 'Selesai' ? 'selected' : '' }}>
                                                            🟢 Selesai (Unit Telah Dikembalikan & Diinspeksi)
                                                        </option>
                                                        <option value="Batal" {{ $rental->status == 'Batal' ? 'selected' : '' }}>
                                                            🔴 Batal (Pemesanan Dibatalkan)
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="alert alert-info py-2 small mb-0" style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd;">
                                                    <i class="bi bi-info-circle me-1"></i> Mengubah status menjadi <strong>Selesai</strong> atau <strong>Batal</strong> akan otomatis membebaskan supercar kembali berstatus <em>Tersedia / Siap Dipacu</em> untuk tanggal lain.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-luxury-red btn-sm fw-bold">Simpan Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-secondary">
                            <i class="bi bi-receipt fs-2 d-block mb-2 text-secondary"></i>
                            Tidak ada transaksi sewa yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rentals->hasPages())
        <div class="card-footer bg-transparent py-3 border-top border-secondary border-opacity-10">
            {{ $rentals->links() }}
        </div>
    @endif
</div>
@endsection

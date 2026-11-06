@extends('layouts.admin')

@section('title', 'Detail Transaksi ' . $rental->invoice_number . ' - Admin Cockpit')

@section('content')
<div class="mb-4 pb-3 border-bottom border-secondary border-opacity-15 d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('admin.rentals.index') }}" class="text-decoration-none text-danger">Transaksi Sewa</a></li>
                <li class="breadcrumb-item active text-secondary" aria-current="page">Detail {{ $rental->invoice_number }}</li>
            </ol>
        </nav>
        <h3 class="fw-bold text-white mb-0">Rincian Reservasi: {{ $rental->invoice_number }}</h3>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary fw-semibold text-white">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Invoice Card Detail Dark Glassmorphism -->
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-start pb-4 mb-4 border-bottom border-secondary border-opacity-15">
                <div>
                    <span class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 1.5px;">FAKTUR SEWA VIP</span>
                    <div class="fs-3 fw-extrabold gold-gradient-text font-monospace">{{ $rental->invoice_number }}</div>
                    <small class="text-secondary">Waktu Dibuat: {{ $rental->created_at->format('d F Y, H:i') }} WIB</small>
                </div>
                <div class="text-end">
                    <span class="text-secondary small d-block mb-1">Status Reservasi:</span>
                    @if($rental->status == 'Disewa')
                        <span class="badge badge-status-disewa px-3 py-2 fs-6">Disewa</span>
                    @elseif($rental->status == 'Selesai')
                        <span class="badge badge-status-selesai px-3 py-2 fs-6">Selesai</span>
                    @else
                        <span class="badge badge-status-batal px-3 py-2 fs-6">Batal</span>
                    @endif
                </div>
            </div>

            <!-- Customer & Car Sections -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(11, 15, 25, 0.7); border: 1px solid var(--border-glass);">
                        <h6 class="fw-bold text-racing-red text-uppercase small mb-3 letter-spacing">
                            <i class="bi bi-person-fill me-1"></i> Data Penyewa VIP
                        </h6>
                        <table class="table table-borderless table-sm small mb-0 text-secondary">
                            <tr>
                                <td class="ps-0" style="width: 40%;">Nama Lengkap</td>
                                <td class="fw-bold text-white">: {{ $rental->customer_name }}</td>
                            </tr>
                            <tr>
                                <td class="ps-0">Nomor NIK</td>
                                <td class="fw-bold text-white">: {{ $rental->nik_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(11, 15, 25, 0.7); border: 1px solid var(--border-glass);">
                        <h6 class="fw-bold text-gold text-uppercase small mb-3 letter-spacing">
                            <i class="bi bi-speedometer2 me-1"></i> Data Supercar
                        </h6>
                        @if($rental->rentalDetail && $rental->rentalDetail->car)
                            <table class="table table-borderless table-sm small mb-0 text-secondary">
                                <tr>
                                    <td class="ps-0" style="width: 40%;">Armada</td>
                                    <td class="fw-bold text-white">: {{ $rental->rentalDetail->car->brand_model }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-0">Kategori</td>
                                    <td>: <span class="badge badge-category-luxury badge-{{ $rental->rentalDetail->car->category }}">{{ $rental->rentalDetail->car->category }}</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-0">No. Plat</td>
                                    <td class="fw-bold text-gold">: {{ $rental->rentalDetail->car->plate_number }}</td>
                                </tr>
                            </table>
                        @else
                            <p class="text-secondary small mb-0">Master data unit ini telah dihapus.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Item Table Dark -->
            <div class="table-responsive mb-4">
                <table class="table table-dark-custom align-middle">
                    <thead>
                        <tr class="text-secondary small text-uppercase">
                            <th class="py-3">Unit Supercar</th>
                            <th class="py-3 text-center">Periode Sewa</th>
                            <th class="py-3 text-center">Durasi</th>
                            <th class="py-3 text-end">Tarif Harian</th>
                            <th class="py-3 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3">
                                @if($rental->rentalDetail && $rental->rentalDetail->car)
                                    <div class="fw-bold text-white">{{ $rental->rentalDetail->car->brand_model }}</div>
                                    <small class="text-secondary">Plat: {{ $rental->rentalDetail->car->plate_number }}</small>
                                @else
                                    <span class="text-secondary">Unit Supercar</span>
                                @endif
                            </td>
                            <td class="text-center small py-3">
                                {{ $rental->start_date->format('d/m/Y') }} s/d {{ $rental->end_date->format('d/m/Y') }}
                            </td>
                            <td class="text-center fw-bold text-racing-red py-3">
                                {{ $rental->rentalDetail->days_count ?? 1 }} Hari
                            </td>
                            <td class="text-end text-secondary py-3">
                                {{ $rental->rentalDetail->car->formatted_rate ?? '-' }}
                            </td>
                            <td class="text-end fw-extrabold text-white py-3">
                                {{ $rental->rentalDetail->formatted_subtotal ?? $rental->formatted_total_price }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end fs-5 fw-bold text-white py-4 border-0">Total Nilai Transaksi:</th>
                            <th class="text-end fs-3 fw-extrabold gold-gradient-text py-4 border-0">
                                {{ $rental->formatted_total_price }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Panel Kontrol Status Transaksi (Kanan) -->
    <div class="col-lg-4">
        <div class="card card-custom p-4 mb-4">
            <h5 class="fw-bold text-white mb-3">Kelola Status Transaksi</h5>
            <form action="{{ route('admin.rentals.status', $rental->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="status" class="form-label text-secondary small fw-bold">Pilih Status Baru:</label>
                    <select name="status" id="status" class="form-select form-select-dark form-select-lg fs-6" required>
                        <option value="Disewa" {{ $rental->status == 'Disewa' ? 'selected' : '' }}>
                            🟡 Disewa (Sedang Berjalan di Lapangan)
                        </option>
                        <option value="Selesai" {{ $rental->status == 'Selesai' ? 'selected' : '' }}>
                            🟢 Selesai (Unit Telah Dikembalikan)
                        </option>
                        <option value="Batal" {{ $rental->status == 'Batal' ? 'selected' : '' }}>
                            🔴 Batal (Dibatalkan)
                        </option>
                    </select>
                </div>
                <div class="alert alert-info small py-2 mb-3" style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd;">
                    <i class="bi bi-info-circle me-1"></i> Status <strong>Selesai</strong> atau <strong>Batal</strong> membebaskan jadwal sewa mobil tersebut.
                </div>
                <button type="submit" class="btn btn-luxury-red w-100 fw-bold py-2">
                    <i class="bi bi-check2-circle me-1"></i> Perbarui Status
                </button>
            </form>
        </div>

        @if($rental->rentalDetail && $rental->rentalDetail->car)
            <div class="card card-custom overflow-hidden">
                <img src="{{ $rental->rentalDetail->car->image_url }}" alt="{{ $rental->rentalDetail->car->brand_model }}" class="w-100 object-fit-cover" style="height: 180px; background: #030508;">
                <div class="p-3">
                    <h6 class="fw-bold text-white mb-1">{{ $rental->rentalDetail->car->brand_model }}</h6>
                    <small class="text-secondary d-block mb-3">No. Plat: {{ $rental->rentalDetail->car->plate_number }}</small>
                    <a href="{{ route('admin.cars.edit', $rental->rentalDetail->car->id) }}" class="btn btn-outline-secondary btn-sm w-100 text-white">
                        <i class="bi bi-pencil-square me-1"></i> Edit Data Supercar
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

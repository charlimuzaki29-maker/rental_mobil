@extends('layouts.admin')

@section('title', 'Cockpit Dashboard - APEX EXOTICS')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-15">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge rounded-pill px-2 py-1" style="background: rgba(225, 29, 72, 0.15); border: 1px solid rgba(225, 29, 72, 0.3); color: #fb7185; font-size: 0.7rem;">
                SUPERCAR FLEET COCKPIT
            </span>
        </div>
        <h3 class="fw-extrabold text-white mb-1">Dashboard Ringkasan Operasional</h3>
        <p class="text-secondary small mb-0">Pantau performa armada supercar, status sewa aktif, dan perolehan omzet.</p>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="{{ route('admin.cars.create') }}" class="btn btn-luxury-red px-3 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Supercar
        </a>
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary px-3 py-2 fw-semibold text-white">
            <i class="bi bi-receipt me-1 text-warning"></i> Kelola Transaksi
        </a>
    </div>
</div>

<!-- Stat KPI Cards Dark Glassmorphism -->
<div class="row g-3 mb-4">
    <!-- Total Armada Mobil -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Koleksi Armada</span>
                <span class="p-2 rounded-3" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                    <i class="bi bi-speedometer2 fs-5"></i>
                </span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-extrabold text-white mb-0">{{ $totalCars }}</h2>
                <span class="text-secondary small">Unit Supercar</span>
            </div>
            <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 text-secondary small" style="font-size: 0.775rem;">
                Sedan: <strong class="text-info">{{ $sedanCount }}</strong> | SUV: <strong class="text-danger">{{ $suvCount }}</strong> | VIP: <strong class="text-warning">{{ $mpvCount }}</strong>
            </div>
        </div>
    </div>

    <!-- Mobil Sedang Disewa -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Sedang Mengaspal</span>
                <span class="p-2 rounded-3" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                    <i class="bi bi-clock-history fs-5"></i>
                </span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-extrabold text-warning mb-0">{{ $activeRentals }}</h2>
                <span class="text-secondary small">Sewa Aktif</span>
            </div>
            <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 text-secondary small" style="font-size: 0.775rem;">
                Unit sedang berada di tangan penyewa VIP
            </div>
        </div>
    </div>

    <!-- Total Transaksi Sewa -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Riwayat Reservasi</span>
                <span class="p-2 rounded-3" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
                    <i class="bi bi-receipt-cutoff fs-5"></i>
                </span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-extrabold text-white mb-0">{{ $totalRentals }}</h2>
                <span class="text-secondary small">Total Pesanan</span>
            </div>
            <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 text-secondary small" style="font-size: 0.775rem;">
                Selesai: <strong class="text-success">{{ $completedRentals }}</strong> | Batal: <strong class="text-danger">{{ $cancelledRentals }}</strong>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan Sewa -->
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary small fw-bold text-uppercase" style="letter-spacing: 1px;">Perputaran Omzet</span>
                <span class="p-2 rounded-3" style="background: rgba(225, 29, 72, 0.15); color: var(--racing-red);">
                    <i class="bi bi-cash-stack fs-5"></i>
                </span>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h3 class="fw-extrabold text-white mb-0" style="font-size: 1.45rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </h3>
            </div>
            <div class="mt-2 pt-2 border-top border-secondary border-opacity-10 text-secondary small" style="font-size: 0.775rem;">
                Akumulasi dari transaksi valid
            </div>
        </div>
    </div>
</div>

<!-- Tabel Transaksi Terbaru -->
<div class="card card-custom overflow-hidden mb-4">
    <div class="card-header bg-transparent py-3 px-4 d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-10">
        <div>
            <h5 class="fw-bold text-white mb-0">Transaksi Sewa Supercar Terbaru</h5>
            <small class="text-secondary">6 reservasi paling mutakhir yang masuk ke sistem</small>
        </div>
        <a href="{{ route('admin.rentals.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 text-white">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark-custom align-middle mb-0">
            <thead>
                <tr class="text-secondary small text-uppercase">
                    <th class="ps-4 py-3">No. Faktur</th>
                    <th class="py-3">Pelanggan VIP</th>
                    <th class="py-3">Armada Supercar</th>
                    <th class="py-3">Periode Sewa</th>
                    <th class="py-3">Total Biaya</th>
                    <th class="py-3">Status</th>
                    <th class="text-end pe-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRentals as $rental)
                    <tr>
                        <td class="ps-4 fw-bold font-monospace text-warning">{{ $rental->invoice_number }}</td>
                        <td>
                            <div class="fw-bold text-white">{{ $rental->customer_name }}</div>
                            <small class="text-secondary">NIK: {{ $rental->nik_number }}</small>
                        </td>
                        <td>
                            @if($rental->rentalDetail && $rental->rentalDetail->car)
                                <div class="fw-bold text-white">{{ $rental->rentalDetail->car->brand_model }}</div>
                                <span class="badge rounded-pill px-2 py-0 font-monospace small" style="background: rgba(255,255,255,0.08); color: #fbbf24;">
                                    {{ $rental->rentalDetail->car->plate_number }}
                                </span>
                            @else
                                <span class="text-secondary fst-italic">Unit dihapus</span>
                            @endif
                        </td>
                        <td>
                            <div class="small fw-semibold text-white">{{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}</div>
                            <small class="text-secondary">{{ $rental->rentalDetail->days_count ?? 1 }} Hari Sewa</small>
                        </td>
                        <td class="fw-extrabold text-white">
                            {{ $rental->formatted_total_price }}
                        </td>
                        <td>
                            @if($rental->status == 'Disewa')
                                <span class="badge badge-status-disewa px-3 py-1">Disewa</span>
                            @elseif($rental->status == 'Selesai')
                                <span class="badge badge-status-selesai px-3 py-1">Selesai</span>
                            @else
                                <span class="badge badge-status-batal px-3 py-1">Batal</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.rentals.show', $rental->id) }}" class="btn btn-sm btn-outline-secondary rounded-2 text-white">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            Belum ada riwayat transaksi sewa supercar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

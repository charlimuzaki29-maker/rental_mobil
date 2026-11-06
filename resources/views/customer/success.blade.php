@extends('layouts.app')

@section('title', 'VIP Reservation Receipt - ' . $rental->invoice_number . ' | APEX EXOTICS')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Glassmorphism VIP Receipt Card -->
            <div class="glass-card overflow-hidden print-area">
                <!-- Header Gold / Emerald Banner -->
                <div class="p-4 p-md-5 text-center position-relative" 
                     style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(7, 9, 14, 0.95) 100%); border-bottom: 1px solid rgba(16, 185, 129, 0.3);">
                    <div class="display-5 mb-2 text-success">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <span class="badge rounded-pill px-3 py-1 mb-2 text-uppercase" 
                          style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7; letter-spacing: 1px; font-size: 0.75rem;">
                        RESERVASI TERKONFIRMASI
                    </span>
                    <h3 class="fw-extrabold text-white mb-1">Pengajuan Sewa Supercar Berhasil</h3>
                    <p class="text-secondary small mb-0">Permintaan reservasi unit Anda telah tersimpan dengan aman dalam sistem reservasi VIP kami.</p>
                </div>

                <div class="p-4 p-md-5">
                    <!-- Invoice Bar -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mb-4 border-bottom border-secondary border-opacity-15 gy-3">
                        <div>
                            <span class="text-secondary small d-block">Nomor Faktur VIP:</span>
                            <span class="fs-4 fw-extrabold gold-gradient-text font-monospace">{{ $rental->invoice_number }}</span>
                        </div>
                        <div class="text-md-end">
                            <span class="text-secondary small d-block mb-1">Status Reservasi:</span>
                            <span class="badge rounded-pill px-3 py-2 fw-bold" 
                                  style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24;">
                                <i class="bi bi-clock-history me-1"></i> {{ $rental->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Grid Info Penyewa & Armada -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-glass);">
                                <h6 class="fw-bold text-racing-red text-uppercase small mb-3 letter-spacing">
                                    <i class="bi bi-person-badge me-1"></i> Identitas Penyewa
                                </h6>
                                <table class="table table-borderless table-sm small mb-0 text-secondary">
                                    <tr>
                                        <td class="ps-0" style="width: 40%;">Nama Lengkap</td>
                                        <td class="fw-bold text-white">: {{ $rental->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">Nomor NIK</td>
                                        <td class="fw-semibold text-white">: {{ $rental->nik_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">Waktu Order</td>
                                        <td class="text-white-50">: {{ $rental->created_at->format('d M Y, H:i') }} WIB</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-glass);">
                                <h6 class="fw-bold text-gold text-uppercase small mb-3 letter-spacing">
                                    <i class="bi bi-speedometer2 me-1"></i> Spesifikasi Armada
                                </h6>
                                <table class="table table-borderless table-sm small mb-0 text-secondary">
                                    <tr>
                                        <td class="ps-0" style="width: 40%;">Merek & Model</td>
                                        <td class="fw-bold text-white">: {{ $rental->rentalDetail->car->brand_model }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">Kategori</td>
                                        <td>: <span class="badge badge-category-luxury badge-{{ $rental->rentalDetail->car->category }}">{{ $rental->rentalDetail->car->category }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0">Nomor Plat</td>
                                        <td class="fw-bold text-gold">: {{ $rental->rentalDetail->car->plate_number }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Breakdown Table -->
                    <div class="table-responsive mb-4">
                        <table class="table align-middle" style="color: #cbd5e1;">
                            <thead>
                                <tr class="text-secondary small text-uppercase" style="border-bottom: 1px solid var(--border-glass);">
                                    <th class="py-3">Rincian Sewa Supercar</th>
                                    <th class="py-3 text-center">Periode Sewa</th>
                                    <th class="py-3 text-center">Durasi</th>
                                    <th class="py-3 text-end">Tarif Harian</th>
                                    <th class="py-3 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid var(--border-glass);">
                                    <td class="py-3">
                                        <div class="fw-bold text-white">{{ $rental->rentalDetail->car->brand_model }}</div>
                                        <small class="text-secondary">Plat: {{ $rental->rentalDetail->car->plate_number }}</small>
                                    </td>
                                    <td class="text-center small py-3">
                                        {{ $rental->start_date->format('d M Y') }} s/d {{ $rental->end_date->format('d M Y') }}
                                    </td>
                                    <td class="text-center fw-bold text-racing-red py-3">
                                        {{ $rental->rentalDetail->days_count }} Hari
                                    </td>
                                    <td class="text-end text-secondary py-3">
                                        {{ $rental->rentalDetail->car->formatted_rate }}
                                    </td>
                                    <td class="text-end fw-bold text-white py-3">
                                        {{ $rental->rentalDetail->formatted_subtotal }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end fs-5 fw-bold text-white py-4 border-0">Total Investasi Sewa:</th>
                                    <th class="text-end fs-3 fw-extrabold gold-gradient-text py-4 border-0">
                                        {{ $rental->formatted_total_price }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- VIP Pickup / Delivery Notice -->
                    <div class="p-3 rounded-3 mb-4 d-flex gap-3 align-items-center" 
                         style="background: rgba(212, 175, 55, 0.08); border: 1px solid rgba(212, 175, 55, 0.25);">
                        <i class="bi bi-info-circle-fill text-gold fs-4"></i>
                        <div class="small text-secondary">
                            <strong class="text-white">Protokol Penyerahan Armada:</strong> Tim VIP Concierge kami akan menghubungi Anda untuk verifikasi identitas (KTP NIK <strong>{{ $rental->nik_number }}</strong>) serta konfirmasi titik pengantaran towing tertutup.
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-between pt-3 border-top border-secondary border-opacity-15 d-print-none">
                        <a href="{{ route('home') }}" class="btn btn-luxury-outline px-4 py-2">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Showroom
                        </a>
                        <button onclick="window.print()" class="btn btn-luxury-red px-4 py-2">
                            <i class="bi bi-printer me-1"></i> Cetak Dokumen Faktur
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
        .navbar, footer, .d-print-none {
            display: none !important;
        }
        .print-area {
            background: #ffffff !important;
            border: 1px solid #ccc !important;
            box-shadow: none !important;
            color: #000000 !important;
        }
        .print-area * {
            color: #000000 !important;
            text-shadow: none !important;
        }
    }
</style>
@endpush

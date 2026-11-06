@extends('layouts.app')

@section('title', 'Booking Supercar - ' . $car->brand_model . ' | APEX EXOTICS')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb Nav -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-racing-red"><i class="bi bi-arrow-left me-1"></i> Kembali ke Showroom</a></li>
            <li class="breadcrumb-item active text-secondary" aria-current="page">Pengajuan Sewa Supercar</li>
        </ol>
    </nav>

    <!-- Error Alert from Availability check -->
    @if($errors->has('availability'))
        <div class="glass-card p-4 mb-4 border-danger border-opacity-50" style="background: rgba(225, 29, 72, 0.12);">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-exclamation-octagon-fill fs-3 text-racing-red"></i>
                <div>
                    <h5 class="fw-bold text-white mb-1">Armada Sedang Tidak Tersedia</h5>
                    <p class="text-secondary mb-0 small">{{ $errors->first('availability') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Rincian Supercar Terpilih (Kiri) -->
        <div class="col-lg-5">
            <div class="glass-card overflow-hidden sticky-top" style="top: 95px;">
                <div class="position-relative" style="height: 250px; background-color: #030508;">
                    <img src="{{ $car->image_url }}" alt="{{ $car->brand_model }}" class="w-100 h-100 object-fit-cover">
                    <span class="position-absolute top-0 start-0 m-3 badge badge-category-luxury badge-{{ $car->category }}">
                        {{ $car->category }}
                    </span>
                    <span class="position-absolute top-0 end-0 m-3 badge rounded-pill px-3 py-1 font-monospace" 
                          style="background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.2); color: #fbbf24;">
                        Plat: {{ $car->plate_number }}
                    </span>
                </div>

                <div class="p-4">
                    <span class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 1.5px;">Supercar Terpilih</span>
                    <h3 class="fw-extrabold text-white mb-1">{{ $car->brand_model }}</h3>
                    
                    <div class="p-3 my-3 rounded-3" style="background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-glass);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small fw-semibold">Tarif Sewa Harian</span>
                            <span class="fs-4 fw-extrabold text-white">{{ $car->formatted_rate }} <span class="fs-6 text-secondary fw-normal">/ hari</span></span>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary text-uppercase small mb-2" style="letter-spacing: 1px;">Layanan Eksklusif Termasuk:</h6>
                    <ul class="list-unstyled small text-secondary mb-0">
                        <li class="mb-2"><i class="bi bi-shield-check text-racing-red me-2"></i> Asuransi All-Risk Komprehensif Supercar</li>
                        <li class="mb-2"><i class="bi bi-truck-front text-gold me-2"></i> Pengiriman Towing Eksklusif Tertutup</li>
                        <li class="mb-2"><i class="bi bi-speedometer2 text-info me-2"></i> Inspeksi PDI & Bahan Bakar Oktan 98+ Terisi Penuh</li>
                        <li class="mb-0"><i class="bi bi-incognito text-white-50 me-2"></i> Jaminan Kerahasiaan Data Penyewa (NDA Protocol)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Formulir Pengajuan Sewa & Live Price Calculator (Kanan) -->
        <div class="col-lg-7">
            <div class="glass-card p-4 p-md-5">
                <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-15">
                    <span class="badge px-3 py-1 rounded-pill mb-2" style="background: rgba(225, 29, 72, 0.15); border: 1px solid rgba(225, 29, 72, 0.3); color: #fb7185;">
                        VIP BOOKING FORM
                    </span>
                    <h3 class="fw-bold text-white mb-1">Formulir Pengajuan Sewa</h3>
                    <p class="text-secondary small mb-0">Lengkapi data identitas Anda untuk verifikasi reservasi unit.</p>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" id="rentalForm">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    <input type="hidden" id="ratePerDay" value="{{ $car->rental_rate_per_day }}">

                    <!-- Nama Lengkap Sesuai KTP/Paspor -->
                    <div class="mb-4">
                        <label for="customer_name" class="form-label text-white small fw-bold">
                            Nama Lengkap Penyewa (Sesuai KTP/Paspor) <span class="text-racing-red">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control form-control-dark form-control-lg fs-6 @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" name="customer_name" 
                                   value="{{ old('customer_name') }}" 
                                   placeholder="Contoh: Raden Surya Atmadja" required>
                        </div>
                        @error('customer_name')
                            <div class="text-racing-red small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIK 16 Digit -->
                    <div class="mb-4">
                        <label for="nik_number" class="form-label text-white small fw-bold">
                            Nomor Induk Kependudukan (NIK 16 Digit) <span class="text-racing-red">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-card-heading"></i></span>
                            <input type="text" class="form-control form-control-dark form-control-lg fs-6 @error('nik_number') is-invalid @enderror" 
                                   id="nik_number" name="nik_number" 
                                   value="{{ old('nik_number') }}" 
                                   placeholder="Contoh: 3171012345670001" 
                                   maxlength="16" pattern="[0-9]{16}" required>
                        </div>
                        <small class="text-secondary" style="font-size: 0.775rem;">Harus berupa 16 digit angka resmi KTP.</small>
                        @error('nik_number')
                            <div class="text-racing-red small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Periode Sewa -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label text-white small fw-bold">
                                Tanggal Mulai Sewa <span class="text-racing-red">*</span>
                            </label>
                            <input type="date" class="form-control form-control-dark form-control-lg fs-6 @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" 
                                   value="{{ old('start_date', $startDate) }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="text-racing-red small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label text-white small fw-bold">
                                Tanggal Selesai Sewa <span class="text-racing-red">*</span>
                            </label>
                            <input type="date" class="form-control form-control-dark form-control-lg fs-6 @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" 
                                   value="{{ old('end_date', $endDate) }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('end_date')
                                <div class="text-racing-red small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- LIVE PRICE CALCULATOR CARD (LUXURY GLASSMORPHISM) -->
                    <div class="p-4 rounded-4 mb-4 position-relative overflow-hidden" 
                         style="background: linear-gradient(135deg, rgba(225,29,72,0.12) 0%, rgba(15,23,42,0.85) 100%); border: 1px solid rgba(225,29,72,0.35); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-calculator text-racing-red fs-5"></i>
                                <span>Live Price Calculator (Kalkulator Real-Time)</span>
                            </h6>
                            <span class="badge rounded-pill px-2 py-1 text-gold" style="background: rgba(212,175,55,0.15); border: 1px solid rgba(212,175,55,0.3); font-size: 0.7rem;">
                                OTOMATIS
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-secondary">Tarif Sewa Harian:</span>
                            <span class="fw-bold text-white">{{ $car->formatted_rate }} / hari</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2 small">
                            <span class="text-secondary">Durasi Sewa:</span>
                            <span class="badge rounded-pill px-3 py-1 fs-6 fw-bold" 
                                  style="background: rgba(225,29,72,0.2); border: 1px solid rgba(225,29,72,0.4); color: #fca5a5;" id="displayDaysCount">
                                {{ $initialDays }} Hari
                            </span>
                        </div>

                        <hr class="my-3 border-secondary border-opacity-25">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-secondary small d-block">Estimasi Total Biaya Sewa:</span>
                                <small class="text-white-50" style="font-size: 0.725rem;">(Durasi Hari × Tarif Harian)</small>
                            </div>
                            <div class="text-end">
                                <span class="fs-2 fw-extrabold gold-gradient-text" id="displayTotalPrice">
                                    Rp {{ number_format($initialSubtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-luxury-red btn-lg py-3 fw-bold fs-6">
                            <i class="bi bi-shield-check me-2"></i> Konfirmasi & Ajukan Reservasi Supercar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const ratePerDay = parseInt(document.getElementById('ratePerDay').value, 10);
        const displayDaysCount = document.getElementById('displayDaysCount');
        const displayTotalPrice = document.getElementById('displayTotalPrice');

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function calculateRental() {
            const startVal = startDateInput.value;
            const endVal = endDateInput.value;

            if (!startVal || !endVal) return;

            const start = new Date(startVal);
            const end = new Date(endVal);

            // Validasi tanggal selesai tidak boleh sebelum mulai
            if (end < start) {
                endDateInput.value = startVal;
                displayDaysCount.textContent = '1 Hari';
                displayTotalPrice.textContent = formatRupiah(ratePerDay);
                return;
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            // Minimal 1 hari jika start == end
            const daysCount = diffDays === 0 ? 1 : diffDays;
            const subtotal = daysCount * ratePerDay;

            // Update DOM dengan animasi singkat
            displayDaysCount.textContent = daysCount + ' Hari';
            displayTotalPrice.textContent = formatRupiah(subtotal);
        }

        // Live calculation event listeners
        startDateInput.addEventListener('change', function() {
            endDateInput.min = startDateInput.value;
            calculateRental();
        });

        endDateInput.addEventListener('change', calculateRental);
        startDateInput.addEventListener('input', calculateRental);
        endDateInput.addEventListener('input', calculateRental);
    });
</script>
@endpush

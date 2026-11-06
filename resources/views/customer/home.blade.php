@extends('layouts.app')

@section('title', 'APEX EXOTICS - Supercar & Luxury Car Rental Showroom')

@section('content')
<!-- Hero Supercar Section -->
<section class="hero-luxury mb-5">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-5">
            <div class="col-lg-7 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-3" 
                     style="background: rgba(225, 29, 72, 0.12); border: 1px solid rgba(225, 29, 72, 0.3);">
                    <i class="bi bi-fire text-racing-red"></i>
                    <span class="text-white small fw-bold text-uppercase" style="letter-spacing: 1.5px;">Eksklusivitas Tanpa Batas</span>
                </div>
                
                <h1 class="display-4 fw-extrabold text-white mb-3" style="letter-spacing: -1px; line-height: 1.15;">
                    Sensasi Mengemudi <span class="red-gradient-text">Supercar</span> & <span class="gold-gradient-text">Luxury Vehicles</span> Terbaik
                </h1>
                
                <p class="lead text-secondary mb-4 fs-6" style="line-height: 1.8;">
                    Wujudkan impian mengendarai mahakarya otomotif dunia. Dari raungan mesin V8 & twin-turbo hingga kenyamanan kabin first-class, kami hadirkan armada eksklusif dengan standar keselamatan dan privasi VIP tertinggi.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4">
                    <a href="#showroom" class="btn btn-luxury-red btn-lg px-4 py-3 fw-bold">
                        <i class="bi bi-speedometer2 me-2"></i> Jelajahi Showroom
                    </a>
                    <a href="#showroom" class="btn btn-luxury-outline btn-lg px-4 py-3 fw-semibold">
                        <i class="bi bi-calendar-check me-2 text-gold"></i> Cek Jadwal Ketersediaan
                    </a>
                </div>

                <!-- Fast Specs Badges -->
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start pt-2">
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="bi bi-check-circle-fill text-racing-red"></i> Unit Asli Terawat Dealer Resmi
                    </div>
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="bi bi-check-circle-fill text-gold"></i> Layanan Pengantaran Towing VIP
                    </div>
                    <div class="d-flex align-items-center gap-2 text-secondary small">
                        <i class="bi bi-check-circle-fill text-success"></i> Privasi & Asuransi Komprehensif
                    </div>
                </div>
            </div>

            <!-- Hero Supercar Feature Showcase Card -->
            <div class="col-lg-5">
                <div class="p-4 glass-card border-0 position-relative overflow-hidden" 
                     style="background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(7,9,14,0.95) 100%); border: 1px solid rgba(225,29,72,0.2) !important;">
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge" style="background: rgba(225,29,72,0.2); color: #fb7185; border: 1px solid rgba(225,29,72,0.4);">
                            <i class="bi bi-star-fill text-gold me-1"></i> TOP PERFORMANCE
                        </span>
                    </div>

                    <div class="mb-3">
                        <span class="text-uppercase text-secondary small fw-bold" style="letter-spacing: 2px;">Featured Machine</span>
                        <h4 class="text-white fw-bold mt-1 mb-0">Lamborghini Urus Performante</h4>
                        <span class="badge badge-category-luxury badge-SUV mt-2">Super SUV</span>
                    </div>

                    <div class="rounded-4 overflow-hidden mb-3 border border-secondary border-opacity-25" style="height: 200px;">
                        <img src="https://images.unsplash.com/photo-1544829099-b9a0c07fad1a?auto=format&fit=crop&w=800&q=80" 
                             alt="Lamborghini Urus" class="w-100 h-100 object-fit-cover">
                    </div>

                    <div class="row g-2 text-center pt-2 border-top border-secondary border-opacity-10 mb-3">
                        <div class="col-4">
                            <small class="text-secondary d-block" style="font-size: 0.7rem;">POWER</small>
                            <span class="text-white fw-bold">666 HP</span>
                        </div>
                        <div class="col-4 border-start border-secondary border-opacity-10">
                            <small class="text-secondary d-block" style="font-size: 0.7rem;">0 - 100 KM/H</small>
                            <span class="text-gold fw-bold">3.3 Detik</span>
                        </div>
                        <div class="col-4 border-start border-secondary border-opacity-10">
                            <small class="text-secondary d-block" style="font-size: 0.7rem;">TRANSMISI</small>
                            <span class="text-white fw-bold">8-Speed AT</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-secondary d-block" style="font-size: 0.75rem;">Mulai dari:</small>
                            <span class="fs-5 fw-extrabold text-white">Rp 18.000.000 <span class="fs-6 text-secondary fw-normal">/ hari</span></span>
                        </div>
                        <a href="#showroom" class="btn btn-sm btn-luxury-red px-3 py-2">
                            Pesan Unit Ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Showroom & Filter Section -->
<div class="container mb-5" id="showroom">
    <!-- Filter Card Glassmorphism -->
    <div class="glass-card p-4 mb-4">
        <!-- Interactive Category Tabs -->
        <div class="d-flex flex-wrap gap-2 mb-4 pb-3 border-bottom border-secondary border-opacity-15 justify-content-center justify-content-md-start">
            <a href="{{ route('home', array_merge(request()->except('category', 'page'))) }}" 
               class="btn btn-sm px-4 py-2 rounded-pill fw-bold transition-all {{ empty($selectedCategory) ? 'btn-luxury-red' : 'btn-luxury-outline' }}">
                <i class="bi bi-grid-fill me-1"></i> Semua Armada ({{ $cars->count() }})
            </a>
            <a href="{{ route('home', array_merge(request()->except('page'), ['category' => 'Sedan'])) }}" 
               class="btn btn-sm px-4 py-2 rounded-pill fw-bold transition-all {{ $selectedCategory == 'Sedan' ? 'btn-luxury-red' : 'btn-luxury-outline' }}">
                <i class="bi bi-lightning-charge-fill me-1 text-primary"></i> Sport Sedan & Coupe
            </a>
            <a href="{{ route('home', array_merge(request()->except('page'), ['category' => 'SUV'])) }}" 
               class="btn btn-sm px-4 py-2 rounded-pill fw-bold transition-all {{ $selectedCategory == 'SUV' ? 'btn-luxury-red' : 'btn-luxury-outline' }}">
                <i class="bi bi-shield-shaded me-1 text-racing-red"></i> Super SUV Performance
            </a>
            <a href="{{ route('home', array_merge(request()->except('page'), ['category' => 'MPV'])) }}" 
               class="btn btn-sm px-4 py-2 rounded-pill fw-bold transition-all {{ $selectedCategory == 'MPV' ? 'btn-luxury-red' : 'btn-luxury-outline' }}">
                <i class="bi bi-gem me-1 text-gold"></i> VIP Presidential Lounge
            </a>
        </div>

        <!-- Filter Tanggal Sewa -->
        <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-end">
            @if($selectedCategory)
                <input type="hidden" name="category" value="{{ $selectedCategory }}">
            @endif

            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">
                    <i class="bi bi-calendar-event me-1 text-racing-red"></i> Tanggal Mulai Sewa
                </label>
                <input type="date" name="start_date" class="form-control form-control-dark form-control-lg fs-6" 
                       value="{{ $startDate ?? '' }}" min="{{ date('Y-m-d') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label text-secondary small fw-bold">
                    <i class="bi bi-calendar-check me-1 text-gold"></i> Tanggal Selesai Sewa
                </label>
                <input type="date" name="end_date" class="form-control form-control-dark form-control-lg fs-6" 
                       value="{{ $endDate ?? '' }}" min="{{ date('Y-m-d') }}">
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-luxury-gold btn-lg w-100 fs-6 fw-bold">
                    <i class="bi bi-search me-1"></i> Cek Ketersediaan
                </button>
                @if($startDate || $endDate || $selectedCategory)
                    <a href="{{ route('home') }}" class="btn btn-luxury-outline btn-lg fs-6" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>

        @if($startDate && $endDate)
            <div class="mt-3 pt-3 border-top border-secondary border-opacity-10 d-flex align-items-center gap-2 small text-gold">
                <i class="bi bi-info-circle-fill"></i>
                <span>Menampilkan armada supercar yang <strong>TERSEDIA (siap dipacu)</strong> untuk periode <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong> hingga <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>.</span>
            </div>
        @endif
    </div>

    <!-- Section Title & Results Count -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-10">
        <div>
            <h3 class="fw-bold text-white mb-1">
                Koleksi Supercar & Kendaraan Mewah
            </h3>
            <p class="text-secondary small mb-0">Tersedia {{ $cars->count() }} unit performa tinggi yang terawat sempurna</p>
        </div>
        @if($selectedCategory)
            <span class="badge badge-category-luxury badge-{{ $selectedCategory }} fs-6 mt-2 mt-md-0">
                Kategori: {{ $selectedCategory }}
            </span>
        @endif
    </div>

    <!-- Cars Showcase Grid -->
    @if($cars->isEmpty())
        <div class="glass-card p-5 text-center my-4">
            <div class="mb-3">
                <i class="bi bi-speedometer text-secondary" style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold text-white">Tidak Ada Supercar yang Tersedia</h4>
            <p class="text-secondary mb-4">
                Seluruh armada pada kriteria atau rentang tanggal tersebut sedang berada di lintasan / disewa. Silakan pilih tanggal alternatif atau kategori lain.
            </p>
            <div>
                <a href="{{ route('home') }}" class="btn btn-luxury-red px-4 py-2">
                    <i class="bi bi-arrow-clockwise me-1"></i> Tampilkan Seluruh Koleksi
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($cars as $car)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-card h-100 d-flex flex-column overflow-hidden position-relative">
                        <!-- Top Image with Gradient Overlay -->
                        <div class="position-relative overflow-hidden" style="height: 220px; background-color: #030508;">
                            <img src="{{ $car->image_url }}" alt="{{ $car->brand_model }}" 
                                 class="w-100 h-100 object-fit-cover transition-transform" 
                                 style="transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);">
                            
                            <!-- Badges Overlay -->
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge badge-category-luxury badge-{{ $car->category }}">
                                    {{ $car->category }}
                                </span>
                            </div>

                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge rounded-pill px-3 py-1 shadow-sm small" 
                                      style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); color: #6ee7b7;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Siap Dipacu
                                </span>
                            </div>

                            <!-- Dark bottom gradient -->
                            <div class="position-absolute bottom-0 start-0 end-0 p-3" 
                                 style="background: linear-gradient(0deg, rgba(7,9,14,0.95) 0%, transparent 100%);">
                                <span class="badge font-monospace text-uppercase" 
                                      style="background: rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.15); color: #e2e8f0; font-size: 0.75rem;">
                                    <i class="bi bi-shield-lock me-1 text-gold"></i> Plat: {{ $car->plate_number }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold text-white mb-2" style="letter-spacing: -0.3px;">{{ $car->brand_model }}</h5>
                            
                            <div class="d-flex align-items-center gap-2 mb-3 small text-secondary">
                                <span><i class="bi bi-fuel-pump-diesel text-racing-red me-1"></i> High Octane RON 98+</span>
                                <span>•</span>
                                <span><i class="bi bi-shield-check text-gold me-1"></i> VIP Protocol</span>
                            </div>

                            <div class="mt-auto pt-3 border-top border-secondary border-opacity-15 d-flex justify-content-between align-items-end">
                                <div>
                                    <small class="text-secondary d-block" style="font-size: 0.725rem;">Tarif Sewa Eksklusif</small>
                                    <div class="fs-5 fw-extrabold text-white">
                                        {{ $car->formatted_rate }}
                                        <span class="fs-6 fw-normal text-secondary">/ hari</span>
                                    </div>
                                </div>
                                <a href="{{ route('booking.create', ['car' => $car->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                                   class="btn btn-luxury-red px-3 py-2 fs-6">
                                    <i class="bi bi-key-fill me-1"></i> Sewa Unit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Keunggulan Layanan VIP Concierge Section -->
<div class="container py-5" id="keunggulan">
    <div class="text-center mb-5">
        <span class="badge px-3 py-2 rounded-pill text-gold mb-2" style="background: rgba(212, 175, 55, 0.1); border: 1px solid rgba(212, 175, 55, 0.25);">
            STANDAR KUALITAS PRESTISIUS
        </span>
        <h3 class="fw-bold text-white">Mengapa Memilih Layanan APEX EXOTICS?</h3>
        <p class="text-secondary small">Setiap detail dipersiapkan untuk kesempurnaan perjalanan Anda.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="glass-card p-4 h-100">
                <div class="p-3 rounded-3 d-inline-flex mb-3" style="background: rgba(225, 29, 72, 0.15); color: var(--racing-red);">
                    <i class="bi bi-truck-front-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-white mb-2">Towing Delivery Tertutup</h5>
                <p class="text-secondary small mb-0" style="line-height: 1.7;">
                    Unit diantar langsung ke depan lobi hotel bintang lima, bandara VIP, atau kediaman Anda menggunakan truk towing hidrolik tertutup demi menjaga kebersihan dan kilometer armada.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4 h-100">
                <div class="p-3 rounded-3 d-inline-flex mb-3" style="background: rgba(212, 175, 55, 0.15); color: #fbbf24;">
                    <i class="bi bi-incognito fs-3"></i>
                </div>
                <h5 class="fw-bold text-white mb-2">Jaminan Privasi & NDA</h5>
                <p class="text-secondary small mb-0" style="line-height: 1.7;">
                    Kami memahami kebutuhan privasi pejabat, selebriti, dan eksekutif. Seluruh data penyewa dan aktivitas rental dilindungi oleh protokol kerahasiaan ketat.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4 h-100">
                <div class="p-3 rounded-3 d-inline-flex mb-3" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
                <h5 class="fw-bold text-white mb-2">Asuransi Komprehensif</h5>
                <p class="text-secondary small mb-0" style="line-height: 1.7;">
                    Nikmati sensasi performa supercar dengan rasa tenang berkat perlindungan asuransi all-risk komprehensif serta tim respons darurat 24 jam di seluruh kota besar.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

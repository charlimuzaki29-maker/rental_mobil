<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APEX EXOTICS - Luxury & Supercar Rental Showroom')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bg-carbon: #07090e;
            --bg-slate: #0b0f19;
            --bg-card: rgba(15, 23, 42, 0.72);
            --border-glass: rgba(255, 255, 255, 0.08);
            --racing-red: #e11d48;
            --racing-red-hover: #be123c;
            --metallic-gold: #d4af37;
            --gold-gradient: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #d4af37 100%);
            --red-gradient: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            --text-silver: #94a3b8;
            --text-heading: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-carbon);
            color: var(--text-silver);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Glassmorphism Classes */
        .glass-nav {
            background: rgba(7, 9, 14, 0.82) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-glass) !important;
        }

        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass);
            border-radius: 1.25rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card:hover {
            border-color: rgba(225, 29, 72, 0.35);
            box-shadow: 0 20px 40px -15px rgba(225, 29, 72, 0.15), 0 0 20px 0 rgba(0, 0, 0, 0.4);
            transform: translateY(-4px);
        }

        /* Typography & Brand */
        .brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #ffffff;
        }

        .text-gold {
            color: #fbbf24 !important;
        }

        .text-racing-red {
            color: var(--racing-red) !important;
        }

        .gold-gradient-text {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .red-gradient-text {
            background: var(--red-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Hero Banner */
        .hero-luxury {
            background: radial-gradient(circle at 80% 20%, rgba(225, 29, 72, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
                        linear-gradient(180deg, #07090e 0%, #0b0f19 100%);
            padding: 5rem 0 4rem;
            position: relative;
            border-bottom: 1px solid var(--border-glass);
        }

        /* Buttons */
        .btn-luxury-red {
            background: var(--red-gradient);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.35);
            transition: all 0.25s ease;
        }
        .btn-luxury-red:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(225, 29, 72, 0.5);
            transform: translateY(-2px);
        }

        .btn-luxury-outline {
            background: transparent;
            color: #e2e8f0;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 0.75rem;
            transition: all 0.25s ease;
        }
        .btn-luxury-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-luxury-gold {
            background: var(--gold-gradient);
            color: #07090e;
            font-weight: 700;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            transition: all 0.25s ease;
        }
        .btn-luxury-gold:hover {
            color: #000000;
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
            transform: translateY(-2px);
        }

        /* Badges */
        .badge-category-luxury {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-Sedan {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .badge-SUV {
            background: rgba(225, 29, 72, 0.15);
            color: #fb7185;
            border: 1px solid rgba(225, 29, 72, 0.3);
        }
        .badge-MPV {
            background: rgba(212, 175, 55, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        /* Inputs in Dark Theme */
        .form-control-dark, .form-select-dark {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border: 1px solid var(--border-glass) !important;
            color: #f8fafc !important;
            border-radius: 0.75rem;
        }
        .form-control-dark:focus, .form-select-dark:focus {
            background-color: rgba(15, 23, 42, 0.9) !important;
            border-color: var(--racing-red) !important;
            box-shadow: 0 0 0 0.25rem rgba(225, 29, 72, 0.2) !important;
            color: #ffffff !important;
        }
        .form-control-dark::placeholder {
            color: #64748b;
        }

        footer {
            margin-top: auto;
            background-color: #030508;
            border-top: 1px solid var(--border-glass);
            color: #64748b;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Luxury Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark glass-nav sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('home') }}">
                <span class="p-2 rounded-3 d-inline-flex align-items-center justify-content-center" 
                      style="background: linear-gradient(135deg, #e11d48, #9f1239); width: 42px; height: 42px; box-shadow: 0 0 15px rgba(225,29,72,0.5);">
                    <i class="bi bi-speedometer2 text-white fs-5"></i>
                </span>
                <div>
                    <span class="fs-4 brand-title">APEX<span class="text-racing-red">.</span>EXOTICS</span>
                    <small class="d-block text-uppercase text-secondary fw-semibold" style="font-size: 0.625rem; letter-spacing: 2px;">
                        Supercar & Luxury Rental
                    </small>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 {{ request()->routeIs('home') ? 'text-white active' : 'text-secondary' }}" href="{{ route('home') }}">
                            <i class="bi bi-collection-play me-1 text-racing-red"></i> Showroom Armada
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3 text-secondary" href="{{ route('home') }}#keunggulan">
                            <i class="bi bi-award me-1 text-gold"></i> Layanan VIP
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-luxury-red px-3 py-2 fw-semibold">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard Cockpit
                            </a>
                        @else
                            <a href="{{ route('admin.login') }}" class="btn btn-luxury-outline px-3 py-2 fw-semibold">
                                <i class="bi bi-shield-lock me-1 text-gold"></i> Admin VIP Login
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Notifications with Luxury Styling -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 p-3 shadow-lg" 
                 style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3) !important; color: #6ee7b7;" role="alert">
                <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 p-3 shadow-lg" 
                 style="background: rgba(225, 29, 72, 0.15); border: 1px solid rgba(225, 29, 72, 0.3) !important; color: #fca5a5;" role="alert">
                <i class="bi bi-exclamation-octagon-fill fs-4 text-racing-red"></i>
                <div class="fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 p-3 shadow-lg" 
                 style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3) !important; color: #fde68a;" role="alert">
                <i class="bi bi-info-circle-fill fs-4 text-warning"></i>
                <div class="fw-medium">{{ session('info') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Luxury Dark Footer -->
    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4 justify-content-between mb-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="p-2 rounded-2 d-inline-flex" style="background: var(--red-gradient);">
                            <i class="bi bi-speedometer2 text-white"></i>
                        </span>
                        <span class="fs-4 brand-title text-white">APEX<span class="text-racing-red">.</span>EXOTICS</span>
                    </div>
                    <p class="text-secondary small mb-4" style="line-height: 1.8;">
                        Penyedia layanan rental supercar, luxury performance SUV, dan VIP chauffeur nomor satu di Indonesia. Kami menghadirkan armada prestisius dengan standar performa dan privasi tertinggi untuk kebutuhan eksekutif, photoshoot, dan pengalaman berkendara impian.
                    </p>
                    <div class="d-flex gap-3 text-secondary">
                        <span class="badge border border-secondary border-opacity-25 rounded-pill px-3 py-2 text-white-50"><i class="bi bi-shield-check text-gold me-1"></i> Asuransi Komprehensif</span>
                        <span class="badge border border-secondary border-opacity-25 rounded-pill px-3 py-2 text-white-50"><i class="bi bi-patch-check text-racing-red me-1"></i> Garansi Unit Original</span>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-white fw-bold text-uppercase small mb-3 letter-spacing">Kategori Armada</h6>
                    <ul class="list-unstyled small text-secondary">
                        <li class="mb-2"><a href="{{ route('home', ['category' => 'Sedan']) }}" class="text-decoration-none text-secondary hover-white">Sport Sedan & Coupe</a></li>
                        <li class="mb-2"><a href="{{ route('home', ['category' => 'SUV']) }}" class="text-decoration-none text-secondary hover-white">Super SUV & Performance</a></li>
                        <li class="mb-2"><a href="{{ route('home', ['category' => 'MPV']) }}" class="text-decoration-none text-secondary hover-white">VIP Presidential Lounge</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-white fw-bold text-uppercase small mb-3 letter-spacing">Layanan Concierge</h6>
                    <ul class="list-unstyled small text-secondary">
                        <li class="mb-2"><i class="bi bi-geo-alt text-racing-red me-2"></i> Senayan City / SCBD, Jakarta</li>
                        <li class="mb-2"><i class="bi bi-telephone text-gold me-2"></i> +62 (21) 8088-APEX</li>
                        <li class="mb-2"><i class="bi bi-clock text-white-50 me-2"></i> 24/7 VIP Assistance</li>
                    </ul>
                </div>
            </div>

            <div class="pt-4 border-top border-secondary border-opacity-10 d-flex flex-wrap justify-content-between align-items-center small text-secondary">
                <div>&copy; {{ date('Y') }} APEX EXOTICS - Luxury & Supercar Rental. All rights reserved.</div>
                <div class="text-muted">Designed for Supercar Enthusiasts & VIP Executives.</div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

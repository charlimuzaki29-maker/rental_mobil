<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Cockpit - APEX EXOTICS Supercar Rental')</title>
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
            --bg-carbon: #06080d;
            --bg-content: #090d16;
            --bg-card: rgba(15, 23, 42, 0.7);
            --border-glass: rgba(255, 255, 255, 0.08);
            --racing-red: #e11d48;
            --racing-red-hover: #be123c;
            --metallic-gold: #d4af37;
            --gold-gradient: linear-gradient(135deg, #f59e0b 0%, #fbbf24 50%, #d4af37 100%);
            --red-gradient: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            --text-silver: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-content);
            color: var(--text-silver);
            min-height: 100vh;
        }

        .admin-sidebar {
            background-color: var(--bg-carbon);
            min-height: 100vh;
            border-right: 1px solid var(--border-glass);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid var(--border-glass);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #ffffff;
        }

        .nav-item-custom {
            margin: 0.25rem 0.75rem;
        }
        .nav-link-custom {
            color: #94a3b8;
            padding: 0.75rem 1rem;
            border-radius: 0.6rem;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link-custom:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }
        .nav-link-custom.active {
            color: #ffffff;
            background: var(--red-gradient);
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.35);
        }

        /* Dark Glass Cards */
        .card-custom {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass);
            border-radius: 1rem;
        }

        /* Badges */
        .badge-category-luxury {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-Sedan { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
        .badge-SUV { background: rgba(225, 29, 72, 0.15); color: #fb7185; border: 1px solid rgba(225, 29, 72, 0.3); }
        .badge-MPV { background: rgba(212, 175, 55, 0.15); color: #fbbf24; border: 1px solid rgba(212, 175, 55, 0.3); }

        /* Status Badges */
        .badge-status-disewa {
            background: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(245, 158, 11, 0.4) !important;
        }
        .badge-status-selesai {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border: 1px solid rgba(16, 185, 129, 0.4) !important;
        }
        .badge-status-batal {
            background: rgba(225, 29, 72, 0.15) !important;
            color: #f87171 !important;
            border: 1px solid rgba(225, 29, 72, 0.4) !important;
        }

        /* Dark Table & Form Controls */
        .table-dark-custom {
            color: #cbd5e1;
        }
        .table-dark-custom thead th {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--border-glass);
            color: #94a3b8;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .table-dark-custom tbody td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: transparent;
            color: #cbd5e1;
        }
        .table-dark-custom tbody tr:hover td {
            background: rgba(255, 255, 255, 0.03);
        }

        .form-control-dark, .form-select-dark {
            background-color: rgba(15, 23, 42, 0.7) !important;
            border: 1px solid var(--border-glass) !important;
            color: #f8fafc !important;
            border-radius: 0.6rem;
        }
        .form-control-dark:focus, .form-select-dark:focus {
            background-color: rgba(15, 23, 42, 0.95) !important;
            border-color: var(--racing-red) !important;
            box-shadow: 0 0 0 0.25rem rgba(225, 29, 72, 0.2) !important;
            color: #ffffff !important;
        }

        .btn-luxury-red {
            background: var(--red-gradient);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 0.6rem;
            transition: all 0.2s ease;
        }
        .btn-luxury-red:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .modal-content-dark {
            background-color: #0b0f19;
            border: 1px solid var(--border-glass);
            color: #e2e8f0;
        }
        .modal-content-dark .modal-header, 
        .modal-content-dark .modal-footer {
            border-color: var(--border-glass);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar Desktop -->
            <div class="col-lg-2 col-md-3 admin-sidebar d-none d-md-flex flex-column">
                <div class="sidebar-brand">
                    <span class="p-2 rounded-3 d-inline-flex" style="background: var(--red-gradient);">
                        <i class="bi bi-speedometer2 text-white fs-5"></i>
                    </span>
                    <div>
                        <span class="fs-5 brand-title">APEX<span class="text-danger">.</span></span>
                        <small class="d-block text-uppercase text-secondary" style="font-size: 0.65rem; letter-spacing: 1px;">Admin Cockpit</small>
                    </div>
                </div>

                <div class="py-3 flex-grow-1">
                    <div class="text-uppercase text-secondary px-4 mb-2" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 1.5px;">
                        Menu Operasional
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item-custom">
                            <a class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Dashboard KPI</span>
                            </a>
                        </li>
                        <li class="nav-item-custom">
                            <a class="nav-link-custom {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}" href="{{ route('admin.cars.index') }}">
                                <i class="bi bi-car-front-fill"></i>
                                <span>Armada Supercar</span>
                            </a>
                        </li>
                        <li class="nav-item-custom">
                            <a class="nav-link-custom {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}" href="{{ route('admin.rentals.index') }}">
                                <i class="bi bi-receipt-cutoff"></i>
                                <span>Transaksi Sewa</span>
                            </a>
                        </li>
                    </ul>

                    <div class="text-uppercase text-secondary px-4 mt-4 mb-2" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 1.5px;">
                        Portal Publik
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item-custom">
                            <a class="nav-link-custom" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-box-arrow-up-right text-warning"></i>
                                <span>Lihat Showroom</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Admin Profile & Logout bottom -->
                <div class="p-3 border-top border-secondary border-opacity-10">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                             style="width: 38px; height: 38px; background: var(--red-gradient); color: #fff;">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="text-white fw-bold text-truncate" style="font-size: 0.875rem;">
                                {{ Auth::user()->name ?? 'Administrator' }}
                            </div>
                            <small class="text-secondary d-block text-truncate" style="font-size: 0.725rem;">
                                {{ Auth::user()->email ?? 'admin@rentalmobil.com' }}
                            </small>
                        </div>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-semibold rounded-2 py-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar Cockpit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Topbar Header -->
            <div class="col-12 d-md-none p-3 d-flex justify-content-between align-items-center" style="background-color: var(--bg-carbon); border-bottom: 1px solid var(--border-glass);">
                <span class="brand-title fs-5 text-white">APEX<span class="text-danger">.</span> Cockpit</span>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
            <div class="col-12 d-md-none collapse p-3 border-bottom border-secondary border-opacity-15" style="background-color: var(--bg-carbon);" id="mobileMenu">
                <ul class="nav flex-column gap-2 mb-3">
                    <li><a class="nav-link text-white" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill me-2 text-danger"></i> Dashboard</a></li>
                    <li><a class="nav-link text-white" href="{{ route('admin.cars.index') }}"><i class="bi bi-car-front-fill me-2"></i> Armada Supercar</a></li>
                    <li><a class="nav-link text-white" href="{{ route('admin.rentals.index') }}"><i class="bi bi-receipt-cutoff me-2"></i> Transaksi Sewa</a></li>
                    <li><a class="nav-link text-white" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-2 text-warning"></i> Lihat Showroom</a></li>
                </ul>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm w-100"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                </form>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-10 col-md-9 p-4 p-md-5">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="alert alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 p-3 shadow-lg mb-4" 
                         style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3) !important; color: #6ee7b7;" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-dismissible fade show border-0 rounded-4 d-flex align-items-center gap-3 p-3 shadow-lg mb-4" 
                         style="background: rgba(225, 29, 72, 0.15); border: 1px solid rgba(225, 29, 72, 0.3) !important; color: #fca5a5;" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

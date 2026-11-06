<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cockpit Login - APEX EXOTICS Supercar Rental</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cinzel:wght@700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 20%, rgba(225, 29, 72, 0.18) 0%, transparent 60%),
                        radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.08) 0%, transparent 60%),
                        #06080d;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7), 0 0 30px rgba(225, 29, 72, 0.15);
            width: 100%;
            max-width: 460px;
        }

        .brand-title {
            font-family: 'Cinzel', serif;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #ffffff;
        }

        .form-control-dark {
            background-color: rgba(11, 15, 25, 0.75) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
            border-radius: 0.75rem;
        }
        .form-control-dark:focus {
            background-color: rgba(11, 15, 25, 0.95) !important;
            border-color: #e11d48 !important;
            box-shadow: 0 0 0 0.25rem rgba(225, 29, 72, 0.25) !important;
            color: #ffffff !important;
        }

        .btn-luxury-red {
            background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.35);
            transition: all 0.2s ease;
        }
        .btn-luxury-red:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: #ffffff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container p-3">
        <div class="login-card mx-auto p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="p-3 rounded-4 d-inline-flex align-items-center justify-content-center mb-3" 
                     style="background: linear-gradient(135deg, #e11d48, #9f1239); width: 60px; height: 60px; box-shadow: 0 0 20px rgba(225,29,72,0.6);">
                    <i class="bi bi-shield-lock-fill text-white fs-2"></i>
                </div>
                <h4 class="brand-title mb-1 text-white">APEX<span class="text-danger">.</span> COCKPIT</h4>
                <p class="text-secondary small mb-0">Autentikasi Administrator Showroom Supercar</p>
            </div>

            <!-- Flash Notifications -->
            @if(session('error'))
                <div class="alert alert-dismissible fade show border-0 rounded-3 small p-3 mb-4" 
                     style="background: rgba(225, 29, 72, 0.2); border: 1px solid rgba(225, 29, 72, 0.4) !important; color: #fca5a5;" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1 text-danger"></i> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-dismissible fade show border-0 rounded-3 small p-3 mb-4" 
                     style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.4) !important; color: #fde68a;" role="alert">
                    <i class="bi bi-info-circle-fill me-1 text-warning"></i> {{ session('info') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label text-white small fw-bold">Email Administrator</label>
                    <div class="input-group">
                        <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control form-control-dark form-control-lg fs-6 @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', 'admin@rentalmobil.com') }}" required autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label text-white small fw-bold">Password Kredensial</label>
                    <div class="input-group">
                        <span class="input-group-text form-control-dark border-end-0 text-secondary"><i class="bi bi-key"></i></span>
                        <input type="password" class="form-control form-control-dark form-control-lg fs-6 @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                        <label class="form-check-label small text-secondary" for="remember">
                            Pertahankan Sesi
                        </label>
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-luxury-red btn-lg py-2 fs-6">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Cockpit
                    </button>
                </div>
            </form>

            <!-- Kredensial Box -->
            <div class="p-3 rounded-3 small" style="background: rgba(11, 15, 25, 0.7); border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="fw-bold text-warning mb-1">
                    <i class="bi bi-key-fill me-1"></i> Kredensial Akun Default:
                </div>
                <div class="text-secondary" style="font-size: 0.825rem;">
                    <div>Email: <strong class="text-white">admin@rentalmobil.com</strong></div>
                    <div>Password: <strong class="text-white">admin123</strong></div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none small text-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Showroom Publik
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

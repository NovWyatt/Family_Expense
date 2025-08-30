<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Meta Tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Quỹ Đi Chợ">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-touch-fullscreen" content="yes">

    <!-- Icons for PWA -->
    <link rel="apple-touch-icon" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgwIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE4MCAxODAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxODAiIGhlaWdodD0iMTgwIiByeD0iNDAiIGZpbGw9IiM2NjdlZWEiLz4KPHN2ZyB4PSI0NSIgeT0iNDUiIHdpZHRoPSI5MCIgaGVpZ2h0PSI5MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJ3aGl0ZSI+CjxwYXRoIGQ9Ik03IDR2MTZoMTBWNEg3em0yIDJoNnYxMkg5VjZ6Ii8+CjxwYXRoIGQ9Ik01IDhINHYxMGMwIDEuMS45IDIgMiAyaDEwdi0xSDZWOHoiLz4KPHN2Zz4KPHN2Zz4=">
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iOCIgZmlsbD0iIzY2N2VlYSIvPgo8c3ZnIHg9IjgiIHk9IjgiIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJ3aGl0ZSI+CjxwYXRoIGQ9Ik0xOSA3aC0zVjZhNCA0IDAgMCAwLTgtMHYxSDVhMSAxIDAgMCAwLTEgMXYxMWExIDEgMCAwIDAgMSAxaDE0YTEgMSAwIDAgMCAxLTFWOGExIDEgMCAwIDAtMS0xek0xMCA2YTIgMiAwIDAgMSA0IDB2MWgtNFY2eiIvPgo8L3N2Zz4KPHN2Zz4=">

    <title>@yield('title', 'Đăng nhập') - Quỹ Đi Chợ</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --safe-area-top: env(safe-area-inset-top, 0px);
            --safe-area-bottom: env(safe-area-inset-bottom, 0px);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            padding-top: var(--safe-area-top);
            padding-bottom: var(--safe-area-bottom);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            animation: backgroundFloat 15s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes backgroundFloat {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(1deg);
            }

            66% {
                transform: translateY(10px) rotate(-1deg);
            }
        }

        /* Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            color: rgba(255, 255, 255, 0.1);
            animation: float 10s infinite ease-in-out;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            font-size: 2rem;
            animation-delay: -2s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 15%;
            font-size: 1.5rem;
            animation-delay: -4s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            font-size: 2.5rem;
            animation-delay: -6s;
        }

        .floating-element:nth-child(4) {
            bottom: 30%;
            right: 10%;
            font-size: 1.8rem;
            animation-delay: -8s;
        }

        .floating-element:nth-child(5) {
            top: 60%;
            left: 5%;
            font-size: 1.2rem;
            animation-delay: -1s;
        }

        .floating-element:nth-child(6) {
            top: 40%;
            right: 30%;
            font-size: 1.6rem;
            animation-delay: -3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.1;
            }

            25% {
                transform: translateY(-20px) translateX(10px) rotate(5deg);
                opacity: 0.2;
            }

            50% {
                transform: translateY(10px) translateX(-5px) rotate(-3deg);
                opacity: 0.15;
            }

            75% {
                transform: translateY(-10px) translateX(-10px) rotate(2deg);
                opacity: 0.08;
            }
        }

        /* Main Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        /* Auth Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 25px 25px 0 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* App Branding */
        .app-branding {
            text-align: center;
            margin-bottom: 2rem;
        }

        .app-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: iconFloat 3s ease-in-out infinite;
            position: relative;
        }

        .app-icon::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: var(--primary-gradient);
            border-radius: 23px;
            z-index: -1;
            opacity: 0.3;
            animation: iconGlow 2s ease-in-out infinite alternate;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes iconGlow {
            0% {
                opacity: 0.3;
                transform: scale(1);
            }

            100% {
                opacity: 0.6;
                transform: scale(1.05);
            }
        }

        .app-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .app-subtitle {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Form Styles */
        .auth-form {
            margin-top: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(248, 249, 250, 0.5);
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        .form-floating label {
            font-weight: 500;
            color: #6c757d;
            padding-left: 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control:focus+label,
        .form-control:not(:placeholder-shown)+label {
            color: #667eea;
            transform: scale(0.9) translateY(-0.5rem);
        }

        /* Button Styles */
        .btn-auth {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-auth::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-auth:hover::before {
            left: 100%;
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .btn-auth:disabled {
            opacity: 0.7;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            animation: alertSlide 0.3s ease-out;
        }

        @keyframes alertSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fff5f5, #ffe6e6);
            color: #c53030;
            border-left: 4px solid #e53e3e;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fff4, #e6fffa);
            color: #2f855a;
            border-left: 4px solid #38a169;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fffbf0, #fef5e7);
            color: #b7791f;
            border-left: 4px solid #d69e2e;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .auth-footer small {
            color: #6c757d;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .love-icon {
            color: #e53e3e;
            animation: heartbeat 2s ease-in-out infinite;
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Loading State */
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .spinner-border {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }

        /* PWA Install Prompt */
        .install-prompt {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .install-prompt.show {
            transform: translateY(0);
            opacity: 1;
        }

        .install-prompt .btn-sm {
            border-radius: 8px;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .auth-container {
                padding: 15px;
            }

            .auth-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
                margin-top: 10px;
            }

            .app-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            .app-title {
                font-size: 1.6rem;
            }

            .floating-element {
                display: none;
                /* Hide on mobile for performance */
            }
        }

        @media (max-height: 700px) {
            .auth-card {
                padding: 2rem;
            }

            .app-icon {
                width: 65px;
                height: 65px;
                margin-bottom: 1rem;
            }
        }

        /* PWA Standalone Mode */
        @media (display-mode: standalone) {
            .auth-container {
                padding-top: calc(20px + var(--safe-area-top));
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .auth-card {
                background: rgba(45, 45, 45, 0.95);
                color: #ffffff;
            }

            .app-title {
                color: #ffffff;
            }

            .form-control {
                background: rgba(60, 60, 60, 0.5);
                border-color: #495057;
                color: #ffffff;
            }

            .form-floating label {
                color: #adb5bd;
            }

            .form-control:focus+label,
            .form-control:not(:placeholder-shown)+label {
                color: #667eea;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High Contrast Mode */
        @media (prefers-contrast: high) {
            .auth-card {
                background: #ffffff;
                border: 2px solid #000000;
            }

            .form-control {
                border-color: #000000;
            }
        }

    </style>

    @stack('styles')
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element">
            <i class="bi bi-basket2"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-wallet2"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-house-heart"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-piggy-bank"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-receipt"></i>
        </div>
    </div>

    <!-- Main Content -->
    <div class="auth-container">
        <div class="auth-card">
            <!-- App Branding -->
            <div class="app-branding">
                <div class="app-icon">
                    <i class="bi bi-basket2-fill"></i>
                </div>
                <h1 class="app-title">Quỹ Đi Chợ</h1>
                <p class="app-subtitle">Family Expense Manager</p>
            </div>

            <!-- Alerts -->
            @if (session('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Có lỗi xảy ra:</strong>
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Page Content -->
            @yield('content')

            <!-- Footer -->
            <div class="auth-footer">
                <small>
                    Ứng dụng quản lý quỹ gia đình<br>
                    Made with <span class="love-icon">Wyatt</span>
                </small>
            </div>
        </div>
    </div>

    <!-- PWA Install Prompt -->
    <div class="install-prompt" id="installPrompt">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <strong>Cài đặt App</strong><br>
                <small class="text-muted">Thêm vào màn hình chính để dùng như app</small>
            </div>
            <div>
                <button class="btn btn-primary btn-sm me-2" id="installBtn">
                    <i class="bi bi-download me-1"></i>Cài đặt
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="dismissInstall">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Common Scripts -->
    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? .getAttribute('content');

        // Show loading state for forms
        function showLoading(element, loadingText = 'Đang xử lý...') {
            if (element.classList.contains('btn')) {
                element.innerHTML = `
                    <div class="loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        ${loadingText}
                    </div>
                `;
                element.disabled = true;
            }
        }

        // Hide loading state
        function hideLoading(element, originalText) {
            if (element.classList.contains('btn')) {
                element.innerHTML = originalText;
                element.disabled = false;
            }
        }

        // PWA Install Functionality
        let deferredPrompt;
        const installPrompt = document.getElementById('installPrompt');
        const installBtn = document.getElementById('installBtn');
        const dismissInstall = document.getElementById('dismissInstall');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show install prompt after 3 seconds
            setTimeout(() => {
                if (!localStorage.getItem('pwa-dismissed')) {
                    installPrompt.classList.add('show');
                }
            }, 3000);
        });

        installBtn ? .addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const {
                    outcome
                } = await deferredPrompt.userChoice;

                if (outcome === 'accepted') {
                    console.log('PWA installed');
                }

                deferredPrompt = null;
                installPrompt.classList.remove('show');
            }
        });

        dismissInstall ? .addEventListener('click', () => {
            installPrompt.classList.remove('show');
            localStorage.setItem('pwa-dismissed', 'true');
        });

        // Auto-hide install prompt after 10 seconds
        setTimeout(() => {
            installPrompt ? .classList.remove('show');
        }, 13000);

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                // Register service worker when ready
                console.log('Service Worker ready for registration');
            });
        }

        // Auto-focus first input field
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('input[type="text"], input[type="email"], input[type="password"]');
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 100);
            }
        });

        // Enhanced form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.needs-validation');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Enter key on forms
            if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                const form = e.target.closest('form');
                const submitBtn = form ? .querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.click();
                }
            }
        });

    </script>

    @stack('scripts')
</body>
</html>

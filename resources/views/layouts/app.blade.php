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
    <link rel="apple-touch-icon"
        href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgwIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDE4MCAxODAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxODAiIGhlaWdodD0iMTgwIiByeD0iNDAiIGZpbGw9IiM2NjdlZWEiLz4KPHN2ZyB4PSI0NSIgeT0iNDUiIHdpZHRoPSI5MCIgaGVpZ2h0PSI5MCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJ3aGl0ZSI+CjxwYXRoIGQ9Ik03IDR2MTZoMTBWNEg3em0yIDJoNnYxMkg5VjZ6Ii8+CjxwYXRoIGQ9Ik01IDhINHYxMGMwIDEuMS45IDIgMiAyaDEwdi0xSDZWOHoiLz4KPHN2Zz4KPHN2Zz4=">
    <link rel="icon" type="image/x-icon"
        href="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiByeD0iOCIgZmlsbD0iIzY2N2VlYSIvPgo8c3ZnIHg9IjgiIHk9IjgiIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJ3aGl0ZSI+CjxwYXRoIGQ9Ik0xOSA3aC0zVjZhNCA0IDAgMCAwLTgtMHYxSDVhMSAxIDAgMCAwLTEgMXYxMWExIDEgMCAwIDAgMSAxaDE0YTEgMSAwIDAgMCAxLTFWOGExIDEgMCAwIDAtMS0xek0xMCA2YTIgMiAwIDAgMSA0IDB2MWgtNFY2eiIvPgo8L3N2Zz4KPHN2Zz4=">

    <title>@yield('title', 'Quỹ Đi Chợ') - Family App</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --safe-area-top: env(safe-area-inset-top, 0px);
            --safe-area-bottom: env(safe-area-inset-bottom, 0px);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            padding-top: var(--safe-area-top);
            padding-bottom: var(--safe-area-bottom);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Header Styles */
        .main-header {
            background: var(--primary-gradient);
            border-radius: 0 0 20px 20px;
            padding: 1rem 0 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .main-header .container {
            padding-top: var(--safe-area-top);
        }

        .header-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .header-brand:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        .header-brand i {
            font-size: 1.8rem;
            margin-right: 0.5rem;
        }

        .user-info {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            text-align: right;
        }

        .current-balance {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }

        /* Navigation Styles */
        .main-nav {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: -10px 15px 20px;
            overflow: hidden;
            position: sticky;
            top: 10px;
            z-index: 100;
        }

        .nav-item {
            flex: 1;
        }

        .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.75rem 0.5rem;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
            border: none;
            background: none;
            position: relative;
        }

        .nav-link i {
            font-size: 1.4rem;
            margin-bottom: 0.25rem;
        }

        .nav-link span {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 3px 3px 0 0;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding-bottom: 2rem;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        /* Button Styles */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        /* FAB Style */
        .fab {
            position: fixed;
            bottom: calc(20px + var(--safe-area-bottom));
            right: 20px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        /* Loading Styles */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .main-nav {
                margin: -10px 10px 15px;
                border-radius: 12px;
            }

            .card {
                margin-left: 5px;
                margin-right: 5px;
            }
        }

        /* PWA specific styles */
        @media (display-mode: standalone) {
            .main-header .container {
                padding-top: calc(var(--safe-area-top) + 10px);
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
                color: #ffffff;
            }

            .card {
                background-color: #2d2d2d;
                color: #ffffff;
            }

            .main-nav {
                background: #2d2d2d;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <a href="{{ route('dashboard') }}" class="header-brand">
                        <i class="bi bi-basket2-fill"></i>
                        <span>Quỹ Đi Chợ</span>
                    </a>
                </div>
                <div class="col-4">
                    <div class="user-info">
                        <div class="current-balance" id="currentBalance">
                            {{ number_format($currentBalance ?? \App\Models\AppSetting::getCurrentFundBalance()) }} VNĐ
                        </div>
                        <small>Quỹ hiện tại</small>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="d-flex">
            <div class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('funds.index') }}"
                    class="nav-link {{ request()->routeIs('funds.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet-fill"></i>
                    <span>Quỹ</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('shopping.index') }}"
                    class="nav-link {{ request()->routeIs('shopping.*') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i>
                    <span>Đi chợ</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('export.index') }}"
                    class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
                    <i class="bi bi-download"></i>
                    <span>Xuất Excel</span>
                </a>
            </div>
            <div class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Thoát</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Breadcrumb -->
            @if(!request()->routeIs('dashboard'))
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb bg-transparent p-0 mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                <i class="bi bi-house"></i> Trang chủ
                            </a>
                        </li>
                        @stack('breadcrumb')
                    </ol>
                </nav>
            @endif

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Có lỗi xảy ra:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- FAB Button (conditionally shown) -->
    @stack('fab')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Common Scripts -->
    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Update current balance
        function updateBalance() {
            fetch('{{ route("funds.api.balance") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.formatted_balance) {
                        document.getElementById('currentBalance').textContent = data.formatted_balance;
                    }
                })
                .catch(error => console.log('Balance update error:', error));
        }

        // Auto refresh balance every 30 seconds
        setInterval(updateBalance, 30000);

        // Show loading state
        function showLoading(element) {
            element.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Đang xử lý...';
            element.disabled = true;
        }

        // Hide loading state
        function hideLoading(element, originalText) {
            element.innerHTML = originalText;
            element.disabled = false;
        }

        // Format number as Vietnamese currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
        }

        // Format Vietnamese date
        function formatDate(date) {
            return new Date(date).toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = `
                <div class="toast align-items-center text-white bg-${type} border-0" role="alert" style="position: fixed; top: 100px; right: 20px; z-index: 9999;">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toast);
            const toastEl = document.querySelector('.toast:last-child');
            new bootstrap.Toast(toastEl).show();

            // Auto remove after 5 seconds
            setTimeout(() => toastEl.remove(), 5000);
        }

        // PWA install prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            deferredPrompt = e;
            // Show install button if needed
        });

        // Service worker registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                // Register service worker when ready
            });
        }
    </script>

    @stack('scripts')
</body>

</html>

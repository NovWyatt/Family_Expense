<!DOCTYPE html>
<html lang="vi">
<head>
    {{-- Meta Tags --}}
    @include('layouts.partials.meta-tags')

    <title>@yield('title', 'Trang chủ') - Quỹ Đi Chợ</title>

    {{-- Styles --}}
    @include('layouts.partials.styles')

    {{-- PWA Manifest --}}
    @include('layouts.partials.pwa-manifest')

    {{-- Page specific head content --}}
    @stack('head')
</head>
<body class="@yield('body-class', '')">
    {{-- Page Loading Overlay --}}
    <div id="pageLoadingOverlay" class="page-loading-overlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Đang tải...</p>
        </div>
    </div>

    {{-- Navigation Header --}}
    @include('layouts.components.navbar')

    {{-- Main Content Container --}}
    <main class="main-container" id="mainContainer">
        {{-- Breadcrumb Navigation --}}
        @include('layouts.components.breadcrumb')

        {{-- Alert Messages --}}
        @include('layouts.components.alert')

        {{-- Page Content --}}
        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        {{-- Floating Action Button --}}
        @stack('fab')

        {{-- Bottom Navigation (Mobile) --}}
        <nav class="bottom-nav" id="bottomNav">
            <div class="bottom-nav-items">
                <a href="{{ route('dashboard') }}" class="bottom-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Trang chủ</span>
                </a>
                <a href="{{ route('funds.index') }}" class="bottom-nav-item {{ request()->routeIs('funds.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet-fill"></i>
                    <span>Quỹ</span>
                </a>
                <a href="{{ route('shopping.create') }}" class="bottom-nav-item bottom-nav-fab">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Thêm</span>
                </a>
                <a href="{{ route('shopping.index') }}" class="bottom-nav-item {{ request()->routeIs('shopping.*') && !request()->routeIs('shopping.create') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i>
                    <span>Đi chợ</span>
                </a>
                <a href="{{ route('export.index') }}" class="bottom-nav-item {{ request()->routeIs('export.*') ? 'active' : '' }}">
                    <i class="bi bi-download"></i>
                    <span>Excel</span>
                </a>
            </div>
        </nav>
    </main>

    {{-- Sidebar (Desktop) --}}
    @include('layouts.components.sidebar')

    {{-- Global Modals --}}
    <div class="modals-container">
        {{-- Quick Add Fund Modal --}}
        <div class="modal fade" id="quickAddFundModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-plus-circle me-2"></i>Nạp Quỹ Nhanh
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="quickAddFundForm" data-loading="true">
                        @csrf
                        <div class="modal-body">
                            <!-- Quick Amount Buttons -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chọn số tiền:</label>
                                <div class="quick-amounts-grid">
                                    <button type="button" class="quick-amount-btn" data-amount="100000">100k</button>
                                    <button type="button" class="quick-amount-btn" data-amount="200000">200k</button>
                                    <button type="button" class="quick-amount-btn" data-amount="500000">500k</button>
                                    <button type="button" class="quick-amount-btn" data-amount="1000000">1M</button>
                                    <button type="button" class="quick-amount-btn" data-amount="2000000">2M</button>
                                    <button type="button" class="quick-amount-btn" data-amount="5000000">5M</button>
                                </div>
                            </div>

                            <!-- Custom Amount -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control currency-input" id="quickAmount" name="amount"
                                           min="1000" max="100000000" placeholder="Nhập số tiền..." required>
                                    <label for="quickAmount">Hoặc nhập số tiền khác (VNĐ)</label>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="quickDescription" name="description"
                                           placeholder="Ghi chú..." maxlength="255">
                                    <label for="quickDescription">Ghi chú (tùy chọn)</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary" id="quickAddBtn">
                                <i class="bi bi-plus-circle me-1"></i>Nạp Quỹ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Settings Modal --}}
        <div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-gear me-2"></i>Cài đặt
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Theme Settings -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Giao diện</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="theme" id="themeAuto" value="auto" checked>
                                <label class="btn btn-outline-primary" for="themeAuto">Tự động</label>

                                <input type="radio" class="btn-check" name="theme" id="themeLight" value="light">
                                <label class="btn btn-outline-primary" for="themeLight">Sáng</label>

                                <input type="radio" class="btn-check" name="theme" id="themeDark" value="dark">
                                <label class="btn btn-outline-primary" for="themeDark">Tối</label>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="notificationsEnabled" checked>
                                <label class="form-check-label" for="notificationsEnabled">
                                    Bật thông báo
                                </label>
                            </div>
                        </div>

                        <!-- Auto-save Settings -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="autoSaveEnabled" checked>
                                <label class="form-check-label" for="autoSaveEnabled">
                                    Tự động lưu dữ liệu form
                                </label>
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key me-2"></i>Đổi mật khẩu
                            </button>
                        </div>

                        <!-- App Info -->
                        <div class="text-center text-muted">
                            <small>
                                Phiên bản 1.0.0<br>
                                © 2024 Family Expense Manager
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Change Password Modal --}}
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-key me-2"></i>Đổi mật khẩu
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="changePasswordForm" data-loading="true">
                        @csrf
                        <div class="modal-body">
                            <!-- Current Password -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                                    <label for="currentPassword">Mật khẩu hiện tại</label>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="newPassword" name="new_password"
                                           minlength="6" required>
                                    <label for="newPassword">Mật khẩu mới</label>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation"
                                           minlength="6" required>
                                    <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Đổi mật khẩu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Additional modals from pages --}}
        @stack('modals')
    </div>

    {{-- Loading Component --}}
    @include('layouts.components.loading', ['overlay' => true])

    {{-- Scripts --}}
    @include('layouts.partials.scripts')

    {{-- Additional Styles --}}
    <style>
        /* App Layout Styles */
        .main-container {
            min-height: 100vh;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: calc(env(safe-area-inset-bottom, 0px) + 80px); /* Space for bottom nav */
        }

        .content-wrapper {
            padding: 1rem 0 2rem;
        }

        .page-loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            visibility: visible;
            transition: all 0.3s ease;
        }

        .page-loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loading-spinner {
            text-align: center;
            color: #667eea;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(102, 126, 234, 0.3);
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            padding-bottom: calc(0.5rem + env(safe-area-inset-bottom, 0px));
            z-index: 1000;
            display: block;
        }

        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
            max-width: 500px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #6c757d;
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 12px;
            position: relative;
            min-width: 60px;
        }

        .bottom-nav-item:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .bottom-nav-item.active {
            color: #667eea;
            background: rgba(102, 126, 234, 0.15);
        }

        .bottom-nav-item.active::after {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 3px;
            background: #667eea;
            border-radius: 0 0 3px 3px;
        }

        .bottom-nav-item i {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .bottom-nav-item span {
            font-size: 0.7rem;
            font-weight: 500;
        }

        .bottom-nav-fab {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            color: white !important;
            border-radius: 50% !important;
            width: 50px !important;
            height: 50px !important;
            margin-top: -10px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .bottom-nav-fab:hover {
            color: white !important;
            transform: scale(1.05);
        }

        .bottom-nav-fab span {
            display: none;
        }

        .bottom-nav-fab i {
            font-size: 1.5rem;
            margin: 0;
        }

        /* Quick Actions */
        .quick-amounts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .quick-amount-btn {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            color: #495057;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .quick-amount-btn:hover,
        .quick-amount-btn.selected {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: #667eea;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Responsive Design */
        @media (min-width: 992px) {
            .bottom-nav {
                display: none;
            }

            .main-container {
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }

            .content-wrapper {
                margin-left: 280px; /* Sidebar width */
            }
        }

        @media (max-width: 991.98px) {
            .content-wrapper {
                margin-left: 0;
            }
        }

        @media (max-width: 576px) {
            .quick-amounts-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .bottom-nav-items {
                padding: 0 0.5rem;
            }

            .bottom-nav-item {
                min-width: 50px;
                padding: 0.25rem;
            }

            .bottom-nav-item span {
                font-size: 0.65rem;
            }
        }

        /* Dark Mode */
        @media (prefers-color-scheme: dark) {
            .page-loading-overlay {
                background: rgba(26, 26, 26, 0.95);
            }

            .bottom-nav {
                background: rgba(45, 45, 45, 0.95);
                border-top-color: rgba(255, 255, 255, 0.1);
            }

            .bottom-nav-item {
                color: #adb5bd;
            }

            .bottom-nav-item:hover,
            .bottom-nav-item.active {
                color: #667eea;
                background: rgba(102, 126, 234, 0.2);
            }

            .theme-toggle {
                background: rgba(45, 45, 45, 0.9);
                color: #667eea;
            }
        }

        /* PWA Standalone Mode */
        @media (display-mode: standalone) {
            .main-container {
                padding-top: calc(env(safe-area-inset-top, 0px) + 10px);
            }

            body {
                -webkit-user-select: none;
                -webkit-touch-callout: none;
                -webkit-tap-highlight-color: transparent;
            }

            input, textarea {
                -webkit-user-select: auto;
            }
        }

        /* Print Styles */
        @media print {
            .bottom-nav,
            .theme-toggle,
            .page-loading-overlay,
            .fab,
            [class*="modal"],
            .alert {
                display: none !important;
            }

            .main-container {
                padding: 0 !important;
            }

            .content-wrapper {
                margin: 0 !important;
            }
        }

        /* High Contrast Mode */
        @media (prefers-contrast: high) {
            .bottom-nav {
                border-top: 3px solid #000000;
            }

            .bottom-nav-item {
                border: 1px solid transparent;
            }

            .bottom-nav-item.active {
                border-color: #000000;
            }
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>

    {{-- Page Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading overlay after page load
            setTimeout(() => {
                const loadingOverlay = document.getElementById('pageLoadingOverlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('hidden');
                    setTimeout(() => {
                        loadingOverlay.style.display = 'none';
                    }, 300);
                }
            }, 500);

            // Initialize global modals
            initializeGlobalModals();

            // Initialize theme toggle
            initializeThemeToggle();

            // Initialize app features
            initializeAppFeatures();
        });

        function initializeGlobalModals() {
            // Quick Add Fund Form
            const quickAddForm = document.getElementById('quickAddFundForm');
            const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
            const quickAmountInput = document.getElementById('quickAmount');

            // Quick amount selection
            quickAmountBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    quickAmountBtns.forEach(b => b.classList.remove('selected'));
                    this.classList.add('selected');
                    quickAmountInput.value = this.dataset.amount;
                });
            });

            // Clear selection when typing custom amount
            quickAmountInput?.addEventListener('input', function() {
                quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
            });

            // Form submission
            if (quickAddForm) {
                quickAddForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const amount = parseInt(quickAmountInput.value);
                    if (!amount || amount < 1000) {
                        showToast('Số tiền tối thiểu là 1,000 VNĐ', 'warning');
                        return;
                    }

                    const formData = new FormData(this);

                    try {
                        const response = await axios.post('{{ route("funds.add") }}', formData);

                        if (response.data.success) {
                            // Update balance displays
                            updateAllBalanceDisplays(response.data.new_balance);

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('quickAddFundModal'));
                            modal.hide();

                            // Reset form
                            this.reset();
                            quickAmountBtns.forEach(btn => btn.classList.remove('selected'));

                            // Show success
                            showToast('Nạp quỹ thành công! ' + response.data.formatted_amount, 'success');
                        } else {
                            showToast(response.data.message || 'Có lỗi xảy ra', 'error');
                        }
                    } catch (error) {
                        console.error('Add fund error:', error);
                        showToast('Có lỗi kết nối. Vui lòng thử lại.', 'error');
                    }
                });
            }

            // Change Password Form
            const changePasswordForm = document.getElementById('changePasswordForm');
            if (changePasswordForm) {
                changePasswordForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const newPassword = document.getElementById('newPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;

                    if (newPassword !== confirmPassword) {
                        showToast('Mật khẩu xác nhận không khớp', 'warning');
                        return;
                    }

                    const formData = new FormData(this);

                    try {
                        const response = await axios.post('{{ route("change.password") }}', formData);

                        if (response.data.success) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                            modal.hide();

                            // Reset form
                            this.reset();

                            // Show success
                            showToast('Đổi mật khẩu thành công!', 'success');
                        } else {
                            showToast(response.data.message || 'Có lỗi xảy ra', 'error');
                        }
                    } catch (error) {
                        console.error('Change password error:', error);
                        if (error.response?.data?.message) {
                            showToast(error.response.data.message, 'error');
                        } else {
                            showToast('Có lỗi kết nối. Vui lòng thử lại.', 'error');
                        }
                    }
                });
            }
        }

        function initializeThemeToggle() {
            // Create theme toggle button
            const themeToggle = document.createElement('button');
            themeToggle.className = 'theme-toggle';
            themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i>';
            themeToggle.title = 'Chuyển đổi giao diện';
            document.body.appendChild(themeToggle);

            // Get saved theme or default to auto
            const savedTheme = localStorage.getItem('theme') || 'auto';
            applyTheme(savedTheme);

            // Theme toggle click handler
            themeToggle.addEventListener('click', function() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'auto';
                let newTheme;

                switch (currentTheme) {
                    case 'light':
                        newTheme = 'dark';
                        break;
                    case 'dark':
                        newTheme = 'auto';
                        break;
                    default:
                        newTheme = 'light';
                        break;
                }

                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });

            function applyTheme(theme) {
                document.documentElement.setAttribute('data-theme', theme);

                // Update toggle icon
                const icon = themeToggle.querySelector('i');
                switch (theme) {
                    case 'light':
                        icon.className = 'bi bi-sun-fill';
                        break;
                    case 'dark':
                        icon.className = 'bi bi-moon-fill';
                        break;
                    default:
                        icon.className = 'bi bi-circle-half';
                        break;
                }

                // Update settings modal radio buttons
                const radioButtons = document.querySelectorAll('input[name="theme"]');
                radioButtons.forEach(radio => {
                    radio.checked = radio.value === theme;
                });
            }

            // Listen for settings modal changes
            document.addEventListener('change', function(e) {
                if (e.target.name === 'theme') {
                    applyTheme(e.target.value);
                    localStorage.setItem('theme', e.target.value);
                }
            });
        }

        function initializeAppFeatures() {
            // Auto-hide bottom nav on scroll
            let lastScrollTop = 0;
            window.addEventListener('scroll', throttle(function() {
                const st = window.pageYOffset || document.documentElement.scrollTop;
                const bottomNav = document.getElementById('bottomNav');

                if (bottomNav && window.innerWidth <= 768) {
                    if (st > lastScrollTop && st > 100) {
                        // Scrolling down
                        bottomNav.style.transform = 'translateY(100%)';
                    } else {
                        // Scrolling up
                        bottomNav.style.transform = 'translateY(0)';
                    }
                }

                lastScrollTop = st <= 0 ? 0 : st;
            }, 100));

            // Swipe gestures for navigation
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            document.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeDistance = Math.abs(touchEndX - touchStartX);
                if (swipeDistance < 50) return; // Minimum swipe distance

                if (touchEndX < touchStartX - 50) {
                    // Swipe left - next page
                    // Implement navigation logic
                } else if (touchEndX > touchStartX + 50) {
                    // Swipe right - previous page
                    // Implement navigation logic
                }
            }
        }

        function updateAllBalanceDisplays(newBalance) {
            const formattedBalance = new Intl.NumberFormat('vi-VN').format(newBalance) + ' VNĐ';
            const balanceElements = document.querySelectorAll(
                '.current-balance, #currentBalance, #navBalance, #sidebarBalance, #dashboardBalance'
            );

            balanceElements.forEach(el => {
                if (el.id === 'dashboardBalance') {
                    el.textContent = new Intl.NumberFormat('vi-VN').format(newBalance);
                } else {
                    el.textContent = formattedBalance;
                }
            });

            // Dispatch custom event for other components
            window.dispatchEvent(new CustomEvent('balanceUpdated', {
                detail: { newBalance, formattedBalance }
            }));
        }

        // Global keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Shift + A for quick add fund
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'A') {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('quickAddFundModal'));
                modal.show();
            }

            // Ctrl/Cmd + Shift + S for settings
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'S') {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('settingsModal'));
                modal.show();
            }

            // Alt + 1-5 for navigation
            if (e.altKey && e.key >= '1' && e.key <= '5') {
                e.preventDefault();
                const navItems = document.querySelectorAll('.bottom-nav-item');
                const index = parseInt(e.key) - 1;
                if (navItems[index]) {
                    navItems[index].click();
                }
            }
        });

        // Auto-refresh balance periodically
        setInterval(async function() {
            try {
                const response = await axios.get('{{ route("funds.api.balance") }}');
                if (response.data.balance !== undefined) {
                    updateAllBalanceDisplays(response.data.balance);
                }
            } catch (error) {
                // Silent fail for background refresh
                console.debug('Background balance refresh failed:', error);
            }
        }, 120000); // Every 2 minutes

        // Install prompt for PWA
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show install banner after 5 seconds if not dismissed
            setTimeout(() => {
                if (!localStorage.getItem('pwa-install-dismissed')) {
                    const banner = document.getElementById('pwa-install-banner');
                    if (banner) {
                        banner.style.display = 'block';
                    }
                }
            }, 5000);
        });

        // PWA install handlers
        document.addEventListener('click', async function(e) {
            if (e.target.id === 'pwa-install-btn' || e.target.closest('#pwa-install-btn')) {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;

                    if (outcome === 'accepted') {
                        showToast('App đã được cài đặt thành công!', 'success');
                    }

                    deferredPrompt = null;
                    document.getElementById('pwa-install-banner').style.display = 'none';
                }
            }

            if (e.target.id === 'pwa-dismiss-btn' || e.target.closest('#pwa-dismiss-btn')) {
                document.getElementById('pwa-install-banner').style.display = 'none';
                localStorage.setItem('pwa-install-dismissed', 'true');
            }
        });

        // Handle app visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                // App became visible - refresh data
                setTimeout(() => {
                    if (typeof window.refreshPageData === 'function') {
                        window.refreshPageData();
                    }
                }, 1000);
            }
        });

        // Handle online/offline status
        window.addEventListener('online', function() {
            showToast('Đã kết nối lại internet!', 'success');

            // Retry failed requests if any
            if (typeof window.retryFailedRequests === 'function') {
                window.retryFailedRequests();
            }
        });

        window.addEventListener('offline', function() {
            showToast('Mất kết nối internet. Một số tính năng có thể bị hạn chế.', 'warning', 5000);
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Handle touch events for better mobile experience
        document.addEventListener('touchstart', function() {}, { passive: true });

        // Prevent zoom on double tap for iOS
        let lastTouchEnd = 0;
        document.addEventListener('touchend', function (event) {
            const now = (new Date()).getTime();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);

        // Custom context menu for app actions
        document.addEventListener('contextmenu', function(e) {
            if (e.target.closest('.context-menu-enabled')) {
                e.preventDefault();
                // Show custom context menu
                showCustomContextMenu(e.clientX, e.clientY, e.target);
            }
        });

        function showCustomContextMenu(x, y, target) {
            // Implementation for custom context menu
            // This would show app-specific actions
        }
    </script>

    {{-- Service Worker Registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');

                        // Check for updates
                        registration.addEventListener('updatefound', function() {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', function() {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    showToast(
                                        'Có bản cập nhật mới! Nhấn để tải lại.',
                                        'info',
                                        0
                                    );
                                }
                            });
                        });
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>

    {{-- Additional page-specific scripts --}}
    @stack('scripts')

    {{-- Development Tools (only in debug mode) --}}
    @if(config('app.debug'))
    <script>
        // Development helpers
        window.debugApp = {
            clearStorage: function() {
                localStorage.clear();
                sessionStorage.clear();
                showToast('Đã xóa toàn bộ dữ liệu lưu trữ', 'info');
            },
            showStorageInfo: function() {
                console.log('LocalStorage:', localStorage);
                console.log('SessionStorage:', sessionStorage);
            },
            toggleDebugMode: function() {
                document.body.classList.toggle('debug-mode');
            }
        };

        // Show debug info in console
        console.log('🎯 Family App Debug Mode');
        console.log('📱 App Version: 1.0.0');
        console.log('🔧 Available debug commands:', Object.keys(window.debugApp));

        // Add debug styles
        const debugCSS = `
            .debug-mode .card { outline: 2px dashed #ff6b6b; }
            .debug-mode .btn { outline: 1px dashed #4ecdc4; }
            .debug-mode .form-control { outline: 1px dashed #45b7d1; }
        `;
        const debugStyleSheet = document.createElement('style');
        debugStyleSheet.textContent = debugCSS;
        document.head.appendChild(debugStyleSheet);
    </script>
    @endif

</body>
</html>

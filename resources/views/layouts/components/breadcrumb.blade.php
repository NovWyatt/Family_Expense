{{-- Breadcrumb Navigation Component --}}
@if(!request()->routeIs('dashboard'))
<nav class="breadcrumb-nav" aria-label="Breadcrumb Navigation">
    <div class="breadcrumb-container">
        <!-- Back Button -->
        <button class="back-btn" onclick="goBack()" title="Quay lại">
            <i class="bi bi-arrow-left"></i>
        </button>

        <!-- Breadcrumb Items -->
        <ol class="breadcrumb-list">
            <!-- Home -->
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link home">
                    <i class="bi bi-house-fill"></i>
                    <span class="breadcrumb-text">Trang chủ</span>
                </a>
            </li>

            <!-- Dynamic Breadcrumb based on current route -->
            @if(request()->routeIs('funds.*'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                @if(request()->routeIs('funds.index'))
                <span class="breadcrumb-current">
                    <i class="bi bi-wallet"></i>
                    Quản lý Quỹ
                </span>
                @else
                <a href="{{ route('funds.index') }}" class="breadcrumb-link">
                    <i class="bi bi-wallet"></i>
                    <span class="breadcrumb-text">Quản lý Quỹ</span>
                </a>
                @endif
            </li>
            @if(request()->routeIs('funds.history'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">
                    <i class="bi bi-clock-history"></i>
                    Lịch sử
                </span>
            </li>
            @endif
            @endif

            @if(request()->routeIs('shopping.*'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                @if(request()->routeIs('shopping.index'))
                <span class="breadcrumb-current">
                    <i class="bi bi-cart"></i>
                    Đi Chợ
                </span>
                @else
                <a href="{{ route('shopping.index') }}" class="breadcrumb-link">
                    <i class="bi bi-cart"></i>
                    <span class="breadcrumb-text">Đi Chợ</span>
                </a>
                @endif
            </li>
            @if(request()->routeIs('shopping.create'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">
                    <i class="bi bi-plus-circle"></i>
                    Thêm mới
                </span>
            </li>
            @elseif(request()->routeIs('shopping.show'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">
                    <i class="bi bi-eye"></i>
                    Chi tiết
                </span>
            </li>
            @endif
            @endif

            @if(request()->routeIs('export.*'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">
                    <i class="bi bi-download"></i>
                    Xuất Excel
                </span>
            </li>
            @endif

            @if(request()->routeIs('settings.*'))
            <li class="breadcrumb-item">
                <i class="bi bi-chevron-right breadcrumb-separator"></i>
                <span class="breadcrumb-current">
                    <i class="bi bi-gear"></i>
                    Cài đặt
                </span>
            </li>
            @endif

            <!-- Custom breadcrumb from stack -->
            @stack('breadcrumb')
        </ol>

        <!-- Page Actions -->
        <div class="page-actions">
            @stack('page-actions')

            <!-- Default actions based on page -->
            @if(request()->routeIs('shopping.index'))
            <a href="{{ route('shopping.create') }}" class="page-action-btn primary" title="Thêm lần đi chợ mới">
                <i class="bi bi-plus"></i>
                <span>Thêm mới</span>
            </a>
            @elseif(request()->routeIs('funds.index'))
            <button class="page-action-btn primary" data-bs-toggle="modal" data-bs-target="#quickAddFundModal" title="Nạp quỹ nhanh">
                <i class="bi bi-plus"></i>
                <span>Nạp Quỹ</span>
            </button>
            @elseif(request()->routeIs('shopping.show'))
            <button class="page-action-btn danger" onclick="confirmDelete()" title="Xóa lần đi chợ này">
                <i class="bi bi-trash"></i>
                <span>Xóa</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Mobile Breadcrumb -->
    <div class="mobile-breadcrumb">
        <div class="mobile-breadcrumb-content">
            <button class="mobile-back-btn" onclick="goBack()">
                <i class="bi bi-arrow-left"></i>
            </button>
            <div class="mobile-page-title">
                @if(request()->routeIs('funds.index'))
                <i class="bi bi-wallet"></i>
                <span>Quản lý Quỹ</span>
                @elseif(request()->routeIs('funds.history'))
                <i class="bi bi-clock-history"></i>
                <span>Lịch sử Giao dịch</span>
                @elseif(request()->routeIs('shopping.index'))
                <i class="bi bi-cart"></i>
                <span>Danh sách Đi Chợ</span>
                @elseif(request()->routeIs('shopping.create'))
                <i class="bi bi-plus-circle"></i>
                <span>Thêm lần đi chợ</span>
                @elseif(request()->routeIs('shopping.show'))
                <i class="bi bi-eye"></i>
                <span>Chi tiết đi chợ</span>
                @elseif(request()->routeIs('export.*'))
                <i class="bi bi-download"></i>
                <span>Xuất Excel</span>
                @elseif(request()->routeIs('settings.*'))
                <i class="bi bi-gear"></i>
                <span>Cài đặt</span>
                @else
                <i class="bi bi-file-text"></i>
                <span>{{ $pageTitle ?? 'Trang' }}</span>
                @endif
            </div>
            <div class="mobile-page-actions">
                @stack('mobile-page-actions')

                @if(request()->routeIs('shopping.index'))
                <a href="{{ route('shopping.create') }}" class="mobile-action-btn">
                    <i class="bi bi-plus"></i>
                </a>
                @elseif(request()->routeIs('funds.index'))
                <button class="mobile-action-btn" data-bs-toggle="modal" data-bs-target="#quickAddFundModal">
                    <i class="bi bi-plus"></i>
                </button>
                @endif
            </div>
        </div>
    </div>
</nav>
@endif

<style>
    /* Desktop Breadcrumb */
    .breadcrumb-nav {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        border: 1px solid #f0f0f0;
        overflow: hidden;
    }

    .breadcrumb-container {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        gap: 1rem;
    }

    /* Back Button */
    .back-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #495057;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        flex-shrink: 0;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        transform: translateX(-2px);
    }

    /* Breadcrumb List */
    .breadcrumb-list {
        display: flex;
        align-items: center;
        flex: 1;
        margin: 0;
        padding: 0;
        list-style: none;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .breadcrumb-list::-webkit-scrollbar {
        display: none;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .breadcrumb-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #6c757d;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .breadcrumb-link:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        transform: translateY(-1px);
    }

    .breadcrumb-link.home {
        color: #667eea;
    }

    .breadcrumb-link i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .breadcrumb-text {
        font-size: 0.9rem;
    }

    .breadcrumb-separator {
        margin: 0 0.5rem;
        color: #dee2e6;
        font-size: 0.8rem;
    }

    .breadcrumb-current {
        display: flex;
        align-items: center;
        color: #495057;
        font-weight: 600;
        padding: 0.5rem 0.75rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .breadcrumb-current i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    /* Page Actions */
    .page-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .page-action-btn {
        display: flex;
        align-items: center;
        padding: 0.6rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        white-space: nowrap;
    }

    .page-action-btn i {
        margin-right: 0.4rem;
        font-size: 0.9rem;
    }

    .page-action-btn.primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .page-action-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .page-action-btn.danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .page-action-btn.danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .page-action-btn.secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .page-action-btn.secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        color: white;
    }

    /* Mobile Breadcrumb */
    .mobile-breadcrumb {
        display: none;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        border: 1px solid #f0f0f0;
    }

    .mobile-breadcrumb-content {
        display: flex;
        align-items: center;
        padding: 1rem;
        gap: 1rem;
    }

    .mobile-back-btn {
        width: 35px;
        height: 35px;
        border: none;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #495057;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        flex-shrink: 0;
    }

    .mobile-back-btn:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .mobile-page-title {
        display: flex;
        align-items: center;
        flex: 1;
        font-weight: 600;
        color: #495057;
        font-size: 1rem;
    }

    .mobile-page-title i {
        margin-right: 0.75rem;
        color: #667eea;
        font-size: 1.1rem;
    }

    .mobile-page-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .mobile-action-btn {
        width: 35px;
        height: 35px;
        border: none;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .mobile-action-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .breadcrumb-nav {
            margin-bottom: 1rem;
        }

        .breadcrumb-container {
            padding: 0.75rem 1rem;
            gap: 0.75rem;
        }

        .back-btn {
            width: 35px;
            height: 35px;
        }

        .breadcrumb-text {
            display: none;
        }

        .breadcrumb-link,
        .breadcrumb-current {
            padding: 0.4rem 0.6rem;
        }

        .page-action-btn span {
            display: none;
        }

        .page-action-btn {
            padding: 0.6rem;
            width: 35px;
            height: 35px;
            justify-content: center;
        }

        .page-action-btn i {
            margin: 0;
        }
    }

    @media (max-width: 576px) {
        .breadcrumb-nav {
            display: none;
        }

        .mobile-breadcrumb {
            display: block;
        }
    }

    /* Animation Effects */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .breadcrumb-nav {
        animation: slideDown 0.3s ease-out;
    }

    .mobile-breadcrumb {
        animation: slideDown 0.3s ease-out;
    }

    /* Hover effects for breadcrumb items */
    .breadcrumb-item {
        position: relative;
    }

    .breadcrumb-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #667eea;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .breadcrumb-link:hover::before {
        width: 80%;
    }

    /* Loading state for action buttons */
    .page-action-btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .page-action-btn.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    /* Focus states for accessibility */
    .back-btn:focus,
    .breadcrumb-link:focus,
    .page-action-btn:focus,
    .mobile-back-btn:focus,
    .mobile-action-btn:focus {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {

        .breadcrumb-nav,
        .mobile-breadcrumb {
            background: #2d2d2d;
            border-color: #404040;
        }

        .back-btn,
        .mobile-back-btn {
            background: linear-gradient(135deg, #404040, #2d2d2d);
            color: #cccccc;
        }

        .breadcrumb-link {
            color: #cccccc;
        }

        .breadcrumb-current {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
        }

        .mobile-page-title {
            color: #ffffff;
        }

        .breadcrumb-separator {
            color: #666666;
        }
    }

    /* Print styles */
    @media print {

        .breadcrumb-nav,
        .mobile-breadcrumb {
            display: none !important;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {

        .breadcrumb-nav,
        .mobile-breadcrumb {
            border: 2px solid #000000;
        }

        .breadcrumb-link,
        .breadcrumb-current {
            border: 1px solid #000000;
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {

        .breadcrumb-nav,
        .mobile-breadcrumb,
        .breadcrumb-link,
        .page-action-btn,
        .back-btn,
        .mobile-back-btn,
        .mobile-action-btn {
            transition: none;
            animation: none;
        }

        .breadcrumb-link:hover,
        .page-action-btn:hover,
        .back-btn:hover {
            transform: none;
        }
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle back button functionality
        window.goBack = function() {
            // Check if there's a previous page in history
            if (window.history.length > 1 && document.referrer.includes(window.location.hostname)) {
                window.history.back();
            } else {
                // Fallback to appropriate parent page
                const currentRoute = window.location.pathname;

                if (currentRoute.includes('/funds/history')) {
                    window.location.href = '{{ route("funds.index") }}';
                } else if (currentRoute.includes('/funds')) {
                    window.location.href = '{{ route("dashboard") }}';
                } else if (currentRoute.includes('/shopping/create') || currentRoute.includes('/shopping/show')) {
                    window.location.href = '{{ route("shopping.index") }}';
                } else if (currentRoute.includes('/shopping')) {
                    window.location.href = '{{ route("dashboard") }}';
                } else if (currentRoute.includes('/export') || currentRoute.includes('/settings')) {
                    window.location.href = '{{ route("dashboard") }}';
                } else {
                    window.location.href = '{{ route("dashboard") }}';
                }
            }
        };

        // Handle delete confirmation for shopping trips
        window.confirmDelete = function() {
            if (confirm('Bạn có chắc muốn xóa lần đi chợ này?\n\nTiền sẽ được hoàn lại vào quỹ.')) {
                const tripId = window.location.pathname.split('/').pop();
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/shopping/${tripId}`;
                form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                document.body.appendChild(form);
                form.submit();
            }
        };

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Alt + Left Arrow or Backspace for back navigation
            if ((e.altKey && e.key === 'ArrowLeft') || (e.key === 'Backspace' && !isInputFocused())) {
                e.preventDefault();
                goBack();
            }

            // Ctrl/Cmd + N for new actions
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                const createBtn = document.querySelector('.page-action-btn.primary, .mobile-action-btn');
                if (createBtn) {
                    createBtn.click();
                }
            }
        });

        // Helper function to check if an input is focused
        function isInputFocused() {
            const activeElement = document.activeElement;
            return activeElement && (
                activeElement.tagName === 'INPUT' ||
                activeElement.tagName === 'TEXTAREA' ||
                activeElement.isContentEditable
            );
        }

        // Smooth scroll for breadcrumb navigation on mobile
        const breadcrumbList = document.querySelector('.breadcrumb-list');
        if (breadcrumbList) {
            const currentItem = breadcrumbList.querySelector('.breadcrumb-current');
            if (currentItem) {
                currentItem.scrollIntoView({
                    behavior: 'smooth'
                    , inline: 'center'
                });
            }
        }

        // Handle loading states for action buttons
        document.querySelectorAll('.page-action-btn, .mobile-action-btn').forEach(btn => {
            if (btn.tagName === 'A') {
                btn.addEventListener('click', function() {
                    this.classList.add('loading');
                });
            }
        });

        // Add ripple effect for buttons
        function addRippleEffect(button) {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
                z-index: 1;
            `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        }

        // Apply ripple effect to all buttons
        document.querySelectorAll('.back-btn, .page-action-btn, .mobile-back-btn, .mobile-action-btn').forEach(addRippleEffect);

        // Auto-hide breadcrumb on scroll (mobile)
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            if (window.innerWidth <= 576) {
                const st = window.pageYOffset || document.documentElement.scrollTop;
                const breadcrumb = document.querySelector('.mobile-breadcrumb');

                if (breadcrumb) {
                    if (st > lastScrollTop && st > 100) {
                        // Scrolling down
                        breadcrumb.style.transform = 'translateY(-100%)';
                    } else {
                        // Scrolling up
                        breadcrumb.style.transform = 'translateY(0)';
                    }
                }

                lastScrollTop = st <= 0 ? 0 : st;
            }
        });
    });

    // Add CSS for ripple animation
    const rippleStyle = document.createElement('style');
    rippleStyle.textContent = `
    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
`;
    document.head.appendChild(rippleStyle);

</script>

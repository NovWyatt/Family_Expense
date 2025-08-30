{{-- Navigation Bar Component --}}
<nav class="main-navbar" id="mainNavbar">
    <div class="navbar-container">
        <!-- Logo/Brand Section -->
        <div class="navbar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <div class="brand-icon">
                    <i class="bi bi-basket2-fill"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-title">Quỹ Đi Chợ</span>
                    <span class="brand-subtitle">Family App</span>
                </div>
            </a>
        </div>

        <!-- Balance Display -->
        <div class="navbar-balance">
            <div class="balance-info">
                <span class="balance-amount" id="navBalance">
                    {{ number_format($currentBalance ?? \App\Models\AppSetting::getCurrentFundBalance()) }} VNĐ
                </span>
                <span class="balance-label">Quỹ hiện tại</span>
            </div>
            <div class="balance-icon">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="navbar-actions">
            <button class="action-btn" data-bs-toggle="modal" data-bs-target="#quickAddFundModal" title="Nạp quỹ nhanh">
                <i class="bi bi-plus-circle"></i>
            </button>
            <button class="action-btn" onclick="refreshData()" title="Refresh dữ liệu" id="refreshBtn">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
            <div class="dropdown">
                <button class="action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" title="Menu">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('settings.index') }}">
                            <i class="bi bi-gear me-2"></i>Cài đặt
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('export.index') }}">
                            <i class="bi bi-download me-2"></i>Xuất Excel
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile Sub Navigation -->
    <div class="mobile-nav">
        <div class="nav-items">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i>
                <span>Trang chủ</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('funds.index') }}" class="nav-item {{ request()->routeIs('funds.*') ? 'active' : '' }}">
                <i class="bi bi-wallet-fill"></i>
                <span>Quỹ</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('shopping.index') }}" class="nav-item {{ request()->routeIs('shopping.*') ? 'active' : '' }}">
                <i class="bi bi-cart-fill"></i>
                <span>Đi chợ</span>
                <div class="nav-indicator"></div>
            </a>
            <a href="{{ route('export.index') }}" class="nav-item {{ request()->routeIs('export.*') ? 'active' : '' }}">
                <i class="bi bi-download"></i>
                <span>Excel</span>
                <div class="nav-indicator"></div>
            </a>
        </div>
    </div>
</nav>

<!-- Quick Add Fund Modal -->
<div class="modal fade" id="quickAddFundModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nạp Quỹ Nhanh
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickAddFundForm">
                @csrf
                <div class="modal-body">
                    <!-- Quick Amount Buttons -->
                    <div class="mb-3">
                        <label class="form-label">Chọn số tiền:</label>
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
                            <input type="number" class="form-control" id="quickAmount" name="amount" min="1000" max="100000000" placeholder="Nhập số tiền..." required>
                            <label for="quickAmount">Hoặc nhập số tiền khác (VNĐ)</label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="quickDescription" name="description" placeholder="Ghi chú..." maxlength="255">
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

<style>
    .main-navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 20px rgba(102, 126, 234, 0.3);
        position: sticky;
        top: 0;
        z-index: 1030;
        border-radius: 0 0 20px 20px;
    }

    .navbar-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Brand Section */
    .brand-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease;
    }

    .brand-link:hover {
        color: rgba(255, 255, 255, 0.9);
        transform: scale(1.02);
    }

    .brand-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .brand-text {
        display: flex;
        flex-direction: column;
    }

    .brand-title {
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .brand-subtitle {
        font-size: 0.75rem;
        opacity: 0.8;
        line-height: 1;
    }

    /* Balance Display */
    .navbar-balance {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border-radius: 15px;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .balance-info {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-right: 0.75rem;
    }

    .balance-amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        line-height: 1.2;
    }

    .balance-label {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1;
    }

    .balance-icon {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.3rem;
    }

    /* Actions */
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        font-size: 1.1rem;
        cursor: pointer;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.05);
        color: white;
    }

    .action-btn:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
    }

    .action-btn.loading {
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

    /* Mobile Navigation */
    .mobile-nav {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
    }

    .nav-items {
        display: flex;
        justify-content: space-around;
        max-width: 1200px;
        margin: 0 auto;
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        padding: 0.5rem;
        border-radius: 12px;
        position: relative;
        min-width: 60px;
    }

    .nav-item:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .nav-item.active {
        color: white;
        background: rgba(255, 255, 255, 0.15);
    }

    .nav-item i {
        font-size: 1.3rem;
        margin-bottom: 0.25rem;
    }

    .nav-item span {
        font-size: 0.7rem;
        font-weight: 500;
        text-align: center;
    }

    .nav-indicator {
        position: absolute;
        bottom: -0.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background: white;
        border-radius: 3px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-item.active .nav-indicator {
        opacity: 1;
    }

    /* Dropdown Styles */
    .dropdown-menu {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0.25rem;
    }

    .dropdown-item:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .dropdown-item.text-danger:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    /* Quick Add Modal Styles */
    .quick-amounts-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
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
    }

    .quick-amount-btn:hover,
    .quick-amount-btn.selected {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .navbar-container {
            padding: 0.75rem 1rem;
        }

        .brand-title {
            font-size: 1rem;
        }

        .brand-subtitle {
            display: none;
        }

        .balance-amount {
            font-size: 0.9rem;
        }

        .balance-label {
            font-size: 0.65rem;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .navbar-container {
            padding: 0.5rem 0.75rem;
        }

        .brand-icon {
            width: 35px;
            height: 35px;
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        .navbar-balance {
            padding: 0.5rem 0.75rem;
        }

        .quick-amounts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* PWA Standalone mode adjustments */
    @media (display-mode: standalone) {
        .main-navbar {
            padding-top: env(safe-area-inset-top, 0px);
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .dropdown-menu {
            background: rgba(45, 45, 45, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .dropdown-item {
            color: #ffffff;
        }

        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.2);
            color: #ffffff;
        }
    }

    /* Animation for refresh button */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .action-btn.refreshing {
        animation: spin 1s linear infinite;
    }

    /* Notification dot for updates */
    .notification-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background: #dc3545;
        border-radius: 50%;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick add fund form
        const quickAddForm = document.getElementById('quickAddFundForm');
        const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
        const quickAmountInput = document.getElementById('quickAmount');
        const quickAddBtn = document.getElementById('quickAddBtn');
        const navBalance = document.getElementById('navBalance');

        // Quick amount selection
        quickAmountBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                quickAmountBtns.forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                quickAmountInput.value = this.dataset.amount;
            });
        });

        // Clear selection when typing custom amount
        quickAmountInput.addEventListener('input', function() {
            quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
        });

        // Quick add form submission
        if (quickAddForm) {
            quickAddForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const amount = parseInt(quickAmountInput.value);
                if (!amount || amount < 1000) {
                    showToast('Số tiền tối thiểu là 1,000 VNĐ', 'warning');
                    return;
                }

                const originalText = quickAddBtn.innerHTML;
                showLoading(quickAddBtn);

                const formData = new FormData(this);

                try {
                    const response = await fetch('{{ route("funds.add") }}', {
                        method: 'POST'
                        , body: formData
                        , headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Update balance displays
                        navBalance.textContent = result.new_balance.toLocaleString('vi-VN') + ' VNĐ';
                        if (window.updateBalance) window.updateBalance();

                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('quickAddFundModal')).hide();

                        // Reset form
                        this.reset();
                        quickAmountBtns.forEach(btn => btn.classList.remove('selected'));

                        // Show success
                        showToast('Nạp quỹ thành công! ' + result.formatted_amount, 'success');

                        // Trigger custom event for other components
                        window.dispatchEvent(new CustomEvent('balanceUpdated', {
                            detail: {
                                newBalance: result.new_balance
                            }
                        }));
                    } else {
                        showToast(result.message || 'Có lỗi xảy ra', 'danger');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Có lỗi kết nối. Vui lòng thử lại.', 'danger');
                } finally {
                    hideLoading(quickAddBtn, originalText);
                }
            });
        }

        // Auto-update balance every 2 minutes
        setInterval(async () => {
            try {
                const response = await fetch('{{ route("funds.api.balance") }}');
                const data = await response.json();
                if (data.formatted_balance) {
                    navBalance.textContent = data.formatted_balance;
                }
            } catch (error) {
                console.log('Balance refresh error:', error);
            }
        }, 120000);
    });

    // Global refresh function
    function refreshData() {
        const refreshBtn = document.getElementById('refreshBtn');
        refreshBtn.classList.add('refreshing');

        // Update balance
        fetch('{{ route("funds.api.balance") }}')
            .then(response => response.json())
            .then(data => {
                if (data.formatted_balance) {
                    document.getElementById('navBalance').textContent = data.formatted_balance;
                    if (window.updateBalance) window.updateBalance();
                }
                showToast('Dữ liệu đã được cập nhật', 'success');
            })
            .catch(error => {
                console.error('Refresh error:', error);
                showToast('Có lỗi khi cập nhật dữ liệu', 'warning');
            })
            .finally(() => {
                setTimeout(() => {
                    refreshBtn.classList.remove('refreshing');
                }, 1000);
            });
    }

</script>

{{-- Sidebar Menu Component --}}
<aside class="main-sidebar" id="mainSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-basket2-fill"></i>
            </div>
            <div class="brand-text">
                <h6 class="brand-title">Quỹ Đi Chợ</h6>
                <small class="brand-subtitle">Family Manager</small>
            </div>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()" title="Thu gọn menu">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Balance Summary -->
    <div class="sidebar-balance">
        <div class="balance-card">
            <div class="balance-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="balance-info">
                <div class="balance-amount" id="sidebarBalance">
                    {{ number_format($currentBalance ?? \App\Models\AppSetting::getCurrentFundBalance()) }}
                </div>
                <div class="balance-label">VNĐ</div>
            </div>
        </div>
        <div class="balance-actions">
            <button class="balance-action-btn" data-bs-toggle="modal" data-bs-target="#sidebarAddFundModal" title="Nạp quỹ">
                <i class="bi bi-plus"></i>
            </button>
            <button class="balance-action-btn" onclick="refreshSidebarData()" title="Cập nhật" id="sidebarRefreshBtn">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">
                <i class="bi bi-house"></i>
                <span>Tổng quan</span>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
                <div class="nav-badge" id="dashboardBadge"></div>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">
                <i class="bi bi-wallet"></i>
                <span>Quản lý Quỹ</span>
            </div>
            <a href="{{ route('funds.index') }}" class="nav-link {{ request()->routeIs('funds.index') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i>
                <span>Tổng quan Quỹ</span>
            </a>
            <a href="{{ route('funds.history') }}" class="nav-link {{ request()->routeIs('funds.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Lịch sử Giao dịch</span>
                <div class="nav-badge" id="fundHistoryBadge">{{ $recentTransactionsCount ?? 0 }}</div>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">
                <i class="bi bi-cart"></i>
                <span>Đi Chợ</span>
            </div>
            <a href="{{ route('shopping.index') }}" class="nav-link {{ request()->routeIs('shopping.index') ? 'active' : '' }}">
                <i class="bi bi-basket"></i>
                <span>Danh sách</span>
                <div class="nav-badge" id="shoppingBadge">{{ $monthlyTripsCount ?? 0 }}</div>
            </a>
            <a href="{{ route('shopping.create') }}" class="nav-link {{ request()->routeIs('shopping.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span>Thêm lần đi chợ</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">
                <i class="bi bi-graph-up"></i>
                <span>Báo cáo</span>
            </div>
            <a href="{{ route('export.index') }}" class="nav-link {{ request()->routeIs('export.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>Xuất Excel</span>
            </a>
        </div>
    </nav>

    <!-- Monthly Stats Summary -->
    <div class="sidebar-stats">
        <div class="stats-title">
            <i class="bi bi-calendar-month"></i>
            <span>Tháng {{ now()->format('m/Y') }}</span>
        </div>
        <div class="stats-items">
            <div class="stats-item positive">
                <i class="bi bi-arrow-down"></i>
                <div class="stats-content">
                    <span class="stats-label">Nạp</span>
                    <span class="stats-value" id="monthlyAdded">{{ number_format($monthlyStats['total_added'] ?? 0) }}</span>
                </div>
            </div>
            <div class="stats-item negative">
                <i class="bi bi-arrow-up"></i>
                <div class="stats-content">
                    <span class="stats-label">Chi</span>
                    <span class="stats-value" id="monthlySpent">{{ number_format($monthlyStats['total_spent'] ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="user-details">
                <div class="user-name">
                    {{ implode(' & ', $userNames ?? ['Gia đình']) }}
                </div>
                <div class="user-status">
                    <i class="bi bi-circle-fill online"></i>
                    Đang online
                </div>
            </div>
        </div>
        <div class="sidebar-actions">
            <a href="{{ route('settings.index') }}" class="sidebar-action" title="Cài đặt">
                <i class="bi bi-gear"></i>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="sidebar-action" title="Đăng xuất" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" onclick="closeSidebar()"></div>
</aside>

<!-- Sidebar Add Fund Modal -->
<div class="modal fade" id="sidebarAddFundModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nạp Quỹ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="sidebarAddFundForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="sidebarAmount" name="amount" min="1000" max="100000000" placeholder="Nhập số tiền..." required>
                            <label for="sidebarAmount">Số tiền (VNĐ)</label>
                        </div>
                    </div>
                    <div class="quick-amounts-mini">
                        <button type="button" class="quick-mini-btn" data-amount="100000">100k</button>
                        <button type="button" class="quick-mini-btn" data-amount="500000">500k</button>
                        <button type="button" class="quick-mini-btn" data-amount="1000000">1M</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="sidebarAddBtn">
                        <i class="bi bi-plus-circle me-1"></i>Nạp Quỹ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Sidebar Main Styles */
    .main-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 280px;
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        border-right: 1px solid #e9ecef;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.08);
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1040;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .main-sidebar.open {
        transform: translateX(0);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 1.5rem 1rem 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 1.3rem;
        backdrop-filter: blur(10px);
    }

    .brand-text {
        display: flex;
        flex-direction: column;
    }

    .brand-title {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        line-height: 1.2;
    }

    .brand-subtitle {
        opacity: 0.8;
        font-size: 0.75rem;
        line-height: 1;
    }

    .sidebar-toggle {
        width: 35px;
        height: 35px;
        border: none;
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        font-size: 1.1rem;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.05);
    }

    /* Balance Section */
    .sidebar-balance {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .balance-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        border-left: 4px solid #667eea;
    }

    .balance-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.3rem;
    }

    .balance-info {
        flex: 1;
    }

    .balance-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.2;
    }

    .balance-label {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
    }

    .balance-actions {
        display: flex;
        gap: 0.5rem;
    }

    .balance-action-btn {
        width: 35px;
        height: 35px;
        border: 2px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .balance-action-btn:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .balance-action-btn.loading {
        animation: spin 1s linear infinite;
    }

    /* Navigation Styles */
    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem 0;
    }

    .nav-section {
        margin-bottom: 1rem;
        padding: 0 1rem;
    }

    .nav-section-title {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
    }

    .nav-section-title i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        text-decoration: none;
        color: #495057;
        border-radius: 10px;
        margin-bottom: 0.25rem;
        transition: all 0.3s ease;
        position: relative;
        font-weight: 500;
    }

    .nav-link:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        transform: translateX(5px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
    }

    .nav-link.active:hover {
        transform: translateX(0);
    }

    .nav-link i {
        width: 20px;
        margin-right: 0.75rem;
        font-size: 1.1rem;
    }

    .nav-badge {
        background: #dc3545;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.4rem;
        border-radius: 10px;
        margin-left: auto;
        min-width: 18px;
        text-align: center;
    }

    .nav-link.active .nav-badge {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Stats Section */
    .sidebar-stats {
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        background: rgba(102, 126, 234, 0.05);
    }

    .stats-title {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
    }

    .stats-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .stats-items {
        display: flex;
        gap: 0.75rem;
    }

    .stats-item {
        flex: 1;
        background: white;
        border-radius: 10px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        border-left: 3px solid #28a745;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
    }

    .stats-item.negative {
        border-left-color: #dc3545;
    }

    .stats-item i {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .stats-item.positive i {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .stats-item.negative i {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .stats-content {
        display: flex;
        flex-direction: column;
    }

    .stats-label {
        font-size: 0.7rem;
        color: #6c757d;
        line-height: 1;
    }

    .stats-value {
        font-size: 0.8rem;
        font-weight: 600;
        color: #2c3e50;
        line-height: 1.2;
    }

    /* Footer */
    .sidebar-footer {
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .user-info {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #2c3e50;
        line-height: 1.2;
    }

    .user-status {
        font-size: 0.7rem;
        color: #6c757d;
        display: flex;
        align-items: center;
    }

    .user-status .online {
        width: 6px;
        height: 6px;
        color: #28a745;
        margin-right: 0.25rem;
    }

    .sidebar-actions {
        display: flex;
        gap: 0.25rem;
    }

    .sidebar-action {
        width: 30px;
        height: 30px;
        border: none;
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .sidebar-action:hover {
        background: #667eea;
        color: white;
        transform: scale(1.1);
    }

    /* Sidebar Overlay */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1035;
    }

    .main-sidebar.open+.sidebar-overlay {
        opacity: 1;
        visibility: visible;
    }

    /* Quick Mini Amounts */
    .quick-amounts-mini {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .quick-mini-btn {
        flex: 1;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 0.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .quick-mini-btn:hover,
    .quick-mini-btn.selected {
        background: #667eea;
        border-color: #667eea;
        color: white;
    }

    /* Responsive Design */
    @media (min-width: 992px) {
        .main-sidebar {
            position: relative;
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
        }

        .main-content {
            margin-left: 280px;
        }
    }

    @media (max-width: 991.98px) {
        .main-sidebar {
            width: 260px;
        }
    }

    @media (max-width: 576px) {
        .main-sidebar {
            width: 100%;
        }

        .sidebar-header {
            padding: 1rem;
        }

        .stats-items {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .main-sidebar {
            background: linear-gradient(180deg, #2d2d2d 0%, #1a1a1a 100%);
            border-right-color: #404040;
        }

        .balance-card {
            background: linear-gradient(135deg, #404040, #2d2d2d);
        }

        .balance-amount {
            color: #ffffff;
        }

        .nav-link {
            color: #cccccc;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.2);
            color: #667eea;
        }

        .stats-item {
            background: #404040;
        }

        .stats-value {
            color: #ffffff;
        }

        .user-name {
            color: #ffffff;
        }

        .sidebar-footer {
            background: linear-gradient(135deg, #2d2d2d, #404040);
            border-top-color: #404040;
        }
    }

    /* Animations */
    @keyframes slideIn {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .nav-link {
        animation: slideIn 0.3s ease-out forwards;
    }

    .nav-section:nth-child(1) .nav-link {
        animation-delay: 0.1s;
    }

    .nav-section:nth-child(2) .nav-link {
        animation-delay: 0.2s;
    }

    .nav-section:nth-child(3) .nav-link {
        animation-delay: 0.3s;
    }

    .nav-section:nth-child(4) .nav-link {
        animation-delay: 0.4s;
    }

    /* Scrollbar Styling */
    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(102, 126, 234, 0.3);
        border-radius: 2px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 126, 234, 0.5);
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('mainSidebar');
        const sidebarForm = document.getElementById('sidebarAddFundForm');
        const sidebarAmountInput = document.getElementById('sidebarAmount');
        const sidebarAddBtn = document.getElementById('sidebarAddBtn');
        const sidebarBalance = document.getElementById('sidebarBalance');
        const quickMiniBtns = document.querySelectorAll('.quick-mini-btn');

        // Quick mini amount selection
        quickMiniBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                quickMiniBtns.forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');
                sidebarAmountInput.value = this.dataset.amount;
            });
        });

        // Clear selection when typing
        sidebarAmountInput.addEventListener('input', function() {
            quickMiniBtns.forEach(btn => btn.classList.remove('selected'));
        });

        // Sidebar add fund form
        if (sidebarForm) {
            sidebarForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const amount = parseInt(sidebarAmountInput.value);
                if (!amount || amount < 1000) {
                    showToast('Số tiền tối thiểu là 1,000 VNĐ', 'warning');
                    return;
                }

                const originalText = sidebarAddBtn.innerHTML;
                showLoading(sidebarAddBtn);

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
                        // Update balance
                        sidebarBalance.textContent = result.new_balance.toLocaleString('vi-VN');
                        if (window.updateBalance) window.updateBalance();

                        // Close modal
                        bootstrap.Modal.getInstance(document.getElementById('sidebarAddFundModal')).hide();

                        // Reset form
                        this.reset();
                        quickMiniBtns.forEach(btn => btn.classList.remove('selected'));

                        // Show success
                        showToast('Nạp quỹ thành công! ' + result.formatted_amount, 'success');

                        // Trigger balance update event
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
                    hideLoading(sidebarAddBtn, originalText);
                }
            });
        }

        // Auto-update sidebar data
        setInterval(async () => {
            try {
                const response = await fetch('{{ route("funds.api.balance") }}');
                const data = await response.json();
                if (data.balance) {
                    sidebarBalance.textContent = data.balance.toLocaleString('vi-VN');
                }
            } catch (error) {
                console.log('Sidebar refresh error:', error);
            }
        }, 180000); // Every 3 minutes

        // Handle responsive behavior
        function handleResize() {
            if (window.innerWidth >= 992) {
                sidebar.classList.add('open');
            } else {
                sidebar.classList.remove('open');
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call

        // Listen for balance updates from other components
        window.addEventListener('balanceUpdated', function(e) {
            sidebarBalance.textContent = e.detail.newBalance.toLocaleString('vi-VN');
        });
    });

    // Toggle sidebar function
    function toggleSidebar() {
        const sidebar = document.getElementById('mainSidebar');
        sidebar.classList.toggle('open');
    }

    // Close sidebar function
    function closeSidebar() {
        const sidebar = document.getElementById('mainSidebar');
        sidebar.classList.remove('open');
    }

    // Refresh sidebar data
    function refreshSidebarData() {
        const refreshBtn = document.getElementById('sidebarRefreshBtn');
        const sidebarBalance = document.getElementById('sidebarBalance');

        refreshBtn.classList.add('loading');

        fetch('{{ route("funds.api.balance") }}')
            .then(response => response.json())
            .then(data => {
                if (data.balance) {
                    sidebarBalance.textContent = data.balance.toLocaleString('vi-VN');
                    showToast('Dữ liệu sidebar đã được cập nhật', 'success');
                }
            })
            .catch(error => {
                console.error('Refresh error:', error);
                showToast('Có lỗi khi cập nhật dữ liệu', 'warning');
            })
            .finally(() => {
                setTimeout(() => {
                    refreshBtn.classList.remove('loading');
                }, 1000);
            });
    }

    // Auto-hide sidebar on mobile when clicking nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                setTimeout(() => closeSidebar(), 300);
            }
        });
    });

</script>

@extends('layouts.app')

@section('title', 'Trang chủ')

@push('styles')

<style>
    .dashboard-container {
        padding: 0;
        max-width: 100%;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 1.5rem;
        margin: -1rem -1rem 2rem -1rem;
        border-radius: 0 0 20px 20px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .dashboard-header .header-content {
        position: relative;
        z-index: 2;
    }

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .welcome-section p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .stat-card .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        display: block;
    }

    .stat-card .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        border: 1px solid #f0f2f5;
    }

    .quick-actions h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .quick-actions h3 i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .action-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .action-card:hover {
        text-decoration: none;
        color: inherit;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .action-card:hover::before {
        left: 100%;
    }

    .action-card .action-icon {
        font-size: 2rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .action-card h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .action-card p {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0;
        line-height: 1.4;
    }

    /* Recent Activities */
    .recent-activities {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        border: 1px solid #f0f2f5;
    }

    .recent-activities h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .recent-activities h3 .title-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .recent-activities h3 i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .view-all-link {
        font-size: 0.9rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f3f5;
        gap: 1rem;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .activity-icon.income {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .activity-icon.expense {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .activity-icon.shopping {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        font-size: 0.95rem;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .activity-details {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .activity-amount {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .activity-amount.positive {
        color: #28a745;
    }

    .activity-amount.negative {
        color: #dc3545;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #adb5bd;
        margin-top: 0.25rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h4 {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.5rem 1rem;
            margin: -1rem -1rem 1.5rem -1rem;
        }

        .welcome-section h1 {
            font-size: 2rem;
        }

        .header-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
        }

        .actions-grid {
            grid-template-columns: 1fr;
        }

        .activity-item {
            padding: 0.75rem 0;
        }
    }

    @media (max-width: 576px) {
        .header-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            padding: 1rem;
        }

        .welcome-section h1 {
            font-size: 1.75rem;
        }
    }

    /* Dark theme support */
    [data-theme="dark"] .quick-actions,
    [data-theme="dark"] .recent-activities {
        background: #2d3748;
        border-color: #4a5568;
        color: #e2e8f0;
    }

    [data-theme="dark"] .quick-actions h3,
    [data-theme="dark"] .recent-activities h3,
    [data-theme="dark"] .activity-title {
        color: #f7fafc;
    }

    [data-theme="dark"] .action-card {
        background: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    [data-theme="dark"] .action-card h4 {
        color: #f9fafb;
    }

    [data-theme="dark"] .activity-item {
        border-bottom-color: #4a5568;
    }

    [data-theme="dark"] .activity-details,
    [data-theme="dark"] .activity-time {
        color: #9ca3af;
    }
</style>

@endpush

@section(‘content’)

<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="welcome-section">
                <h1>
                    <i class="bi bi-house-heart"></i>
                    Xin chào, Gia đình!
                </h1>
                <p>Hôm nay là {{ formatDate(now(), 'dddd, DD/MM/YYYY') }}. Chúc bạn một ngày tuyệt vời!</p>
            </div>

```
        <!-- Quick Stats -->
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <span class="stat-value" id="currentBalance">{{ formatCurrency($currentBalance ?? 0) }}</span>
                <span class="stat-label">Số dư hiện tại</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <span class="stat-value" id="monthlyIncome">{{ formatCurrency($monthlyStats['total_income'] ?? 0) }}</span>
                <span class="stat-label">Thu nhập tháng này</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <span class="stat-value" id="monthlySpent">{{ formatCurrency($monthlyStats['total_spent'] ?? 0) }}</span>
                <span class="stat-label">Chi tiêu tháng này</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-cart3"></i>
                </div>
                <span class="stat-value" id="shoppingTrips">{{ $monthlyStats['shopping_trips'] ?? 0 }}</span>
                <span class="stat-label">Lần đi chợ tháng này</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>
                <span class="title-section">
                    <i class="bi bi-lightning-charge"></i>
                    Thao tác nhanh
                </span>
            </h3>

            <div class="actions-grid">
                <a href="{{ route('funds.add') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h4>Thêm tiền vào quỹ</h4>
                    <p>Nạp tiền lương, tiền thưởng hoặc thu nhập khác vào quỹ gia đình</p>
                </a>

                <a href="{{ route('shopping.create') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-cart-plus"></i>
                    </div>
                    <h4>Đi chợ mới</h4>
                    <p>Tạo danh sách đi chợ mới và ghi nhận chi tiêu</p>
                </a>

                <a href="{{ route('funds.history') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4>Xem lịch sử</h4>
                    <p>Theo dõi tất cả giao dịch thu chi của gia đình</p>
                </a>

                <a href="{{ route('export.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-download"></i>
                    </div>
                    <h4>Xuất báo cáo</h4>
                    <p>Tải báo cáo chi tiêu hàng tháng dưới dạng Excel</p>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="recent-activities">
            <h3>
                <span class="title-section">
                    <i class="bi bi-activity"></i>
                    Hoạt động gần đây
                </span>
                <a href="{{ route('funds.history') }}" class="view-all-link">
                    Xem tất cả
                    <i class="bi bi-arrow-right"></i>
                </a>
            </h3>

            @if(!empty($recentActivities) && count($recentActivities) > 0)
                <ul class="activity-list">
                    @foreach($recentActivities as $activity)
                        <li class="activity-item">
                            <div class="activity-icon {{ $activity['type'] }}">
                                <i class="bi {{ $activity['icon'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-details">{{ $activity['description'] }}</div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                            <div class="activity-amount {{ $activity['amount'] > 0 ? 'positive' : 'negative' }}">
                                {{ $activity['amount'] > 0 ? '+' : '' }}{{ formatCurrency($activity['amount']) }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h4>Chưa có hoạt động nào</h4>
                    <p>Các giao dịch gần đây sẽ hiển thị ở đây</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Monthly Summary Widget -->
        <div class="quick-actions">
            <h3>
                <span class="title-section">
                    <i class="bi bi-calendar3"></i>
                    Tháng {{ now()->format('m/Y') }}
                </span>
            </h3>

            <div class="monthly-summary">
                <div class="summary-item">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="summary-label">
                            <i class="bi bi-arrow-up text-success"></i>
                            Thu nhập
                        </span>
                        <span class="summary-value text-success">{{ formatCurrency($monthlyStats['total_income'] ?? 0) }}</span>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>

                <div class="summary-item mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="summary-label">
                            <i class="bi bi-arrow-down text-danger"></i>
                            Chi tiêu
                        </span>
                        <span class="summary-value text-danger">{{ formatCurrency($monthlyStats['total_spent'] ?? 0) }}</span>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger"
                             style="width: {{ ($monthlyStats['total_income'] ?? 1) > 0 ? min(100, (($monthlyStats['total_spent'] ?? 0) / ($monthlyStats['total_income'] ?? 1)) * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                @php
                    $savings = ($monthlyStats['total_income'] ?? 0) - ($monthlyStats['total_spent'] ?? 0);
                @endphp
                <div class="summary-item mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="summary-label">
                            <i class="bi bi-piggy-bank {{ $savings >= 0 ? 'text-primary' : 'text-warning' }}"></i>
                            Tiết kiệm
                        </span>
                        <span class="summary-value {{ $savings >= 0 ? 'text-primary' : 'text-warning' }}">
                            {{ formatCurrency($savings) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Widget -->
        <div class="quick-actions">
            <h3>
                <span class="title-section">
                    <i class="bi bi-lightbulb"></i>
                    Mẹo tiết kiệm
                </span>
            </h3>

            <div class="tips-content">
                <div class="tip-item">
                    <i class="bi bi-check-circle text-success"></i>
                    <span>Lập danh sách mua sắm trước khi đi chợ để tránh mua thừa</span>
                </div>
                <div class="tip-item mt-2">
                    <i class="bi bi-check-circle text-success"></i>
                    <span>So sánh giá cả giữa các chợ và siêu thị</span>
                </div>
                <div class="tip-item mt-2">
                    <i class="bi bi-check-circle text-success"></i>
                    <span>Mua theo mùa để có giá tốt nhất</span>
                </div>
            </div>
        </div>
    </div>
</div>
```

</div>
@endsection

@push(‘scripts’)

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dashboard
    initializeDashboard();
    loadRealtimeData();

    // Refresh data every 5 minutes
    setInterval(loadRealtimeData, 5 * 60 * 1000);
});

/**
 * Initialize dashboard functionality
 */
function initializeDashboard() {
    // Add greeting based on time
    updateTimeBasedGreeting();

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add smooth scroll to action cards
    document.querySelectorAll('.action-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');
            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    console.log('Dashboard initialized successfully');
}

/**
 * Update greeting based on current time
 */
function updateTimeBasedGreeting() {
    const hour = new Date().getHours();
    const welcomeSection = document.querySelector('.welcome-section h1');

    if (!welcomeSection) return;

    let greeting = 'Xin chào';
    let icon = 'bi-house-heart';

    if (hour < 6) {
        greeting = 'Chúc ngủ ngon';
        icon = 'bi-moon-stars';
    } else if (hour < 12) {
        greeting = 'Chào buổi sáng';
        icon = 'bi-sun';
    } else if (hour < 18) {
        greeting = 'Chào buổi chiều';
        icon = 'bi-sun-fill';
    } else if (hour < 22) {
        greeting = 'Chào buổi tối';
        icon = 'bi-sunset';
    } else {
        greeting = 'Chúc ngủ ngon';
        icon = 'bi-moon';
    }

    welcomeSection.innerHTML = `
        <i class="bi ${icon}"></i>
        ${greeting}, Gia đình!
    `;
}

/**
 * Load realtime data via API
 */
async function loadRealtimeData() {
    try {
        // Load current balance
        const balanceResponse = await axios.get(window.App.routes.funds.balance);
        if (balanceResponse.data.success) {
            document.getElementById('currentBalance').textContent =
                formatCurrency(balanceResponse.data.balance);
        }

        // Load monthly stats
        const statsResponse = await axios.get(window.App.routes.funds.balance + '?type=stats');
        if (statsResponse.data.success) {
            const stats = statsResponse.data;

            document.getElementById('monthlyIncome').textContent =
                formatCurrency(stats.monthly_income || 0);
            document.getElementById('monthlySpent').textContent =
                formatCurrency(stats.monthly_spent || 0);
            document.getElementById('shoppingTrips').textContent =
                stats.shopping_trips || 0;
        }

        console.log('Dashboard data updated');
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        // Don't show error to user, just log it
    }
}

/**
 * Helper function for currency formatting
 */
function formatCurrency(amount) {
    if (!window.formatCurrency) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
    }
    return window.formatCurrency(amount);
}

// Add custom styles for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale(0);
    }

    @keyframes ripple {
        to {
            transform: translate(-50%, -50%) scale(4);
            opacity: 0;
        }
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .tip-item i {
        margin-top: 0.1rem;
        flex-shrink: 0;
    }

    .summary-item .summary-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .summary-item .summary-value {
        font-weight: 600;
        font-size: 0.95rem;
    }

    [data-theme="dark"] .summary-item .summary-label {
        color: #9ca3af;
    }
`;
document.head.appendChild(style);
</script>

@endpush

{{-- Shopping Statistics Component --}}
@props([
    'monthlyStats' => [],
    'month' => null,
    'year' => null,
    'showTrends' => true,
    'showTopItems' => true,
    'showCharts' => true,
    'size' => 'default' // 'compact', 'default', 'detailed'
])

@php
    $currentMonth = $month ?? now()->month;
    $currentYear = $year ?? now()->year;
    $monthName = Carbon\Carbon::create($currentYear, $currentMonth)->format('m/Y');

    // Default stats structure
    $defaultStats = [
        'total_trips' => 0,
        'total_amount' => 0,
        'total_items' => 0,
        'avg_per_trip' => 0,
        'most_expensive_trip' => 0,
        'cheapest_trip' => 0
    ];

    $stats = array_merge($defaultStats, $monthlyStats);
@endphp

<div class="shopping-stats-container" data-month="{{ $currentMonth }}" data-year="{{ $currentYear }}">
    {{-- Stats Header --}}
    <div class="stats-header">
        <div class="stats-title">
            <i class="bi bi-graph-up-arrow"></i>
            <span>Thống kê tháng {{ $monthName }}</span>
        </div>
        <div class="stats-actions">
            <button class="btn btn-sm btn-outline-primary" onclick="refreshShoppingStats()">
                <i class="bi bi-arrow-clockwise"></i>
                <span class="d-none d-md-inline">Làm mới</span>
            </button>
            @if($showCharts)
            <button class="btn btn-sm btn-outline-secondary" onclick="toggleChartsView()">
                <i class="bi bi-bar-chart"></i>
                <span class="d-none d-md-inline">Biểu đồ</span>
            </button>
            @endif
        </div>
    </div>

    {{-- Main Stats Cards --}}
    <div class="row g-4 mb-4">
        {{-- Total Trips --}}
        <div class="col-lg-3 col-md-6">
            <div class="stats-card trips-card">
                <div class="stats-card-body">
                    <div class="stats-icon bg-primary">
                        <i class="bi bi-basket2"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value" id="totalTrips">{{ $stats['total_trips'] }}</div>
                        <div class="stats-label">Lần đi chợ</div>
                        <div class="stats-change">
                            <i class="bi bi-calendar-week"></i>
                            <span id="tripsFrequency">{{ $stats['total_trips'] > 0 ? round(30 / max($stats['total_trips'], 1), 1) : 0 }} ngày/lần</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Amount --}}
        <div class="col-lg-3 col-md-6">
            <div class="stats-card amount-card">
                <div class="stats-card-body">
                    <div class="stats-icon bg-danger">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value" id="totalAmount">{{ number_format($stats['total_amount']) }}</div>
                        <div class="stats-label">Tổng chi tiêu (VNĐ)</div>
                        <div class="stats-change">
                            <i class="bi bi-arrow-down"></i>
                            <span id="amountPerDay">{{ number_format($stats['total_amount'] / max(now()->day, 1)) }}/ngày</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average per Trip --}}
        <div class="col-lg-3 col-md-6">
            <div class="stats-card average-card">
                <div class="stats-card-body">
                    <div class="stats-icon bg-info">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value" id="avgPerTrip">{{ number_format($stats['avg_per_trip']) }}</div>
                        <div class="stats-label">TB mỗi lần (VNĐ)</div>
                        <div class="stats-change">
                            <i class="bi bi-graph-up"></i>
                            <span id="avgChange">Cao nhất: {{ number_format($stats['most_expensive_trip']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Items --}}
        <div class="col-lg-3 col-md-6">
            <div class="stats-card items-card">
                <div class="stats-card-body">
                    <div class="stats-icon bg-success">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-value" id="totalItems">{{ $stats['total_items'] }}</div>
                        <div class="stats-label">Món đồ đã mua</div>
                        <div class="stats-change">
                            <i class="bi bi-box"></i>
                            <span id="itemsPerTrip">{{ $stats['total_trips'] > 0 ? round($stats['total_items'] / $stats['total_trips'], 1) : 0 }} món/lần</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($size !== 'compact')
    {{-- Secondary Stats Row --}}
    <div class="row g-4 mb-4">
        {{-- Budget Performance --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-detail-card budget-card">
                <div class="detail-header">
                    <h6 class="detail-title">
                        <i class="bi bi-piggy-bank"></i>
                        Hiệu quả chi tiêu
                    </h6>
                </div>
                <div class="detail-body">
                    <div class="budget-item">
                        <span class="budget-label">Cao nhất:</span>
                        <span class="budget-value text-danger" id="highestAmount">{{ number_format($stats['most_expensive_trip']) }} VNĐ</span>
                    </div>
                    <div class="budget-item">
                        <span class="budget-label">Thấp nhất:</span>
                        <span class="budget-value text-success" id="lowestAmount">{{ number_format($stats['cheapest_trip']) }} VNĐ</span>
                    </div>
                    <div class="budget-item">
                        <span class="budget-label">Chênh lệch:</span>
                        <span class="budget-value text-info" id="amountDiff">{{ number_format($stats['most_expensive_trip'] - $stats['cheapest_trip']) }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Time Analysis --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-detail-card time-card">
                <div class="detail-header">
                    <h6 class="detail-title">
                        <i class="bi bi-clock-history"></i>
                        Phân tích thời gian
                    </h6>
                </div>
                <div class="detail-body" id="timeAnalysis">
                    <div class="time-loading">
                        <i class="bi bi-arrow-clockwise spin"></i>
                        Đang tải...
                    </div>
                </div>
            </div>
        </div>

        {{-- Progress Goals --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-detail-card goals-card">
                <div class="detail-header">
                    <h6 class="detail-title">
                        <i class="bi bi-target"></i>
                        Mục tiêu tháng
                    </h6>
                </div>
                <div class="detail-body">
                    <div class="goal-item">
                        <div class="goal-header">
                            <span class="goal-label">Tần suất đi chợ</span>
                            <span class="goal-progress" id="frequencyProgress">{{ min(100, ($stats['total_trips'] / 15) * 100) }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ min(100, ($stats['total_trips'] / 15) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">Mục tiêu: 15 lần/tháng</small>
                    </div>

                    <div class="goal-item mt-3">
                        <div class="goal-header">
                            <span class="goal-label">Tiết kiệm chi phí</span>
                            <span class="goal-progress" id="savingProgress">{{ $stats['avg_per_trip'] <= 200000 ? 100 : (200000 / $stats['avg_per_trip']) * 100 }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: {{ min(100, $stats['avg_per_trip'] <= 200000 ? 100 : (200000 / $stats['avg_per_trip']) * 100) }}%"></div>
                        </div>
                        <small class="text-muted">Mục tiêu: ≤200k/lần</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showTopItems && $size !== 'compact')
    {{-- Top Items Section --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="top-items-card">
                <div class="top-items-header">
                    <h5 class="top-items-title">
                        <i class="bi bi-trophy"></i>
                        Top món đồ mua nhiều nhất
                    </h5>
                    <div class="top-items-controls">
                        <button class="btn btn-sm btn-outline-primary" onclick="loadTopItems('frequency')">
                            Theo tần suất
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="loadTopItems('amount')">
                            Theo số tiền
                        </button>
                    </div>
                </div>
                <div class="top-items-body">
                    <div class="top-items-loading" id="topItemsLoading">
                        <i class="bi bi-arrow-clockwise spin"></i>
                        Đang tải dữ liệu...
                    </div>
                    <div class="top-items-list" id="topItemsList"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showCharts && $size === 'detailed')
    {{-- Charts Section --}}
    <div class="row g-4 charts-section" id="chartsSection" style="display: none;">
        {{-- Weekly Trend Chart --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h6 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        Xu hướng chi tiêu theo tuần
                    </h6>
                </div>
                <div class="chart-body">
                    <canvas id="weeklyTrendChart" height="300"></canvas>
                </div>
            </div>
        </div>

        {{-- Category Distribution --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h6 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        Phân bổ theo ngày
                    </h6>
                </div>
                <div class="chart-body">
                    <canvas id="dayDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Comparison Section --}}
    @if($showTrends && $size !== 'compact')
    <div class="row g-4">
        <div class="col-12">
            <div class="comparison-card">
                <div class="comparison-header">
                    <h5 class="comparison-title">
                        <i class="bi bi-arrow-left-right"></i>
                        So sánh với các tháng trước
                    </h5>
                    <div class="comparison-controls">
                        <select class="form-select form-select-sm" id="comparisonPeriod" onchange="loadComparison()">
                            <option value="3">3 tháng gần đây</option>
                            <option value="6" selected>6 tháng gần đây</option>
                            <option value="12">12 tháng gần đây</option>
                        </select>
                    </div>
                </div>
                <div class="comparison-body">
                    <div class="comparison-loading" id="comparisonLoading">
                        <i class="bi bi-arrow-clockwise spin"></i>
                        Đang tải dữ liệu so sánh...
                    </div>
                    <div class="comparison-results" id="comparisonResults"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Component Styles --}}
<style>
.shopping-stats-container {
    margin-bottom: 2rem;
}

/* Stats Header */
.stats-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f1f3f4;
}

.stats-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
}

.stats-title i {
    color: var(--bs-primary);
    font-size: 1.5rem;
}

.stats-actions {
    display: flex;
    gap: 0.5rem;
}

/* Main Stats Cards */
.stats-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stats-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stats-content {
    flex: 1;
}

.stats-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.25rem;
}

.stats-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stats-change {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: #6c757d;
}

.stats-change i {
    font-size: 0.7rem;
}

/* Detail Cards */
.stats-detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f3f4;
    height: 100%;
}

.detail-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f3f4;
    background: #f8f9fa;
}

.detail-title {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-body {
    padding: 1.25rem;
}

/* Budget Card */
.budget-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.budget-item:last-child {
    margin-bottom: 0;
}

.budget-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.budget-value {
    font-weight: 600;
    font-size: 0.875rem;
}

/* Goals Card */
.goal-item {
    margin-bottom: 1rem;
}

.goal-item:last-child {
    margin-bottom: 0;
}

.goal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.goal-label {
    font-size: 0.875rem;
    color: #495057;
}

.goal-progress {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--bs-primary);
}

.progress {
    height: 8px;
    margin-bottom: 0.25rem;
}

/* Top Items Card */
.top-items-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f3f4;
}

.top-items-header {
    padding: 1.25rem;
    border-bottom: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.top-items-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.top-items-controls {
    display: flex;
    gap: 0.5rem;
}

.top-items-body {
    padding: 1.25rem;
    min-height: 200px;
}

.top-items-loading,
.comparison-loading,
.time-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px;
    color: #6c757d;
}

.top-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    transition: background-color 0.2s ease;
}

.top-item:hover {
    background: #f8f9fa;
}

.top-item:last-child {
    margin-bottom: 0;
}

.top-item-rank {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--bs-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.top-item-rank.rank-1 { background: #ffd700; color: #000; }
.top-item-rank.rank-2 { background: #c0c0c0; color: #000; }
.top-item-rank.rank-3 { background: #cd7f32; color: #fff; }

.top-item-info {
    flex: 1;
    margin-left: 1rem;
}

.top-item-name {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
}

.top-item-details {
    font-size: 0.75rem;
    color: #6c757d;
}

.top-item-stats {
    text-align: right;
}

.top-item-value {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

.top-item-frequency {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Chart Cards */
.chart-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f3f4;
}

.chart-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f1f3f4;
}

.chart-title {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.chart-body {
    padding: 1.25rem;
}

/* Comparison Card */
.comparison-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #f1f3f4;
}

.comparison-header {
    padding: 1.25rem;
    border-bottom: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.comparison-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.comparison-body {
    padding: 1.25rem;
}

.comparison-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #f1f3f4;
    margin-bottom: 0.75rem;
}

.comparison-item:last-child {
    margin-bottom: 0;
}

.comparison-period {
    font-weight: 500;
    color: #495057;
}

.comparison-stats {
    display: flex;
    gap: 1rem;
}

.comparison-stat {
    text-align: center;
}

.comparison-stat-label {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.comparison-stat-value {
    font-weight: 600;
    font-size: 0.875rem;
}

/* Animations */
.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Loading States */
.top-items-loading,
.comparison-loading,
.time-loading {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .stats-actions {
        justify-content: center;
    }

    .stats-card-body {
        padding: 1rem;
        gap: 0.75rem;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .stats-value {
        font-size: 1.5rem;
    }

    .top-items-header,
    .comparison-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .top-items-controls,
    .comparison-controls {
        justify-content: center;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .stats-card,
    .stats-detail-card,
    .top-items-card,
    .chart-card,
    .comparison-card {
        background: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }

    .detail-header {
        background: #343a40;
        border-color: #495057;
    }

    .top-item:hover {
        background: #343a40;
    }

    .comparison-item {
        border-color: #495057;
    }
}
</style>

{{-- Component JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeShoppingStats();
    loadTimeAnalysis();
    loadTopItems('frequency');
    loadComparison();
});

// Initialize shopping statistics
function initializeShoppingStats() {
    // Update any calculated values that need JS
    updateCalculatedStats();

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Update calculated statistics
function updateCalculatedStats() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;

    // Calculate days in month for per-day average
    const daysInMonth = new Date(year, month, 0).getDate();
    const currentDay = new Date().getDate();
    const actualDays = month == new Date().getMonth() + 1 && year == new Date().getFullYear()
        ? currentDay
        : daysInMonth;

    // Update per-day calculations if needed
    const totalAmount = parseCurrency(document.getElementById('totalAmount')?.textContent || '0');
    const amountPerDayEl = document.getElementById('amountPerDay');
    if (amountPerDayEl && totalAmount > 0) {
        const perDay = Math.round(totalAmount / actualDays);
        amountPerDayEl.textContent = formatCurrency(perDay) + '/ngày';
    }
}

// Refresh shopping statistics
async function refreshShoppingStats() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;

    try {
        showStatsLoading();

        // Get fresh stats from API
        const response = await fetch(`/api/shopping/stats?month=${month}&year=${year}`);
        const data = await response.json();

        if (data.success) {
            updateStatsDisplay(data.stats);
        }

        hideStatsLoading();

        // Refresh sub-components
        loadTimeAnalysis();
        loadTopItems('frequency');
        loadComparison();

    } catch (error) {
        console.error('Error refreshing shopping stats:', error);
        hideStatsLoading();
    }
}

// Load time analysis data
async function loadTimeAnalysis() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;
    const timeAnalysisEl = document.getElementById('timeAnalysis');

    if (!timeAnalysisEl) return;

    try {
        const response = await fetch(`/api/shopping/time-analysis?month=${month}&year=${year}`);
        const data = await response.json();

        if (data.success) {
            renderTimeAnalysis(data.analysis);
        } else {
            showTimeAnalysisError();
        }
    } catch (error) {
        console.error('Error loading time analysis:', error);
        showTimeAnalysisError();
    }
}

// Load top items data
async function loadTopItems(sortBy = 'frequency') {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;
    const topItemsList = document.getElementById('topItemsList');
    const topItemsLoading = document.getElementById('topItemsLoading');

    if (!topItemsList) return;

    try {
        topItemsLoading.style.display = 'flex';
        topItemsList.style.display = 'none';

        const response = await fetch(`/api/shopping/top-items?month=${month}&year=${year}&sort=${sortBy}&limit=10`);
        const data = await response.json();

        if (data.success && data.items.length > 0) {
            renderTopItems(data.items, sortBy);
        } else {
            showNoTopItems();
        }

        topItemsLoading.style.display = 'none';
        topItemsList.style.display = 'block';

    } catch (error) {
        console.error('Error loading top items:', error);
        showTopItemsError();
        topItemsLoading.style.display = 'none';
    }
}

// Render top items list
function renderTopItems(items, sortBy) {
    const topItemsList = document.getElementById('topItemsList');
    if (!topItemsList) return;

    const itemsHtml = items.map((item, index) => {
        const rankClass = index < 3 ? `rank-${index + 1}` : '';
        const primaryStat = sortBy === 'frequency' ? item.frequency + ' lần' : formatCurrency(item.total_spent);
        const secondaryStat = sortBy === 'frequency' ? formatCurrency(item.total_spent) : item.frequency + ' lần';

        return `
            <div class="top-item">
                <div class="top-item-rank ${rankClass}">${index + 1}</div>
                <div class="top-item-info">
                    <div class="top-item-name">${item.item_name}</div>
                    <div class="top-item-details">Giá TB: ${formatCurrency(item.avg_price)}</div>
                </div>
                <div class="top-item-stats">
                    <div class="top-item-value">${primaryStat}</div>
                    <div class="top-item-frequency">${secondaryStat}</div>
                </div>
            </div>
        `;
    }).join('');

    topItemsList.innerHTML = itemsHtml;

    // Update active button
    document.querySelectorAll('.top-items-controls .btn').forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });

    const activeBtn = sortBy === 'frequency'
        ? document.querySelector('.top-items-controls .btn:first-child')
        : document.querySelector('.top-items-controls .btn:last-child');

    if (activeBtn) {
        activeBtn.classList.remove('btn-outline-primary');
        activeBtn.classList.add('btn-primary');
    }
}

// Load comparison data
async function loadComparison() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;
    const comparisonResults = document.getElementById('comparisonResults');
    const comparisonLoading = document.getElementById('comparisonLoading');
    const period = document.getElementById('comparisonPeriod')?.value || 6;

    if (!comparisonResults) return;

    try {
        comparisonLoading.style.display = 'flex';
        comparisonResults.style.display = 'none';

        const response = await fetch(`/api/shopping/comparison?month=${month}&year=${year}&period=${period}`);
        const data = await response.json();

        if (data.success) {
            renderComparison(data.comparison);
        } else {
            showComparisonError();
        }

        comparisonLoading.style.display = 'none';
        comparisonResults.style.display = 'block';

    } catch (error) {
        console.error('Error loading comparison:', error);
        showComparisonError();
        comparisonLoading.style.display = 'none';
    }
}

// Render comparison results
function renderComparison(comparison) {
    const comparisonResults = document.getElementById('comparisonResults');
    if (!comparisonResults || !comparison.length) return;

    const comparisonHtml = comparison.map(item => {
        const isCurrentMonth = item.is_current;
        const cardClass = isCurrentMonth ? 'border-primary bg-light' : '';

        return `
            <div class="comparison-item ${cardClass}">
                <div class="comparison-period">
                    ${item.month_name} ${item.year}
                    ${isCurrentMonth ? '<small class="text-primary">(Hiện tại)</small>' : ''}
                </div>
                <div class="comparison-stats">
                    <div class="comparison-stat">
                        <div class="comparison-stat-label">Lần đi chợ</div>
                        <div class="comparison-stat-value">${item.total_trips}</div>
                    </div>
                    <div class="comparison-stat">
                        <div class="comparison-stat-label">Chi tiêu</div>
                        <div class="comparison-stat-value">${formatCurrency(item.total_amount)}</div>
                    </div>
                    <div class="comparison-stat">
                        <div class="comparison-stat-label">TB/lần</div>
                        <div class="comparison-stat-value">${formatCurrency(item.avg_per_trip)}</div>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    comparisonResults.innerHTML = comparisonHtml;
}

// Render time analysis
function renderTimeAnalysis(analysis) {
    const timeAnalysisEl = document.getElementById('timeAnalysis');
    if (!timeAnalysisEl) return;

    const analysisHtml = `
        <div class="time-stat">
            <span class="time-label">Ngày trong tuần hay đi chợ nhất:</span>
            <span class="time-value text-primary">${analysis.favorite_day || 'Chưa có dữ liệu'}</span>
        </div>
        <div class="time-stat mt-2">
            <span class="time-label">Khoảng thời gian trung bình giữa các lần:</span>
            <span class="time-value text-info">${analysis.avg_interval || 0} ngày</span>
        </div>
        <div class="time-stat mt-2">
            <span class="time-label">Tuần trong tháng tích cực nhất:</span>
            <span class="time-value text-success">Tuần ${analysis.most_active_week || 1}</span>
        </div>
    `;

    timeAnalysisEl.innerHTML = analysisHtml;
}

// Toggle charts view
function toggleChartsView() {
    const chartsSection = document.getElementById('chartsSection');
    if (!chartsSection) return;

    const isVisible = chartsSection.style.display !== 'none';

    if (isVisible) {
        chartsSection.style.display = 'none';
    } else {
        chartsSection.style.display = 'block';
        loadCharts();
    }
}

// Load and render charts
function loadCharts() {
    loadWeeklyTrendChart();
    loadDayDistributionChart();
}

// Load weekly trend chart
async function loadWeeklyTrendChart() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;
    const canvas = document.getElementById('weeklyTrendChart');

    if (!canvas) return;

    try {
        const response = await fetch(`/api/shopping/weekly-trends?month=${month}&year=${year}`);
        const data = await response.json();

        if (data.success && window.Chart) {
            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.weeks.map(w => `Tuần ${w.week}`),
                    datasets: [{
                        label: 'Chi tiêu (VNĐ)',
                        data: data.weeks.map(w => w.amount),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatCurrency(value);
                                }
                            }
                        }
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error loading weekly trend chart:', error);
    }
}

// Load day distribution chart
async function loadDayDistributionChart() {
    const container = document.querySelector('.shopping-stats-container');
    const month = container.dataset.month;
    const year = container.dataset.year;
    const canvas = document.getElementById('dayDistributionChart');

    if (!canvas) return;

    try {
        const response = await fetch(`/api/shopping/day-distribution?month=${month}&year=${year}`);
        const data = await response.json();

        if (data.success && window.Chart) {
            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.days.map(d => d.day_name),
                    datasets: [{
                        data: data.days.map(d => d.count),
                        backgroundColor: [
                            '#0d6efd', '#6610f2', '#6f42c1', '#d63384',
                            '#dc3545', '#fd7e14', '#ffc107'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        }
                    }
                }
            });
        }
    } catch (error) {
        console.error('Error loading day distribution chart:', error);
    }
}

// Error and empty state handlers
function showStatsLoading() {
    // Show loading indicators on main stats
    document.querySelectorAll('.stats-value').forEach(el => {
        el.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';
    });
}

function hideStatsLoading() {
    // This would be called after successful update
    // The actual values would be updated by updateStatsDisplay()
}

function updateStatsDisplay(stats) {
    document.getElementById('totalTrips').textContent = stats.total_trips || 0;
    document.getElementById('totalAmount').textContent = formatCurrency(stats.total_amount || 0);
    document.getElementById('avgPerTrip').textContent = formatCurrency(stats.avg_per_trip || 0);
    document.getElementById('totalItems').textContent = stats.total_items || 0;

    // Update calculated fields
    updateCalculatedStats();
}

function showNoTopItems() {
    const topItemsList = document.getElementById('topItemsList');
    if (topItemsList) {
        topItemsList.innerHTML = `
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox display-4 mb-3"></i>
                <p>Chưa có dữ liệu món đồ cho tháng này</p>
            </div>
        `;
    }
}

function showTopItemsError() {
    const topItemsList = document.getElementById('topItemsList');
    if (topItemsList) {
        topItemsList.innerHTML = `
            <div class="text-center py-4 text-muted">
                <i class="bi bi-exclamation-triangle display-4 mb-3"></i>
                <p>Có lỗi khi tải dữ liệu. Vui lòng thử lại.</p>
            </div>
        `;
    }
}

function showTimeAnalysisError() {
    const timeAnalysisEl = document.getElementById('timeAnalysis');
    if (timeAnalysisEl) {
        timeAnalysisEl.innerHTML = `
            <div class="text-center text-muted">
                <i class="bi bi-exclamation-triangle"></i>
                Không thể tải phân tích thời gian
            </div>
        `;
    }
}

function showComparisonError() {
    const comparisonResults = document.getElementById('comparisonResults');
    if (comparisonResults) {
        comparisonResults.innerHTML = `
            <div class="text-center py-4 text-muted">
                <i class="bi bi-exclamation-triangle display-4 mb-3"></i>
                <p>Có lỗi khi tải dữ liệu so sánh</p>
            </div>
        `;
    }
}

// Utility functions
function formatCurrency(amount) {
    if (!amount) return '0';
    return new Intl.NumberFormat('vi-VN').format(Math.round(amount));
}

function parseCurrency(str) {
    if (!str) return 0;
    return parseInt(str.replace(/[^\d]/g, '')) || 0;
}

// Export functions for external use
window.refreshShoppingStats = refreshShoppingStats;
window.loadTopItems = loadTopItems;
window.loadComparison = loadComparison;
window.toggleChartsView = toggleChartsView;
</script>

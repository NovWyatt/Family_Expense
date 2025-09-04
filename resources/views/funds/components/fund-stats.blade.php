{{-- Fund Statistics Component --}}
<div class="fund-stats-container">
    <!-- Overview Cards -->
    <div class="row g-4 mb-4">
        <!-- Current Balance Card -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card balance-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-primary">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Số Dư Hiện Tại</h6>
                        <div class="stats-value" id="currentBalanceStats">
                            {{ number_format(auth()->user()->balance ?? 0) }} VNĐ
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="balanceTrend">
                    <i class="bi bi-arrow-up text-success"></i>
                    <span class="trend-text">Ổn định</span>
                </div>
            </div>
        </div>

        <!-- Monthly Added Card -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card added-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-success">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Nạp Tháng Này</h6>
                        <div class="stats-value" id="monthlyAddedStats">
                            0 VNĐ
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="addedTrend">
                    <i class="bi bi-arrow-up"></i>
                    <span class="trend-text">+0% so với tháng trước</span>
                </div>
            </div>
        </div>

        <!-- Monthly Spent Card -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card spent-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-danger">
                        <i class="bi bi-dash-circle"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Chi Tháng Này</h6>
                        <div class="stats-value" id="monthlySpentStats">
                            0 VNĐ
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="spentTrend">
                    <i class="bi bi-arrow-down"></i>
                    <span class="trend-text">+0% so với tháng trước</span>
                </div>
            </div>
        </div>

        <!-- Net Change Card -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card net-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-info">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Thay Đổi Ròng</h6>
                        <div class="stats-value" id="netChangeStats">
                            0 VNĐ
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="netTrend">
                    <i class="bi bi-arrow-up"></i>
                    <span class="trend-text">Tích cực</span>
                </div>
            </div>
        </div>

        <!-- Transactions Count Card -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card transactions-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-warning">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Số Giao Dịch</h6>
                        <div class="stats-value" id="transactionsCountStats">
                            0 giao dịch
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="transactionsTrend">
                    <i class="bi bi-arrow-up"></i>
                    <span class="trend-text">Hoạt động bình thường</span>
                </div>
            </div>
        </div>

        <!-- Average Per Transaction -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card average-card">
                <div class="stats-card-header">
                    <div class="stats-icon bg-secondary">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <div class="stats-info">
                        <h6 class="stats-title">Trung Bình/GD</h6>
                        <div class="stats-value" id="averageTransactionStats">
                            0 VNĐ
                        </div>
                    </div>
                </div>
                <div class="stats-trend" id="averageTrend">
                    <i class="bi bi-dash"></i>
                    <span class="trend-text">Chưa có dữ liệu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Monthly Trend Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up me-2"></i>
                        Xu Hướng Tháng
                    </h5>
                    <div class="chart-controls">
                        <select class="form-select form-select-sm" id="chartPeriod">
                            <option value="6">6 tháng gần đây</option>
                            <option value="12" selected>12 tháng gần đây</option>
                            <option value="24">24 tháng gần đây</option>
                        </select>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="monthlyTrendChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribution Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart me-2"></i>
                        Phân Bổ Tháng Này
                    </h5>
                </div>
                <div class="chart-body">
                    <canvas id="distributionChart" height="300"></canvas>
                    <div class="distribution-legend" id="distributionLegend">
                        <!-- Legend items will be populated by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Stats Table -->
    <div class="row g-4">
        <div class="col-12">
            <div class="stats-table-card">
                <div class="stats-table-header">
                    <h5 class="stats-table-title">
                        <i class="bi bi-table me-2"></i>
                        Thống Kê Chi Tiết
                    </h5>
                    <div class="stats-table-controls">
                        <button class="btn btn-sm btn-outline-primary" id="refreshStatsBtn">
                            <i class="bi bi-arrow-clockwise"></i>
                            Làm mới
                        </button>
                    </div>
                </div>
                <div class="stats-table-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tháng</th>
                                    <th class="text-end">Nạp vào</th>
                                    <th class="text-end">Chi tiêu</th>
                                    <th class="text-end">Thay đổi ròng</th>
                                    <th class="text-center">Giao dịch</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody id="detailedStatsTable">
                                <!-- Table rows will be populated by JS -->
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Đang tải...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mt-2">
        <div class="col-md-3">
            <button class="btn btn-primary w-100" onclick="showAddFundModal()">
                <i class="bi bi-plus-circle me-1"></i>
                Nạp Quỹ
            </button>
        </div>
        <div class="col-md-3">
            <a href="{{ route('funds.history') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-clock-history me-1"></i>
                Xem Lịch Sử
            </a>
        </div>
        <div class="col-md-3">
            <button class="btn btn-outline-info w-100" onclick="exportStats()">
                <i class="bi bi-download me-1"></i>
                Xuất Báo Cáo
            </button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-outline-success w-100" onclick="shareStats()">
                <i class="bi bi-share me-1"></i>
                Chia Sẻ
            </button>
        </div>
    </div>
</div>

<style>
/* Fund Stats Styles */
.fund-stats-container {
    padding: 1rem 0;
}

.stats-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--bs-primary), var(--bs-success));
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stats-card-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.stats-icon i {
    font-size: 1.25rem;
    color: white;
}

.stats-info {
    flex-grow: 1;
}

.stats-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
    line-height: 1.2;
}

.stats-trend {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.stats-trend i {
    margin-right: 0.25rem;
}

.trend-text {
    color: #6c757d;
}

/* Specific card colors */
.balance-card::before {
    background: linear-gradient(90deg, #0d6efd, #6f42c1);
}

.added-card::before {
    background: linear-gradient(90deg, #198754, #20c997);
}

.spent-card::before {
    background: linear-gradient(90deg, #dc3545, #fd7e14);
}

.net-card::before {
    background: linear-gradient(90deg, #0dcaf0, #6f42c1);
}

.transactions-card::before {
    background: linear-gradient(90deg, #ffc107, #fd7e14);
}

.average-card::before {
    background: linear-gradient(90deg, #6c757d, #495057);
}

/* Charts */
.chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.chart-header {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    align-items: center;
    justify-content: between;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    flex-grow: 1;
}

.chart-controls .form-select {
    min-width: 140px;
}

.chart-body {
    padding: 1rem 1.5rem 1.5rem;
    position: relative;
}

.distribution-legend {
    margin-top: 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
}

.legend-item {
    display: flex;
    align-items: center;
    font-size: 0.875rem;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
    margin-right: 0.5rem;
}

/* Stats Table */
.stats-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.stats-table-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.stats-table-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.stats-table-body {
    padding: 0;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-positive {
    background: #d1e7dd;
    color: #0f5132;
}

.status-negative {
    background: #f8d7da;
    color: #721c24;
}

.status-neutral {
    background: #e2e3e5;
    color: #41464b;
}

/* Loading Animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.loading {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-card {
        padding: 1rem;
    }

    .stats-value {
        font-size: 1.25rem;
    }

    .chart-header {
        padding: 1rem;
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .chart-body {
        padding: 1rem;
    }

    .stats-table-header {
        padding: 1rem;
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
}

/* Dark Theme Support */
@media (prefers-color-scheme: dark) {
    .stats-card {
        background: linear-gradient(135deg, #2b3035 0%, #1a1d20 100%);
        color: #f8f9fa;
    }

    .stats-value {
        color: #f8f9fa;
    }

    .chart-card, .stats-table-card {
        background: #2b3035;
        color: #f8f9fa;
    }

    .stats-table-header {
        background: linear-gradient(135deg, #1a1d20 0%, #2b3035 100%);
        border-bottom-color: #495057;
    }

    .table-light {
        background-color: #495057;
        color: #f8f9fa;
    }

    .table th, .table td {
        border-color: #495057;
        color: #f8f9fa;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeFundStats();
});

function initializeFundStats() {
    // Initialize variables
    let monthlyTrendChart = null;
    let distributionChart = null;
    let statsData = {};

    // Load initial data
    loadStatsData();

    // Event listeners
    document.getElementById('chartPeriod').addEventListener('change', function() {
        loadStatsData();
    });

    document.getElementById('refreshStatsBtn').addEventListener('click', function() {
        const btn = this;
        const originalContent = btn.innerHTML;

        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Đang tải...';
        btn.disabled = true;

        loadStatsData().finally(() => {
            btn.innerHTML = originalContent;
            btn.disabled = false;
        });
    });

    // Listen for fund updates
    window.addEventListener('fundAdded', function(event) {
        setTimeout(loadStatsData, 1000); // Delay to ensure backend is updated
    });

    async function loadStatsData() {
        try {
            showLoadingStates();

            // Load current stats
            const statsResponse = await fetch('/api/funds/stats', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!statsResponse.ok) throw new Error('Failed to load stats');

            const result = await statsResponse.json();

            if (result.success) {
                statsData = result.data;
                updateStatsCards(statsData);
                updateCharts(statsData);
                updateDetailedTable(statsData);
            }

        } catch (error) {
            console.error('Error loading stats:', error);
            showErrorState('Không thể tải thống kê. Vui lòng thử lại.');
        } finally {
            hideLoadingStates();
        }
    }

    function updateStatsCards(data) {
        // Update current balance
        const currentBalance = data.current_balance || 0;
        document.getElementById('currentBalanceStats').textContent = formatCurrency(currentBalance);

        // Update monthly stats
        const monthly = data.monthly || {};
        document.getElementById('monthlyAddedStats').textContent = formatCurrency(monthly.total_added || 0);
        document.getElementById('monthlySpentStats').textContent = formatCurrency(monthly.total_spent || 0);
        document.getElementById('netChangeStats').textContent = formatCurrency(monthly.net_change || 0);
        document.getElementById('transactionsCountStats').textContent = (monthly.transactions_count || 0) + ' giao dịch';

        // Calculate average
        const avgTransaction = monthly.transactions_count > 0 ?
            Math.abs(monthly.total_spent) / monthly.transactions_count : 0;
        document.getElementById('averageTransactionStats').textContent = formatCurrency(avgTransaction);

        // Update trends
        const comparison = data.comparison || {};
        updateTrendIndicators(comparison);
    }

    function updateTrendIndicators(comparison) {
        // Added trend
        const addedChange = comparison.added_change || 0;
        const addedTrend = document.getElementById('addedTrend');
        updateTrendElement(addedTrend, addedChange, 'nạp');

        // Spent trend
        const spentChange = comparison.spent_change || 0;
        const spentTrend = document.getElementById('spentTrend');
        updateTrendElement(spentTrend, spentChange, 'chi');

        // Net trend
        const netChange = statsData.monthly?.net_change || 0;
        const netTrend = document.getElementById('netTrend');
        if (netChange > 0) {
            netTrend.innerHTML = '<i class="bi bi-arrow-up text-success"></i><span class="trend-text">Tích cực</span>';
        } else if (netChange < 0) {
            netTrend.innerHTML = '<i class="bi bi-arrow-down text-danger"></i><span class="trend-text">Tiêu cực</span>';
        } else {
            netTrend.innerHTML = '<i class="bi bi-dash text-secondary"></i><span class="trend-text">Cân bằng</span>';
        }
    }

    function updateTrendElement(element, changePercent, type) {
        const isPositive = changePercent > 0;
        const icon = isPositive ? 'bi-arrow-up' : (changePercent < 0 ? 'bi-arrow-down' : 'bi-dash');
        const colorClass = isPositive ? 'text-success' : (changePercent < 0 ? 'text-danger' : 'text-secondary');
        const prefix = changePercent > 0 ? '+' : '';

        element.innerHTML = `
            <i class="bi ${icon} ${colorClass}"></i>
            <span class="trend-text">${prefix}${changePercent}% so với tháng trước</span>
        `;
    }

    function updateCharts(data) {
        // Update monthly trend chart
        updateMonthlyTrendChart(data);

        // Update distribution chart
        updateDistributionChart(data);
    }

    function updateMonthlyTrendChart(data) {
        const ctx = document.getElementById('monthlyTrendChart');
        if (!ctx) return;

        // Destroy existing chart
        if (monthlyTrendChart) {
            monthlyTrendChart.destroy();
        }

        // Prepare data for chart
        const months = generateMonthLabels(parseInt(document.getElementById('chartPeriod').value));
        const addedData = months.map(() => Math.random() * 2000000); // Mock data
        const spentData = months.map(() => Math.random() * 1500000);  // Mock data

        monthlyTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Nạp vào',
                        data: addedData,
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Chi tiêu',
                        data: spentData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + formatCurrency(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatCurrencyShort(value);
                            }
                        }
                    }
                }
            }
        });
    }

    function updateDistributionChart(data) {
        const ctx = document.getElementById('distributionChart');
        if (!ctx) return;

        if (distributionChart) {
            distributionChart.destroy();
        }

        const monthly = data.monthly || {};
        const totalAdded = monthly.total_added || 0;
        const totalSpent = Math.abs(monthly.total_spent || 0);

        if (totalAdded === 0 && totalSpent === 0) {
            // Show empty state
            ctx.getContext('2d').clearRect(0, 0, ctx.width, ctx.height);
            return;
        }

        distributionChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Nạp vào', 'Chi tiêu'],
                datasets: [{
                    data: [totalAdded, totalSpent],
                    backgroundColor: ['#198754', '#dc3545'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const percentage = ((context.parsed / (totalAdded + totalSpent)) * 100).toFixed(1);
                                return context.label + ': ' + formatCurrency(context.parsed) + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Update legend
        updateDistributionLegend(totalAdded, totalSpent);
    }

    function updateDistributionLegend(added, spent) {
        const legend = document.getElementById('distributionLegend');
        const total = added + spent;

        if (total === 0) {
            legend.innerHTML = '<p class="text-muted">Chưa có dữ liệu</p>';
            return;
        }

        const addedPercent = ((added / total) * 100).toFixed(1);
        const spentPercent = ((spent / total) * 100).toFixed(1);

        legend.innerHTML = `
            <div class="legend-item">
                <div class="legend-color" style="background-color: #198754;"></div>
                <span>Nạp vào (${addedPercent}%)</span>
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #dc3545;"></div>
                <span>Chi tiêu (${spentPercent}%)</span>
            </div>
        `;
    }

    function updateDetailedTable(data) {
        const tbody = document.getElementById('detailedStatsTable');

        // Mock data for detailed table (replace with real API call)
        const tableData = generateMockTableData();

        tbody.innerHTML = tableData.map(row => `
            <tr>
                <td><strong>${row.month}</strong></td>
                <td class="text-end text-success">${formatCurrency(row.added)}</td>
                <td class="text-end text-danger">${formatCurrency(row.spent)}</td>
                <td class="text-end ${row.net >= 0 ? 'text-success' : 'text-danger'}">
                    ${formatCurrency(row.net)}
                </td>
                <td class="text-center">
                    <span class="badge bg-secondary">${row.transactions}</span>
                </td>
                <td class="text-center">
                    <span class="status-badge ${row.status.class}">${row.status.text}</span>
                </td>
            </tr>
        `).join('');
    }

    // Helper functions
    function generateMonthLabels(count) {
        const months = [];
        const now = new Date();

        for (let i = count - 1; i >= 0; i--) {
            const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
            months.push(date.toLocaleDateString('vi-VN', { month: 'short', year: '2-digit' }));
        }

        return months;
    }

    function generateMockTableData() {
        const data = [];
        const now = new Date();

        for (let i = 5; i >= 0; i--) {
            const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
            const added = Math.random() * 3000000;
            const spent = Math.random() * 2000000;
            const net = added - spent;
            const transactions = Math.floor(Math.random() * 20) + 5;

            let status;
            if (net > 500000) {
                status = { class: 'status-positive', text: 'Tốt' };
            } else if (net < -200000) {
                status = { class: 'status-negative', text: 'Cần chú ý' };
            } else {
                status = { class: 'status-neutral', text: 'Bình thường' };
            }

            data.push({
                month: date.toLocaleDateString('vi-VN', { month: 'long', year: 'numeric' }),
                added: added,
                spent: spent,
                net: net,
                transactions: transactions,
                status: status
            });
        }

        return data;
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(Math.abs(amount)) + ' VNĐ';
    }

    function formatCurrencyShort(amount) {
        const absAmount = Math.abs(amount);
        if (absAmount >= 1000000) {
            return (absAmount / 1000000).toFixed(1) + 'M';
        } else if (absAmount >= 1000) {
            return (absAmount / 1000).toFixed(0) + 'K';
        }
        return absAmount.toString();
    }

    function showLoadingStates() {
        // Add loading class to stats cards
        document.querySelectorAll('.stats-card').forEach(card => {
            card.classList.add('loading');
        });

        // Show loading in table
        const tbody = document.getElementById('detailedStatsTable');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function hideLoadingStates() {
        document.querySelectorAll('.stats-card').forEach(card => {
            card.classList.remove('loading');
        });
    }

    function showErrorState(message) {
        const tbody = document.getElementById('detailedStatsTable');
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4 text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${message}
                </td>
            </tr>
        `;
    }
}

// Global functions
function exportStats() {
    // Create export data
    const exportData = {
        date: new Date().toLocaleDateString('vi-VN'),
        balance: document.getElementById('currentBalanceStats').textContent,
        monthly_added: document.getElementById('monthlyAddedStats').textContent,
        monthly_spent: document.getElementById('monthlySpentStats').textContent,
        net_change: document.getElementById('netChangeStats').textContent,
        transactions: document.getElementById('transactionsCountStats').textContent
    };

    // Create and download file
    const dataStr = JSON.stringify(exportData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);

    const link = document.createElement('a');
    link.href = url;
    link.download = `fund-stats-${new Date().toISOString().slice(0, 10)}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    showToast('Xuất báo cáo thành công!', 'success');
}

function shareStats() {
    const balance = document.getElementById('currentBalanceStats').textContent;
    const monthlyAdded = document.getElementById('monthlyAddedStats').textContent;
    const monthlySpent = document.getElementById('monthlySpentStats').textContent;

    const shareText = `📊 Thống kê quỹ tháng ${new Date().getMonth() + 1}:
💰 Số dư hiện tại: ${balance}
📈 Nạp trong tháng: ${monthlyAdded}
📉 Chi trong tháng: ${monthlySpent}

#QuanLyQuy #ThongKe`;

    if (navigator.share) {
        navigator.share({
            title: 'Thống kê quỹ',
            text: shareText,
            url: window.location.href
        }).then(() => {
            showToast('Chia sẻ thành công!', 'success');
        }).catch(() => {
            fallbackShare(shareText);
        });
    } else {
        fallbackShare(shareText);
    }
}

function fallbackShare(text) {
    // Copy to clipboard as fallback
    navigator.clipboard.writeText(text).then(() => {
        showToast('Đã sao chép thống kê vào clipboard!', 'success');
    }).catch(() => {
        showToast('Không thể chia sẻ. Vui lòng thử lại.', 'error');
    });
}

// Auto refresh stats every 5 minutes
setInterval(function() {
    if (document.getElementById('fundStats') && document.visibilityState === 'visible') {
        document.getElementById('refreshStatsBtn')?.click();
    }
}, 5 * 60 * 1000);

// Initialize Chart.js if not already loaded
if (typeof Chart === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.9.1/chart.min.js';
    script.onload = function() {
        // Charts will be initialized when data is loaded
    };
    document.head.appendChild(script);
}
</script>

@extends('layouts.app')

@section('title', 'Lịch sử Giao dịch')

@section('body-class', 'funds-history-page')

@push('head')
<!-- Custom Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<!-- Chart.js for mini charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.9.1/chart.min.js"></script>
@endpush

@push('styles')
<style>
    /* Funds History Page Styles */
    .funds-history-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    .history-container {
        padding: 1rem 0;
        max-width: 100%;
    }

    /* Page Header */
    .history-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -1rem -15px 2rem -15px;
        padding: 2rem;
        border-radius: 0 0 24px 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .history-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="lines" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M0,40 L40,0 M-10,10 L10,-10 M30,50 L50,30" stroke="white" stroke-opacity="0.05" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23lines)"/></svg>');
        animation: slide 15s linear infinite;
    }

    @keyframes slide {
        0% { transform: translateX(0); }
        100% { transform: translateX(40px); }
    }

    .history-header-content {
        position: relative;
        z-index: 2;
    }

    .history-title {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .history-title h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .history-title .title-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        backdrop-filter: blur(10px);
    }

    /* Period Selector */
    .period-selector {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .period-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .period-label {
        font-size: 1.2rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .period-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .period-nav-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .period-nav-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .period-nav-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .period-dropdown {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 600;
        backdrop-filter: blur(10px);
        cursor: pointer;
    }

    .period-dropdown option {
        background: #2d3748;
        color: white;
    }

    /* Monthly Stats Cards */
    .monthly-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color, #667eea), var(--card-color-light, #764ba2));
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-card.total-added {
        --card-color: #10b981;
        --card-color-light: #34d399;
    }

    .stat-card.total-spent {
        --card-color: #f59e0b;
        --card-color-light: #fbbf24;
    }

    .stat-card.net-change {
        --card-color: #3b82f6;
        --card-color-light: #60a5fa;
    }

    .stat-card.transactions-count {
        --card-color: #8b5cf6;
        --card-color-light: #a78bfa;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--card-color);
        background: rgba(var(--card-color-rgb, 102, 126, 234), 0.1);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .stat-change.positive {
        color: #059669;
    }

    .stat-change.negative {
        color: #dc2626;
    }

    .stat-change.neutral {
        color: #6b7280;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filter-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-content {
        padding: 1.5rem;
    }

    .filter-controls {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
        align-items: end;
    }

    /* Transaction History Section */
    .history-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .history-header-section {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .history-section-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Transaction Table */
    .transaction-table-wrapper {
        position: relative;
    }

    .transaction-table {
        width: 100%;
        margin: 0;
    }

    .transaction-table th {
        background: #f8f9fa;
        border: none;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem 0.75rem;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .transaction-table td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f1f3f4;
        vertical-align: middle;
    }

    .transaction-row {
        transition: all 0.2s ease;
    }

    .transaction-row:hover {
        background: #f8f9fa;
    }

    .transaction-date {
        font-weight: 600;
        color: #374151;
    }

    .transaction-date small {
        color: #6b7280;
        font-weight: 400;
        display: block;
        margin-top: 0.25rem;
    }

    .transaction-type {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .transaction-type.add {
        background: #d1f2eb;
        color: #0d5430;
        border: 1px solid #a7f3d0;
    }

    .transaction-type.subtract {
        background: #fed7d7;
        color: #9b2c2c;
        border: 1px solid #fca5a5;
    }

    .transaction-description {
        color: #374151;
        font-weight: 500;
    }

    .transaction-description small {
        color: #6b7280;
        display: block;
        margin-top: 0.25rem;
    }

    .transaction-amount {
        font-weight: 800;
        font-size: 1.1rem;
    }

    .transaction-amount.positive {
        color: #059669;
    }

    .transaction-amount.negative {
        color: #dc2626;
    }

    .balance-after {
        font-weight: 600;
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    /* Loading State */
    .loading-state {
        text-align: center;
        padding: 3rem;
    }

    .loading-spinner {
        width: 48px;
        height: 48px;
        border: 4px solid #e5e7eb;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Pagination */
    .history-pagination {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Export Actions */
    .export-section {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .export-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .export-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .export-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .export-option:hover {
        border-color: #667eea;
        background: #f8f9fa;
    }

    .export-option-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #667eea;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .export-option-content h6 {
        font-weight: 600;
        color: #374151;
        margin: 0 0 0.25rem 0;
    }

    .export-option-content p {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
    }

    /* Mini Chart */
    .mini-chart-container {
        height: 100px;
        width: 150px;
        margin-left: auto;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .history-header {
            margin: -1rem -1rem 1.5rem -1rem;
            padding: 1.5rem;
        }

        .history-title {
            flex-direction: column;
            text-align: center;
        }

        .history-title h1 {
            font-size: 2rem;
        }

        .period-selector {
            flex-direction: column;
            align-items: stretch;
        }

        .monthly-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .filter-controls {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            justify-content: stretch;
        }

        .filter-actions .btn {
            flex: 1;
        }

        .transaction-table {
            font-size: 0.875rem;
        }

        .transaction-table th,
        .transaction-table td {
            padding: 0.75rem 0.5rem;
        }

        .history-pagination {
            flex-direction: column;
            gap: 1rem;
        }

        .export-options {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .monthly-stats {
            grid-template-columns: 1fr;
        }

        .history-title .title-icon {
            width: 56px;
            height: 56px;
            font-size: 1.8rem;
        }

        .history-title h1 {
            font-size: 1.8rem;
        }
    }

    /* Dark Theme Support */
    @media (prefers-color-scheme: dark) {
        .funds-history-page {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }

        .stat-card,
        .filter-section,
        .history-section,
        .export-section {
            background: #2d3748;
            border-color: #4a5568;
            color: #f7fafc;
        }

        .filter-header,
        .history-header-section {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            border-bottom-color: #6b7280;
        }

        .filter-title,
        .history-section-title,
        .export-title {
            color: #f7fafc;
        }

        .transaction-table th {
            background: #374151;
            color: #e5e7eb;
        }

        .transaction-table td {
            border-bottom-color: #4a5568;
            color: #e5e7eb;
        }

        .transaction-row:hover {
            background: #374151;
        }

        .export-option {
            background: #374151;
            border-color: #4a5568;
        }

        .export-option:hover {
            background: #4b5563;
            border-color: #667eea;
        }
    }
</style>
@endpush

@section('content')
<div class="history-container">
    <!-- History Header -->
    <div class="history-header">
        <div class="history-header-content">
            <div class="history-title">
                <div class="title-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <h1>Lịch sử Giao dịch</h1>
                </div>
            </div>

            <!-- Period Selector -->
            <div class="period-selector">
                <div class="period-info">
                    <div class="period-label">
                        <i class="bi bi-calendar-month me-2"></i>
                        Tháng {{ sprintf('%02d/%04d', $month, $year) }}
                    </div>
                </div>

                <div class="period-controls">
                    <form method="GET" id="periodForm" style="display: none;">
                        <input type="hidden" name="month" id="hiddenMonth" value="{{ $month }}">
                        <input type="hidden" name="year" id="hiddenYear" value="{{ $year }}">
                    </form>

                    <button class="period-nav-btn" onclick="navigatePeriod('prev')"
                            title="Tháng trước"
                            {{ ($year <= 2020 && $month <= 1) ? 'disabled' : '' }}>
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <select class="period-dropdown" onchange="navigateToMonth(this.value)">
                        @if(isset($availableMonths) && $availableMonths->count() > 0)
                            @foreach($availableMonths as $monthData)
                            <option value="{{ $monthData['month'] }}-{{ $monthData['year'] }}"
                                    {{ ($monthData['month'] == $month && $monthData['year'] == $year) ? 'selected' : '' }}>
                                {{ $monthData['label'] }}
                            </option>
                            @endforeach
                        @else
                            <option value="{{ $month }}-{{ $year }}">{{ sprintf('%02d/%04d', $month, $year) }}</option>
                        @endif
                    </select>

                    <button class="period-nav-btn" onclick="navigatePeriod('next')"
                            title="Tháng sau"
                            {{ ($year >= now()->year && $month >= now()->month) ? 'disabled' : '' }}>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="monthly-stats">
        <div class="stat-card total-added">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="addedChart"></canvas>
                </div>
            </div>
            <div class="stat-value" id="totalAdded">
                {{ number_format($monthlyStats['total_added'] ?? 0) }}
            </div>
            <div class="stat-label">Tổng Nạp (VNĐ)</div>
            <div class="stat-change positive">
                <i class="bi bi-arrow-up"></i>
                <span>+15% so với tháng trước</span>
            </div>
        </div>

        <div class="stat-card total-spent">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="spentChart"></canvas>
                </div>
            </div>
            <div class="stat-value" id="totalSpent">
                {{ number_format(abs($monthlyStats['total_spent'] ?? 0)) }}
            </div>
            <div class="stat-label">Tổng Chi (VNĐ)</div>
            <div class="stat-change negative">
                <i class="bi bi-arrow-down"></i>
                <span>-8% so với tháng trước</span>
            </div>
        </div>

        <div class="stat-card net-change">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
            <div class="stat-value {{ ($monthlyStats['net_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}" id="netChange">
                {{ ($monthlyStats['net_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($monthlyStats['net_change'] ?? 0) }}
            </div>
            <div class="stat-label">Thay Đổi Ròng (VNĐ)</div>
            <div class="stat-change {{ ($monthlyStats['net_change'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="bi bi-{{ ($monthlyStats['net_change'] ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                <span>{{ ($monthlyStats['net_change'] ?? 0) >= 0 ? 'Tích cực' : 'Cần cải thiện' }}</span>
            </div>
        </div>

        <div class="stat-card transactions-count">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="bi bi-list-ul"></i>
                </div>
            </div>
            <div class="stat-value" id="transactionCount">
                {{ $monthlyStats['transactions_count'] ?? 0 }}
            </div>
            <div class="stat-label">Giao Dịch</div>
            <div class="stat-change positive">
                <i class="bi bi-arrow-up"></i>
                <span>Hoạt động bình thường</span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <div class="filter-title">
                <i class="bi bi-funnel"></i>
                Bộ Lọc
            </div>
            <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                <i class="bi bi-x-lg me-1"></i>Xóa bộ lọc
            </button>
        </div>
        <div class="filter-content">
            <form method="GET" id="filterForm">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <div class="filter-controls">
                    <div class="filter-group">
                        <label>Tìm kiếm</label>
                        <input type="text" class="form-control" name="search"
                               value="{{ request('search') }}"
                               placeholder="Tìm theo mô tả...">
                    </div>

                    <div class="filter-group">
                        <label>Loại giao dịch</label>
                        <select class="form-select" name="type">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Tất cả</option>
                            <option value="add" {{ request('type') == 'add' ? 'selected' : '' }}>Nạp tiền</option>
                            <option value="subtract" {{ request('type') == 'subtract' ? 'selected' : '' }}>Chi tiêu</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Số tiền từ</label>
                        <input type="number" class="form-control" name="min_amount"
                               value="{{ request('min_amount') }}"
                               placeholder="VNĐ" min="0">
                    </div>

                    <div class="filter-group">
                        <label>Số tiền đến</label>
                        <input type="number" class="form-control" name="max_amount"
                               value="{{ request('max_amount') }}"
                               placeholder="VNĐ" min="0">
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>Lọc
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="history-section">
        <div class="history-header-section">
            <div class="history-section-title">
                <i class="bi bi-journal-text"></i>
                Danh Sách Giao Dịch
                <span class="badge bg-primary ms-2">{{ $transactions->count() }}</span>
            </div>
            <div class="history-section-actions">
                <button class="btn btn-sm btn-outline-primary" onclick="refreshTransactions()"
                        id="refreshBtn" title="Làm mới">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                            data-bs-toggle="dropdown" title="Tùy chọn xem">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="changeView('table')">
                            <i class="bi bi-table me-2"></i>Dạng bảng
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="changeView('timeline')">
                            <i class="bi bi-clock-history me-2"></i>Dạng timeline
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="transaction-table-wrapper">
            @if($transactions->count() > 0)
                <!-- Table View -->
                <div id="tableView">
                    <table class="table transaction-table">
                        <thead>
                            <tr>
                                <th width="15%">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-reset d-flex align-items-center">
                                        Ngày & Giờ
                                        <i class="bi bi-arrow-{{ request('sort') == 'date' && request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                    </a>
                                </th>
                                <th width="12%">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-reset d-flex align-items-center">
                                        Loại
                                        <i class="bi bi-arrow-{{ request('sort') == 'type' && request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                    </a>
                                </th>
                                <th width="35%">Mô tả</th>
                                <th width="15%" class="text-end">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'amount', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none text-reset d-flex align-items-center justify-content-end">
                                        Số tiền
                                        <i class="bi bi-arrow-{{ request('sort') == 'amount' && request('direction') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                    </a>
                                </th>
                                <th width="15%" class="text-end">Số dư sau GD</th>
                                <th width="8%" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr class="transaction-row" data-id="{{ $transaction->id }}">
                                <td>
                                    <div class="transaction-date">
                                        {{ $transaction->created_at->format('d/m/Y') }}
                                        <small>{{ $transaction->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="transaction-type {{ $transaction->type }}">
                                        <i class="bi bi-{{ $transaction->type === 'add' ? 'plus' : 'dash' }}-circle"></i>
                                        {{ $transaction->type === 'add' ? 'Nạp' : 'Chi' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="transaction-description">
                                        {{ $transaction->description }}
                                        @if($transaction->shoppingTrip)
                                            <small>
                                                <i class="bi bi-cart me-1"></i>
                                                <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}"
                                                   class="text-decoration-none">
                                                    Đi chợ ngày {{ $transaction->shoppingTrip->shopping_date->format('d/m/Y') }}
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="transaction-amount {{ $transaction->type === 'add' ? 'positive' : 'negative' }}">
                                        {{ $transaction->type === 'add' ? '+' : '-' }}{{ number_format(abs($transaction->amount)) }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="balance-after">
                                        {{ number_format($transaction->running_balance ?? 0) }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        @if($transaction->shoppingTrip)
                                            <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}"
                                               class="btn btn-outline-info btn-sm" title="Xem chi tiết đi chợ">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                        <button class="btn btn-outline-secondary btn-sm"
                                                onclick="showTransactionDetails('{{ $transaction->id }}')"
                                                title="Chi tiết giao dịch">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Timeline View (Initially Hidden) -->
                <div id="timelineView" style="display: none;">
                    <div class="timeline-container p-4">
                        @php
                            $groupedTransactions = $transactions->groupBy(function($transaction) {
                                return $transaction->created_at->format('Y-m-d');
                            });
                        @endphp

                        @foreach($groupedTransactions as $date => $dayTransactions)
                        <div class="timeline-day mb-4">
                            <div class="timeline-date-header mb-3">
                                <h6 class="fw-bold mb-1">
                                    {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                </h6>
                                <small class="text-muted">{{ $dayTransactions->count() }} giao dịch</small>
                            </div>

                            <div class="timeline-items">
                                @foreach($dayTransactions as $transaction)
                                <div class="timeline-item d-flex mb-3">
                                    <div class="timeline-marker me-3 mt-1">
                                        <div class="timeline-dot bg-{{ $transaction->type === 'add' ? 'success' : 'warning' }}"></div>
                                    </div>
                                    <div class="timeline-content flex-grow-1">
                                        <div class="timeline-header d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <span class="transaction-type {{ $transaction->type }}">
                                                    <i class="bi bi-{{ $transaction->type === 'add' ? 'plus' : 'dash' }}-circle"></i>
                                                    {{ $transaction->type === 'add' ? 'Nạp tiền' : 'Chi tiêu' }}
                                                </span>
                                                <small class="text-muted ms-2">{{ $transaction->created_at->format('H:i') }}</small>
                                            </div>
                                            <div class="transaction-amount {{ $transaction->type === 'add' ? 'positive' : 'negative' }}">
                                                {{ $transaction->type === 'add' ? '+' : '-' }}{{ number_format(abs($transaction->amount)) }} VNĐ
                                            </div>
                                        </div>
                                        <div class="timeline-description">
                                            {{ $transaction->description }}
                                        </div>
                                        @if($transaction->shoppingTrip)
                                            <div class="timeline-extra mt-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-cart me-1"></i>
                                                    <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}"
                                                       class="text-decoration-none">
                                                        Xem chi tiết đi chợ
                                                    </a>
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <div class="empty-title">Không có giao dịch nào</div>
                    <div class="empty-text">
                        Không tìm thấy giao dịch nào trong tháng {{ sprintf('%02d/%04d', $month, $year) }}.
                        <br>Hãy thử chọn tháng khác hoặc thêm giao dịch mới.
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary me-2" onclick="showAddFundModal()">
                            <i class="bi bi-plus-circle me-1"></i>Nạp quỹ
                        </button>
                        <a href="{{ route('shopping.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-cart-plus me-1"></i>Đi chợ
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if($transactions->count() > 0)
        <!-- Pagination -->
        <div class="history-pagination">
            <div class="pagination-info">
                Hiển thị {{ $transactions->count() }} giao dịch trong tháng {{ sprintf('%02d/%04d', $month, $year) }}
            </div>
            <div class="pagination-actions">
                <a href="{{ route('export.monthly', ['month' => $month, 'year' => $year]) }}"
                   class="btn btn-sm btn-outline-success">
                    <i class="bi bi-download me-1"></i>Xuất Excel
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Export Options -->
    @if($transactions->count() > 0)
    <div class="export-section">
        <div class="export-title">
            <i class="bi bi-download"></i>
            Xuất Báo Cáo
        </div>
        <div class="export-options">
            <div class="export-option" onclick="exportMonthly()">
                <div class="export-option-icon">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </div>
                <div class="export-option-content">
                    <h6>Báo cáo tháng</h6>
                    <p>Xuất chi tiết các giao dịch trong tháng này</p>
                </div>
            </div>

            <div class="export-option" onclick="exportSummary()">
                <div class="export-option-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <div class="export-option-content">
                    <h6>Tóm tắt thống kê</h6>
                    <p>Báo cáo tổng hợp và biểu đồ</p>
                </div>
            </div>

            <div class="export-option" onclick="exportPDF()">
                <div class="export-option-icon">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div class="export-option-content">
                    <h6>Báo cáo PDF</h6>
                    <p>Định dạng PDF để in hoặc chia sẻ</p>
                </div>
            </div>

            <div class="export-option" onclick="shareReport()">
                <div class="export-option-icon">
                    <i class="bi bi-share"></i>
                </div>
                <div class="export-option-content">
                    <h6>Chia sẻ</h6>
                    <p>Gửi qua email hoặc tin nhắn</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-info-circle me-2"></i>
                    Chi Tiết Giao Dịch
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="transactionDetailsContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Fund Modal Component -->
@include('funds.components.add-fund-modal')
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeHistoryPage();
});

function initializeHistoryPage() {
    // Initialize mini charts
    initializeMiniCharts();

    // Initialize animations
    initializeAnimations();

    // Initialize periodic refresh
    initializePeriodicRefresh();

    // Add loading states
    addLoadingStates();
}

function initializeMiniCharts() {
    // Added chart
    const addedCtx = document.getElementById('addedChart');
    if (addedCtx) {
        new Chart(addedCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [1500000, 1800000, 2000000, 1700000, 2200000, {{ $monthlyStats['total_added'] ?? 0 }}],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }

    // Spent chart
    const spentCtx = document.getElementById('spentChart');
    if (spentCtx) {
        new Chart(spentCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [1200000, 1500000, 1300000, 1800000, 1600000, {{ abs($monthlyStats['total_spent'] ?? 0) }}],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }
}

function initializeAnimations() {
    // Animate stat values on page load
    animateStatValues();

    // Add entrance animations
    const elements = document.querySelectorAll('.stat-card, .filter-section, .history-section');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';

        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

function animateStatValues() {
    const statElements = [
        { id: 'totalAdded', target: {{ $monthlyStats['total_added'] ?? 0 }} },
        { id: 'totalSpent', target: {{ abs($monthlyStats['total_spent'] ?? 0) }} },
        { id: 'netChange', target: {{ $monthlyStats['net_change'] ?? 0 }} },
        { id: 'transactionCount', target: {{ $monthlyStats['transactions_count'] ?? 0 }} }
    ];

    statElements.forEach(stat => {
        const element = document.getElementById(stat.id);
        if (element) {
            animateNumber(element, 0, stat.target, 1000);
        }
    });
}

function animateNumber(element, start, end, duration) {
    const startTime = Date.now();
    const isCount = element.id === 'transactionCount';

    function update() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const current = Math.floor(start + (end - start) * progress);

        if (isCount) {
            element.textContent = current;
        } else {
            element.textContent = new Intl.NumberFormat('vi-VN').format(current);
        }

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    update();
}

function initializePeriodicRefresh() {
    // Auto-refresh every 5 minutes
    setInterval(refreshTransactions, 5 * 60 * 1000);
}

function addLoadingStates() {
    // Add loading classes for better UX
    const buttons = document.querySelectorAll('button[onclick]');
    buttons.forEach(btn => {
        const originalOnclick = btn.getAttribute('onclick');
        btn.addEventListener('click', function() {
            if (!this.disabled) {
                this.disabled = true;
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';

                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = originalContent;
                }, 2000);
            }
        });
    });
}

// Navigation functions
function navigatePeriod(direction) {
    const currentMonth = {{ $month }};
    const currentYear = {{ $year }};

    let newMonth, newYear;

    if (direction === 'next') {
        if (currentMonth === 12) {
            newMonth = 1;
            newYear = currentYear + 1;
        } else {
            newMonth = currentMonth + 1;
            newYear = currentYear;
        }

        // Don't go beyond current month
        const now = new Date();
        if (newYear > now.getFullYear() || (newYear === now.getFullYear() && newMonth > now.getMonth() + 1)) {
            return;
        }
    } else {
        if (currentMonth === 1) {
            newMonth = 12;
            newYear = currentYear - 1;
        } else {
            newMonth = currentMonth - 1;
            newYear = currentYear;
        }

        // Don't go before 2020
        if (newYear < 2020) {
            return;
        }
    }

    window.location.href = `{{ route('funds.history') }}?month=${newMonth}&year=${newYear}`;
}

function navigateToMonth(monthYear) {
    const [month, year] = monthYear.split('-');
    window.location.href = `{{ route('funds.history') }}?month=${month}&year=${year}`;
}

// View functions
function changeView(viewType) {
    const tableView = document.getElementById('tableView');
    const timelineView = document.getElementById('timelineView');

    if (viewType === 'table') {
        tableView.style.display = 'block';
        timelineView.style.display = 'none';
    } else if (viewType === 'timeline') {
        tableView.style.display = 'none';
        timelineView.style.display = 'block';
    }
}

// Filter functions
function clearFilters() {
    const form = document.getElementById('filterForm');
    const inputs = form.querySelectorAll('input[type="text"], input[type="number"], select');

    inputs.forEach(input => {
        if (input.name !== 'month' && input.name !== 'year') {
            if (input.type === 'select-one') {
                input.selectedIndex = 0;
            } else {
                input.value = '';
            }
        }
    });

    form.submit();
}

// Transaction details
function showTransactionDetails(transactionId) {
    const modal = new bootstrap.Modal(document.getElementById('transactionDetailsModal'));
    const content = document.getElementById('transactionDetailsContent');

    // Show loading
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
        </div>
    `;

    modal.show();

    // Find transaction data from current page
    const transactionRow = document.querySelector(`[data-id="${transactionId}"]`);
    if (transactionRow) {
        // Extract data from the row
        const cells = transactionRow.querySelectorAll('td');
        const date = cells[0].textContent.trim();
        const type = cells[1].textContent.trim();
        const description = cells[2].textContent.trim();
        const amount = cells[3].textContent.trim();
        const balance = cells[4].textContent.trim();

        setTimeout(() => {
            content.innerHTML = `
                <div class="transaction-detail-card">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ngày & Giờ:</label>
                            <div class="form-control-plaintext">${date}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Loại giao dịch:</label>
                            <div class="form-control-plaintext">${type}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Mô tả:</label>
                            <div class="form-control-plaintext">${description}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số tiền:</label>
                            <div class="form-control-plaintext fw-bold">${amount} VNĐ</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Số dư sau giao dịch:</label>
                            <div class="form-control-plaintext">${balance} VNĐ</div>
                        </div>
                    </div>
                </div>
            `;
        }, 500);
    }
}

// Refresh function
function refreshTransactions() {
    window.location.reload();
}

// Export functions
function exportMonthly() {
    const url = `{{ route('export.monthly', ['month' => $month, 'year' => $year]) }}`;
    window.open(url, '_blank');
    showToast('Đang tạo file Excel...', 'info');
}

function exportSummary() {
    const url = `{{ route('export.summary', ['month' => $month, 'year' => $year]) }}`;
    window.open(url, '_blank');
    showToast('Đang tạo báo cáo tóm tắt...', 'info');
}

function exportPDF() {
    // Convert current page to PDF
    showToast('Tính năng xuất PDF đang được phát triển...', 'info');
}

function shareReport() {
    const shareData = {
        title: `Báo cáo quỹ tháng {{ sprintf('%02d/%04d', $month, $year) }}`,
        text: `📊 Báo cáo quỹ tháng {{ sprintf('%02d/%04d', $month, $year) }}:
💰 Tổng nạp: {{ number_format($monthlyStats['total_added'] ?? 0) }} VNĐ
💸 Tổng chi: {{ number_format(abs($monthlyStats['total_spent'] ?? 0)) }} VNĐ
📈 Thay đổi ròng: {{ ($monthlyStats['net_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($monthlyStats['net_change'] ?? 0) }} VNĐ
📋 Số giao dịch: {{ $monthlyStats['transactions_count'] ?? 0 }}

#QuanLyQuy #BaoCao`,
        url: window.location.href
    };

    if (navigator.share) {
        navigator.share(shareData).then(() => {
            showToast('Chia sẻ thành công!', 'success');
        }).catch(() => {
            fallbackShare(shareData.text);
        });
    } else {
        fallbackShare(shareData.text);
    }
}

function fallbackShare(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Đã sao chép báo cáo vào clipboard!', 'success');
    }).catch(() => {
        showToast('Không thể chia sẻ. Vui lòng thử lại.', 'error');
    });
}

// CSS for animations
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    .spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .timeline-item {
        position: relative;
    }

    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 11px;
        top: 20px;
        bottom: -16px;
        width: 2px;
        background: #e5e7eb;
    }
`;
document.head.appendChild(animationStyles);
</script>
@endpush

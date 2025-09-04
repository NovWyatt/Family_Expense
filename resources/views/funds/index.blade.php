@extends('layouts.app')

@section('title', 'Quản lý Quỹ')

@section('body-class', 'funds-page')

@push('head')
<!-- Chart.js for statistics -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.9.1/chart.min.js"></script>
<!-- Custom Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@push('styles')
<style>
    /* Funds Page Specific Styles */
    .funds-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .funds-container {
        padding: 1rem 0;
        max-width: 100%;
    }

    /* Page Header */
    .funds-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -1rem -15px 2rem -15px;
        padding: 2.5rem 2rem;
        border-radius: 0 0 24px 24px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }

    .funds-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23dots)"/></svg>');
        animation: drift 20s ease-in-out infinite;
    }

    @keyframes drift {
        0%, 100% { transform: translateX(0) translateY(0); }
        50% { transform: translateX(10px) translateY(-10px); }
    }

    .funds-header-content {
        position: relative;
        z-index: 2;
    }

    .funds-title {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .funds-title h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        font-family: 'Inter', sans-serif;
    }

    .funds-title .title-icon {
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

    .funds-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        font-weight: 300;
    }

    /* Balance Overview Cards */
    .balance-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .balance-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .balance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { background-position: 200% 0; }
        50% { background-position: -200% 0; }
    }

    .balance-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .balance-icon {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        flex-shrink: 0;
    }

    .balance-info {
        flex-grow: 1;
    }

    .balance-amount {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        line-height: 1;
    }

    .balance-label {
        font-size: 1rem;
        opacity: 0.8;
        font-weight: 500;
    }

    .balance-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }

    /* Quick Actions */
    .funds-quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .quick-action-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 1.2rem 1.5rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .quick-action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        color: white;
    }

    .quick-action-btn i {
        font-size: 1.2rem;
    }

    /* Main Content Sections */
    .funds-main-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        margin-top: 2rem;
    }

    .content-section {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-header {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: between;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .section-title i {
        font-size: 1.6rem;
        color: #667eea;
    }

    .section-actions {
        display: flex;
        gap: 0.5rem;
    }

    .section-content {
        padding: 0;
    }

    /* Statistics Section */
    .stats-section {
        margin-bottom: 2rem;
    }

    /* Transaction List Section */
    .transactions-section {
        margin-bottom: 2rem;
    }

    /* Tabs Navigation */
    .funds-tabs {
        background: white;
        border-radius: 16px 16px 0 0;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 0;
    }

    .funds-tabs .nav-tabs {
        border: none;
        padding: 0 1.5rem;
    }

    .funds-tabs .nav-link {
        border: none;
        padding: 1.2rem 1.5rem;
        color: #6c757d;
        font-weight: 600;
        border-radius: 12px 12px 0 0;
        margin-right: 0.5rem;
        transition: all 0.3s ease;
    }

    .funds-tabs .nav-link:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .funds-tabs .nav-link.active {
        background: #667eea;
        color: white;
        box-shadow: 0 -2px 12px rgba(102, 126, 234, 0.3);
    }

    /* Floating Action Button */
    .funds-fab {
        position: fixed;
        bottom: 90px;
        right: 2rem;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
    }

    .funds-fab:hover {
        transform: translateY(-4px) scale(1.1);
        box-shadow: 0 12px 40px rgba(102, 126, 234, 0.5);
    }

    .funds-fab:active {
        transform: translateY(-2px) scale(1.05);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .balance-overview {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .funds-header {
            margin: -1rem -1rem 1.5rem -1rem;
            padding: 2rem 1.5rem;
        }

        .funds-title h1 {
            font-size: 2rem;
        }

        .funds-title .title-icon {
            width: 56px;
            height: 56px;
            font-size: 1.8rem;
        }

        .balance-overview {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .balance-card {
            padding: 1.5rem;
        }

        .balance-amount {
            font-size: 2.2rem;
        }

        .funds-quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-action-btn {
            padding: 1rem;
            font-size: 0.9rem;
        }

        .section-header {
            padding: 1rem 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .funds-fab {
            bottom: 110px;
            right: 1rem;
            width: 56px;
            height: 56px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 576px) {
        .funds-header {
            padding: 1.5rem 1rem;
        }

        .funds-title {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .funds-title h1 {
            font-size: 1.8rem;
        }

        .funds-quick-actions {
            grid-template-columns: 1fr;
        }

        .balance-card {
            padding: 1.25rem;
        }

        .balance-icon {
            width: 64px;
            height: 64px;
            font-size: 2rem;
        }

        .balance-amount {
            font-size: 2rem;
        }
    }

    /* Dark Theme Support */
    @media (prefers-color-scheme: dark) {
        .funds-page {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        }

        .content-section {
            background: #2d3748;
            border-color: #4a5568;
        }

        .section-header {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            border-bottom-color: #6b7280;
        }

        .section-title {
            color: #f7fafc;
        }

        .funds-tabs {
            background: #2d3748;
        }

        .funds-tabs .nav-link {
            color: #a0aec0;
        }

        .funds-tabs .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #e2e8f0;
        }
    }

    /* Loading Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }

    /* Custom Scrollbar */
    .funds-container::-webkit-scrollbar {
        width: 6px;
    }

    .funds-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 3px;
    }

    .funds-container::-webkit-scrollbar-thumb {
        background: rgba(102, 126, 234, 0.3);
        border-radius: 3px;
    }

    .funds-container::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 126, 234, 0.5);
    }
</style>
@endpush

@section('content')
<div class="funds-container">
    <!-- Funds Header -->
    <div class="funds-header animate-fade-in-up">
        <div class="funds-header-content">
            <div class="funds-title">
                <div class="title-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <h1>Quản lý Quỹ</h1>
                    <div class="funds-subtitle">
                        Theo dõi và quản lý tài chính gia đình một cách thông minh
                    </div>
                </div>
            </div>

            <!-- Balance Overview Cards -->
            <div class="balance-overview">
                <div class="balance-card animate-fade-in-up animate-delay-1">
                    <div class="balance-icon">
                        <i class="bi bi-piggy-bank"></i>
                    </div>
                    <div class="balance-info">
                        <div class="balance-amount" id="headerCurrentBalance">
                            {{ number_format($currentBalance ?? 0) }}
                        </div>
                        <div class="balance-label">Số dư hiện tại</div>
                        <div class="balance-trend">
                            <i class="bi bi-graph-up text-success"></i>
                            <span>Ổn định</span>
                        </div>
                    </div>
                </div>

                <div class="balance-card animate-fade-in-up animate-delay-2">
                    <div class="balance-icon">
                        <i class="bi bi-arrow-up-circle"></i>
                    </div>
                    <div class="balance-info">
                        <div class="balance-amount" id="headerMonthlyAdded">
                            {{ number_format($monthlyStats['total_added'] ?? 0) }}
                        </div>
                        <div class="balance-label">Nạp tháng này</div>
                        <div class="balance-trend">
                            <i class="bi bi-arrow-up text-success"></i>
                            <span>+12% so với tháng trước</span>
                        </div>
                    </div>
                </div>

                <div class="balance-card animate-fade-in-up animate-delay-3">
                    <div class="balance-icon">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <div class="balance-info">
                        <div class="balance-amount" id="headerMonthlySpent">
                            {{ number_format($monthlyStats['total_spent'] ?? 0) }}
                        </div>
                        <div class="balance-label">Chi tháng này</div>
                        <div class="balance-trend">
                            <i class="bi bi-arrow-down text-info"></i>
                            <span>-8% so với tháng trước</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="funds-quick-actions animate-fade-in-up animate-delay-4">
                <button class="quick-action-btn" onclick="showAddFundModal()">
                    <i class="bi bi-plus-circle"></i>
                    <span>Nạp Quỹ</span>
                </button>

                <a href="{{ route('funds.history') }}" class="quick-action-btn">
                    <i class="bi bi-clock-history"></i>
                    <span>Lịch Sử</span>
                </a>

                <a href="{{ route('shopping.create') }}" class="quick-action-btn">
                    <i class="bi bi-cart-plus"></i>
                    <span>Đi Chợ</span>
                </a>

                <button class="quick-action-btn" onclick="exportFundsReport()">
                    <i class="bi bi-download"></i>
                    <span>Xuất Excel</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="funds-main-content">
        <!-- Tabbed Content -->
        <div class="funds-tabs animate-fade-in-up animate-delay-1">
            <ul class="nav nav-tabs" id="fundsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-pane" type="button" role="tab" aria-controls="overview-pane" aria-selected="true">
                        <i class="bi bi-graph-up me-2"></i>
                        Tổng Quan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions-pane" type="button" role="tab" aria-controls="transactions-pane" aria-selected="false">
                        <i class="bi bi-list-ul me-2"></i>
                        Giao Dịch
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics-pane" type="button" role="tab" aria-controls="analytics-pane" aria-selected="false">
                        <i class="bi bi-pie-chart me-2"></i>
                        Thống Kê
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="fundsTabContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview-pane" role="tabpanel" aria-labelledby="overview-tab">
                <!-- Fund Statistics Component -->
                <div class="content-section stats-section animate-fade-in-up animate-delay-2">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-bar-chart-line"></i>
                            Thống Kê Tổng Quan
                        </div>
                        <div class="section-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshStats()">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>
                    <div class="section-content">
                        @include('funds.components.fund-stats')
                    </div>
                </div>

                <!-- Recent Transactions Preview -->
                <div class="content-section animate-fade-in-up animate-delay-3">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-clock-history"></i>
                            Giao Dịch Gần Đây
                        </div>
                        <div class="section-actions">
                            <a href="{{ route('funds.history') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>
                                Xem tất cả
                            </a>
                        </div>
                    </div>
                    <div class="section-content">
                        <div class="recent-transactions-preview">
                            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Loại</th>
                                                <th>Mô tả</th>
                                                <th class="text-end">Số tiền</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTransactions->take(5) as $transaction)
                                            <tr>
                                                <td>
                                                    <div class="text-sm">
                                                        <div>{{ $transaction->created_at->format('d/m/Y') }}</div>
                                                        <div class="text-muted small">{{ $transaction->created_at->format('H:i') }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $transaction->type === 'add' ? 'bg-success' : 'bg-danger' }}">
                                                        <i class="bi bi-{{ $transaction->type === 'add' ? 'plus' : 'dash' }}-circle me-1"></i>
                                                        {{ $transaction->type === 'add' ? 'Nạp' : 'Chi' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div>{{ Str::limit($transaction->description, 40) }}</div>
                                                    @if($transaction->shoppingTrip)
                                                        <small class="text-muted">
                                                            <i class="bi bi-cart me-1"></i>
                                                            Đi chợ ngày {{ $transaction->shoppingTrip->shopping_date->format('d/m') }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <span class="fw-bold {{ $transaction->type === 'add' ? 'text-success' : 'text-danger' }}">
                                                        {{ $transaction->type === 'add' ? '+' : '-' }}{{ number_format(abs($transaction->amount)) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($transaction->shoppingTrip)
                                                        <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}"
                                                           class="btn btn-sm btn-outline-info">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                                            <i class="bi bi-info-circle"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <h6 class="mt-3 text-muted">Chưa có giao dịch nào</h6>
                                    <p class="text-muted">Hãy bắt đầu bằng việc nạp quỹ!</p>
                                    <button class="btn btn-primary" onclick="showAddFundModal()">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Nạp quỹ ngay
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Tab -->
            <div class="tab-pane fade" id="transactions-pane" role="tabpanel" aria-labelledby="transactions-tab">
                <div class="content-section transactions-section">
                    <div class="section-content">
                        @include('funds.components.transaction-list')
                    </div>
                </div>
            </div>

            <!-- Analytics Tab -->
            <div class="tab-pane fade" id="analytics-pane" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="content-section">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="bi bi-graph-up-arrow"></i>
                            Phân Tích Chi Tiết
                        </div>
                        <div class="section-actions">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-secondary" onclick="exportAnalytics()">
                                    <i class="bi bi-download"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" onclick="shareAnalytics()">
                                    <i class="bi bi-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="section-content">
                        <div class="analytics-content p-4">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="analytics-card">
                                        <h6 class="analytics-title">
                                            <i class="bi bi-calendar-month me-2"></i>
                                            Xu Hướng 6 Tháng Gần Đây
                                        </h6>
                                        <canvas id="monthlyTrendChart" height="200"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="analytics-card">
                                        <h6 class="analytics-title">
                                            <i class="bi bi-pie-chart me-2"></i>
                                            Phân Bố Thu Chi
                                        </h6>
                                        <canvas id="incomeExpenseChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Detailed Analytics Tables -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="analytics-table">
                                        <h6 class="analytics-title mb-3">
                                            <i class="bi bi-table me-2"></i>
                                            Báo Cáo Chi Tiết Theo Tháng
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Tháng</th>
                                                        <th class="text-end">Nạp vào</th>
                                                        <th class="text-end">Chi tiêu</th>
                                                        <th class="text-end">Thay đổi ròng</th>
                                                        <th class="text-center">Số GD</th>
                                                        <th class="text-center">Trạng thái</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="analyticsTableBody">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<button class="funds-fab animate-fade-in-up animate-delay-4" onclick="showAddFundModal()" title="Nạp quỹ nhanh">
    <i class="bi bi-plus-lg"></i>
</button>

<!-- Add Fund Modal Component -->
@include('funds.components.add-fund-modal')
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeFundsPage();
});

function initializeFundsPage() {
    // Initialize page animations
    initializeAnimations();

    // Initialize tab functionality
    initializeTabs();

    // Initialize data updates
    initializeDataUpdates();

    // Initialize analytics
    initializeAnalytics();

    // Load initial data
    loadFundsData();
}

function initializeAnimations() {
    // Add entrance animations to elements
    const animatedElements = document.querySelectorAll('.animate-fade-in-up');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });
}

function initializeTabs() {
    const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');

    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const targetPane = event.target.getAttribute('data-bs-target');

            // Load data based on active tab
            switch(targetPane) {
                case '#transactions-pane':
                    // Refresh transaction list if needed
                    if (typeof refreshTransactionList === 'function') {
                        refreshTransactionList();
                    }
                    break;
                case '#analytics-pane':
                    // Load analytics data
                    loadAnalyticsData();
                    break;
            }
        });
    });
}

function initializeDataUpdates() {
    // Listen for fund updates
    window.addEventListener('fundAdded', function(event) {
        updateHeaderBalances(event.detail);
        showSuccessMessage('Nạp quỹ thành công!', event.detail.formattedAmount);
    });

    // Auto-refresh data every 5 minutes
    setInterval(refreshFundsData, 5 * 60 * 1000);
}

function initializeAnalytics() {
    // Initialize chart contexts
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart');
    const incomeExpenseCtx = document.getElementById('incomeExpenseChart');

    if (monthlyTrendCtx) {
        window.monthlyTrendChart = new Chart(monthlyTrendCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
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

    if (incomeExpenseCtx) {
        window.incomeExpenseChart = new Chart(incomeExpenseCtx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
}

async function loadFundsData() {
    try {
        // Show loading state
        showLoadingState();

        // Load balance and stats
        const response = await fetch('/api/funds/stats', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) throw new Error('Failed to load data');

        const result = await response.json();

        if (result.success) {
            updateHeaderBalances(result.data);
            hideLoadingState();
        }

    } catch (error) {
        console.error('Error loading funds data:', error);
        showErrorState('Không thể tải dữ liệu. Vui lòng thử lại.');
    }
}

async function loadAnalyticsData() {
    try {
        // Load monthly trend data
        const trendResponse = await fetch('/api/funds/analytics/trend', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (trendResponse.ok) {
            const trendData = await trendResponse.json();
            updateMonthlyTrendChart(trendData);
        }

        // Load income/expense distribution
        const distributionResponse = await fetch('/api/funds/analytics/distribution', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (distributionResponse.ok) {
            const distributionData = await distributionResponse.json();
            updateIncomeExpenseChart(distributionData);
        }

        // Load analytics table
        loadAnalyticsTable();

    } catch (error) {
        console.error('Error loading analytics:', error);
    }
}

function updateMonthlyTrendChart(data) {
    if (!window.monthlyTrendChart) return;

    // Mock data for demonstration
    const months = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'];
    const incomeData = [2000000, 2500000, 1800000, 3000000, 2200000, 2800000];
    const expenseData = [1500000, 1800000, 2100000, 2200000, 1900000, 2000000];

    window.monthlyTrendChart.data = {
        labels: months,
        datasets: [
            {
                label: 'Thu nhập',
                data: incomeData,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Chi tiêu',
                data: expenseData,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    };

    window.monthlyTrendChart.update();
}

function updateIncomeExpenseChart(data) {
    if (!window.incomeExpenseChart) return;

    // Mock data for demonstration
    const totalIncome = 15000000;
    const totalExpense = 12000000;
    const savings = totalIncome - totalExpense;

    window.incomeExpenseChart.data = {
        labels: ['Thu nhập', 'Chi tiêu', 'Tiết kiệm'],
        datasets: [{
            data: [totalIncome, totalExpense, savings],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#3b82f6'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    };

    window.incomeExpenseChart.update();
}

async function loadAnalyticsTable() {
    const tbody = document.getElementById('analyticsTableBody');

    try {
        // Mock data for demonstration
        const tableData = [
            {
                month: 'Tháng 6/2024',
                income: 2800000,
                expense: 2000000,
                net: 800000,
                transactions: 15,
                status: 'positive'
            },
            {
                month: 'Tháng 5/2024',
                income: 2200000,
                expense: 1900000,
                net: 300000,
                transactions: 12,
                status: 'positive'
            },
            {
                month: 'Tháng 4/2024',
                income: 3000000,
                expense: 2200000,
                net: 800000,
                transactions: 18,
                status: 'positive'
            },
            {
                month: 'Tháng 3/2024',
                income: 1800000,
                expense: 2100000,
                net: -300000,
                transactions: 14,
                status: 'negative'
            }
        ];

        tbody.innerHTML = tableData.map(row => `
            <tr>
                <td><strong>${row.month}</strong></td>
                <td class="text-end text-success">+${formatCurrency(row.income)}</td>
                <td class="text-end text-warning">-${formatCurrency(row.expense)}</td>
                <td class="text-end ${row.net >= 0 ? 'text-success' : 'text-danger'}">
                    ${row.net >= 0 ? '+' : ''}${formatCurrency(row.net)}
                </td>
                <td class="text-center">
                    <span class="badge bg-secondary">${row.transactions}</span>
                </td>
                <td class="text-center">
                    <span class="badge ${row.status === 'positive' ? 'bg-success' : 'bg-danger'}">
                        ${row.status === 'positive' ? 'Tốt' : 'Cần chú ý'}
                    </span>
                </td>
            </tr>
        `).join('');

    } catch (error) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-4 text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Không thể tải dữ liệu phân tích
                </td>
            </tr>
        `;
    }
}

function updateHeaderBalances(data) {
    // Update current balance
    if (data.current_balance !== undefined) {
        const balanceElement = document.getElementById('headerCurrentBalance');
        if (balanceElement) {
            animateNumberChange(balanceElement, data.current_balance);
        }
    }

    // Update monthly stats
    if (data.monthly) {
        const addedElement = document.getElementById('headerMonthlyAdded');
        const spentElement = document.getElementById('headerMonthlySpent');

        if (addedElement) {
            animateNumberChange(addedElement, data.monthly.total_added || 0);
        }

        if (spentElement) {
            animateNumberChange(spentElement, Math.abs(data.monthly.total_spent || 0));
        }
    }
}

function animateNumberChange(element, newValue) {
    const currentValue = parseInt(element.textContent.replace(/[^\d]/g, '')) || 0;
    const difference = newValue - currentValue;
    const steps = 30;
    const stepValue = difference / steps;

    let currentStep = 0;
    const timer = setInterval(() => {
        currentStep++;
        const value = Math.round(currentValue + (stepValue * currentStep));
        element.textContent = formatNumber(value);

        if (currentStep >= steps) {
            clearInterval(timer);
            element.textContent = formatNumber(newValue);
        }
    }, 50);
}

function refreshFundsData() {
    loadFundsData();
}

function refreshStats() {
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;

    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';
    btn.disabled = true;

    loadFundsData().finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
    });
}

function exportFundsReport() {
    const exportData = {
        balance: document.getElementById('headerCurrentBalance').textContent,
        monthly_added: document.getElementById('headerMonthlyAdded').textContent,
        monthly_spent: document.getElementById('headerMonthlySpent').textContent,
        export_date: new Date().toLocaleDateString('vi-VN'),
        export_time: new Date().toLocaleTimeString('vi-VN')
    };

    const dataStr = JSON.stringify(exportData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });

    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = `bao-cao-quy-${new Date().toISOString().slice(0, 10)}.json`;
    link.click();

    showToast('Xuất báo cáo thành công!', 'success');
}

function exportAnalytics() {
    // Implementation for analytics export
    showToast('Đang xuất dữ liệu phân tích...', 'info');

    setTimeout(() => {
        showToast('Xuất phân tích thành công!', 'success');
    }, 2000);
}

function shareAnalytics() {
    const shareData = {
        title: 'Báo cáo quỹ gia đình',
        text: `📊 Báo cáo quỹ tháng ${new Date().getMonth() + 1}:
💰 Số dư: ${document.getElementById('headerCurrentBalance').textContent} VNĐ
📈 Nạp: ${document.getElementById('headerMonthlyAdded').textContent} VNĐ
📉 Chi: ${document.getElementById('headerMonthlySpent').textContent} VNĐ

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

function showLoadingState() {
    // Add loading states to relevant elements
    const balanceElements = ['headerCurrentBalance', 'headerMonthlyAdded', 'headerMonthlySpent'];
    balanceElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.classList.add('loading-shimmer');
        }
    });
}

function hideLoadingState() {
    const balanceElements = ['headerCurrentBalance', 'headerMonthlyAdded', 'headerMonthlySpent'];
    balanceElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.classList.remove('loading-shimmer');
        }
    });
}

function showErrorState(message) {
    showToast(message, 'error');
}

function showSuccessMessage(title, amount) {
    showToast(title + ' ' + amount, 'success');

    // Optional: Show celebration effect
    if (typeof confetti !== 'undefined') {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 }
        });
    }
}

// Helper functions
function formatNumber(num) {
    return new Intl.NumberFormat('vi-VN').format(num);
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

// CSS for loading animation
const loadingStyle = document.createElement('style');
loadingStyle.textContent = `
    .loading-shimmer {
        background: linear-gradient(-90deg, #f0f0f0 0%, #e0e0e0 50%, #f0f0f0 100%);
        background-size: 400% 400%;
        animation: shimmer 1.5s ease-in-out infinite;
        color: transparent !important;
        border-radius: 4px;
    }

    @keyframes shimmer {
        0% { background-position: 0% 0%; }
        100% { background-position: -135% 0%; }
    }

    .spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(loadingStyle);
</script>
@endpush

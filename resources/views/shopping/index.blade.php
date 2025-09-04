@extends('layouts.app')

@section('title', 'Đi chợ - Quản lý mua sắm')

@push('styles')
<style>
/* Shopping Index Styles */
.shopping-container {
    padding: 0;
}

/* Header Section */
.shopping-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2.5rem 0;
    margin: -2rem -2rem 2rem -2rem;
    position: relative;
    overflow: hidden;
}

.shopping-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="25" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="25" r="1" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    pointer-events: none;
}

.shopping-header-content {
    position: relative;
    z-index: 1;
}

.shopping-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.shopping-title h1 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    backdrop-filter: blur(10px);
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.header-btn {
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.header-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.header-btn.primary {
    background: rgba(255, 255, 255, 0.9);
    color: #667eea;
    font-weight: 600;
}

.header-btn.primary:hover {
    background: white;
    color: #5a67d8;
}

/* Month Navigation */
.month-navigation {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 1.25rem;
    border-radius: 16px;
    backdrop-filter: blur(10px);
    margin-top: 1.5rem;
}

.month-nav-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.month-nav-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.month-nav-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
}

.current-month {
    text-align: center;
    min-width: 200px;
}

.current-month-text {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.current-month-desc {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Quick Stats Bar */
.quick-stats-bar {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #f0f2f5;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-item.trips .stat-value {
    color: #667eea;
}

.stat-item.amount .stat-value {
    color: #e74c3c;
}

.stat-item.average .stat-value {
    color: #f39c12;
}

.stat-item.items .stat-value {
    color: #27ae60;
}

/* Main Content */
.shopping-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
}

@media (min-width: 1200px) {
    .shopping-content {
        grid-template-columns: 2fr 1fr;
    }
}

/* Trips Section */
.trips-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.trips-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.trips-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.trips-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.view-toggle {
    display: flex;
    background: white;
    border-radius: 8px;
    padding: 0.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.view-toggle input[type="radio"] {
    display: none;
}

.view-toggle label {
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-toggle input[type="radio"]:checked + label {
    background: #667eea;
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

/* Trips List */
.trips-list {
    padding: 1.5rem;
    min-height: 400px;
}

.trips-grid {
    display: grid;
    gap: 1.25rem;
}

.trips-grid.list-view {
    grid-template-columns: 1fr;
}

.trips-grid.grid-view {
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
}

/* Empty State */
.empty-trips {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.75rem;
}

.empty-text {
    color: #adb5bd;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.empty-action {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.3s ease;
}

.empty-action:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.4);
}

/* Pagination */
.trips-pagination {
    padding: 1.5rem;
    border-top: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Stats Sidebar */
.stats-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Monthly Calendar Widget */
.calendar-widget {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.calendar-header {
    text-align: center;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.mini-calendar {
    width: 100%;
}

.mini-calendar table {
    width: 100%;
    border-collapse: collapse;
}

.mini-calendar th,
.mini-calendar td {
    width: 14.28%;
    height: 32px;
    text-align: center;
    font-size: 0.875rem;
    border: none;
}

.mini-calendar th {
    color: #6c757d;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    padding-bottom: 0.5rem;
}

.mini-calendar td {
    position: relative;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.mini-calendar td:hover {
    background: #f8f9fa;
}

.mini-calendar td.has-trip {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    font-weight: 600;
}

.mini-calendar td.today {
    background: #667eea;
    color: white;
    font-weight: 600;
}

.mini-calendar td.other-month {
    color: #dee2e6;
}

/* Quick Actions Widget */
.quick-actions-widget {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.widget-header {
    margin-bottom: 1.25rem;
}

.widget-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quick-action-btn {
    display: block;
    width: 100%;
    padding: 1rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    color: #495057;
    text-decoration: none;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.quick-action-btn:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.quick-action-btn:last-child {
    margin-bottom: 0;
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    flex-shrink: 0;
}

.quick-action-btn.primary .quick-action-icon {
    background: #667eea;
}

.quick-action-btn.success .quick-action-icon {
    background: #10b981;
}

.quick-action-btn.warning .quick-action-icon {
    background: #f59e0b;
}

.quick-action-btn.info .quick-action-icon {
    background: #3b82f6;
}

/* Floating Action Button */
.shopping-fab {
    position: fixed;
    bottom: 90px;
    right: 2rem;
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.shopping-fab:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    transform: translateY(-4px) scale(1.1);
    box-shadow: 0 12px 40px rgba(16, 185, 129, 0.5);
}

.shopping-fab:active {
    transform: translateY(-2px) scale(1.05);
}

/* Loading States */
.loading-trips {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #6c757d;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .shopping-content {
        grid-template-columns: 1fr;
    }

    .stats-sidebar {
        grid-row: 1;
    }
}

@media (max-width: 768px) {
    .shopping-header {
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    }

    .shopping-title {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .shopping-title h1 {
        font-size: 2rem;
    }

    .header-actions {
        flex-wrap: wrap;
        justify-content: center;
    }

    .month-navigation {
        gap: 1rem;
        padding: 1rem;
        margin-top: 1rem;
    }

    .current-month-text {
        font-size: 1.25rem;
    }

    .stats-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .trips-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .trips-controls {
        width: 100%;
        justify-content: center;
    }

    .trips-grid.grid-view {
        grid-template-columns: 1fr;
    }

    .shopping-fab {
        bottom: 80px;
        right: 1rem;
        width: 56px;
        height: 56px;
        font-size: 1.25rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .quick-stats-bar,
    .trips-section,
    .calendar-widget,
    .quick-actions-widget {
        background: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }

    .trips-header {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }

    .stat-item {
        background: #343a40;
        color: #f8f9fa;
    }

    .stat-item:hover {
        background: #495057;
    }

    .quick-action-btn {
        background: #343a40;
        border-color: #495057;
        color: #f8f9fa;
    }

    .quick-action-btn:hover {
        background: #495057;
        color: #f8f9fa;
    }

    .mini-calendar td:hover {
        background: #343a40;
    }

    .mini-calendar td.has-trip {
        background: rgba(102, 126, 234, 0.2);
    }
}
</style>
@endpush

@section('content')
<div class="shopping-container">
    {{-- Header Section --}}
    <div class="shopping-header">
        <div class="container-fluid shopping-header-content">
            <div class="shopping-title">
                <h1>
                    <div class="title-icon">
                        <i class="bi bi-basket"></i>
                    </div>
                    Đi chợ
                </h1>
                <div class="header-actions">
                    <a href="{{ route('shopping.create') }}" class="header-btn primary">
                        <i class="bi bi-plus-circle"></i>
                        Thêm lần đi chợ
                    </a>
                    <a href="{{ route('export.index') }}" class="header-btn">
                        <i class="bi bi-download"></i>
                        <span class="d-none d-md-inline">Xuất Excel</span>
                    </a>
                </div>
            </div>

            {{-- Month Navigation --}}
            <div class="month-navigation">
                @php
                    $prevMonth = $month > 1 ? $month - 1 : 12;
                    $prevYear = $month > 1 ? $year : $year - 1;
                    $nextMonth = $month < 12 ? $month + 1 : 1;
                    $nextYear = $month < 12 ? $year : $year + 1;
                    $canGoPrev = $availableMonths->contains(function ($item) use ($prevMonth, $prevYear) {
                        return $item['month'] == $prevMonth && $item['year'] == $prevYear;
                    });
                    $canGoNext = $availableMonths->contains(function ($item) use ($nextMonth, $nextYear) {
                        return $item['month'] == $nextMonth && $item['year'] == $nextYear;
                    }) && !($nextYear > now()->year || ($nextYear == now()->year && $nextMonth > now()->month));
                @endphp

                <button class="month-nav-btn"
                        onclick="navigateToMonth({{ $prevMonth }}, {{ $prevYear }})"
                        {{ !$canGoPrev ? 'disabled' : '' }}>
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="current-month">
                    <div class="current-month-text">
                        Tháng {{ $month }}/{{ $year }}
                    </div>
                    <div class="current-month-desc">
                        {{ $monthlyStats['total_trips'] }} lần đi chợ • {{ number_format($monthlyStats['total_amount']) }} VNĐ
                    </div>
                </div>

                <button class="month-nav-btn"
                        onclick="navigateToMonth({{ $nextMonth }}, {{ $nextYear }})"
                        {{ !$canGoNext ? 'disabled' : '' }}>
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    @if($monthlyStats['total_trips'] > 0)
    <div class="quick-stats-bar">
        <div class="stats-row">
            <div class="stat-item trips">
                <div class="stat-value">{{ $monthlyStats['total_trips'] }}</div>
                <div class="stat-label">Lần đi chợ</div>
            </div>
            <div class="stat-item amount">
                <div class="stat-value">{{ number_format($monthlyStats['total_amount']) }}</div>
                <div class="stat-label">Tổng chi tiêu (VNĐ)</div>
            </div>
            <div class="stat-item average">
                <div class="stat-value">{{ number_format($monthlyStats['avg_per_trip']) }}</div>
                <div class="stat-label">Trung bình/lần (VNĐ)</div>
            </div>
            <div class="stat-item items">
                <div class="stat-value">{{ $monthlyStats['total_items'] }}</div>
                <div class="stat-label">Tổng món đồ</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <div class="shopping-content">
        {{-- Trips Section --}}
        <div class="trips-section">
            <div class="trips-header">
                <div class="trips-title">
                    <i class="bi bi-list-ul"></i>
                    Danh sách lần đi chợ
                    @if($trips->total() > 0)
                    <span class="badge bg-primary ms-2">{{ $trips->total() }}</span>
                    @endif
                </div>

                <div class="trips-controls">
                    <div class="view-toggle">
                        <input type="radio" id="listView" name="viewMode" value="list" checked>
                        <label for="listView">
                            <i class="bi bi-list-ul"></i>
                            Danh sách
                        </label>
                        <input type="radio" id="gridView" name="viewMode" value="grid">
                        <label for="gridView">
                            <i class="bi bi-grid-3x2"></i>
                            Lưới
                        </label>
                    </div>
                </div>
            </div>

            <div class="trips-list">
                @if($trips->count() > 0)
                    <div class="trips-grid list-view" id="tripsContainer">
                        @foreach($trips as $trip)
                            <x-shopping.trip-card
                                :trip="$trip"
                                :showActions="true"
                                size="default" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($trips->hasPages())
                    <div class="trips-pagination">
                        {{ $trips->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                    @endif
                @else
                    <div class="empty-trips">
                        <div class="empty-icon">
                            <i class="bi bi-basket"></i>
                        </div>
                        <div class="empty-title">
                            @if($month == now()->month && $year == now()->year)
                                Chưa có lần đi chợ nào trong tháng này
                            @else
                                Không có lần đi chợ nào trong {{ $month }}/{{ $year }}
                            @endif
                        </div>
                        <div class="empty-text">
                            @if($month == now()->month && $year == now()->year)
                                Hãy bắt đầu ghi lại các lần đi chợ để quản lý chi tiêu hiệu quả hơn.
                            @else
                                Thử chọn tháng khác hoặc tạo lần đi chợ mới.
                            @endif
                        </div>
                        @if($month == now()->month && $year == now()->year)
                        <a href="{{ route('shopping.create') }}" class="empty-action">
                            <i class="bi bi-plus-circle"></i>
                            Thêm lần đi chợ đầu tiên
                        </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Stats Sidebar --}}
        <div class="stats-sidebar">
            {{-- Monthly Statistics --}}
            @if($monthlyStats['total_trips'] > 0)
            <x-shopping.shopping-stats
                :monthlyStats="$monthlyStats"
                :month="$month"
                :year="$year"
                size="compact"
                :showCharts="false"
                :showTopItems="true"
                :showTrends="false" />
            @endif

            {{-- Mini Calendar --}}
            <div class="calendar-widget">
                <div class="calendar-header">
                    <i class="bi bi-calendar3"></i>
                    Lịch tháng {{ $month }}/{{ $year }}
                </div>
                <div class="mini-calendar" id="miniCalendar">
                    {{-- Calendar will be generated by JavaScript --}}
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-actions-widget">
                <div class="widget-header">
                    <h6 class="widget-title">
                        <i class="bi bi-lightning-charge"></i>
                        Thao tác nhanh
                    </h6>
                </div>

                <a href="{{ route('shopping.create') }}" class="quick-action-btn primary">
                    <div class="quick-action-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Thêm lần đi chợ</div>
                        <small class="text-muted">Ghi lại mua sắm mới</small>
                    </div>
                </a>

                <a href="{{ route('funds.index') }}" class="quick-action-btn success">
                    <div class="quick-action-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Quản lý quỹ</div>
                        <small class="text-muted">Xem số dư hiện tại</small>
                    </div>
                </a>

                <a href="{{ route('export.index') }}" class="quick-action-btn warning">
                    <div class="quick-action-icon">
                        <i class="bi bi-file-earmark-excel"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Xuất báo cáo</div>
                        <small class="text-muted">Tải Excel chi tiết</small>
                    </div>
                </a>

                @if($availableMonths->count() > 1)
                <div class="quick-action-btn info" style="cursor: default;">
                    <div class="quick-action-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $availableMonths->count() }} tháng dữ liệu</div>
                        <small class="text-muted">Từ {{ $availableMonths->last()['label'] ?? '' }} đến {{ $availableMonths->first()['label'] ?? '' }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Floating Action Button --}}
<a href="{{ route('shopping.create') }}" class="shopping-fab" title="Thêm lần đi chợ mới">
    <i class="bi bi-plus"></i>
</a>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeShoppingIndex();
    generateMiniCalendar();
    setupViewModeToggle();
});

// Initialize shopping index functionality
function initializeShoppingIndex() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Setup keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N = New trip
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '{{ route("shopping.create") }}';
        }

        // Left/Right arrows for month navigation
        if (e.key === 'ArrowLeft' && e.altKey) {
            e.preventDefault();
            const prevBtn = document.querySelector('.month-nav-btn:first-child');
            if (prevBtn && !prevBtn.disabled) {
                prevBtn.click();
            }
        }

        if (e.key === 'ArrowRight' && e.altKey) {
            e.preventDefault();
            const nextBtn = document.querySelector('.month-nav-btn:last-child');
            if (nextBtn && !nextBtn.disabled) {
                nextBtn.click();
            }
        }
    });
}

// Navigate to specific month
function navigateToMonth(month, year) {
    const url = new URL(window.location.href);
    url.searchParams.set('month', month);
    url.searchParams.set('year', year);

    // Show loading state
    showNavigationLoading();

    window.location.href = url.toString();
}

// Show navigation loading
function showNavigationLoading() {
    const buttons = document.querySelectorAll('.month-nav-btn');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<div class="loading-spinner" style="width: 16px; height: 16px; border-width: 2px;"></div>';
    });
}

// Generate mini calendar
function generateMiniCalendar() {
    const calendarContainer = document.getElementById('miniCalendar');
    if (!calendarContainer) return;

    const currentMonth = {{ $month }};
    const currentYear = {{ $year }};
    const today = new Date();
    const trips = @json($trips->pluck('shopping_date')->map(fn($date) => $date->format('Y-m-d')));

    // Create calendar
    const firstDay = new Date(currentYear, currentMonth - 1, 1);
    const lastDay = new Date(currentYear, currentMonth, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay()); // Start from Sunday

    let calendarHTML = '<table><thead><tr>';
    const dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
    dayNames.forEach(day => {
        calendarHTML += `<th>${day}</th>`;
    });
    calendarHTML += '</tr></thead><tbody>';

    const currentDate = new Date(startDate);
    for (let week = 0; week < 6; week++) {
        calendarHTML += '<tr>';
        for (let day = 0; day < 7; day++) {
            const dateStr = currentDate.toISOString().split('T')[0];
            const isCurrentMonth = currentDate.getMonth() === currentMonth - 1;
            const isToday = currentDate.toDateString() === today.toDateString();
            const hasTrip = trips.includes(dateStr);

            let cellClass = '';
            if (!isCurrentMonth) cellClass += ' other-month';
            if (isToday) cellClass += ' today';
            if (hasTrip && isCurrentMonth) cellClass += ' has-trip';

            calendarHTML += `<td class="${cellClass}" title="${hasTrip ? 'Có đi chợ ngày này' : ''}">
                ${currentDate.getDate()}
            </td>`;

            currentDate.setDate(currentDate.getDate() + 1);
        }
        calendarHTML += '</tr>';

        // Stop if we've passed the current month
        if (currentDate.getMonth() !== currentMonth - 1 && week > 3) {
            break;
        }
    }

    calendarHTML += '</tbody></table>';
    calendarContainer.innerHTML = calendarHTML;
}

// Setup view mode toggle
function setupViewModeToggle() {
    const viewModeInputs = document.querySelectorAll('input[name="viewMode"]');
    const tripsContainer = document.getElementById('tripsContainer');

    viewModeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked && tripsContainer) {
                // Remove existing view classes
                tripsContainer.classList.remove('list-view', 'grid-view');

                // Add new view class
                tripsContainer.classList.add(this.value + '-view');

                // Store preference in localStorage
                localStorage.setItem('shopping-view-mode', this.value);

                // Add animation class
                tripsContainer.style.opacity = '0.7';
                setTimeout(() => {
                    tripsContainer.style.opacity = '1';
                }, 150);
            }
        });
    });

    // Load saved preference
    const savedViewMode = localStorage.getItem('shopping-view-mode');
    if (savedViewMode && ['list', 'grid'].includes(savedViewMode)) {
        const targetInput = document.getElementById(savedViewMode + 'View');
        if (targetInput) {
            targetInput.checked = true;
            targetInput.dispatchEvent(new Event('change'));
        }
    }
}

// Refresh page data
function refreshData() {
    // Show loading state
    const statsBar = document.querySelector('.quick-stats-bar');
    const tripsList = document.querySelector('.trips-list');

    if (statsBar) {
        statsBar.style.opacity = '0.6';
    }

    if (tripsList) {
        tripsList.style.opacity = '0.6';
    }

    // Reload page
    window.location.reload();
}

// Export current month data
function exportCurrentMonth() {
    const month = {{ $month }};
    const year = {{ $year }};

    const exportUrl = `{{ route('export.monthly', ['month' => ':month', 'year' => ':year']) }}`
        .replace(':month', month)
        .replace(':year', year);

    window.open(exportUrl, '_blank');
}

// Show success message
function showSuccessMessage(message) {
    const toast = document.createElement('div');
    toast.className = 'position-fixed top-0 end-0 p-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <strong class="me-auto">Thành công</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    document.body.appendChild(toast);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
}

// Handle trip deletion confirmation
function confirmDeleteTrip(tripId, tripDate) {
    if (confirm(`Bạn có chắc chắn muốn xóa lần đi chợ ngày ${tripDate}?\n\nSố tiền sẽ được hoàn lại vào quỹ.`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/shopping/${tripId}`;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Add loading animation to links
document.querySelectorAll('a[href*="shopping"], a[href*="funds"], a[href*="export"]').forEach(link => {
    link.addEventListener('click', function(e) {
        // Skip for external links or javascript: links
        if (this.hostname !== window.location.hostname || this.href.startsWith('javascript:')) {
            return;
        }

        // Add loading state
        const originalContent = this.innerHTML;
        const isButton = this.classList.contains('btn') || this.classList.contains('header-btn');

        if (isButton) {
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';

            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'bi bi-arrow-clockwise';
                icon.style.animation = 'spin 1s linear infinite';
            }
        }
    });
});

// Back to top functionality
let backToTopButton;
function createBackToTopButton() {
    backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '<i class="bi bi-chevron-up"></i>';
    backToTopButton.className = 'btn btn-primary position-fixed';
    backToTopButton.style.cssText = `
        bottom: 160px;
        right: 2rem;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        z-index: 999;
        display: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    document.body.appendChild(backToTopButton);
}

// Show/hide back to top button
window.addEventListener('scroll', () => {
    if (!backToTopButton) createBackToTopButton();

    if (window.scrollY > 300) {
        backToTopButton.style.display = 'flex';
        backToTopButton.style.alignItems = 'center';
        backToTopButton.style.justifyContent = 'center';
    } else {
        backToTopButton.style.display = 'none';
    }
});

// Global functions
window.navigateToMonth = navigateToMonth;
window.refreshData = refreshData;
window.exportCurrentMonth = exportCurrentMonth;
window.confirmDeleteTrip = confirmDeleteTrip;

// Check for success messages from redirects
@if(session('success'))
    showSuccessMessage('{{ session('success') }}');
@endif

// PWA: Add to home screen prompt
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
    deferredPrompt = e;

    // Show custom install prompt after 30 seconds
    setTimeout(() => {
        if (deferredPrompt && !localStorage.getItem('pwa-dismissed')) {
            showInstallPrompt();
        }
    }, 30000);
});

function showInstallPrompt() {
    const installPrompt = document.createElement('div');
    installPrompt.className = 'position-fixed bottom-0 start-0 end-0 bg-primary text-white p-3 text-center';
    installPrompt.style.zIndex = '9999';
    installPrompt.innerHTML = `
        <div class="container">
            <p class="mb-2"><i class="bi bi-phone me-2"></i>Cài đặt ứng dụng để sử dụng offline!</p>
            <button class="btn btn-light btn-sm me-2" onclick="installPWA()">Cài đặt</button>
            <button class="btn btn-outline-light btn-sm" onclick="dismissInstallPrompt()">Bỏ qua</button>
        </div>
    `;

    document.body.appendChild(installPrompt);
    window.installPrompt = installPrompt;
}

function installPWA() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            deferredPrompt = null;
            if (window.installPrompt) {
                window.installPrompt.remove();
            }
        });
    }
}

function dismissInstallPrompt() {
    localStorage.setItem('pwa-dismissed', 'true');
    if (window.installPrompt) {
        window.installPrompt.remove();
    }
}

window.installPWA = installPWA;
window.dismissInstallPrompt = dismissInstallPrompt;
</script>
@endpush

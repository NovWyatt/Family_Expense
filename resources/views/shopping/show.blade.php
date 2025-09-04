@extends('layouts.app')

@section('title', 'Chi tiết lần đi chợ - ' . $trip->formatted_date)

@push('styles')
<style>
/* Shopping Show Styles */
.shopping-show-container {
    padding: 0;
    max-width: 1200px;
    margin: 0 auto;
}

/* Header Section */
.trip-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2.5rem 0;
    margin: -2rem -2rem 2rem -2rem;
    position: relative;
    overflow: hidden;
}

.trip-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="lines" width="100" height="20" patternUnits="userSpaceOnUse"><line x1="0" y1="10" x2="100" y2="10" stroke="white" opacity="0.1" stroke-width="1"/></pattern></defs><rect width="100" height="20" fill="url(%23lines)"/></svg>');
    pointer-events: none;
}

.trip-header-content {
    position: relative;
    z-index: 1;
}

.trip-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.title-info h1 {
    font-size: 2.25rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    backdrop-filter: blur(10px);
}

.trip-date {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 500;
}

.header-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
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

.header-btn.danger {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.4);
}

.header-btn.danger:hover {
    background: rgba(239, 68, 68, 0.3);
    color: white;
}

/* Trip Summary */
.trip-summary {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 1.5rem;
}

.summary-item {
    text-align: center;
}

.summary-value {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.summary-label {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 500;
}

.summary-note {
    font-size: 0.875rem;
    opacity: 0.8;
    margin-top: 0.25rem;
}

/* Main Content */
.trip-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .trip-content {
        grid-template-columns: 1fr;
    }
}

/* Trip Details Card */
.trip-details-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
    overflow: hidden;
}

.details-header {
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #e9ecef;
}

.details-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.details-subtitle {
    margin: 0.5rem 0 0 0;
    color: #6c757d;
    font-size: 1rem;
}

.details-body {
    padding: 2rem;
}

/* Basic Info Section */
.basic-info-section {
    margin-bottom: 3rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.25rem;
    border-left: 4px solid var(--bs-primary);
}

.info-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.info-item.total .info-value {
    color: #dc3545;
    font-size: 1.5rem;
}

.info-item.date .info-value {
    color: #0d6efd;
}

.info-item.items .info-value {
    color: #198754;
}

/* Notes Section */
.notes-section {
    margin-bottom: 2rem;
}

.notes-card {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 12px;
    padding: 1.25rem;
    border-left: 4px solid #ffc107;
}

.notes-header {
    font-size: 0.875rem;
    font-weight: 600;
    color: #856404;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.notes-content {
    color: #664d03;
    line-height: 1.6;
    font-size: 0.9rem;
}

/* Items Section */
.items-section {
    margin-top: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.items-controls {
    display: flex;
    gap: 0.5rem;
}

/* Sidebar */
.trip-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Fund Transaction Card */
.fund-transaction-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.fund-card-header {
    margin-bottom: 1rem;
}

.fund-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.fund-transaction {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    border-left: 4px solid #dc3545;
}

.transaction-type {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.transaction-amount {
    font-size: 1.25rem;
    font-weight: 700;
    color: #dc3545;
    margin-bottom: 0.5rem;
}

.transaction-description {
    font-size: 0.875rem;
    color: #495057;
}

/* Statistics Card */
.statistics-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.stats-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.stats-item:last-child {
    border-bottom: none;
}

.stats-label {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stats-value {
    font-weight: 600;
    color: #2c3e50;
}

/* Actions Card */
.actions-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.action-btn {
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

.action-btn:hover {
    background: #e9ecef;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.action-btn:last-child {
    margin-bottom: 0;
}

.action-btn.danger {
    background: rgba(239, 68, 68, 0.1);
    border-color: rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

.action-btn.danger:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

.action-icon {
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

.action-btn.primary .action-icon {
    background: #0d6efd;
}

.action-btn.success .action-icon {
    background: #198754;
}

.action-btn.warning .action-icon {
    background: #ffc107;
    color: #000;
}

.action-btn.danger .action-icon {
    background: #dc3545;
}

/* Related Trips */
.related-trips-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    border: 1px solid #f0f2f5;
}

.related-trip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
}

.related-trip:hover {
    background: #e9ecef;
    color: inherit;
    transform: translateY(-1px);
}

.related-trip:last-child {
    margin-bottom: 0;
}

.related-date {
    font-size: 0.875rem;
    color: #495057;
    font-weight: 500;
}

.related-amount {
    font-size: 0.875rem;
    color: #dc3545;
    font-weight: 600;
}

/* Delete Modal Enhancement */
.modal-header.danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.modal-header.danger .btn-close {
    filter: invert(1);
}

/* Loading States */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loading-overlay.show {
    opacity: 1;
    visibility: visible;
}

.loading-content {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.loading-spinner {
    width: 48px;
    height: 48px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #dc3545;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .trip-header {
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    }

    .trip-title {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .title-info h1 {
        font-size: 2rem;
    }

    .header-actions {
        flex-wrap: wrap;
        justify-content: center;
    }

    .trip-summary {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1.5rem;
    }

    .summary-value {
        font-size: 2rem;
    }

    .trip-content {
        gap: 1.5rem;
    }

    .details-header,
    .details-body {
        padding: 1.5rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

/* Print Styles */
@media print {
    .trip-header,
    .header-actions,
    .trip-sidebar {
        display: none !important;
    }

    .trip-content {
        grid-template-columns: 1fr;
    }

    .trip-details-card {
        box-shadow: none;
        border: 1px solid #dee2e6;
    }

    body {
        background: white !important;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .trip-details-card,
    .fund-transaction-card,
    .statistics-card,
    .actions-card,
    .related-trips-card {
        background: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }

    .details-header {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }

    .info-item,
    .fund-transaction {
        background: #343a40;
        color: #f8f9fa;
    }

    .notes-card {
        background: #332d00;
        border-color: #ffc107;
    }

    .action-btn,
    .related-trip {
        background: #343a40;
        border-color: #495057;
        color: #f8f9fa;
    }

    .action-btn:hover,
    .related-trip:hover {
        background: #495057;
        color: #f8f9fa;
    }

    .stats-item {
        border-color: #495057;
    }
}
</style>
@endpush

@section('content')
<div class="shopping-show-container">
    {{-- Header Section --}}
    <div class="trip-header">
        <div class="container-fluid trip-header-content">
            <div class="trip-title">
                <div class="title-info">
                    <h1>
                        <div class="title-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        Chi tiết lần đi chợ
                    </h1>
                    <div class="trip-date">{{ $trip->formatted_date }}</div>
                </div>

                <div class="header-actions">
                    <a href="{{ route('shopping.index') }}" class="header-btn">
                        <i class="bi bi-arrow-left"></i>
                        <span class="d-none d-md-inline">Quay lại</span>
                    </a>
                    <button class="header-btn" onclick="window.print()">
                        <i class="bi bi-printer"></i>
                        <span class="d-none d-md-inline">In hóa đơn</span>
                    </button>
                    <button class="header-btn danger" onclick="confirmDeleteTrip()">
                        <i class="bi bi-trash"></i>
                        <span class="d-none d-md-inline">Xóa</span>
                    </button>
                </div>
            </div>

            {{-- Trip Summary --}}
            <div class="trip-summary">
                <div class="summary-item">
                    <div class="summary-value">{{ number_format($trip->total_amount) }}</div>
                    <div class="summary-label">Tổng chi tiêu (VNĐ)</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ $trip->items_count }}</div>
                    <div class="summary-label">Số món đồ</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ number_format($trip->items_count > 0 ? $trip->total_amount / $trip->items_count : 0) }}</div>
                    <div class="summary-label">Giá TB/món (VNĐ)</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ $trip->created_at->diffForHumans() }}</div>
                    <div class="summary-label">Thời gian tạo</div>
                    <div class="summary-note">{{ $trip->created_at->format('H:i - d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="trip-content">
        {{-- Trip Details --}}
        <div class="trip-details-card">
            <div class="details-header">
                <h2 class="details-title">
                    <i class="bi bi-clipboard-data"></i>
                    Thông tin chi tiết
                </h2>
                <p class="details-subtitle">Chi tiết về lần đi chợ và các món đồ đã mua</p>
            </div>

            <div class="details-body">
                {{-- Basic Information --}}
                <div class="basic-info-section">
                    <div class="info-grid">
                        <div class="info-item date">
                            <div class="info-label">
                                <i class="bi bi-calendar-event"></i>
                                Ngày đi chợ
                            </div>
                            <div class="info-value">{{ $trip->formatted_date }}</div>
                        </div>

                        <div class="info-item total">
                            <div class="info-label">
                                <i class="bi bi-cash-stack"></i>
                                Tổng chi tiêu
                            </div>
                            <div class="info-value">{{ $trip->formatted_total }}</div>
                        </div>

                        <div class="info-item items">
                            <div class="info-label">
                                <i class="bi bi-bag-check"></i>
                                Số món đồ
                            </div>
                            <div class="info-value">{{ $trip->items_count }} món</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock-history"></i>
                                Thời gian tạo
                            </div>
                            <div class="info-value">{{ $trip->created_at->format('H:i - d/m/Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Notes Section --}}
                @if($trip->notes)
                <div class="notes-section">
                    <div class="notes-card">
                        <div class="notes-header">
                            <i class="bi bi-sticky"></i>
                            Ghi chú
                        </div>
                        <div class="notes-content">{{ $trip->notes }}</div>
                    </div>
                </div>
                @endif

                {{-- Items List --}}
                <div class="items-section">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="bi bi-list-check"></i>
                            Danh sách món đồ ({{ $trip->items_count }})
                        </h3>
                        <div class="items-controls">
                            <button class="btn btn-sm btn-outline-primary" onclick="exportToExcel()">
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                        </div>
                    </div>

                    <x-shopping.item-list
                        :items="$trip->items"
                        :showActions="false"
                        :allowSelect="false"
                        :allowSort="true"
                        :allowFilter="true"
                        viewMode="table"
                        :showTotal="true"
                        :editable="false" />
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="trip-sidebar">
            {{-- Fund Transaction --}}
            @if($trip->fundTransaction)
            <div class="fund-transaction-card">
                <div class="fund-card-header">
                    <h6 class="fund-card-title">
                        <i class="bi bi-credit-card"></i>
                        Giao dịch quỹ
                    </h6>
                </div>

                <div class="fund-transaction">
                    <div class="transaction-type">
                        <i class="bi bi-arrow-down-circle"></i>
                        Trừ tiền từ quỹ
                    </div>
                    <div class="transaction-amount">-{{ number_format($trip->fundTransaction->amount) }} VNĐ</div>
                    <div class="transaction-description">{{ $trip->fundTransaction->description }}</div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('funds.history') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                        Xem trong lịch sử quỹ
                    </a>
                </div>
            </div>
            @endif

            {{-- Statistics --}}
            <div class="statistics-card">
                <div class="fund-card-header">
                    <h6 class="fund-card-title">
                        <i class="bi bi-graph-up"></i>
                        Thống kê
                    </h6>
                </div>

                <div class="stats-item">
                    <div class="stats-label">
                        <i class="bi bi-currency-dollar"></i>
                        Món đắt nhất
                    </div>
                    <div class="stats-value">{{ number_format($trip->items->max('total_price')) }}đ</div>
                </div>

                <div class="stats-item">
                    <div class="stats-label">
                        <i class="bi bi-tags"></i>
                        Món rẻ nhất
                    </div>
                    <div class="stats-value">{{ number_format($trip->items->min('total_price')) }}đ</div>
                </div>

                <div class="stats-item">
                    <div class="stats-label">
                        <i class="bi bi-calculator"></i>
                        Trung bình/món
                    </div>
                    <div class="stats-value">{{ number_format($trip->items->avg('total_price')) }}đ</div>
                </div>

                <div class="stats-item">
                    <div class="stats-label">
                        <i class="bi bi-123"></i>
                        Tổng số lượng
                    </div>
                    <div class="stats-value">{{ $trip->items->sum('quantity') }}</div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="actions-card">
                <div class="fund-card-header">
                    <h6 class="fund-card-title">
                        <i class="bi bi-gear"></i>
                        Thao tác
                    </h6>
                </div>

                <a href="{{ route('shopping.create') }}" class="action-btn primary">
                    <div class="action-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Thêm lần đi chợ mới</div>
                        <small class="text-muted">Ghi lại lần mua sắm tiếp theo</small>
                    </div>
                </a>

                <button class="action-btn success" onclick="shareTrip()">
                    <div class="action-icon">
                        <i class="bi bi-share"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Chia sẻ</div>
                        <small class="text-muted">Chia sẻ chi tiết với người khác</small>
                    </div>
                </button>

                <button class="action-btn warning" onclick="duplicateTrip()">
                    <div class="action-icon">
                        <i class="bi bi-files"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Nhân bản</div>
                        <small class="text-muted">Tạo lần đi chợ tương tự</small>
                    </div>
                </button>

                <button class="action-btn danger" onclick="confirmDeleteTrip()">
                    <div class="action-icon">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">Xóa lần đi chợ</div>
                        <small class="text-muted">Hoàn tiền và xóa dữ liệu</small>
                    </div>
                </button>
            </div>

            {{-- Related Trips --}}
            @php
                $relatedTrips = App\Models\ShoppingTrip::where('id', '!=', $trip->id)
                    ->whereMonth('shopping_date', $trip->shopping_date->month)
                    ->whereYear('shopping_date', $trip->shopping_date->year)
                    ->orderBy('shopping_date', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($relatedTrips->count() > 0)
            <div class="related-trips-card">
                <div class="fund-card-header">
                    <h6 class="fund-card-title">
                        <i class="bi bi-clock-history"></i>
                        Cùng tháng ({{ $relatedTrips->count() }})
                    </h6>
                </div>

                @foreach($relatedTrips as $relatedTrip)
                <a href="{{ route('shopping.show', $relatedTrip) }}" class="related-trip">
                    <div class="related-date">{{ $relatedTrip->formatted_date }}</div>
                    <div class="related-amount">{{ number_format($relatedTrip->total_amount) }}đ</div>
                </a>
                @endforeach

                <div class="mt-3">
                    <a href="{{ route('shopping.index', ['month' => $trip->shopping_date->month, 'year' => $trip->shopping_date->year]) }}"
                       class="btn btn-sm btn-outline-primary w-100">
                        Xem tất cả lần đi chợ tháng này
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header danger">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Xác nhận xóa lần đi chợ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="display-1 text-danger mb-3">
                        <i class="bi bi-trash"></i>
                    </div>
                    <h5>Bạn có chắc chắn muốn xóa lần đi chợ này?</h5>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Lưu ý:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Số tiền <strong>{{ $trip->formatted_total }}</strong> sẽ được hoàn lại vào quỹ</li>
                        <li>Tất cả {{ $trip->items_count }} món đồ sẽ bị xóa</li>
                        <li>Hành động này không thể hoàn tác</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <label for="deleteReason" class="form-label">Lý do xóa (tùy chọn):</label>
                    <textarea class="form-control" id="deleteReason" rows="3"
                              placeholder="VD: Nhập sai thông tin, lần đi chợ trùng lặp..."></textarea>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                    <label class="form-check-label" for="confirmDelete">
                        Tôi hiểu rằng hành động này không thể hoàn tác
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i>
                    Hủy
                </button>
                <button type="button" class="btn btn-danger" onclick="deleteTrip()" disabled id="confirmDeleteBtn">
                    <i class="bi bi-trash"></i>
                    Xóa lần đi chợ
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Share Modal --}}
<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-share me-2"></i>
                    Chia sẻ lần đi chợ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="display-4 text-primary mb-3">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    <h6>Quét mã QR để xem chi tiết</h6>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <div id="qrcode" class="border rounded p-3"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hoặc copy link:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareUrl"
                               value="{{ url()->current() }}" readonly>
                        <button class="btn btn-outline-secondary" onclick="copyShareUrl()">
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-success" onclick="shareViaWhatsApp()">
                        <i class="bi bi-whatsapp me-2"></i>
                        Chia sẻ qua WhatsApp
                    </button>
                    <button class="btn btn-primary" onclick="shareViaEmail()">
                        <i class="bi bi-envelope me-2"></i>
                        Chia sẻ qua Email
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Loading Overlay --}}
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <div>Đang xử lý...</div>
    </div>
</div>
@endsection

@push('scripts')
<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeShoppingShow();
    setupDeleteModal();
});

// Initialize shopping show functionality
function initializeShoppingShow() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Setup keyboard shortcuts
    setupKeyboardShortcuts();

    // Setup print optimization
    setupPrintOptimization();
}

// Setup delete modal
function setupDeleteModal() {
    const confirmCheckbox = document.getElementById('confirmDelete');
    const confirmBtn = document.getElementById('confirmDeleteBtn');

    if (confirmCheckbox && confirmBtn) {
        confirmCheckbox.addEventListener('change', function() {
            confirmBtn.disabled = !this.checked;
        });
    }
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Escape = Go back
        if (e.key === 'Escape' && !document.querySelector('.modal.show')) {
            window.location.href = '{{ route("shopping.index") }}';
        }

        // Ctrl/Cmd + P = Print
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            window.print();
        }

        // Delete key = Delete trip (with confirmation)
        if (e.key === 'Delete' && !document.querySelector('.modal.show')) {
            confirmDeleteTrip();
        }

        // Ctrl/Cmd + D = Duplicate
        if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
            e.preventDefault();
            duplicateTrip();
        }

        // Ctrl/Cmd + S = Share
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            shareTrip();
        }
    });
}

// Setup print optimization
function setupPrintOptimization() {
    window.addEventListener('beforeprint', function() {
        // Expand any collapsed sections
        document.querySelectorAll('.collapse').forEach(el => {
            el.classList.add('show');
        });

        // Add print-specific styles
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });
}

// Confirm delete trip
function confirmDeleteTrip() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Delete trip
function deleteTrip() {
    const reason = document.getElementById('deleteReason').value.trim();

    showLoading('Đang xóa lần đi chợ và hoàn tiền...');

    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("shopping.destroy", $trip) }}';
    form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        ${reason ? `<input type="hidden" name="reason" value="${reason}">` : ''}
    `;

    document.body.appendChild(form);
    form.submit();
}

// Share trip
function shareTrip() {
    generateQRCode();
    const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
    shareModal.show();
}

// Generate QR code
function generateQRCode() {
    const qrContainer = document.getElementById('qrcode');
    if (!qrContainer) return;

    // Clear existing QR code
    qrContainer.innerHTML = '';

    const qr = qrcode(0, 'M');
    qr.addData(window.location.href);
    qr.make();

    qrContainer.innerHTML = qr.createImgTag(4);
}

// Copy share URL
function copyShareUrl() {
    const shareUrl = document.getElementById('shareUrl');
    if (shareUrl) {
        shareUrl.select();
        shareUrl.setSelectionRange(0, 99999);

        try {
            document.execCommand('copy');
            showToast('Đã copy link chia sẻ', 'success');
        } catch (err) {
            // Fallback for modern browsers
            navigator.clipboard.writeText(shareUrl.value).then(() => {
                showToast('Đã copy link chia sẻ', 'success');
            }).catch(() => {
                showToast('Không thể copy link', 'error');
            });
        }
    }
}

// Share via WhatsApp
function shareViaWhatsApp() {
    const message = `Xem chi tiết lần đi chợ ngày {{ $trip->formatted_date }}:\n` +
                   `💰 Tổng: {{ $trip->formatted_total }}\n` +
                   `🛒 {{ $trip->items_count }} món đồ\n\n` +
                   `${window.location.href}`;

    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Share via Email
function shareViaEmail() {
    const subject = `Chi tiết lần đi chợ - {{ $trip->formatted_date }}`;
    const body = `Xem chi tiết lần đi chợ ngày {{ $trip->formatted_date }}:\n\n` +
                `Tổng chi tiêu: {{ $trip->formatted_total }}\n` +
                `Số món đồ: {{ $trip->items_count }}\n` +
                `Thời gian: {{ $trip->created_at->format('H:i - d/m/Y') }}\n\n` +
                `Link chi tiết: ${window.location.href}`;

    const mailtoUrl = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = mailtoUrl;
}

// Duplicate trip
function duplicateTrip() {
    if (confirm('Tạo lần đi chợ mới với danh sách món đồ tương tự?')) {
        showLoading('Đang tạo bản sao...');

        // Prepare items data for create form
        const items = @json($trip->items->map(function($item) {
            return [
                'item_name' => $item->item_name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'notes' => $item->notes
            ];
        }));

        // Store in sessionStorage for the create form to pick up
        sessionStorage.setItem('duplicate_trip_data', JSON.stringify({
            items: items,
            notes: '{{ addslashes($trip->notes) }}'
        }));

        // Redirect to create form
        window.location.href = '{{ route("shopping.create") }}?duplicate={{ $trip->id }}';
    }
}

// Export to Excel
function exportToExcel() {
    showToast('Tính năng xuất Excel đang được phát triển', 'info');

    // TODO: Implement Excel export functionality
    // This would call an API endpoint to generate and download Excel file
    /*
    const exportUrl = `{{ route('export.trip', $trip) }}`;
    window.open(exportUrl, '_blank');
    */
}

// Show loading overlay
function showLoading(message = 'Đang xử lý...') {
    const overlay = document.getElementById('loadingOverlay');
    const content = overlay.querySelector('.loading-content div:last-child');

    if (content) content.textContent = message;
    overlay.classList.add('show');
}

// Hide loading overlay
function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    overlay.classList.remove('show');
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `position-fixed top-0 end-0 p-3`;
    toast.style.zIndex = '9999';

    const iconClass = {
        success: 'bi-check-circle-fill text-success',
        error: 'bi-exclamation-triangle-fill text-danger',
        info: 'bi-info-circle-fill text-info',
        warning: 'bi-exclamation-triangle-fill text-warning'
    }[type] || 'bi-info-circle-fill text-info';

    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="${iconClass} me-2"></i>
                <strong class="me-auto">Thông báo</strong>
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

// Handle back navigation with animation
function goBack() {
    document.body.style.opacity = '0.7';
    setTimeout(() => {
        window.location.href = '{{ route("shopping.index") }}';
    }, 200);
}

// Global functions
window.confirmDeleteTrip = confirmDeleteTrip;
window.deleteTrip = deleteTrip;
window.shareTrip = shareTrip;
window.duplicateTrip = duplicateTrip;
window.exportToExcel = exportToExcel;
window.goBack = goBack;

// Handle success messages from redirects
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error');
@endif

// Auto-hide loading on page load
window.addEventListener('load', function() {
    hideLoading();
});

// Handle duplicate trip data from sessionStorage (for create form)
if (sessionStorage.getItem('duplicate_trip_data')) {
    // This would be handled in the create form
    console.log('Duplicate trip data available');
}
</script>
@endpush

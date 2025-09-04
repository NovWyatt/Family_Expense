{{-- Shopping Trip Card Component --}}
@props([
    'trip',
    'showActions' => true,
    'size' => 'default' // 'default', 'compact', 'detailed'
])

@php
    $cardClass = match($size) {
        'compact' => 'trip-card compact',
        'detailed' => 'trip-card detailed',
        default => 'trip-card'
    };
@endphp

<div class="{{ $cardClass }}" data-trip-id="{{ $trip->id }}">
    {{-- Card Header --}}
    <div class="trip-card-header">
        <div class="trip-date">
            <div class="date-primary">{{ $trip->shopping_date->format('d') }}</div>
            <div class="date-secondary">
                <div class="month">{{ $trip->shopping_date->format('M') }}</div>
                <div class="year">{{ $trip->shopping_date->format('Y') }}</div>
            </div>
        </div>

        <div class="trip-info">
            <div class="trip-title">
                Đi chợ
                <span class="trip-date-text">{{ $trip->shopping_date->format('d/m/Y') }}</span>
            </div>
            <div class="trip-meta">
                <span class="items-count">
                    <i class="bi bi-bag"></i>
                    {{ $trip->items_count }} món
                </span>
                <span class="trip-time">
                    <i class="bi bi-clock"></i>
                    {{ $trip->created_at->format('H:i') }}
                </span>
            </div>
        </div>

        @if($showActions)
        <div class="trip-actions">
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('shopping.show', $trip->id) }}">
                            <i class="bi bi-eye"></i>
                            Xem chi tiết
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger"
                           href="#"
                           onclick="confirmDeleteTrip({{ $trip->id }})">
                            <i class="bi bi-trash"></i>
                            Xóa lần đi chợ
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @endif
    </div>

    {{-- Card Body --}}
    <div class="trip-card-body">
        {{-- Total Amount --}}
        <div class="trip-total">
            <div class="amount-display">
                <span class="amount-value">{{ number_format($trip->total_amount) }}</span>
                <span class="amount-currency">VNĐ</span>
            </div>
            <div class="amount-label">Tổng chi tiêu</div>
        </div>

        {{-- Trip Notes (if any) --}}
        @if($trip->notes)
        <div class="trip-notes">
            <div class="notes-header">
                <i class="bi bi-sticky"></i>
                Ghi chú
            </div>
            <div class="notes-content">{{ $trip->notes }}</div>
        </div>
        @endif

        {{-- Items Preview --}}
        @if($size !== 'compact' && $trip->items->count() > 0)
        <div class="trip-items-preview">
            <div class="items-header">
                <span class="items-title">Danh sách mua sắm</span>
                @if($trip->items_count > 3)
                <span class="items-more">+{{ $trip->items_count - 3 }} món khác</span>
                @endif
            </div>
            <div class="items-list">
                @foreach($trip->items->take(3) as $item)
                <div class="item-preview">
                    <div class="item-name">{{ $item->item_name }}</div>
                    <div class="item-details">
                        @if($item->quantity != 1)
                        <span class="item-quantity">{{ number_format($item->quantity, 1) }}x</span>
                        @endif
                        <span class="item-price">{{ number_format($item->total_price) }}đ</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Card Footer --}}
    <div class="trip-card-footer">
        <div class="footer-left">
            <span class="trip-status">
                @if($trip->created_at->isToday())
                    <i class="bi bi-circle-fill text-success"></i>
                    Hôm nay
                @elseif($trip->created_at->isYesterday())
                    <i class="bi bi-circle-fill text-warning"></i>
                    Hôm qua
                @else
                    <i class="bi bi-circle-fill text-muted"></i>
                    {{ $trip->created_at->diffForHumans() }}
                @endif
            </span>
        </div>

        <div class="footer-right">
            @if($showActions && !request()->routeIs('shopping.show'))
            <a href="{{ route('shopping.show', $trip->id) }}"
               class="btn btn-sm btn-primary">
                <i class="bi bi-arrow-right"></i>
                Xem chi tiết
            </a>
            @endif
        </div>
    </div>
</div>

{{-- Component Styles --}}
<style>
.trip-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.trip-card:hover {
    border-color: var(--bs-primary);
    box-shadow: 0 4px 20px rgba(13, 110, 253, 0.15);
    transform: translateY(-2px);
}

.trip-card.compact {
    border-radius: 12px;
}

.trip-card.detailed {
    border-radius: 20px;
}

/* Card Header */
.trip-card-header {
    padding: 1.25rem;
    border-bottom: 1px solid #f1f3f4;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.trip-card.compact .trip-card-header {
    padding: 1rem;
    gap: 0.75rem;
}

.trip-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 60px;
    padding: 0.75rem;
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-info));
    color: white;
    border-radius: 12px;
    text-align: center;
}

.trip-card.compact .trip-date {
    min-width: 50px;
    padding: 0.5rem;
    border-radius: 8px;
}

.date-primary {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.trip-card.compact .date-primary {
    font-size: 1.25rem;
}

.date-secondary {
    margin-top: 0.25rem;
}

.month {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.9;
}

.year {
    font-size: 0.625rem;
    opacity: 0.8;
}

.trip-info {
    flex: 1;
    min-width: 0;
}

.trip-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.5rem;
}

.trip-card.compact .trip-title {
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.trip-date-text {
    color: var(--bs-primary);
    font-weight: 500;
}

.trip-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.875rem;
    color: #6c757d;
}

.trip-card.compact .trip-meta {
    font-size: 0.8rem;
    gap: 0.75rem;
}

.trip-meta i {
    margin-right: 0.25rem;
    font-size: 0.8em;
}

.trip-actions .dropdown-toggle {
    border: none;
    background: transparent;
    color: #6c757d;
}

.trip-actions .dropdown-toggle:hover,
.trip-actions .dropdown-toggle:focus {
    background: #f8f9fa;
    color: #495057;
}

/* Card Body */
.trip-card-body {
    padding: 1.25rem;
}

.trip-card.compact .trip-card-body {
    padding: 1rem;
}

.trip-total {
    text-align: center;
    margin-bottom: 1.25rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 4px solid var(--bs-danger);
}

.trip-card.compact .trip-total {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: 8px;
}

.amount-display {
    margin-bottom: 0.25rem;
}

.amount-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #dc3545;
}

.trip-card.compact .amount-value {
    font-size: 1.5rem;
}

.amount-currency {
    font-size: 1rem;
    color: #6c757d;
    margin-left: 0.25rem;
}

.amount-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Trip Notes */
.trip-notes {
    margin-bottom: 1rem;
    padding: 1rem;
    background: #fff3cd;
    border-radius: 8px;
    border-left: 4px solid #ffc107;
}

.trip-card.compact .trip-notes {
    padding: 0.75rem;
    margin-bottom: 0.75rem;
}

.notes-header {
    font-size: 0.875rem;
    font-weight: 600;
    color: #856404;
    margin-bottom: 0.5rem;
}

.notes-header i {
    margin-right: 0.5rem;
}

.notes-content {
    font-size: 0.875rem;
    color: #664d03;
    line-height: 1.5;
}

/* Items Preview */
.trip-items-preview {
    margin-bottom: 1rem;
}

.items-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.items-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #495057;
}

.items-more {
    font-size: 0.75rem;
    color: #6c757d;
    font-style: italic;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.item-preview {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 6px;
    font-size: 0.875rem;
}

.item-name {
    color: #495057;
    font-weight: 500;
    flex: 1;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.item-details {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.item-quantity {
    color: #6c757d;
    font-size: 0.8rem;
}

.item-price {
    color: #dc3545;
    font-weight: 600;
}

/* Card Footer */
.trip-card-footer {
    padding: 1rem 1.25rem;
    background: #f8f9fa;
    border-top: 1px solid #f1f3f4;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.trip-card.compact .trip-card-footer {
    padding: 0.75rem 1rem;
}

.footer-left {
    display: flex;
    align-items: center;
}

.trip-status {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.trip-status i {
    font-size: 0.5rem;
}

.footer-right .btn {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
}

/* Responsive */
@media (max-width: 768px) {
    .trip-card-header {
        flex-direction: column;
        gap: 0.75rem;
    }

    .trip-date {
        align-self: flex-start;
        min-width: auto;
        padding: 0.5rem 0.75rem;
    }

    .trip-meta {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .trip-card-footer {
        flex-direction: column;
        gap: 0.75rem;
        align-items: stretch;
    }

    .footer-right {
        text-align: center;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .trip-card {
        background: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }

    .trip-card:hover {
        border-color: var(--bs-primary);
        box-shadow: 0 4px 20px rgba(13, 110, 253, 0.25);
    }

    .trip-total {
        background: #343a40;
    }

    .trip-notes {
        background: #332d00;
        border-color: #ffc107;
    }

    .item-preview {
        background: #343a40;
    }

    .trip-card-footer {
        background: #343a40;
        border-color: #495057;
    }
}
</style>

{{-- JavaScript for Trip Card Actions --}}
<script>
function confirmDeleteTrip(tripId) {
    if (confirm('Bạn có chắc chắn muốn xóa lần đi chợ này? Số tiền sẽ được hoàn lại vào quỹ.')) {
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
</script>

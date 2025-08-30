@extends('layouts.app')

@section('title', 'Trang chủ')

@push('styles')
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .stats-card .stats-icon {
        font-size: 2.5rem;
        opacity: 0.8;
        margin-bottom: 0.5rem;
    }

    .stats-card .stats-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stats-card .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .monthly-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #667eea;
    }

    .stat-item.success {
        border-left-color: #28a745;
    }

    .stat-item.warning {
        border-left-color: #ffc107;
    }

    .stat-item.info {
        border-left-color: #17a2b8;
    }

    .stat-item .stat-number {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stat-item .stat-text {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .activity-card {
        background: white;
        border-radius: 15px;
        margin-bottom: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .activity-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1rem;
        font-weight: 600;
        color: #495057;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        align-items: center;
        transition: background 0.2s ease;
    }

    .activity-item:hover {
        background: #f8f9fa;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .activity-icon.add {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .activity-icon.subtract {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .activity-meta {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .activity-amount {
        font-weight: 700;
        text-align: right;
    }

    .activity-amount.positive {
        color: #28a745;
    }

    .activity-amount.negative {
        color: #dc3545;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .quick-action {
        background: white;
        border-radius: 15px;
        padding: 1.5rem 1rem;
        text-align: center;
        text-decoration: none;
        color: #495057;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 2px solid transparent;
    }

    .quick-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        color: #667eea;
        border-color: #667eea;
    }

    .quick-action i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #667eea;
    }

    .quick-action .action-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .quick-action .action-desc {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .warning-card {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: white;
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .warning-card i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 576px) {
        .monthly-stats {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .stats-card {
            padding: 1rem;
        }

        .stats-card .stats-value {
            font-size: 1.5rem;
        }
    }

</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Welcome Card -->
        <div class="stats-card">
            <div class="stats-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stats-value" id="mainBalance">
                {{ number_format($currentBalance) }} VNĐ
            </div>
            <div class="stats-label">
                Quỹ gia đình hiện tại
                @if(count($userNames) > 0)
                • {{ implode(' & ', $userNames) }}
                @endif
            </div>
        </div>

        <!-- Low Fund Warning -->
        @if($lowFundWarning)
        <div class="warning-card">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Cảnh báo quỹ thấp!</strong><br>
                <small>Quỹ hiện tại dưới 100,000 VNĐ. Nên nạp thêm tiền.</small>
            </div>
        </div>
        @endif

        <!-- Monthly Statistics -->
        <div class="monthly-stats">
            <div class="stat-item success">
                <div class="stat-number">+{{ number_format($monthlyStats['total_added']) }}</div>
                <div class="stat-text">VNĐ nạp tháng này</div>
            </div>
            <div class="stat-item warning">
                <div class="stat-number">-{{ number_format($monthlyStats['total_spent']) }}</div>
                <div class="stat-text">VNĐ chi tháng này</div>
            </div>
            <div class="stat-item info">
                <div class="stat-number">{{ $monthlyStats['trips_count'] }}</div>
                <div class="stat-text">lần đi chợ</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $monthlyStats['items_count'] }}</div>
                <div class="stat-text">món đồ đã mua</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="#" class="quick-action" data-bs-toggle="modal" data-bs-target="#addFundModal">
                <i class="bi bi-plus-circle-fill"></i>
                <div class="action-title">Nạp Quỹ</div>
                <div class="action-desc">Thêm tiền vào quỹ</div>
            </a>
            <a href="{{ route('shopping.create') }}" class="quick-action">
                <i class="bi bi-cart-plus-fill"></i>
                <div class="action-title">Đi Chợ</div>
                <div class="action-desc">Thêm lần đi chợ mới</div>
            </a>
        </div>

        <!-- Recent Transactions -->
        <div class="activity-card">
            <div class="activity-header">
                <span><i class="bi bi-clock-history me-2"></i>Giao dịch gần đây</span>
                <a href="{{ route('funds.history') }}" class="text-decoration-none small">
                    Xem tất cả <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @if(count($recentTransactions) > 0)
            @foreach($recentTransactions as $transaction)
            <div class="activity-item">
                <div class="activity-icon {{ $transaction->type }}">
                    <i class="bi {{ $transaction->type === 'add' ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">{{ $transaction->description }}</div>
                    <div class="activity-meta">
                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                        @if($transaction->shoppingTrip)
                        • <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}" class="text-decoration-none">
                            Chi tiết đi chợ
                        </a>
                        @endif
                    </div>
                </div>
                <div class="activity-amount {{ $transaction->type === 'add' ? 'positive' : 'negative' }}">
                    {{ $transaction->formatted_amount }}
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <div>Chưa có giao dịch nào</div>
                <small>Hãy bắt đầu bằng việc nạp quỹ!</small>
            </div>
            @endif
        </div>

        <!-- Recent Shopping Trips -->
        <div class="activity-card">
            <div class="activity-header">
                <span><i class="bi bi-basket me-2"></i>Lần đi chợ gần đây</span>
                <a href="{{ route('shopping.index') }}" class="text-decoration-none small">
                    Xem tất cả <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            @if(count($recentTrips) > 0)
            @foreach($recentTrips as $trip)
            <div class="activity-item">
                <div class="activity-icon subtract">
                    <i class="bi bi-basket-fill"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">
                        Đi chợ ngày {{ $trip->shopping_date->format('d/m/Y') }}
                    </div>
                    <div class="activity-meta">
                        {{ $trip->items_count }} món đồ
                        @if($trip->items->count() > 0)
                        • {{ $trip->items->take(2)->pluck('item_name')->join(', ') }}
                        @if($trip->items->count() > 2)
                        và {{ $trip->items->count() - 2 }} món khác...
                        @endif
                        @endif
                    </div>
                </div>
                <div class="activity-amount negative">
                    -{{ number_format($trip->total_amount) }} VNĐ
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-state">
                <i class="bi bi-basket"></i>
                <div>Chưa có lần đi chợ nào</div>
                <small>Hãy thêm lần đi chợ đầu tiên!</small>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Fund Modal -->
<div class="modal fade" id="addFundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Nạp Quỹ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addFundForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Số tiền (VNĐ)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="1000" max="100000000" placeholder="Nhập số tiền..." required>
                        <div class="form-text">Tối thiểu 1,000 VNĐ - Tối đa 100,000,000 VNĐ</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Ghi chú (tùy chọn)</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Ví dụ: Nạp quỹ đầu tháng..." maxlength="255">
                    </div>
                    <!-- Quick amounts -->
                    <div class="mb-3">
                        <label class="form-label">Số tiền thường dùng:</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-primary btn-sm quick-amount" data-amount="100000">100k</button>
                            <button type="button" class="btn btn-outline-primary btn-sm quick-amount" data-amount="200000">200k</button>
                            <button type="button" class="btn btn-outline-primary btn-sm quick-amount" data-amount="500000">500k</button>
                            <button type="button" class="btn btn-outline-primary btn-sm quick-amount" data-amount="1000000">1M</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="addFundBtn">
                        <i class="bi bi-plus-circle me-1"></i>Nạp Quỹ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick amount buttons
        document.querySelectorAll('.quick-amount').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('amount').value = this.dataset.amount;
            });
        });

        // Add fund form
        document.getElementById('addFundForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('addFundBtn');
            const originalText = btn.innerHTML;
            showLoading(btn);

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
                    document.getElementById('mainBalance').textContent = result.new_balance.toLocaleString('vi-VN') + ' VNĐ';
                    document.getElementById('currentBalance').textContent = result.new_balance.toLocaleString('vi-VN') + ' VNĐ';

                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('addFundModal')).hide();

                    // Reset form
                    this.reset();

                    // Show success message
                    showToast('Nạp quỹ thành công! ' + result.formatted_amount, 'success');

                    // Refresh page after 1.5s to show new transaction
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast(result.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
            } finally {
                hideLoading(btn, originalText);
            }
        });

        // Auto refresh data every 2 minutes
        setInterval(() => {
            updateBalance();
        }, 120000);
    });

</script>
@endpush

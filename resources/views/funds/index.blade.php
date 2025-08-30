@extends('layouts.app')

@section('title', 'Quản lý Quỹ')

@push('breadcrumb')
<li class="breadcrumb-item active">Quản lý Quỹ</li>
@endpush

@push('styles')
<style>
    .fund-dashboard {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .balance-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
    }

    .balance-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .balance-card::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .balance-amount {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .balance-label {
        font-size: 1rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .balance-actions {
        margin-top: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .balance-actions .btn {
        margin: 0 0.25rem;
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .balance-actions .btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-card.positive {
        border-left-color: #28a745;
    }

    .stat-card.negative {
        border-left-color: #dc3545;
    }

    .stat-card.info {
        border-left-color: #17a2b8;
    }

    .stat-card.warning {
        border-left-color: #ffc107;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #667eea;
    }

    .stat-card.positive .stat-icon {
        color: #28a745;
    }

    .stat-card.negative .stat-icon {
        color: #dc3545;
    }

    .stat-card.info .stat-icon {
        color: #17a2b8;
    }

    .stat-card.warning .stat-icon {
        color: #ffc107;
    }

    .stat-number {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .quick-add-section {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .section-header h5 {
        margin: 0;
        font-weight: 600;
        color: #2c3e50;
    }

    .section-header i {
        font-size: 1.5rem;
        color: #667eea;
        margin-right: 0.75rem;
    }

    .quick-amounts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .quick-amount-btn {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 0.75rem 0.5rem;
        text-align: center;
        font-weight: 600;
        color: #495057;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .quick-amount-btn:hover {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .quick-amount-btn.selected {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
    }

    .custom-amount {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .add-fund-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        min-height: 50px;
    }

    .add-fund-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .add-fund-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .transactions-section {
        background: white;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .transactions-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .transaction-item {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        position: relative;
    }

    .transaction-item:hover {
        background: rgba(102, 126, 234, 0.05);
        padding-left: 2rem;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .transaction-icon.add {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .transaction-icon.subtract {
        background: linear-gradient(135deg, #dc3545, #fd7e7e);
        color: white;
    }

    .transaction-content {
        flex: 1;
        min-width: 0;
    }

    .transaction-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .transaction-meta {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .transaction-amount {
        font-weight: 700;
        font-size: 1.1rem;
        text-align: right;
        white-space: nowrap;
    }

    .transaction-amount.positive {
        color: #28a745;
    }

    .transaction-amount.negative {
        color: #dc3545;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h6 {
        margin-bottom: 0.5rem;
        color: #495057;
    }

    .warning-low-fund {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #856404;
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 10px rgba(255, 193, 7, 0.3);
    }

    .warning-low-fund i {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    @media (max-width: 768px) {
        .balance-amount {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .quick-amounts {
            grid-template-columns: repeat(4, 1fr);
        }

        .custom-amount {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .transaction-item {
            padding: 1rem;
        }

        .transaction-item:hover {
            padding-left: 1.25rem;
        }

        .transaction-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .balance-card {
            padding: 1.5rem;
        }

        .quick-add-section,
        .transactions-section {
            margin-left: -5px;
            margin-right: -5px;
            border-radius: 15px;
        }
    }

    /* Loading animation */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        z-index: 10;
    }

</style>
@endpush

@section('content')
<div class="funds-container">
    <!-- Fund Dashboard -->
    <div class="fund-dashboard">
        <div class="balance-card">
            <div class="balance-amount" id="balanceAmount">
                {{ number_format($currentBalance) }} VNĐ
            </div>
            <div class="balance-label">
                Quỹ gia đình hiện tại
            </div>
            <div class="balance-actions">
                <button class="btn" onclick="scrollToAddFund()">
                    <i class="bi bi-plus-circle me-1"></i>Nạp Quỹ
                </button>
                <a href="{{ route('funds.history') }}" class="btn">
                    <i class="bi bi-clock-history me-1"></i>Lịch Sử
                </a>
            </div>
        </div>
    </div>

    <!-- Low Fund Warning -->
    @if($currentBalance < 100000) <div class="warning-low-fund">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Cảnh báo quỹ thấp!</strong><br>
            <small>Quỹ hiện tại dưới 100,000 VNĐ. Nên nạp thêm tiền để tiện việc đi chợ.</small>
        </div>
</div>
@endif

<!-- Monthly Statistics -->
<div class="stats-grid">
    <div class="stat-card positive">
        <div class="stat-icon">
            <i class="bi bi-arrow-down-circle-fill"></i>
        </div>
        <div class="stat-number">+{{ number_format($monthlyStats['total_added']) }}</div>
        <div class="stat-label">Nạp tháng này</div>
    </div>

    <div class="stat-card negative">
        <div class="stat-icon">
            <i class="bi bi-arrow-up-circle-fill"></i>
        </div>
        <div class="stat-number">-{{ number_format($monthlyStats['total_spent']) }}</div>
        <div class="stat-label">Chi tháng này</div>
    </div>

    <div class="stat-card info">
        <div class="stat-icon">
            <i class="bi bi-graph-up"></i>
        </div>
        <div class="stat-number">{{ $monthlyStats['transactions_count'] }}</div>
        <div class="stat-label">Giao dịch</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon">
            <i class="bi bi-calendar-month"></i>
        </div>
        <div class="stat-number">{{ now()->format('m/Y') }}</div>
        <div class="stat-label">Tháng hiện tại</div>
    </div>
</div>

<!-- Quick Add Fund Section -->
<div class="quick-add-section" id="addFundSection">
    <div class="section-header">
        <i class="bi bi-plus-circle-fill"></i>
        <h5>Nạp Quỹ Nhanh</h5>
    </div>

    <form id="quickAddForm">
        @csrf
        <!-- Quick Amount Buttons -->
        <div class="quick-amounts">
            <div class="quick-amount-btn" data-amount="50000">50k</div>
            <div class="quick-amount-btn" data-amount="100000">100k</div>
            <div class="quick-amount-btn" data-amount="200000">200k</div>
            <div class="quick-amount-btn" data-amount="500000">500k</div>
            <div class="quick-amount-btn" data-amount="1000000">1M</div>
            <div class="quick-amount-btn" data-amount="2000000">2M</div>
            <div class="quick-amount-btn" data-amount="5000000">5M</div>
            <div class="quick-amount-btn" data-amount="other">Khác</div>
        </div>

        <!-- Custom Amount Input -->
        <div class="custom-amount">
            <div class="form-floating">
                <input type="number" class="form-control" id="customAmount" name="amount" min="1000" max="100000000" placeholder="Nhập số tiền..." required>
                <label for="customAmount">Số tiền (VNĐ) *</label>
            </div>
            <button type="submit" class="add-fund-btn" id="addFundBtn">
                <i class="bi bi-plus-circle me-1"></i>
                <span>Nạp Quỹ</span>
            </button>
        </div>

        <!-- Description Input (Optional) -->
        <div class="mt-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="fundDescription" name="description" placeholder="Ghi chú (tùy chọn)..." maxlength="255">
                <label for="fundDescription">Ghi chú (tùy chọn)</label>
            </div>
        </div>
    </form>
</div>

<!-- Recent Transactions -->
<div class="transactions-section">
    <div class="transactions-header">
        <div class="section-header">
            <i class="bi bi-clock-history"></i>
            <h5>Giao Dịch Gần Đây</h5>
        </div>
        <a href="{{ route('funds.history') }}" class="btn btn-outline-primary btn-sm">
            Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="transactions-list" id="transactionsList">
        @if(count($recentTransactions) > 0)
        @foreach($recentTransactions as $transaction)
        <div class="transaction-item">
            <div class="transaction-icon {{ $transaction->type }}">
                <i class="bi {{ $transaction->type === 'add' ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' }}"></i>
            </div>
            <div class="transaction-content">
                <div class="transaction-title">
                    {{ $transaction->description }}
                </div>
                <div class="transaction-meta">
                    <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                    </span>
                    @if($transaction->shoppingTrip)
                    <span>
                        <i class="bi bi-basket me-1"></i>
                        <a href="{{ route('shopping.show', $transaction->shoppingTrip) }}" class="text-decoration-none">
                            Chi tiết đi chợ
                        </a>
                    </span>
                    @endif
                    @if($transaction->type === 'add')
                    <span class="badge bg-success">
                        <i class="bi bi-plus"></i> Nạp tiền
                    </span>
                    @else
                    <span class="badge bg-danger">
                        <i class="bi bi-dash"></i> Chi tiêu
                    </span>
                    @endif
                </div>
            </div>
            <div class="transaction-amount {{ $transaction->type === 'add' ? 'positive' : 'negative' }}">
                {{ $transaction->formatted_amount }}
            </div>
        </div>
        @endforeach
        @else
        <div class="empty-state">
            <i class="bi bi-wallet"></i>
            <h6>Chưa có giao dịch nào</h6>
            <p>Giao dịch đầu tiên sẽ xuất hiện ở đây</p>
        </div>
        @endif
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
        const customAmountInput = document.getElementById('customAmount');
        const addFundForm = document.getElementById('quickAddForm');
        const addFundBtn = document.getElementById('addFundBtn');
        const balanceAmount = document.getElementById('balanceAmount');

        let selectedAmount = 0;

        // Quick amount button handlers
        quickAmountBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove selected class from all buttons
                quickAmountBtns.forEach(b => b.classList.remove('selected'));

                const amount = this.dataset.amount;

                if (amount === 'other') {
                    // Select "Khác" and focus on input
                    this.classList.add('selected');
                    customAmountInput.focus();
                    selectedAmount = 0;
                } else {
                    // Select amount and fill input
                    this.classList.add('selected');
                    customAmountInput.value = amount;
                    selectedAmount = parseInt(amount);

                    // Update button text with formatted amount
                    updateButtonText();
                }
            });
        });

        // Custom input handler
        customAmountInput.addEventListener('input', function() {
            const value = parseInt(this.value) || 0;
            selectedAmount = value;

            // Remove selection from quick buttons if typing custom amount
            const matchingBtn = Array.from(quickAmountBtns).find(btn =>
                btn.dataset.amount === value.toString()
            );

            quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
            if (matchingBtn) {
                matchingBtn.classList.add('selected');
            } else if (value > 0) {
                document.querySelector('[data-amount="other"]').classList.add('selected');
            }

            updateButtonText();
        });

        // Form submit
        addFundForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!selectedAmount || selectedAmount < 1000) {
                showToast('Số tiền tối thiểu là 1,000 VNĐ', 'warning');
                return;
            }

            const originalBtnHtml = addFundBtn.innerHTML;
            addFundBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Đang xử lý...';
            addFundBtn.disabled = true;

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
                    // Update balance display
                    balanceAmount.textContent = result.new_balance.toLocaleString('vi-VN') + ' VNĐ';
                    document.getElementById('currentBalance').textContent = result.new_balance.toLocaleString('vi-VN') + ' VNĐ';

                    // Reset form
                    this.reset();
                    quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
                    selectedAmount = 0;
                    updateButtonText();

                    // Show success message
                    showToast(`Nạp quỹ thành công! ${result.formatted_amount}`, 'success');

                    // Add new transaction to list
                    addTransactionToList(result.data);

                    // Scroll to transactions to see new transaction
                    setTimeout(() => {
                        document.querySelector('.transactions-section').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 1000);

                } else {
                    showToast(result.message || 'Có lỗi xảy ra', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Có lỗi kết nối. Vui lòng thử lại.', 'danger');
            } finally {
                addFundBtn.innerHTML = originalBtnHtml;
                addFundBtn.disabled = false;
            }
        });

        function updateButtonText() {
            const btnText = addFundBtn.querySelector('span');
            if (selectedAmount > 0) {
                btnText.textContent = `Nạp ${formatCurrency(selectedAmount)}`;
            } else {
                btnText.textContent = 'Nạp Quỹ';
            }
        }

        function formatCurrency(amount) {
            if (amount >= 1000000) {
                return (amount / 1000000).toFixed(amount % 1000000 === 0 ? 0 : 1) + 'M';
            } else if (amount >= 1000) {
                return (amount / 1000).toFixed(amount % 1000 === 0 ? 0 : 1) + 'k';
            }
            return amount.toLocaleString('vi-VN');
        }

        function addTransactionToList(transactionData) {
            const transactionsList = document.getElementById('transactionsList');

            // Remove empty state if exists
            const emptyState = transactionsList.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            // Create new transaction element
            const newTransaction = document.createElement('div');
            newTransaction.className = 'transaction-item';
            newTransaction.style.opacity = '0';
            newTransaction.style.transform = 'translateY(-20px)';

            newTransaction.innerHTML = `
            <div class="transaction-icon add">
                <i class="bi bi-arrow-down-circle"></i>
            </div>
            <div class="transaction-content">
                <div class="transaction-title">${transactionData.description}</div>
                <div class="transaction-meta">
                    <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        Vừa xong
                    </span>
                    <span class="badge bg-success">
                        <i class="bi bi-plus"></i> Nạp tiền
                    </span>
                </div>
            </div>
            <div class="transaction-amount positive">${transactionData.formatted_amount}</div>
        `;

            // Insert at the beginning
            transactionsList.insertBefore(newTransaction, transactionsList.firstChild);

            // Animate in
            setTimeout(() => {
                newTransaction.style.transition = 'all 0.5s ease';
                newTransaction.style.opacity = '1';
                newTransaction.style.transform = 'translateY(0)';
            }, 100);

            // Remove oldest transaction if more than 10
            const transactions = transactionsList.querySelectorAll('.transaction-item');
            if (transactions.length > 10) {
                transactions[transactions.length - 1].remove();
            }
        }

        // Scroll to add fund section
        window.scrollToAddFund = function() {
            document.getElementById('addFundSection').scrollIntoView({
                behavior: 'smooth'
            });
            setTimeout(() => customAmountInput.focus(), 500);
        };

        // Auto refresh balance every minute
        setInterval(async () => {
            try {
                const response = await fetch('{{ route("funds.api.balance") }}');
                const data = await response.json();
                if (data.formatted_balance) {
                    balanceAmount.textContent = data.formatted_balance;
                    document.getElementById('currentBalance').textContent = data.formatted_balance;
                }
            } catch (error) {
                console.log('Balance refresh error:', error);
            }
        }, 60000);
    });

</script>
@endpush

{{-- Add Fund Modal Component for Funds Page --}}
<div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="addFundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="addFundModalLabel">
                    <i class="bi bi-wallet-fill me-2"></i>
                    Nạp Tiền Vào Quỹ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addFundForm" data-loading="true">
                @csrf
                <div class="modal-body">
                    <!-- Current Balance Display -->
                    <div class="alert alert-info d-flex align-items-center mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <div>
                            <strong>Số dư hiện tại: </strong>
                            <span class="fw-bold text-primary" id="currentBalanceDisplay">
                                {{ number_format(auth()->user()->balance ?? 0) }} VNĐ
                            </span>
                        </div>
                    </div>

                    <!-- Quick Amount Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">
                            <i class="bi bi-lightning-charge me-1"></i>
                            Chọn nhanh số tiền:
                        </label>
                        <div class="quick-amounts-container">
                            <div class="row g-2">
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="50000">
                                        50K
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="100000">
                                        100K
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="200000">
                                        200K
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="500000">
                                        500K
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="1000000">
                                        1M
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="2000000">
                                        2M
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="5000000">
                                        5M
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary w-100 quick-amount-btn" data-amount="10000000">
                                        10M
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Amount Input -->
                    <div class="mb-4">
                        <div class="form-floating">
                            <input type="number"
                                   class="form-control form-control-lg currency-input"
                                   id="fundAmount"
                                   name="amount"
                                   min="1000"
                                   max="100000000"
                                   step="1000"
                                   placeholder="Nhập số tiền..."
                                   required>
                            <label for="fundAmount">
                                <i class="bi bi-cash-coin me-1"></i>
                                Số tiền muốn nạp (VNĐ)
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Số tiền tối thiểu: 1,000 VNĐ - Tối đa: 100,000,000 VNĐ
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <div class="form-floating">
                            <textarea class="form-control"
                                      id="fundDescription"
                                      name="description"
                                      placeholder="Ghi chú..."
                                      maxlength="255"
                                      rows="3"
                                      style="height: 80px;"></textarea>
                            <label for="fundDescription">
                                <i class="bi bi-pencil-square me-1"></i>
                                Ghi chú (tùy chọn)
                            </label>
                        </div>
                        <div class="form-text">
                            <span id="descriptionCounter">0</span>/255 ký tự
                        </div>
                    </div>

                    <!-- Fund Source Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-credit-card me-1"></i>
                            Nguồn tiền:
                        </label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="source" id="sourceCash" value="cash" checked>
                                    <label class="form-check-label d-flex align-items-center" for="sourceCash">
                                        <i class="bi bi-cash me-2 text-success"></i>
                                        Tiền mặt
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="source" id="sourceBank" value="bank">
                                    <label class="form-check-label d-flex align-items-center" for="sourceBank">
                                        <i class="bi bi-bank me-2 text-primary"></i>
                                        Chuyển khoản
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="card bg-light border-0" id="previewSection" style="display: none;">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="bi bi-eye me-1"></i>
                                Xem trước:
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Số tiền nạp:</small>
                                    <div class="fw-bold text-success" id="previewAmount">0 VNĐ</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Số dư sau khi nạp:</small>
                                    <div class="fw-bold text-primary" id="previewNewBalance">0 VNĐ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>
                        Hủy
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg px-4" id="addFundBtn">
                        <i class="bi bi-plus-circle me-1"></i>
                        Nạp Tiền Vào Quỹ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Add Fund Modal Styles */
.quick-amounts-container .quick-amount-btn {
    padding: 12px 8px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.quick-amounts-container .quick-amount-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
}

.quick-amounts-container .quick-amount-btn.selected {
    background-color: var(--bs-primary);
    color: white;
    border-color: var(--bs-primary);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
}

.quick-amounts-container .quick-amount-btn.selected::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
    animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.currency-input:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.form-check-input:checked {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

.form-check-label {
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.form-check-label:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.form-check-input:checked + .form-check-label {
    background-color: rgba(13, 110, 253, 0.1);
    font-weight: 600;
}

/* Preview Section Animation */
#previewSection {
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

#previewSection.show {
    opacity: 1;
    transform: translateY(0);
    display: block !important;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}

/* Loading State */
.btn-loading {
    position: relative;
    color: transparent !important;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-lg {
        max-width: 95%;
        margin: 1rem auto;
    }

    .quick-amounts-container .row {
        --bs-gutter-x: 0.5rem;
    }

    .quick-amounts-container .quick-amount-btn {
        padding: 10px 6px;
        font-size: 0.9rem;
    }
}

/* Dark Theme Support */
@media (prefers-color-scheme: dark) {
    .modal-content {
        background-color: var(--bs-dark);
        color: var(--bs-light);
    }

    .alert-info {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: rgba(13, 110, 253, 0.2);
        color: var(--bs-light);
    }

    .card.bg-light {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }

    .modal-footer.bg-light {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeAddFundModal();
});

function initializeAddFundModal() {
    const modal = document.getElementById('addFundModal');
    const form = document.getElementById('addFundForm');
    const amountInput = document.getElementById('fundAmount');
    const descriptionInput = document.getElementById('fundDescription');
    const descriptionCounter = document.getElementById('descriptionCounter');
    const quickAmountBtns = document.querySelectorAll('.quick-amount-btn');
    const submitBtn = document.getElementById('addFundBtn');
    const previewSection = document.getElementById('previewSection');
    const previewAmount = document.getElementById('previewAmount');
    const previewNewBalance = document.getElementById('previewNewBalance');
    const currentBalanceDisplay = document.getElementById('currentBalanceDisplay');

    let currentBalance = {{ auth()->user()->balance ?? 0 }};

    // Quick amount selection
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove selected class from all buttons
            quickAmountBtns.forEach(b => b.classList.remove('selected'));

            // Add selected class to clicked button
            this.classList.add('selected');

            // Set amount in input
            amountInput.value = this.dataset.amount;

            // Trigger input event to update preview
            amountInput.dispatchEvent(new Event('input'));

            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Clear selection when typing custom amount
    amountInput.addEventListener('input', function() {
        // Remove selected class from quick buttons
        quickAmountBtns.forEach(btn => btn.classList.remove('selected'));

        // Update preview
        updatePreview();

        // Format number display
        formatNumberInput(this);
    });

    // Description character counter
    descriptionInput.addEventListener('input', function() {
        const length = this.value.length;
        descriptionCounter.textContent = length;

        if (length > 200) {
            descriptionCounter.classList.add('text-warning');
        } else if (length > 240) {
            descriptionCounter.classList.add('text-danger');
            descriptionCounter.classList.remove('text-warning');
        } else {
            descriptionCounter.classList.remove('text-warning', 'text-danger');
        }
    });

    // Update preview function
    function updatePreview() {
        const amount = parseInt(amountInput.value) || 0;

        if (amount >= 1000) {
            previewAmount.textContent = formatCurrency(amount);
            previewNewBalance.textContent = formatCurrency(currentBalance + amount);
            previewSection.classList.add('show');
            previewSection.style.display = 'block';
        } else {
            previewSection.classList.remove('show');
            setTimeout(() => {
                if (!previewSection.classList.contains('show')) {
                    previewSection.style.display = 'none';
                }
            }, 300);
        }
    }

    // Format number input
    function formatNumberInput(input) {
        let value = input.value.replace(/[^\d]/g, '');
        if (value) {
            // Add thousand separators for display (optional)
            // input.setAttribute('data-formatted', formatCurrency(parseInt(value)));
        }
    }

    // Format currency helper
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
    }

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const amount = parseInt(amountInput.value);
        if (!amount || amount < 1000) {
            showToast('Số tiền tối thiểu là 1,000 VNĐ', 'warning');
            amountInput.focus();
            return;
        }

        if (amount > 100000000) {
            showToast('Số tiền tối đa là 100,000,000 VNĐ', 'warning');
            amountInput.focus();
            return;
        }

        // Show loading state
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("funds.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                // Update current balance
                currentBalance = result.new_balance;
                currentBalanceDisplay.textContent = formatCurrency(currentBalance);

                // Update global balance displays
                if (window.updateAllBalanceDisplays) {
                    window.updateAllBalanceDisplays(currentBalance);
                }

                // Close modal
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();

                // Reset form
                form.reset();
                quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
                previewSection.classList.remove('show');
                previewSection.style.display = 'none';
                descriptionCounter.textContent = '0';

                // Show success message
                showToast(`Nạp quỹ thành công! +${formatCurrency(amount)}`, 'success');

                // Trigger custom event for other components
                window.dispatchEvent(new CustomEvent('fundAdded', {
                    detail: {
                        amount: amount,
                        newBalance: currentBalance,
                        formattedAmount: formatCurrency(amount)
                    }
                }));

                // Refresh funds list if available
                if (typeof refreshFundsList === 'function') {
                    refreshFundsList();
                }
            } else {
                showToast(result.message || 'Có lỗi xảy ra khi nạp quỹ', 'error');
            }
        } catch (error) {
            console.error('Add fund error:', error);
            showToast('Có lỗi kết nối. Vui lòng thử lại sau.', 'error');
        } finally {
            // Remove loading state
            submitBtn.classList.remove('btn-loading');
            submitBtn.disabled = false;
        }
    });

    // Reset form when modal is hidden
    modal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        quickAmountBtns.forEach(btn => btn.classList.remove('selected'));
        previewSection.classList.remove('show');
        previewSection.style.display = 'none';
        descriptionCounter.textContent = '0';
        submitBtn.classList.remove('btn-loading');
        submitBtn.disabled = false;
    });

    // Focus amount input when modal is shown
    modal.addEventListener('shown.bs.modal', function() {
        amountInput.focus();
    });

    // Keyboard shortcuts
    modal.addEventListener('keydown', function(e) {
        // Enter to submit (if not in textarea)
        if (e.key === 'Enter' && e.target !== descriptionInput && !e.shiftKey) {
            e.preventDefault();
            if (!submitBtn.disabled) {
                form.dispatchEvent(new Event('submit'));
            }
        }

        // Escape to close
        if (e.key === 'Escape') {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        }
    });
}

// Global function to show add fund modal
function showAddFundModal(presetAmount = null) {
    const modal = new bootstrap.Modal(document.getElementById('addFundModal'));
    modal.show();

    if (presetAmount) {
        const amountInput = document.getElementById('fundAmount');
        amountInput.value = presetAmount;
        amountInput.dispatchEvent(new Event('input'));
    }
}
</script>

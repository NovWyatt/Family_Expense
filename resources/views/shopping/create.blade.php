@extends('layouts.app')

@section('title', 'Thêm lần đi chợ')

@push('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('shopping.index') }}" class="text-decoration-none">Đi chợ</a>
</li>
<li class="breadcrumb-item active">Thêm mới</li>
@endpush

@push('styles')
<style>
    .form-container {
        max-width: 100%;
        margin: 0 auto;
    }

    .main-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .card-header-custom h4 {
        margin: 0;
        font-weight: 600;
    }

    .card-header-custom .current-balance {
        font-size: 1.1rem;
        margin-top: 0.5rem;
        opacity: 0.9;
    }

    .form-section {
        padding: 1.5rem;
        border-bottom: 1px solid #f8f9fa;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.5rem;
        color: #667eea;
    }

    .form-control {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .items-container {
        margin-bottom: 1rem;
    }

    .item-row {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .item-row:hover {
        border-color: #667eea;
        box-shadow: 0 2px 10px rgba(102, 126, 234, 0.1);
    }

    .item-row.has-error {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .item-number {
        position: absolute;
        top: -10px;
        left: 15px;
        background: #667eea;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .remove-item {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-item:hover {
        background: #c82333;
        transform: scale(1.1);
    }

    .add-item-btn {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        width: 100%;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .add-item-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .total-summary {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 1rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .total-amount {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .balance-check {
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .balance-check.sufficient {
        color: #28a745;
    }

    .balance-check.insufficient {
        color: #dc3545;
        font-weight: 600;
    }

    .submit-btn {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        width: 100%;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .autocomplete-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 2px solid #e9ecef;
        border-top: none;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f8f9fa;
        transition: background 0.2s ease;
    }

    .autocomplete-item:hover,
    .autocomplete-item.active {
        background: #667eea;
        color: white;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
    }

    .input-group {
        position: relative;
    }

    .currency-input {
        position: relative;
    }

    .currency-input::after {
        content: 'VNĐ';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 0.9rem;
        pointer-events: none;
    }

    .form-floating {
        position: relative;
    }

    .form-floating label {
        font-weight: 500;
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1rem;
        }

        .item-row {
            padding: 0.75rem;
        }

        .total-amount {
            font-size: 1.5rem;
        }
    }

    /* Animation cho item mới */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .item-row.new-item {
        animation: slideIn 0.3s ease-out;
    }

</style>
@endpush

@section('content')
<div class="form-container">
    <form id="shoppingForm" action="{{ route('shopping.store') }}" method="POST">
        @csrf

        <!-- Header Card -->
        <div class="main-card">
            <div class="card-header-custom">
                <h4><i class="bi bi-cart-plus me-2"></i>Thêm lần đi chợ</h4>
                <div class="current-balance">
                    Quỹ hiện tại: <span id="currentBalance">{{ number_format($currentBalance) }} VNĐ</span>
                </div>
            </div>

            <!-- Basic Info Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-calendar-event"></i>
                    Thông tin cơ bản
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" class="form-control @error('shopping_date') is-invalid @enderror" id="shopping_date" name="shopping_date" value="{{ old('shopping_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                            <label for="shopping_date">Ngày đi chợ</label>
                            @error('shopping_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" style="height: 60px" placeholder="Ghi chú cho lần đi chợ này...">{{ old('notes') }}</textarea>
                            <label for="notes">Ghi chú (tùy chọn)</label>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="form-section">
                <div class="section-title">
                    <i class="bi bi-basket"></i>
                    Danh sách món đồ
                </div>

                <div class="items-container" id="itemsContainer">
                    <!-- Template for items will be inserted here -->
                </div>

                <button type="button" class="add-item-btn" id="addItemBtn">
                    <i class="bi bi-plus-circle me-2"></i>Thêm món đồ
                </button>

                <!-- Total Summary -->
                <div class="total-summary">
                    <div class="total-amount" id="totalAmount">0 VNĐ</div>
                    <div class="text-muted">Tổng tiền</div>
                    <div class="balance-check" id="balanceCheck">
                        <i class="bi bi-check-circle"></i> Quỹ đủ để thanh toán
                    </div>
                </div>
            </div>

            <!-- Submit Section -->
            <div class="form-section">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="bi bi-check-circle me-2"></i>Lưu lần đi chợ
                </button>
                <div class="text-center mt-3">
                    <a href="{{ route('shopping.index') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Item Template (Hidden) -->
<template id="itemTemplate">
    <div class="item-row">
        <div class="item-number"></div>
        <button type="button" class="remove-item" onclick="removeItem(this)">
            <i class="bi bi-x"></i>
        </button>

        <div class="row">
            <div class="col-md-5 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control item-name" name="items[][item_name]" placeholder="Nhập tên món đồ..." required>
                    <label>Tên món đồ *</label>
                    <div class="autocomplete-suggestions"></div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-floating currency-input">
                    <input type="number" class="form-control item-price" name="items[][price]" min="100" max="10000000" placeholder="0" required>
                    <label>Giá tiền *</label>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="form-floating">
                    <input type="number" class="form-control item-quantity" name="items[][quantity]" min="0.1" max="999" step="0.1" value="1" placeholder="1">
                    <label>Số lượng</label>
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <div class="form-floating">
                    <input type="text" class="form-control item-total" readonly placeholder="0">
                    <label>Thành tiền</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" name="items[][notes]" placeholder="Ghi chú cho món đồ này...">
                    <label>Ghi chú</label>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsContainer = document.getElementById('itemsContainer');
        const itemTemplate = document.getElementById('itemTemplate');
        const addItemBtn = document.getElementById('addItemBtn');
        const totalAmount = document.getElementById('totalAmount');
        const balanceCheck = document.getElementById('balanceCheck');
        const submitBtn = document.getElementById('submitBtn');
        const currentBalance = {
            {
                $currentBalance
            }
        };

        let itemCount = 0;
        let itemSuggestions = @json($itemSuggestions ? ? []);

        // Add first item on load
        addItem();

        // Add item button
        addItemBtn.addEventListener('click', addItem);

        // Form submit
        document.getElementById('shoppingForm').addEventListener('submit', handleSubmit);

        function addItem() {
            itemCount++;
            const itemElement = itemTemplate.content.cloneNode(true);

            // Set item number
            itemElement.querySelector('.item-number').textContent = itemCount;

            // Add new-item class for animation
            itemElement.querySelector('.item-row').classList.add('new-item');

            // Update input names with proper array index
            const inputs = itemElement.querySelectorAll('input');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('[]', `[${itemCount-1}]`);
                }
            });

            itemsContainer.appendChild(itemElement);

            // Setup event listeners for new item
            const newItem = itemsContainer.lastElementChild;
            setupItemEventListeners(newItem);

            // Focus on item name input
            newItem.querySelector('.item-name').focus();

            // Remove animation class after animation
            setTimeout(() => {
                newItem.classList.remove('new-item');
            }, 300);

            updateItemNumbers();
            calculateTotal();
        }

        function removeItem(button) {
            if (itemsContainer.children.length <= 1) {
                showToast('Cần ít nhất 1 món đồ!', 'warning');
                return;
            }

            button.closest('.item-row').remove();
            updateItemNumbers();
            calculateTotal();
        }

        function updateItemNumbers() {
            const items = itemsContainer.querySelectorAll('.item-row');
            items.forEach((item, index) => {
                item.querySelector('.item-number').textContent = index + 1;

                // Update input names
                const inputs = item.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.name && input.name.includes('[')) {
                        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                    }
                });
            });
        }

        function setupItemEventListeners(itemElement) {
            const itemName = itemElement.querySelector('.item-name');
            const itemPrice = itemElement.querySelector('.item-price');
            const itemQuantity = itemElement.querySelector('.item-quantity');
            const itemTotal = itemElement.querySelector('.item-total');
            const suggestions = itemElement.querySelector('.autocomplete-suggestions');

            // Auto-complete for item name
            setupAutocomplete(itemName, suggestions);

            // Auto-fill price when item name changes
            itemName.addEventListener('blur', async function() {
                if (this.value.trim()) {
                    try {
                        const response = await fetch(`{{ route('shopping.api.item.price') }}?item_name=${encodeURIComponent(this.value)}`);
                        const data = await response.json();

                        if (data.success && data.data.average_price && !itemPrice.value) {
                            itemPrice.value = data.data.average_price;
                            calculateItemTotal(itemElement);
                        }
                    } catch (error) {
                        console.log('Price fetch error:', error);
                    }
                }
            });

            // Calculate item total when price or quantity changes
            [itemPrice, itemQuantity].forEach(input => {
                input.addEventListener('input', () => calculateItemTotal(itemElement));
                input.addEventListener('blur', () => calculateItemTotal(itemElement));
            });

            // Validation
            itemName.addEventListener('input', () => validateItem(itemElement));
            itemPrice.addEventListener('input', () => validateItem(itemElement));
        }

        function setupAutocomplete(input, suggestionsContainer) {
            let selectedIndex = -1;

            input.addEventListener('input', async function() {
                const value = this.value.trim();

                if (value.length < 2) {
                    suggestionsContainer.style.display = 'none';
                    return;
                }

                try {
                    const response = await fetch(`{{ route('shopping.api.item.suggestions') }}?search=${encodeURIComponent(value)}`);
                    const data = await response.json();

                    if (data.success && data.data.length > 0) {
                        showSuggestions(data.data, suggestionsContainer, input);
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                } catch (error) {
                    console.log('Suggestions error:', error);
                    suggestionsContainer.style.display = 'none';
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                    suggestionsContainer.style.display = 'none';
                }
            });

            // Keyboard navigation
            input.addEventListener('keydown', function(e) {
                const items = suggestionsContainer.querySelectorAll('.autocomplete-item');

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                    updateSelection(items, selectedIndex);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    selectedIndex = Math.max(selectedIndex - 1, -1);
                    updateSelection(items, selectedIndex);
                } else if (e.key === 'Enter' && selectedIndex >= 0) {
                    e.preventDefault();
                    items[selectedIndex].click();
                } else if (e.key === 'Escape') {
                    suggestionsContainer.style.display = 'none';
                    selectedIndex = -1;
                }
            });
        }

        function showSuggestions(suggestions, container, input) {
            container.innerHTML = '';

            suggestions.forEach((suggestion, index) => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = suggestion;

                item.addEventListener('click', function() {
                    input.value = suggestion;
                    container.style.display = 'none';
                    input.blur(); // Trigger price fetch
                });

                container.appendChild(item);
            });

            container.style.display = 'block';
        }

        function updateSelection(items, selectedIndex) {
            items.forEach((item, index) => {
                item.classList.toggle('active', index === selectedIndex);
            });
        }

        function calculateItemTotal(itemElement) {
            const price = parseFloat(itemElement.querySelector('.item-price').value) || 0;
            const quantity = parseFloat(itemElement.querySelector('.item-quantity').value) || 1;
            const total = price * quantity;

            itemElement.querySelector('.item-total').value = total ? formatCurrency(total) : '';
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;

            itemsContainer.querySelectorAll('.item-row').forEach(item => {
                const price = parseFloat(item.querySelector('.item-price').value) || 0;
                const quantity = parseFloat(item.querySelector('.item-quantity').value) || 1;
                total += price * quantity;
            });

            totalAmount.textContent = formatCurrency(total);

            // Check balance
            if (total > currentBalance) {
                balanceCheck.className = 'balance-check insufficient';
                balanceCheck.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Không đủ quỹ! Thiếu ' + formatCurrency(total - currentBalance);
                submitBtn.disabled = true;
            } else if (total > 0) {
                balanceCheck.className = 'balance-check sufficient';
                balanceCheck.innerHTML = '<i class="bi bi-check-circle"></i> Quỹ đủ để thanh toán';
                submitBtn.disabled = false;
            } else {
                balanceCheck.className = 'balance-check';
                balanceCheck.innerHTML = '<i class="bi bi-info-circle"></i> Nhập giá tiền các món đồ';
                submitBtn.disabled = true;
            }
        }

        function validateItem(itemElement) {
            const itemName = itemElement.querySelector('.item-name');
            const itemPrice = itemElement.querySelector('.item-price');

            let hasError = false;

            if (!itemName.value.trim()) {
                hasError = true;
            }

            if (!itemPrice.value || itemPrice.value < 100) {
                hasError = true;
            }

            itemElement.classList.toggle('has-error', hasError);
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
        }

        async function handleSubmit(e) {
            e.preventDefault();

            // Validate all items
            let hasError = false;
            itemsContainer.querySelectorAll('.item-row').forEach(item => {
                validateItem(item);
                if (item.classList.contains('has-error')) {
                    hasError = true;
                }
            });

            if (hasError) {
                showToast('Vui lòng kiểm tra lại thông tin các món đồ!', 'danger');
                return;
            }

            const originalText = submitBtn.innerHTML;
            showLoading(submitBtn);

            // Submit form normally
            this.submit();
        }

        // Expose removeItem to global scope
        window.removeItem = removeItem;
    });

</script>
@endpush

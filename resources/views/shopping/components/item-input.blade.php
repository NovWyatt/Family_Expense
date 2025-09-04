{{-- Shopping Item Input Component --}}
@props([
    'index' => 0,
    'item' => null,
    'showRemove' => true,
    'autoFocus' => false,
    'mode' => 'create' // 'create' hoặc 'edit'
])

@php
    $itemData = [
        'item_name' => old("items.{$index}.item_name", $item->item_name ?? ''),
        'price' => old("items.{$index}.price", $item->price ?? ''),
        'quantity' => old("items.{$index}.quantity", $item->quantity ?? 1),
        'notes' => old("items.{$index}.notes", $item->notes ?? '')
    ];

    $hasErrors = $errors->has("items.{$index}.item_name") ||
                 $errors->has("items.{$index}.price") ||
                 $errors->has("items.{$index}.quantity");
@endphp

<div class="item-input-card {{ $hasErrors ? 'has-errors' : '' }}" data-item-index="{{ $index }}">
    {{-- Card Header --}}
    <div class="item-card-header">
        <div class="item-number">
            <span class="item-badge">{{ $index + 1 }}</span>
            <span class="item-label">Món đồ</span>
        </div>

        @if($showRemove)
        <button type="button"
                class="remove-item-btn"
                onclick="removeItemInput({{ $index }})"
                title="Xóa món đồ này">
            <i class="bi bi-x-circle"></i>
        </button>
        @endif
    </div>

    {{-- Card Body --}}
    <div class="item-card-body">
        <div class="row g-3">
            {{-- Tên món đồ với Autocomplete --}}
            <div class="col-12">
                <div class="form-floating">
                    <input type="text"
                           class="form-control item-name-input @error("items.{$index}.item_name") is-invalid @enderror"
                           id="item_name_{{ $index }}"
                           name="items[{{ $index }}][item_name]"
                           value="{{ $itemData['item_name'] }}"
                           placeholder="Nhập tên món đồ..."
                           autocomplete="off"
                           data-item-index="{{ $index }}"
                           {{ $autoFocus ? 'autofocus' : '' }}
                           required>
                    <label for="item_name_{{ $index }}">
                        <i class="bi bi-bag me-2"></i>Tên món đồ *
                    </label>

                    {{-- Autocomplete dropdown --}}
                    <div class="autocomplete-dropdown" id="autocomplete_{{ $index }}"></div>

                    @error("items.{$index}.item_name")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Giá tiền --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text"
                           class="form-control price-input @error("items.{$index}.price") is-invalid @enderror"
                           id="item_price_{{ $index }}"
                           name="items[{{ $index }}][price]"
                           value="{{ $itemData['price'] ? number_format($itemData['price']) : '' }}"
                           placeholder="0"
                           data-item-index="{{ $index }}"
                           required>
                    <label for="item_price_{{ $index }}">
                        <i class="bi bi-currency-dollar me-2"></i>Giá tiền (VNĐ) *
                    </label>

                    {{-- Price suggestion --}}
                    <div class="price-suggestion" id="price_suggestion_{{ $index }}"></div>

                    @error("items.{$index}.price")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Số lượng --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="number"
                           class="form-control quantity-input @error("items.{$index}.quantity") is-invalid @enderror"
                           id="item_quantity_{{ $index }}"
                           name="items[{{ $index }}][quantity]"
                           value="{{ $itemData['quantity'] }}"
                           min="0.1"
                           max="999"
                           step="0.1"
                           placeholder="1"
                           data-item-index="{{ $index }}">
                    <label for="item_quantity_{{ $index }}">
                        <i class="bi bi-123 me-2"></i>Số lượng
                    </label>

                    @error("items.{$index}.quantity")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Ghi chú --}}
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control notes-input"
                              id="item_notes_{{ $index }}"
                              name="items[{{ $index }}][notes]"
                              placeholder="Ghi chú cho món đồ này..."
                              style="height: 80px"
                              maxlength="255">{{ $itemData['notes'] }}</textarea>
                    <label for="item_notes_{{ $index }}">
                        <i class="bi bi-sticky me-2"></i>Ghi chú
                    </label>
                    <small class="text-muted">Tùy chọn - VD: Loại to, màu đỏ, v.v...</small>
                </div>
            </div>
        </div>

        {{-- Thành tiền hiển thị --}}
        <div class="item-total-display" id="total_display_{{ $index }}">
            <div class="total-label">Thành tiền:</div>
            <div class="total-amount">0 VNĐ</div>
        </div>
    </div>

    {{-- Card Footer với Quick Actions --}}
    <div class="item-card-footer">
        <div class="quick-actions">
            {{-- Quick quantity buttons --}}
            <div class="quantity-quick-btns">
                <span class="quick-label">Số lượng nhanh:</span>
                <button type="button" class="btn-quantity-quick" onclick="setQuantity({{ $index }}, 0.5)">0.5</button>
                <button type="button" class="btn-quantity-quick" onclick="setQuantity({{ $index }}, 1)">1</button>
                <button type="button" class="btn-quantity-quick" onclick="setQuantity({{ $index }}, 2)">2</button>
                <button type="button" class="btn-quantity-quick" onclick="setQuantity({{ $index }}, 3)">3</button>
            </div>

            {{-- Duplicate button --}}
            <button type="button"
                    class="btn-duplicate"
                    onclick="duplicateItem({{ $index }})"
                    title="Nhân bản món đồ này">
                <i class="bi bi-files"></i>
                Nhân bản
            </button>
        </div>
    </div>
</div>

{{-- Component Styles --}}
<style>
.item-input-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
}

.item-input-card:hover {
    border-color: #ced4da;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.item-input-card:focus-within {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.item-input-card.has-errors {
    border-color: #dc3545;
    background: #fff5f5;
}

/* Card Header */
.item-card-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.item-input-card.has-errors .item-card-header {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border-color: #f1aeb5;
}

.item-number {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.item-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--bs-primary);
    color: white;
    border-radius: 50%;
    font-weight: 600;
    font-size: 0.875rem;
}

.item-input-card.has-errors .item-badge {
    background: #dc3545;
}

.item-label {
    font-weight: 600;
    color: #495057;
    font-size: 1.1rem;
}

.remove-item-btn {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 1.25rem;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.2s ease;
    cursor: pointer;
}

.remove-item-btn:hover {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

/* Card Body */
.item-card-body {
    padding: 1.25rem;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: var(--bs-primary);
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.form-floating > label i {
    color: #6c757d;
}

.form-floating > .form-control:focus ~ label i {
    color: var(--bs-primary);
}

/* Autocomplete */
.autocomplete-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ced4da;
    border-top: none;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    display: none;
}

.autocomplete-dropdown.show {
    display: block;
}

.autocomplete-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f3f4;
    transition: background-color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.autocomplete-item:hover,
.autocomplete-item.active {
    background: var(--bs-primary);
    color: white;
}

.autocomplete-item:last-child {
    border-bottom: none;
}

.autocomplete-item i {
    font-size: 0.875rem;
    opacity: 0.7;
}

/* Price Suggestion */
.price-suggestion {
    position: absolute;
    top: 100%;
    right: 0;
    background: #28a745;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0 0 4px 4px;
    font-size: 0.75rem;
    font-weight: 500;
    transform: translateY(-2px);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.price-suggestion.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.price-suggestion:hover {
    background: #218838;
}

/* Total Display */
.item-total-display {
    margin-top: 1rem;
    padding: 0.75rem 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid var(--bs-primary);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.total-label {
    font-weight: 500;
    color: #6c757d;
}

.total-amount {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bs-primary);
}

/* Card Footer */
.item-card-footer {
    padding: 1rem 1.25rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.quick-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.quantity-quick-btns {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.quick-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.btn-quantity-quick {
    background: white;
    border: 1px solid #ced4da;
    color: #495057;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-quantity-quick:hover {
    background: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.btn-duplicate {
    background: white;
    border: 1px solid #ced4da;
    color: #495057;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-duplicate:hover {
    background: var(--bs-success);
    border-color: var(--bs-success);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .item-card-header {
        padding: 0.75rem 1rem;
    }

    .item-card-body {
        padding: 1rem;
    }

    .item-card-footer {
        padding: 0.75rem 1rem;
    }

    .quick-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .quantity-quick-btns {
        justify-content: center;
    }

    .btn-duplicate {
        justify-content: center;
    }
}

/* Animation cho new item */
.item-input-card.new-item {
    animation: slideInUp 0.4s ease-out;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation cho remove item */
.item-input-card.removing {
    animation: slideOutRight 0.3s ease-in forwards;
}

@keyframes slideOutRight {
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

/* Loading state */
.autocomplete-loading {
    padding: 0.75rem 1rem;
    text-align: center;
    color: #6c757d;
    font-size: 0.875rem;
}

.autocomplete-loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

{{-- Component JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeItemInput({{ $index }});
});

// Initialize item input functionality
function initializeItemInput(index) {
    const itemNameInput = document.getElementById(`item_name_${index}`);
    const priceInput = document.getElementById(`item_price_${index}`);
    const quantityInput = document.getElementById(`item_quantity_${index}`);

    if (!itemNameInput) return;

    // Setup autocomplete
    setupAutocomplete(itemNameInput, index);

    // Setup price formatting
    setupPriceInput(priceInput, index);

    // Setup total calculation
    setupTotalCalculation(index);

    // Setup price suggestion
    setupPriceSuggestion(itemNameInput, index);
}

// Autocomplete functionality
function setupAutocomplete(input, index) {
    let debounceTimer;
    const dropdown = document.getElementById(`autocomplete_${index}`);

    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            hideAutocomplete(dropdown);
            return;
        }

        debounceTimer = setTimeout(() => {
            fetchItemSuggestions(query, dropdown, input, index);
        }, 300);
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            hideAutocomplete(dropdown);
        }
    });

    // Keyboard navigation
    input.addEventListener('keydown', function(e) {
        handleAutocompleteKeyboard(e, dropdown);
    });
}

// Fetch item suggestions from API
async function fetchItemSuggestions(query, dropdown, input, index) {
    try {
        showAutocompleteLoading(dropdown);

        const response = await fetch(`{{ route('shopping.api.item.suggestions') }}?search=${encodeURIComponent(query)}`);
        const suggestions = await response.json();

        if (suggestions && suggestions.length > 0) {
            showAutocompleteSuggestions(dropdown, suggestions, input, index);
        } else {
            showNoSuggestions(dropdown);
        }
    } catch (error) {
        console.error('Error fetching suggestions:', error);
        hideAutocomplete(dropdown);
    }
}

function showAutocompleteLoading(dropdown) {
    dropdown.innerHTML = '<div class="autocomplete-loading"><i class="bi bi-arrow-clockwise"></i> Đang tìm kiếm...</div>';
    dropdown.classList.add('show');
}

function showAutocompleteSuggestions(dropdown, suggestions, input, index) {
    const items = suggestions.map(suggestion => `
        <div class="autocomplete-item" data-value="${suggestion}">
            <i class="bi bi-bag"></i>
            ${suggestion}
        </div>
    `).join('');

    dropdown.innerHTML = items;
    dropdown.classList.add('show');

    // Add click handlers
    dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
        item.addEventListener('click', function() {
            input.value = this.dataset.value;
            hideAutocomplete(dropdown);

            // Trigger price suggestion
            fetchPriceSuggestion(input.value, index);

            // Focus next input
            const priceInput = document.getElementById(`item_price_${index}`);
            if (priceInput) priceInput.focus();
        });
    });
}

function showNoSuggestions(dropdown) {
    dropdown.innerHTML = '<div class="autocomplete-loading">Không tìm thấy gợi ý</div>';
    dropdown.classList.add('show');
}

function hideAutocomplete(dropdown) {
    dropdown.classList.remove('show');
}

function handleAutocompleteKeyboard(e, dropdown) {
    const items = dropdown.querySelectorAll('.autocomplete-item');
    const active = dropdown.querySelector('.autocomplete-item.active');

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (active && active.nextElementSibling) {
            active.classList.remove('active');
            active.nextElementSibling.classList.add('active');
        } else {
            items.forEach(item => item.classList.remove('active'));
            items[0]?.classList.add('active');
        }
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (active && active.previousElementSibling) {
            active.classList.remove('active');
            active.previousElementSibling.classList.add('active');
        } else {
            items.forEach(item => item.classList.remove('active'));
            items[items.length - 1]?.classList.add('active');
        }
    } else if (e.key === 'Enter' && active) {
        e.preventDefault();
        active.click();
    } else if (e.key === 'Escape') {
        hideAutocomplete(dropdown);
    }
}

// Price input formatting
function setupPriceInput(input, index) {
    if (!input) return;

    input.addEventListener('input', function() {
        // Remove all non-numeric characters
        let value = this.value.replace(/[^\d]/g, '');

        // Format with thousands separator
        if (value) {
            value = parseInt(value).toLocaleString('vi-VN');
        }

        this.value = value;
        updateItemTotal(index);
    });

    input.addEventListener('blur', function() {
        // Ensure minimum value
        const numValue = parseCurrency(this.value);
        if (numValue && numValue < 100) {
            this.value = '100';
            updateItemTotal(index);
        }
    });
}

// Total calculation
function setupTotalCalculation(index) {
    const priceInput = document.getElementById(`item_price_${index}`);
    const quantityInput = document.getElementById(`item_quantity_${index}`);

    [priceInput, quantityInput].forEach(input => {
        if (input) {
            input.addEventListener('input', () => updateItemTotal(index));
        }
    });

    // Initial calculation
    updateItemTotal(index);
}

function updateItemTotal(index) {
    const priceInput = document.getElementById(`item_price_${index}`);
    const quantityInput = document.getElementById(`item_quantity_${index}`);
    const totalDisplay = document.getElementById(`total_display_${index}`);

    if (!priceInput || !quantityInput || !totalDisplay) return;

    const price = parseCurrency(priceInput.value) || 0;
    const quantity = parseFloat(quantityInput.value) || 1;
    const total = price * quantity;

    const totalAmountEl = totalDisplay.querySelector('.total-amount');
    if (totalAmountEl) {
        totalAmountEl.textContent = total > 0 ? formatCurrency(total) : '0 VNĐ';

        // Update global total if function exists
        if (typeof updateGrandTotal === 'function') {
            updateGrandTotal();
        }
    }
}

// Price suggestion
function setupPriceSuggestion(itemNameInput, index) {
    itemNameInput.addEventListener('blur', function() {
        const itemName = this.value.trim();
        if (itemName.length > 2) {
            fetchPriceSuggestion(itemName, index);
        }
    });
}

async function fetchPriceSuggestion(itemName, index) {
    try {
        const response = await fetch(`{{ route('shopping.api.item.price') }}?item_name=${encodeURIComponent(itemName)}`);
        const data = await response.json();

        if (data.price) {
            showPriceSuggestion(index, data.price, data.formatted_price);
        }
    } catch (error) {
        console.error('Error fetching price suggestion:', error);
    }
}

function showPriceSuggestion(index, price, formattedPrice) {
    const suggestionEl = document.getElementById(`price_suggestion_${index}`);
    const priceInput = document.getElementById(`item_price_${index}`);

    if (!suggestionEl || !priceInput) return;

    // Don't show if user already has a price
    if (parseCurrency(priceInput.value) > 0) return;

    suggestionEl.textContent = `Đề xuất: ${formattedPrice}`;
    suggestionEl.classList.add('show');

    // Add click handler
    suggestionEl.onclick = function() {
        priceInput.value = formattedPrice;
        suggestionEl.classList.remove('show');
        updateItemTotal(index);

        // Focus quantity input
        const quantityInput = document.getElementById(`item_quantity_${index}`);
        if (quantityInput) quantityInput.focus();
    };

    // Auto-hide after 10 seconds
    setTimeout(() => {
        suggestionEl.classList.remove('show');
    }, 10000);
}

// Quick actions
function setQuantity(index, quantity) {
    const quantityInput = document.getElementById(`item_quantity_${index}`);
    if (quantityInput) {
        quantityInput.value = quantity;
        updateItemTotal(index);
    }
}

function duplicateItem(index) {
    if (typeof addNewItem === 'function') {
        const currentData = {
            item_name: document.getElementById(`item_name_${index}`)?.value || '',
            price: document.getElementById(`item_price_${index}`)?.value || '',
            quantity: document.getElementById(`item_quantity_${index}`)?.value || 1,
            notes: document.getElementById(`item_notes_${index}`)?.value || ''
        };

        addNewItem(currentData);
    }
}

function removeItemInput(index) {
    const card = document.querySelector(`[data-item-index="${index}"]`);
    if (card) {
        card.classList.add('removing');
        setTimeout(() => {
            if (typeof removeItem === 'function') {
                removeItem(index);
            } else {
                card.remove();
                updateItemIndices();
            }
        }, 300);
    }
}

function updateItemIndices() {
    const cards = document.querySelectorAll('.item-input-card');
    cards.forEach((card, newIndex) => {
        card.dataset.itemIndex = newIndex;
        const badge = card.querySelector('.item-badge');
        if (badge) badge.textContent = newIndex + 1;

        // Update all IDs and names
        const inputs = card.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            if (input.id) {
                input.id = input.id.replace(/_\d+$/, `_${newIndex}`);
            }
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${newIndex}]`);
            }
        });

        // Update labels
        const labels = card.querySelectorAll('label');
        labels.forEach(label => {
            if (label.getAttribute('for')) {
                label.setAttribute('for', label.getAttribute('for').replace(/_\d+$/, `_${newIndex}`));
            }
        });

        // Update other elements with IDs
        const otherElements = card.querySelectorAll('[id*="_"]');
        otherElements.forEach(el => {
            if (el.id) {
                el.id = el.id.replace(/_\d+$/, `_${newIndex}`);
            }
        });

        // Re-initialize functionality
        initializeItemInput(newIndex);
    });

    // Update global total
    if (typeof updateGrandTotal === 'function') {
        updateGrandTotal();
    }
}

// Utility functions
function parseCurrency(value) {
    if (!value) return 0;
    return parseInt(value.toString().replace(/[^\d]/g, '')) || 0;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + ' VNĐ';
}
</script>

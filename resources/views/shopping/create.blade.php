@extends('layouts.app')

@section('title', 'Thêm lần đi chợ mới')

@push('styles')
<style>
/* Shopping Create Styles */
.shopping-create-container {
    padding: 0;
    max-width: 1000px;
    margin: 0 auto;
}

/* Header Section */
.create-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 2.5rem 0;
    margin: -2rem -2rem 2rem -2rem;
    position: relative;
    overflow: hidden;
}

.create-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
    pointer-events: none;
}

.create-header-content {
    position: relative;
    z-index: 1;
}

.create-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.create-title h1 {
    font-size: 2.25rem;
    font-weight: 800;
    margin: 0;
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

.create-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

/* Fund Balance Display */
.fund-balance-display {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.5rem;
}

.balance-info h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    opacity: 0.8;
    font-weight: 500;
}

.balance-amount {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
}

.balance-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.balance-warning {
    background: rgba(251, 191, 36, 0.2);
    border: 1px solid rgba(251, 191, 36, 0.3);
    color: #fbbf24;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Form Container */
.create-form-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    margin-bottom: 2rem;
}

.form-header {
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #e9ecef;
}

.form-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-subtitle {
    margin: 0.5rem 0 0 0;
    color: #6c757d;
    font-size: 1rem;
}

/* Form Body */
.form-body {
    padding: 2rem;
}

/* Basic Info Section */
.basic-info-section {
    margin-bottom: 3rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title i {
    color: var(--bs-primary);
}

.basic-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: start;
}

/* Items Section */
.items-section {
    margin-bottom: 2rem;
}

.items-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.items-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #2c3e50;
}

.add-item-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.add-item-btn:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.items-container {
    min-height: 200px;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Total Summary */
.total-summary {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid #e9ecef;
    border-radius: 16px;
    padding: 1.5rem;
    margin-top: 2rem;
    position: sticky;
    bottom: 2rem;
    z-index: 100;
}

.summary-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.summary-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-label {
    font-size: 1rem;
    color: #6c757d;
    font-weight: 500;
}

.summary-amount {
    font-size: 2rem;
    font-weight: 800;
    color: #10b981;
    margin: 0;
}

.summary-meta {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    gap: 1rem;
}

.balance-check {
    padding: 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.balance-check.sufficient {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #059669;
}

.balance-check.insufficient {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

.balance-check.warning {
    background: rgba(251, 191, 36, 0.1);
    border: 1px solid rgba(251, 191, 36, 0.3);
    color: #d97706;
}

/* Form Actions */
.form-actions {
    padding: 2rem;
    background: #f8f9fa;
    border-top: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.btn-cancel {
    background: white;
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-cancel:hover {
    background: #f8f9fa;
    color: #495057;
    border-color: #adb5bd;
    transform: translateY(-1px);
}

.btn-save {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
}

.btn-save:hover:not(:disabled) {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
}

.btn-save:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.draft-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.auto-save-status {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.auto-save-status.saving {
    color: #f59e0b;
}

.auto-save-status.saved {
    color: #10b981;
}

/* Progress Indicator */
.progress-indicator {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #e9ecef;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.progress-indicator.show {
    opacity: 1;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #059669);
    width: 0%;
    transition: width 0.3s ease;
}

/* Empty State */
.empty-items {
    text-align: center;
    padding: 3rem 2rem;
    color: #6c757d;
}

.empty-icon {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.empty-text {
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

/* Quick Templates */
.quick-templates {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.templates-header {
    margin-bottom: 1rem;
}

.templates-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.templates-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.template-item {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.template-item:hover {
    background: #e9ecef;
    border-color: #10b981;
    transform: translateY(-1px);
}

.template-name {
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.template-items {
    font-size: 0.875rem;
    color: #6c757d;
}

/* Responsive Design */
@media (max-width: 768px) {
    .create-header {
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    }

    .create-title h1 {
        font-size: 2rem;
    }

    .fund-balance-display {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .basic-info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .action-buttons {
        justify-content: center;
    }

    .total-summary {
        position: static;
        margin: 1rem 0;
    }

    .summary-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .templates-list {
        grid-template-columns: 1fr;
    }
}

/* Animation for new items */
.item-input-card.new-item {
    animation: slideInDown 0.4s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading states */
.btn-save.loading {
    pointer-events: none;
}

.btn-save.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .create-form-container,
    .quick-templates {
        background: #212529;
        color: #f8f9fa;
    }

    .form-header {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }

    .total-summary {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        border-color: #495057;
    }

    .form-actions {
        background: #343a40;
        border-color: #495057;
    }

    .template-item {
        background: #343a40;
        border-color: #495057;
        color: #f8f9fa;
    }

    .template-item:hover {
        background: #495057;
    }
}
</style>
@endpush

@section('content')
<div class="shopping-create-container">
    {{-- Header Section --}}
    <div class="create-header">
        <div class="container-fluid create-header-content">
            <div class="create-title">
                <h1>
                    <div class="title-icon">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    Thêm lần đi chợ mới
                </h1>
            </div>

            <div class="create-subtitle">
                Ghi lại chi tiết các món đồ đã mua để theo dõi chi tiêu hiệu quả
            </div>

            {{-- Fund Balance Display --}}
            <div class="fund-balance-display">
                <div class="balance-info">
                    <h3>Số dư quỹ hiện tại</h3>
                    <div class="balance-amount" id="currentBalance">
                        {{ number_format($currentBalance) }} VNĐ
                    </div>
                </div>
                <div class="balance-status">
                    <i class="bi bi-info-circle"></i>
                    <span>Kiểm tra số dư trước khi mua sắm</span>
                </div>
            </div>

            @if($currentBalance < 100000)
            <div class="balance-warning">
                <i class="bi bi-exclamation-triangle"></i>
                Số dư quỹ thấp (dưới 100,000 VNĐ). Hãy cân nhắc nạp thêm tiền.
            </div>
            @endif
        </div>
    </div>

    {{-- Quick Templates --}}
    <div class="quick-templates">
        <div class="templates-header">
            <h6 class="templates-title">
                <i class="bi bi-lightning-charge"></i>
                Mẫu nhanh thường dùng
            </h6>
        </div>
        <div class="templates-list">
            <div class="template-item" onclick="loadTemplate('daily')">
                <div class="template-name">Đi chợ hàng ngày</div>
                <div class="template-items">Rau, thịt, gia vị cơ bản</div>
            </div>
            <div class="template-item" onclick="loadTemplate('weekend')">
                <div class="template-name">Cuối tuần</div>
                <div class="template-items">Thực phẩm cho cả tuần</div>
            </div>
            <div class="template-item" onclick="loadTemplate('party')">
                <div class="template-name">Tiệc nhỏ</div>
                <div class="template-items">Đồ ăn vặt, nước uống</div>
            </div>
        </div>
    </div>

    {{-- Main Form --}}
    <form action="{{ route('shopping.store') }}" method="POST" id="shoppingForm" class="needs-validation" novalidate>
        @csrf

        <div class="create-form-container">
            {{-- Form Header --}}
            <div class="form-header">
                <h2 class="form-title">
                    <i class="bi bi-clipboard-data"></i>
                    Thông tin chi tiết
                </h2>
                <p class="form-subtitle">Nhập ngày đi chợ và danh sách món đồ đã mua</p>
            </div>

            {{-- Form Body --}}
            <div class="form-body">
                {{-- Basic Information --}}
                <div class="basic-info-section">
                    <h3 class="section-title">
                        <i class="bi bi-calendar-event"></i>
                        Thông tin cơ bản
                    </h3>

                    <div class="basic-info-grid">
                        <div class="form-floating">
                            <input type="date"
                                   class="form-control @error('shopping_date') is-invalid @enderror"
                                   id="shopping_date"
                                   name="shopping_date"
                                   value="{{ old('shopping_date', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   required>
                            <label for="shopping_date">
                                <i class="bi bi-calendar me-2"></i>Ngày đi chợ *
                            </label>
                            @error('shopping_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating">
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes"
                                      name="notes"
                                      placeholder="Ghi chú về lần đi chợ này..."
                                      style="height: 100px"
                                      maxlength="500">{{ old('notes') }}</textarea>
                            <label for="notes">
                                <i class="bi bi-sticky me-2"></i>Ghi chú (tùy chọn)
                            </label>
                            <small class="form-text text-muted">Tối đa 500 ký tự</small>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Items Section --}}
                <div class="items-section">
                    <div class="items-header">
                        <h3 class="items-title">
                            <i class="bi bi-bag-check"></i>
                            Danh sách món đồ
                            <span class="badge bg-primary ms-2" id="itemCount">0</span>
                        </h3>
                        <button type="button" class="add-item-btn" onclick="addNewItem()">
                            <i class="bi bi-plus-circle"></i>
                            Thêm món đồ
                        </button>
                    </div>

                    <div class="items-container">
                        <div class="items-list" id="itemsList">
                            {{-- Items will be added dynamically --}}
                        </div>

                        {{-- Empty state --}}
                        <div class="empty-items" id="emptyState">
                            <div class="empty-icon">
                                <i class="bi bi-basket"></i>
                            </div>
                            <div class="empty-title">Chưa có món đồ nào</div>
                            <div class="empty-text">
                                Hãy thêm món đồ đầu tiên bằng cách nhấn nút "Thêm món đồ" hoặc chọn mẫu nhanh bên trên.
                            </div>
                            <button type="button" class="btn btn-primary" onclick="addNewItem()">
                                <i class="bi bi-plus-circle"></i>
                                Thêm món đồ đầu tiên
                            </button>
                        </div>
                    </div>

                    {{-- Total Summary --}}
                    <div class="total-summary" id="totalSummary" style="display: none;">
                        <div class="summary-content">
                            <div class="summary-details">
                                <div class="summary-label">Tổng cộng</div>
                                <div class="summary-amount" id="grandTotal">0 VNĐ</div>
                                <div class="summary-meta">
                                    <span id="totalItems">0 món đồ</span>
                                    <span id="avgPerItem">0 VNĐ/món</span>
                                </div>
                            </div>
                            <div class="balance-check" id="balanceCheck">
                                <i class="bi bi-check-circle"></i>
                                Số dư đủ
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <div class="draft-actions">
                    <div class="auto-save-status" id="autoSaveStatus">
                        <i class="bi bi-cloud"></i>
                        <span>Tự động lưu nháp</span>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadDraft()">
                        <i class="bi bi-folder2-open"></i>
                        Tải nháp
                    </button>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('shopping.index') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i>
                        Hủy
                    </a>
                    <button type="submit" class="btn-save" id="saveBtn">
                        <i class="bi bi-check-circle"></i>
                        Lưu lần đi chợ
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Progress Indicator --}}
<div class="progress-indicator" id="progressIndicator">
    <div class="progress-bar" id="progressBar"></div>
</div>
@endsection

@push('scripts')
<script>
// Global variables
let itemIndex = 0;
let itemSuggestions = @json($itemSuggestions);
let currentBalance = {{ $currentBalance }};

// Templates data
const templates = {
    daily: [
        { name: 'Rau cải xanh', price: 15000, quantity: 1 },
        { name: 'Thịt heo ba chỉ', price: 120000, quantity: 0.5 },
        { name: 'Cà chua', price: 25000, quantity: 1 },
        { name: 'Hành tím', price: 20000, quantity: 0.5 }
    ],
    weekend: [
        { name: 'Gạo ST25', price: 180000, quantity: 5 },
        { name: 'Thịt bò', price: 350000, quantity: 1 },
        { name: 'Cá thu', price: 200000, quantity: 1 },
        { name: 'Rau xanh các loại', price: 80000, quantity: 1 }
    ],
    party: [
        { name: 'Bánh mì sandwich', price: 50000, quantity: 10 },
        { name: 'Nước ngọt', price: 120000, quantity: 1 },
        { name: 'Kem', price: 80000, quantity: 1 },
        { name: 'Trái cây', price: 100000, quantity: 1 }
    ]
};

document.addEventListener('DOMContentLoaded', function() {
    initializeShoppingCreate();
    loadDraftFromStorage();
    setupAutoSave();
});

// Initialize shopping create functionality
function initializeShoppingCreate() {
    // Setup form validation
    setupFormValidation();

    // Initialize tooltips
    initializeTooltips();

    // Setup keyboard shortcuts
    setupKeyboardShortcuts();

    // Load old input if validation fails
    loadOldInput();

    // Add first item if none exist
    if (itemIndex === 0) {
        addNewItem(true);
    }
}

// Setup form validation
function setupFormValidation() {
    const form = document.getElementById('shoppingForm');

    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Check if has items
        if (itemIndex === 0) {
            e.preventDefault();
            alert('Vui lòng thêm ít nhất một món đồ.');
            return;
        }

        // Show loading state
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.classList.add('loading');
        saveBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Đang lưu...';
        saveBtn.disabled = true;

        // Show progress
        showProgress();

        form.classList.add('was-validated');
    });
}

// Add new item
function addNewItem(autoFocus = false, itemData = null) {
    const itemsList = document.getElementById('itemsList');
    const emptyState = document.getElementById('emptyState');

    // Hide empty state
    if (emptyState) {
        emptyState.style.display = 'none';
    }

    // Create item container
    const itemContainer = document.createElement('div');
    itemContainer.innerHTML = createItemInputHTML(itemIndex, itemData);

    // Add to list
    itemsList.appendChild(itemContainer.firstElementChild);

    // Initialize the new item input
    setTimeout(() => {
        initializeItemInput(itemIndex);
        if (autoFocus) {
            const nameInput = document.getElementById(`item_name_${itemIndex}`);
            if (nameInput) nameInput.focus();
        }
    }, 100);

    itemIndex++;
    updateItemCount();
    updateGrandTotal();
    saveDraftToStorage();
}

// Create item input HTML using the component
function createItemInputHTML(index, itemData = null) {
    return `
        <x-shopping.item-input
            :index="${index}"
            :item="${itemData ? JSON.stringify(itemData) : 'null'}"
            :showRemove="true"
            :autoFocus="${index === 0}" />
    `;
}

// Remove item
function removeItem(index) {
    const itemElement = document.querySelector(`[data-item-index="${index}"]`);
    if (itemElement) {
        itemElement.remove();
        updateItemIndices();
        updateItemCount();
        updateGrandTotal();
        saveDraftToStorage();

        // Show empty state if no items
        if (document.querySelectorAll('.item-input-card').length === 0) {
            document.getElementById('emptyState').style.display = 'block';
            document.getElementById('totalSummary').style.display = 'none';
        }
    }
}

// Update item count
function updateItemCount() {
    const count = document.querySelectorAll('.item-input-card').length;
    const itemCountEl = document.getElementById('itemCount');
    if (itemCountEl) {
        itemCountEl.textContent = count;
    }
}

// Update grand total
function updateGrandTotal() {
    const items = document.querySelectorAll('.item-input-card');
    let total = 0;
    let itemCount = 0;

    items.forEach(item => {
        const priceInput = item.querySelector('.price-input');
        const quantityInput = item.querySelector('.quantity-input');

        if (priceInput && quantityInput) {
            const price = parseCurrency(priceInput.value) || 0;
            const quantity = parseFloat(quantityInput.value) || 1;
            total += price * quantity;
            itemCount++;
        }
    });

    // Update display
    const grandTotalEl = document.getElementById('grandTotal');
    const totalItemsEl = document.getElementById('totalItems');
    const avgPerItemEl = document.getElementById('avgPerItem');
    const totalSummary = document.getElementById('totalSummary');

    if (grandTotalEl) grandTotalEl.textContent = formatCurrency(total);
    if (totalItemsEl) totalItemsEl.textContent = `${itemCount} món đồ`;
    if (avgPerItemEl) avgPerItemEl.textContent = itemCount > 0 ? formatCurrency(total / itemCount) + '/món' : '0 VNĐ/món';

    // Show/hide summary
    if (totalSummary) {
        totalSummary.style.display = itemCount > 0 ? 'block' : 'none';
    }

    // Update balance check
    updateBalanceCheck(total);
}

// Update balance check
function updateBalanceCheck(total) {
    const balanceCheck = document.getElementById('balanceCheck');
    if (!balanceCheck) return;

    const remaining = currentBalance - total;
    const percentage = total / currentBalance;

    balanceCheck.classList.remove('sufficient', 'warning', 'insufficient');

    if (remaining < 0) {
        balanceCheck.classList.add('insufficient');
        balanceCheck.innerHTML = `
            <i class="bi bi-exclamation-triangle"></i>
            Vượt quỹ ${formatCurrency(Math.abs(remaining))}
        `;
    } else if (percentage > 0.8) {
        balanceCheck.classList.add('warning');
        balanceCheck.innerHTML = `
            <i class="bi bi-exclamation-circle"></i>
            Còn lại ${formatCurrency(remaining)}
        `;
    } else {
        balanceCheck.classList.add('sufficient');
        balanceCheck.innerHTML = `
            <i class="bi bi-check-circle"></i>
            Còn lại ${formatCurrency(remaining)}
        `;
    }
}

// Load template
function loadTemplate(templateName) {
    if (!templates[templateName]) return;

    // Clear existing items
    const itemsList = document.getElementById('itemsList');
    itemsList.innerHTML = '';
    itemIndex = 0;

    // Add template items
    templates[templateName].forEach((item, index) => {
        addNewItem(index === 0, item);
    });

    showSuccessMessage(`Đã tải mẫu "${getTemplateName(templateName)}"`);
}

// Get template display name
function getTemplateName(templateName) {
    const names = {
        daily: 'Đi chợ hàng ngày',
        weekend: 'Cuối tuần',
        party: 'Tiệc nhỏ'
    };
    return names[templateName] || templateName;
}

// Auto-save functionality
function setupAutoSave() {
    let autoSaveTimeout;

    // Auto-save on input changes
    document.addEventListener('input', function(e) {
        if (e.target.closest('#shoppingForm')) {
            clearTimeout(autoSaveTimeout);

            // Update status
            const status = document.getElementById('autoSaveStatus');
            if (status) {
                status.classList.remove('saved');
                status.classList.add('saving');
                status.innerHTML = '<i class="bi bi-cloud-arrow-up"></i> Đang lưu...';
            }

            autoSaveTimeout = setTimeout(() => {
                saveDraftToStorage();

                if (status) {
                    status.classList.remove('saving');
                    status.classList.add('saved');
                    status.innerHTML = '<i class="bi bi-cloud-check"></i> Đã lưu nháp';
                }
            }, 1000);
        }
    });
}

// Save draft to localStorage
function saveDraftToStorage() {
    try {
        const formData = {
            shopping_date: document.getElementById('shopping_date')?.value || '',
            notes: document.getElementById('notes')?.value || '',
            items: []
        };

        // Collect all items
        document.querySelectorAll('.item-input-card').forEach((item, index) => {
            const nameInput = item.querySelector('.item-name-input');
            const priceInput = item.querySelector('.price-input');
            const quantityInput = item.querySelector('.quantity-input');
            const notesInput = item.querySelector('.notes-input');

            if (nameInput && nameInput.value.trim()) {
                formData.items.push({
                    item_name: nameInput.value.trim(),
                    price: priceInput?.value || '',
                    quantity: quantityInput?.value || '1',
                    notes: notesInput?.value || ''
                });
            }
        });

        localStorage.setItem('shopping_create_draft', JSON.stringify(formData));
        localStorage.setItem('shopping_create_draft_time', Date.now().toString());

    } catch (error) {
        console.error('Error saving draft:', error);
    }
}

// Load draft from localStorage
function loadDraftFromStorage() {
    try {
        const draftData = localStorage.getItem('shopping_create_draft');
        const draftTime = localStorage.getItem('shopping_create_draft_time');

        if (!draftData || !draftTime) return;

        // Check if draft is recent (within 24 hours)
        const draftAge = Date.now() - parseInt(draftTime);
        if (draftAge > 24 * 60 * 60 * 1000) {
            clearDraft();
            return;
        }

        const data = JSON.parse(draftData);

        // Don't auto-load if user is coming from validation errors
        if (hasValidationErrors()) return;

        // Show draft notification if has significant data
        if (data.items.length > 0 || data.notes.trim()) {
            showDraftNotification(data);
        }

    } catch (error) {
        console.error('Error loading draft:', error);
        clearDraft();
    }
}

// Load draft data into form
function loadDraft() {
    try {
        const draftData = localStorage.getItem('shopping_create_draft');
        if (!draftData) {
            alert('Không có nháp nào được lưu.');
            return;
        }

        const data = JSON.parse(draftData);

        // Load basic info
        if (data.shopping_date) {
            document.getElementById('shopping_date').value = data.shopping_date;
        }
        if (data.notes) {
            document.getElementById('notes').value = data.notes;
        }

        // Clear existing items
        const itemsList = document.getElementById('itemsList');
        itemsList.innerHTML = '';
        itemIndex = 0;

        // Load items
        if (data.items && data.items.length > 0) {
            data.items.forEach((item, index) => {
                addNewItem(index === 0, item);
            });
        } else {
            addNewItem(true);
        }

        showSuccessMessage('Đã tải nháp thành công');

    } catch (error) {
        console.error('Error loading draft:', error);
        alert('Có lỗi khi tải nháp');
    }
}

// Show draft notification
function showDraftNotification(data) {
    const notification = document.createElement('div');
    notification.className = 'position-fixed top-0 end-0 p-3';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="bi bi-cloud text-info me-2"></i>
                <strong class="me-auto">Có nháp đã lưu</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Bạn có ${data.items.length} món đồ trong nháp.
                <div class="mt-2">
                    <button class="btn btn-sm btn-primary me-2" onclick="loadDraft(); this.closest('.toast').remove();">Tải nháp</button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="clearDraft(); this.closest('.toast').remove();">Bỏ qua</button>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto remove after 10 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 10000);
}

// Clear draft
function clearDraft() {
    localStorage.removeItem('shopping_create_draft');
    localStorage.removeItem('shopping_create_draft_time');

    const status = document.getElementById('autoSaveStatus');
    if (status) {
        status.classList.remove('saving', 'saved');
        status.innerHTML = '<i class="bi bi-cloud"></i> Tự động lưu nháp';
    }
}

// Check if form has validation errors
function hasValidationErrors() {
    return document.querySelector('.is-invalid') !== null;
}

// Load old input from Laravel
function loadOldInput() {
    @if(old('items'))
        const oldItems = @json(old('items'));

        // Clear existing items first
        const itemsList = document.getElementById('itemsList');
        itemsList.innerHTML = '';
        itemIndex = 0;

        // Add old items
        oldItems.forEach((item, index) => {
            addNewItem(index === 0, item);
        });
    @endif
}

// Setup keyboard shortcuts
function setupKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter = Save
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            const saveBtn = document.getElementById('saveBtn');
            if (saveBtn && !saveBtn.disabled) {
                saveBtn.click();
            }
        }

        // Ctrl/Cmd + N = Add item
        if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
            e.preventDefault();
            addNewItem(true);
        }

        // Escape = Cancel
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-cancel');
            if (cancelBtn && confirm('Bạn có chắc chắn muốn hủy? Dữ liệu chưa lưu sẽ mất.')) {
                window.location.href = cancelBtn.href;
            }
        }
    });
}

// Initialize tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Show progress indicator
function showProgress() {
    const indicator = document.getElementById('progressIndicator');
    const bar = document.getElementById('progressBar');

    if (indicator && bar) {
        indicator.classList.add('show');

        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 90) progress = 90;
            bar.style.width = progress + '%';
        }, 200);

        // Complete on form submission
        setTimeout(() => {
            clearInterval(interval);
            bar.style.width = '100%';
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 500);
        }, 2000);
    }
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

    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + ' VNĐ';
}

function parseCurrency(str) {
    if (!str) return 0;
    return parseInt(str.replace(/[^\d]/g, '')) || 0;
}

// Export functions for use in item-input component
window.addNewItem = addNewItem;
window.removeItem = removeItem;
window.updateGrandTotal = updateGrandTotal;
window.loadTemplate = loadTemplate;
window.loadDraft = loadDraft;
window.clearDraft = clearDraft;

// Prevent accidental page leave
window.addEventListener('beforeunload', function(e) {
    const items = document.querySelectorAll('.item-input-card');
    if (items.length > 0) {
        const hasData = Array.from(items).some(item => {
            const nameInput = item.querySelector('.item-name-input');
            return nameInput && nameInput.value.trim();
        });

        if (hasData) {
            e.preventDefault();
            e.returnValue = 'Bạn có dữ liệu chưa lưu. Bạn có chắc chắn muốn rời khỏi trang này?';
        }
    }
});

// Clear draft on successful form submission
document.getElementById('shoppingForm').addEventListener('submit', function() {
    // Clear draft after small delay to ensure form is valid
    setTimeout(() => {
        clearDraft();
    }, 100);
});
</script>
@endpush

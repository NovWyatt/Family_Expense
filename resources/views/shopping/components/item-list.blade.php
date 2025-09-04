{{-- Shopping Item List Component --}}
@props([
    'items' => collect(),
    'showActions' => true,
    'viewMode' => 'list', // 'list', 'grid', 'table'
    'allowSort' => true,
    'allowFilter' => true,
    'allowSelect' => false,
    'showTotal' => true,
    'editable' => false,
    'trip' => null
])

@php
    $totalAmount = $items->sum('total_price');
    $totalItems = $items->count();
    $hasItems = $items->count() > 0;
@endphp

<div class="item-list-container" data-view-mode="{{ $viewMode }}">
    @if($allowFilter || $allowSort || $showActions)
    {{-- List Header --}}
    <div class="item-list-header">
        <div class="list-info">
            <h5 class="list-title">
                <i class="bi bi-bag-check"></i>
                Danh sách món đồ
                @if($totalItems > 0)
                <span class="item-count">({{ $totalItems }} món)</span>
                @endif
            </h5>
            @if($showTotal)
            <div class="list-subtitle">
                Tổng tiền: <span class="total-amount">{{ number_format($totalAmount) }} VNĐ</span>
            </div>
            @endif
        </div>

        <div class="list-actions">
            @if($allowSort)
            {{-- Sort Controls --}}
            <div class="sort-controls">
                <select class="form-select form-select-sm" id="sortItems" onchange="sortItems(this.value)">
                    <option value="order">Thứ tự mặc định</option>
                    <option value="name_asc">Tên A-Z</option>
                    <option value="name_desc">Tên Z-A</option>
                    <option value="price_asc">Giá thấp đến cao</option>
                    <option value="price_desc">Giá cao đến thấp</option>
                    <option value="total_asc">Thành tiền thấp đến cao</option>
                    <option value="total_desc">Thành tiền cao đến thấp</option>
                    <option value="quantity_desc">Số lượng nhiều nhất</option>
                </select>
            </div>
            @endif

            {{-- View Mode Toggle --}}
            <div class="view-mode-toggle btn-group btn-group-sm" role="group">
                <input type="radio" class="btn-check" name="viewMode" id="viewList" value="list" {{ $viewMode === 'list' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="viewList" onclick="changeViewMode('list')">
                    <i class="bi bi-list-ul"></i>
                </label>

                <input type="radio" class="btn-check" name="viewMode" id="viewGrid" value="grid" {{ $viewMode === 'grid' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="viewGrid" onclick="changeViewMode('grid')">
                    <i class="bi bi-grid"></i>
                </label>

                <input type="radio" class="btn-check" name="viewMode" id="viewTable" value="table" {{ $viewMode === 'table' ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="viewTable" onclick="changeViewMode('table')">
                    <i class="bi bi-table"></i>
                </label>
            </div>

            @if($allowSelect)
            {{-- Select All --}}
            <div class="select-controls">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAllItems" onchange="toggleSelectAll(this)">
                    <label class="form-check-label" for="selectAllItems">
                        Chọn tất cả
                    </label>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Filter Bar (if enabled) --}}
    @if($allowFilter)
    <div class="item-filter-bar">
        <div class="filter-item">
            <input type="text" class="form-control form-control-sm" id="searchItems" placeholder="Tìm kiếm món đồ..." onkeyup="filterItems()">
        </div>
        <div class="filter-item">
            <select class="form-select form-select-sm" id="priceRangeFilter" onchange="filterItems()">
                <option value="">Tất cả giá</option>
                <option value="0-50000">Dưới 50k</option>
                <option value="50000-100000">50k - 100k</option>
                <option value="100000-200000">100k - 200k</option>
                <option value="200000-500000">200k - 500k</option>
                <option value="500000-999999999">Trên 500k</option>
            </select>
        </div>
        <div class="filter-item">
            <button class="btn btn-sm btn-outline-secondary" onclick="clearFilters()">
                <i class="bi bi-x-circle"></i>
                Xóa bộ lọc
            </button>
        </div>
    </div>
    @endif

    {{-- Items Display Area --}}
    <div class="item-list-body">
        @if($hasItems)
            {{-- List View --}}
            <div class="item-view item-list-view" id="listView" style="{{ $viewMode === 'list' ? '' : 'display: none;' }}">
                <div class="items-container" id="listItems">
                    @foreach($items as $index => $item)
                    <div class="item-row" data-item-id="{{ $item->id }}" data-search-text="{{ strtolower($item->item_name . ' ' . ($item->notes ?? '')) }}">
                        @if($allowSelect)
                        <div class="item-select">
                            <div class="form-check">
                                <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->id }}" onchange="updateSelection()">
                            </div>
                        </div>
                        @endif

                        <div class="item-info">
                            <div class="item-main">
                                <div class="item-name">
                                    <i class="bi bi-bag item-icon"></i>
                                    {{ $item->item_name }}
                                </div>
                                @if($item->notes)
                                <div class="item-notes">
                                    <i class="bi bi-sticky"></i>
                                    {{ $item->notes }}
                                </div>
                                @endif
                            </div>

                            <div class="item-details">
                                <div class="detail-item">
                                    <span class="detail-label">Đơn giá:</span>
                                    <span class="detail-value price-value">{{ number_format($item->price) }}đ</span>
                                </div>
                                @if($item->quantity != 1)
                                <div class="detail-item">
                                    <span class="detail-label">Số lượng:</span>
                                    <span class="detail-value quantity-value">{{ $item->formatted_quantity }}</span>
                                </div>
                                @endif
                                <div class="detail-item">
                                    <span class="detail-label">Thành tiền:</span>
                                    <span class="detail-value total-value">{{ number_format($item->total_price) }}đ</span>
                                </div>
                            </div>
                        </div>

                        @if($showActions)
                        <div class="item-actions">
                            @if($editable)
                            <button class="btn btn-sm btn-outline-primary" onclick="editItem({{ $item->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem({{ $item->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                            @else
                            <button class="btn btn-sm btn-outline-info" onclick="viewItemDetails({{ $item->id }})">
                                <i class="bi bi-info-circle"></i>
                            </button>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Grid View --}}
            <div class="item-view item-grid-view" id="gridView" style="{{ $viewMode === 'grid' ? '' : 'display: none;' }}">
                <div class="items-grid" id="gridItems">
                    @foreach($items as $index => $item)
                    <div class="item-card" data-item-id="{{ $item->id }}" data-search-text="{{ strtolower($item->item_name . ' ' . ($item->notes ?? '')) }}">
                        @if($allowSelect)
                        <div class="card-select">
                            <div class="form-check">
                                <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->id }}" onchange="updateSelection()">
                            </div>
                        </div>
                        @endif

                        <div class="card-header">
                            <div class="item-icon-wrapper">
                                <i class="bi bi-bag item-icon"></i>
                            </div>
                            <h6 class="item-name">{{ $item->item_name }}</h6>
                        </div>

                        <div class="card-body">
                            <div class="price-display">
                                <div class="unit-price">{{ number_format($item->price) }}đ</div>
                                @if($item->quantity != 1)
                                <div class="quantity">x{{ $item->formatted_quantity }}</div>
                                @endif
                            </div>

                            <div class="total-price">{{ number_format($item->total_price) }}đ</div>

                            @if($item->notes)
                            <div class="item-notes">
                                <small class="text-muted">{{ $item->notes }}</small>
                            </div>
                            @endif
                        </div>

                        @if($showActions)
                        <div class="card-actions">
                            @if($editable)
                            <button class="btn btn-sm btn-outline-primary" onclick="editItem({{ $item->id }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteItem({{ $item->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                            @else
                            <button class="btn btn-sm btn-outline-info" onclick="viewItemDetails({{ $item->id }})">
                                <i class="bi bi-eye"></i>
                            </button>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Table View --}}
            <div class="item-view item-table-view" id="tableView" style="{{ $viewMode === 'table' ? '' : 'display: none;' }}">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                @if($allowSelect)
                                <th width="5%">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllTable" onchange="toggleSelectAll(this)">
                                    </div>
                                </th>
                                @endif
                                <th width="5%">#</th>
                                <th width="30%">Tên món đồ</th>
                                <th width="15%" class="text-end">Đơn giá</th>
                                <th width="10%" class="text-center">Số lượng</th>
                                <th width="15%" class="text-end">Thành tiền</th>
                                <th width="25%">Ghi chú</th>
                                @if($showActions)
                                <th width="10%" class="text-center">Thao tác</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="tableItems">
                            @foreach($items as $index => $item)
                            <tr data-item-id="{{ $item->id }}" data-search-text="{{ strtolower($item->item_name . ' ' . ($item->notes ?? '')) }}">
                                @if($allowSelect)
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" value="{{ $item->id }}" onchange="updateSelection()">
                                    </div>
                                </td>
                                @endif
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-bag me-2 text-primary"></i>
                                        <strong>{{ $item->item_name }}</strong>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="price-value">{{ number_format($item->price) }}đ</span>
                                </td>
                                <td class="text-center">
                                    <span class="quantity-value">{{ $item->formatted_quantity }}</span>
                                </td>
                                <td class="text-end">
                                    <strong class="total-value text-success">{{ number_format($item->total_price) }}đ</strong>
                                </td>
                                <td>
                                    @if($item->notes)
                                    <small class="text-muted">{{ $item->notes }}</small>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                                @if($showActions)
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        @if($editable)
                                        <button class="btn btn-outline-primary" onclick="editItem({{ $item->id }})" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteItem({{ $item->id }})" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @else
                                        <button class="btn btn-outline-info" onclick="viewItemDetails({{ $item->id }})" title="Chi tiết">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        @if($showTotal)
                        <tfoot class="table-light">
                            <tr>
                                @if($allowSelect)<td></td>@endif
                                <td><strong>Tổng:</strong></td>
                                <td><strong>{{ $totalItems }} món</strong></td>
                                <td></td>
                                <td class="text-center"><strong id="totalQuantity">{{ $items->sum('quantity') }}</strong></td>
                                <td class="text-end"><strong class="text-success" id="grandTotal">{{ number_format($totalAmount) }}đ</strong></td>
                                <td></td>
                                @if($showActions)<td></td>@endif
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-basket"></i>
                </div>
                <div class="empty-title">Chưa có món đồ nào</div>
                <div class="empty-text">Danh sách món đồ trống. Hãy thêm món đồ đầu tiên.</div>
                @if($editable)
                <button class="btn btn-primary" onclick="addFirstItem()">
                    <i class="bi bi-plus-circle"></i>
                    Thêm món đồ đầu tiên
                </button>
                @endif
            </div>
        @endif
    </div>

    @if($allowSelect)
    {{-- Bulk Actions Bar --}}
    <div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
        <div class="bulk-info">
            <span id="selectedCount">0</span> món đã chọn
        </div>
        <div class="bulk-actions">
            <button class="btn btn-sm btn-outline-primary" onclick="exportSelectedItems()">
                <i class="bi bi-download"></i>
                Xuất danh sách
            </button>
            @if($editable)
            <button class="btn btn-sm btn-outline-danger" onclick="deleteSelectedItems()">
                <i class="bi bi-trash"></i>
                Xóa đã chọn
            </button>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- Component Styles --}}
<style>
.item-list-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

/* Header */
.item-list-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.list-title {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.list-title i {
    color: var(--bs-primary);
}

.item-count {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

.list-subtitle {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.total-amount {
    color: var(--bs-success);
    font-weight: 600;
}

.list-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.sort-controls select,
.view-mode-toggle .btn {
    font-size: 0.875rem;
}

/* Filter Bar */
.item-filter-bar {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-item {
    min-width: 200px;
}

.filter-item:last-child {
    margin-left: auto;
    min-width: auto;
}

/* List Body */
.item-list-body {
    min-height: 300px;
    position: relative;
}

/* List View */
.item-list-view {
    padding: 1.5rem;
}

.item-row {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 0.75rem;
    transition: all 0.2s ease;
    gap: 1rem;
}

.item-row:hover {
    border-color: var(--bs-primary);
    background: #f8f9fa;
}

.item-row:last-child {
    margin-bottom: 0;
}

.item-select {
    flex-shrink: 0;
}

.item-info {
    flex: 1;
    min-width: 0;
}

.item-main {
    margin-bottom: 0.5rem;
}

.item-name {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.item-icon {
    color: var(--bs-primary);
    font-size: 0.875rem;
}

.item-notes {
    font-size: 0.875rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.item-notes i {
    font-size: 0.75rem;
}

.item-details {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    gap: 0.5rem;
}

.detail-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.detail-value {
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
}

.price-value {
    color: var(--bs-warning);
}

.total-value {
    color: var(--bs-success);
}

.item-actions {
    flex-shrink: 0;
    display: flex;
    gap: 0.5rem;
}

/* Grid View */
.item-grid-view {
    padding: 1.5rem;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
}

.item-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
}

.item-card:hover {
    border-color: var(--bs-primary);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    transform: translateY(-2px);
}

.card-select {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
}

.card-header {
    text-align: center;
    margin-bottom: 1rem;
}

.item-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--bs-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.25rem;
}

.card-header .item-name {
    font-size: 1rem;
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.card-body {
    text-align: center;
}

.price-display {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.unit-price {
    font-size: 0.875rem;
    color: #6c757d;
}

.quantity {
    font-size: 0.875rem;
    color: #495057;
    font-weight: 500;
}

.total-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--bs-success);
    margin-bottom: 0.75rem;
}

.card-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

/* Table View */
.item-table-view {
    padding: 0;
}

.table {
    margin: 0;
}

.table th {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}

.table tbody tr:hover {
    background: rgba(13, 110, 253, 0.05);
}

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: #adb5bd;
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.75rem;
}

.empty-text {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

/* Bulk Actions Bar */
.bulk-actions-bar {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 1000;
}

.bulk-info {
    font-size: 0.875rem;
    font-weight: 500;
    color: #495057;
}

.bulk-actions {
    display: flex;
    gap: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .item-list-header {
        flex-direction: column;
        align-items: stretch;
    }

    .list-actions {
        justify-content: center;
        flex-wrap: wrap;
    }

    .item-filter-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-item {
        min-width: 100%;
        margin-bottom: 0.5rem;
    }

    .item-row {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }

    .item-details {
        justify-content: space-between;
    }

    .items-grid {
        grid-template-columns: 1fr;
    }

    .table-responsive {
        font-size: 0.8rem;
    }

    .bulk-actions-bar {
        left: 1rem;
        right: 1rem;
        transform: none;
        border-radius: 12px;
        flex-direction: column;
        gap: 0.75rem;
    }
}

/* Loading and Animation States */
.item-row.removing {
    animation: slideOutRight 0.3s ease-in forwards;
}

.item-card.removing {
    animation: fadeOut 0.3s ease-in forwards;
}

@keyframes slideOutRight {
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: scale(0.95);
    }
}

.item-row.new-item,
.item-card.new-item {
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

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .item-list-container {
        background: #212529;
        color: #f8f9fa;
    }

    .item-list-header {
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
        border-color: #495057;
    }

    .item-filter-bar {
        background: #343a40;
        border-color: #495057;
    }

    .item-row,
    .item-card {
        background: #212529;
        border-color: #495057;
        color: #f8f9fa;
    }

    .item-row:hover,
    .item-card:hover {
        background: #343a40;
        border-color: var(--bs-primary);
    }

    .table th {
        background: #343a40;
        border-color: #495057;
        color: #f8f9fa;
    }

    .table td {
        border-color: #495057;
        color: #f8f9fa;
    }

    .bulk-actions-bar {
        background: #212529;
        border-color: #495057;
    }
}
</style>

{{-- Component JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeItemList();
});

// Global variables
let currentViewMode = '{{ $viewMode }}';
let allItems = [];
let filteredItems = [];
let selectedItems = new Set();

// Initialize item list functionality
function initializeItemList() {
    // Store original items data
    allItems = Array.from(document.querySelectorAll('[data-item-id]')).map(el => {
        const itemId = el.dataset.itemId;
        const searchText = el.dataset.searchText;
        const priceElement = el.querySelector('.price-value');
        const totalElement = el.querySelector('.total-value');
        const quantityElement = el.querySelector('.quantity-value');

        return {
            id: itemId,
            element: el,
            searchText: searchText,
            name: el.querySelector('.item-name')?.textContent?.trim() || '',
            price: priceElement ? parseCurrency(priceElement.textContent) : 0,
            total: totalElement ? parseCurrency(totalElement.textContent) : 0,
            quantity: quantityElement ? parseFloat(quantityElement.textContent) || 1 : 1
        };
    });

    filteredItems = [...allItems];

    // Initialize tooltips
    initializeTooltips();

    // Setup event listeners
    setupEventListeners();

    // Update display
    updateItemDisplay();
}

// Setup event listeners
function setupEventListeners() {
    // Search input
    const searchInput = document.getElementById('searchItems');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterItems, 300);
        });
    }

    // Checkbox events
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('item-checkbox')) {
            updateSelection();
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

// Change view mode
function changeViewMode(mode) {
    currentViewMode = mode;

    // Hide all views
    document.querySelectorAll('.item-view').forEach(view => {
        view.style.display = 'none';
    });

    // Show selected view
    const targetView = document.getElementById(mode + 'View');
    if (targetView) {
        targetView.style.display = 'block';
    }

    // Update radio buttons
    document.getElementById('view' + capitalizeFirst(mode)).checked = true;

    // Update container attribute
    const container = document.querySelector('.item-list-container');
    if (container) {
        container.dataset.viewMode = mode;
    }

    // Re-initialize tooltips for the new view
    setTimeout(initializeTooltips, 100);
}

// Sort items
function sortItems(sortBy) {
    let sorted = [...filteredItems];

    switch(sortBy) {
        case 'name_asc':
            sorted.sort((a, b) => a.name.localeCompare(b.name, 'vi'));
            break;
        case 'name_desc':
            sorted.sort((a, b) => b.name.localeCompare(a.name, 'vi'));
            break;
        case 'price_asc':
            sorted.sort((a, b) => a.price - b.price);
            break;
        case 'price_desc':
            sorted.sort((a, b) => b.price - a.price);
            break;
        case 'total_asc':
            sorted.sort((a, b) => a.total - b.total);
            break;
        case 'total_desc':
            sorted.sort((a, b) => b.total - a.total);
            break;
        case 'quantity_desc':
            sorted.sort((a, b) => b.quantity - a.quantity);
            break;
        default: // order
            // Keep original order
            break;
    }

    filteredItems = sorted;
    updateItemDisplay();
}

// Filter items
function filterItems() {
    const searchQuery = document.getElementById('searchItems')?.value.toLowerCase() || '';
    const priceRange = document.getElementById('priceRangeFilter')?.value || '';

    filteredItems = allItems.filter(item => {
        // Search filter
        if (searchQuery && !item.searchText.includes(searchQuery)) {
            return false;
        }

        // Price range filter
        if (priceRange) {
            const [min, max] = priceRange.split('-').map(Number);
            if (item.total < min || (max && item.total > max)) {
                return false;
            }
        }

        return true;
    });

    updateItemDisplay();
}

// Clear all filters
function clearFilters() {
    // Reset search
    const searchInput = document.getElementById('searchItems');
    if (searchInput) searchInput.value = '';

    // Reset price filter
    const priceFilter = document.getElementById('priceRangeFilter');
    if (priceFilter) priceFilter.value = '';

    // Reset sort
    const sortSelect = document.getElementById('sortItems');
    if (sortSelect) sortSelect.value = 'order';

    // Reset data
    filteredItems = [...allItems];
    updateItemDisplay();
}

// Update item display
function updateItemDisplay() {
    // Hide all items first
    allItems.forEach(item => {
        item.element.style.display = 'none';
    });

    // Show filtered items
    filteredItems.forEach((item, index) => {
        item.element.style.display = '';

        // Update table row numbers if in table view
        const rowNumber = item.element.querySelector('td:nth-child(2)');
        if (rowNumber && currentViewMode === 'table') {
            rowNumber.textContent = index + 1;
        }
    });

    // Update totals
    updateTotals();

    // Show empty state if no items
    showEmptyState(filteredItems.length === 0);
}

// Update totals
function updateTotals() {
    const totalAmount = filteredItems.reduce((sum, item) => sum + item.total, 0);
    const totalQuantity = filteredItems.reduce((sum, item) => sum + item.quantity, 0);

    // Update header total
    const headerTotal = document.querySelector('.list-subtitle .total-amount');
    if (headerTotal) {
        headerTotal.textContent = formatCurrency(totalAmount) + ' VNĐ';
    }

    // Update table footer
    const grandTotal = document.getElementById('grandTotal');
    if (grandTotal) {
        grandTotal.textContent = formatCurrency(totalAmount) + 'đ';
    }

    const totalQuantityEl = document.getElementById('totalQuantity');
    if (totalQuantityEl) {
        totalQuantityEl.textContent = totalQuantity;
    }

    // Update item count
    const itemCount = document.querySelector('.item-count');
    if (itemCount) {
        itemCount.textContent = `(${filteredItems.length} món)`;
    }
}

// Show/hide empty state
function showEmptyState(show) {
    const emptyState = document.querySelector('.empty-state');
    const itemViews = document.querySelectorAll('.item-view');

    if (show) {
        itemViews.forEach(view => view.style.display = 'none');
        if (emptyState) {
            emptyState.style.display = 'block';
            // Update empty message for filtered results
            if (filteredItems.length === 0 && allItems.length > 0) {
                const emptyTitle = emptyState.querySelector('.empty-title');
                const emptyText = emptyState.querySelector('.empty-text');
                if (emptyTitle) emptyTitle.textContent = 'Không tìm thấy món đồ';
                if (emptyText) emptyText.textContent = 'Không có món đồ nào phù hợp với bộ lọc hiện tại.';
            }
        }
    } else {
        if (emptyState) emptyState.style.display = 'none';
        // Show current view
        const currentView = document.getElementById(currentViewMode + 'View');
        if (currentView) currentView.style.display = 'block';
    }
}

// Selection management
function toggleSelectAll(checkbox) {
    const isChecked = checkbox.checked;
    const checkboxes = document.querySelectorAll('.item-checkbox');

    checkboxes.forEach(cb => {
        const itemElement = cb.closest('[data-item-id]');
        const isVisible = itemElement && itemElement.style.display !== 'none';

        if (isVisible) {
            cb.checked = isChecked;
            if (isChecked) {
                selectedItems.add(cb.value);
            } else {
                selectedItems.delete(cb.value);
            }
        }
    });

    updateSelectionUI();
}

function updateSelection() {
    selectedItems.clear();

    // Collect all checked items
    document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
        selectedItems.add(cb.value);
    });

    // Update select all checkboxes
    const visibleCheckboxes = Array.from(document.querySelectorAll('.item-checkbox')).filter(cb => {
        const itemElement = cb.closest('[data-item-id]');
        return itemElement && itemElement.style.display !== 'none';
    });

    const checkedVisibleCount = visibleCheckboxes.filter(cb => cb.checked).length;
    const selectAllCheckboxes = document.querySelectorAll('#selectAllItems, #selectAllTable');

    selectAllCheckboxes.forEach(cb => {
        cb.checked = checkedVisibleCount > 0 && checkedVisibleCount === visibleCheckboxes.length;
        cb.indeterminate = checkedVisibleCount > 0 && checkedVisibleCount < visibleCheckboxes.length;
    });

    updateSelectionUI();
}

function updateSelectionUI() {
    const count = selectedItems.size;
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCountEl = document.getElementById('selectedCount');

    if (bulkActionsBar) {
        if (count > 0) {
            bulkActionsBar.style.display = 'flex';
            if (selectedCountEl) {
                selectedCountEl.textContent = count;
            }
        } else {
            bulkActionsBar.style.display = 'none';
        }
    }
}

// Item actions
function viewItemDetails(itemId) {
    // Find item data
    const item = allItems.find(i => i.id == itemId);
    if (!item) return;

    // Show item details modal or navigate to detail page
    // This would be implemented based on your specific requirements
    alert('Xem chi tiết món đồ: ' + item.name);
}

function editItem(itemId) {
    // Implement edit functionality
    // This would typically open an edit modal or form
    console.log('Edit item:', itemId);
    alert('Chức năng sửa món đồ đang được phát triển');
}

function deleteItem(itemId) {
    if (!confirm('Bạn có chắc chắn muốn xóa món đồ này?')) {
        return;
    }

    // Find and remove item
    const itemIndex = allItems.findIndex(i => i.id == itemId);
    if (itemIndex !== -1) {
        const item = allItems[itemIndex];

        // Add removing animation
        item.element.classList.add('removing');

        setTimeout(() => {
            // Remove from DOM
            item.element.remove();

            // Remove from arrays
            allItems.splice(itemIndex, 1);
            const filteredIndex = filteredItems.findIndex(i => i.id == itemId);
            if (filteredIndex !== -1) {
                filteredItems.splice(filteredIndex, 1);
            }

            // Remove from selection
            selectedItems.delete(itemId);

            // Update display
            updateItemDisplay();
            updateSelectionUI();

            // Show success message
            showSuccessMessage('Đã xóa món đồ thành công');

        }, 300);
    }
}

function addFirstItem() {
    // Implement add first item functionality
    // This would typically trigger the add item form
    console.log('Add first item');
    alert('Chức năng thêm món đồ đang được phát triển');
}

// Bulk actions
function exportSelectedItems() {
    if (selectedItems.size === 0) {
        alert('Vui lòng chọn ít nhất một món đồ để xuất');
        return;
    }

    // Create CSV content
    const selectedItemsData = allItems.filter(item => selectedItems.has(item.id));
    const csvContent = createCSVContent(selectedItemsData);

    // Download CSV
    downloadCSV(csvContent, 'danh-sach-mon-do.csv');

    showSuccessMessage(`Đã xuất ${selectedItems.size} món đồ`);
}

function deleteSelectedItems() {
    if (selectedItems.size === 0) {
        alert('Vui lòng chọn ít nhất một món đồ để xóa');
        return;
    }

    if (!confirm(`Bạn có chắc chắn muốn xóa ${selectedItems.size} món đồ đã chọn?`)) {
        return;
    }

    // Remove selected items
    selectedItems.forEach(itemId => {
        deleteItem(itemId);
    });
}

// Utility functions
function createCSVContent(items) {
    const headers = ['Tên món đồ', 'Đơn giá', 'Số lượng', 'Thành tiền', 'Ghi chú'];
    const rows = items.map(item => [
        item.name,
        item.price,
        item.quantity,
        item.total,
        item.element.querySelector('.item-notes')?.textContent?.trim() || ''
    ]);

    return [headers, ...rows].map(row => row.join(',')).join('\n');
}

function downloadCSV(content, filename) {
    const blob = new Blob(['\uFEFF' + content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.setAttribute('href', url);
    link.setAttribute('download', filename);
    link.style.visibility = 'hidden';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function showSuccessMessage(message) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = 'alert alert-success position-fixed';
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="bi bi-check-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 3000);
}

function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(Math.round(amount));
}

function parseCurrency(str) {
    if (!str) return 0;
    return parseInt(str.replace(/[^\d]/g, '')) || 0;
}

// Export functions for external use
window.changeViewMode = changeViewMode;
window.sortItems = sortItems;
window.filterItems = filterItems;
window.clearFilters = clearFilters;
window.toggleSelectAll = toggleSelectAll;
window.updateSelection = updateSelection;
window.viewItemDetails = viewItemDetails;
window.editItem = editItem;
window.deleteItem = deleteItem;
window.addFirstItem = addFirstItem;
window.exportSelectedItems = exportSelectedItems;
window.deleteSelectedItems = deleteSelectedItems;
</script>

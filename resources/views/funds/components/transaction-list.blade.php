{{-- Transaction List Component --}}
<div class="transaction-list-container">
    <!-- Filters and Search Bar -->
    <div class="transaction-filters-card mb-4">
        <div class="filters-header">
            <h5 class="filters-title">
                <i class="bi bi-funnel me-2"></i>
                Lọc Giao Dịch
            </h5>
            <button class="btn btn-sm btn-outline-secondary" id="clearFiltersBtn">
                <i class="bi bi-x-lg me-1"></i>
                Xóa bộ lọc
            </button>
        </div>

        <div class="filters-body">
            <div class="row g-3">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
                        <label for="searchInput">
                            <i class="bi bi-search me-1"></i>
                            Tìm kiếm giao dịch
                        </label>
                    </div>
                </div>

                <!-- Transaction Type Filter -->
                <div class="col-lg-3 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="typeFilter">
                            <option value="all">Tất cả</option>
                            <option value="add">Nạp tiền</option>
                            <option value="subtract">Chi tiêu</option>
                        </select>
                        <label for="typeFilter">
                            <i class="bi bi-filter me-1"></i>
                            Loại giao dịch
                        </label>
                    </div>
                </div>

                <!-- Date Range Filter -->
                <div class="col-lg-2 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="dateRangeFilter">
                            <option value="all">Tất cả</option>
                            <option value="today">Hôm nay</option>
                            <option value="week">7 ngày qua</option>
                            <option value="month" selected>Tháng này</option>
                            <option value="3months">3 tháng qua</option>
                            <option value="year">Năm nay</option>
                        </select>
                        <label for="dateRangeFilter">
                            <i class="bi bi-calendar me-1"></i>
                            Thời gian
                        </label>
                    </div>
                </div>

                <!-- Amount Range Filter -->
                <div class="col-lg-3 col-md-6">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="minAmountFilter" placeholder="Từ">
                            <label for="minAmountFilter">Từ (VNĐ)</label>
                        </div>
                        <span class="input-group-text">-</span>
                        <div class="form-floating">
                            <input type="number" class="form-control" id="maxAmountFilter" placeholder="Đến">
                            <label for="maxAmountFilter">Đến (VNĐ)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Filter Buttons -->
        <div class="quick-filters mt-3">
            <div class="quick-filter-buttons">
                <button class="quick-filter-btn active" data-filter="all">
                    <i class="bi bi-list-ul"></i>
                    Tất cả
                </button>
                <button class="quick-filter-btn" data-filter="add">
                    <i class="bi bi-plus-circle text-success"></i>
                    Nạp tiền
                </button>
                <button class="quick-filter-btn" data-filter="subtract">
                    <i class="bi bi-dash-circle text-danger"></i>
                    Chi tiêu
                </button>
                <button class="quick-filter-btn" data-filter="large">
                    <i class="bi bi-exclamation-triangle text-warning"></i>
                    Lớn (>500K)
                </button>
                <button class="quick-filter-btn" data-filter="shopping">
                    <i class="bi bi-cart text-info"></i>
                    Đi chợ
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="transaction-summary mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="summary-card total-card">
                    <div class="summary-icon">
                        <i class="bi bi-list-ul"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value" id="totalTransactions">0</div>
                        <div class="summary-label">Tổng GD</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card added-card">
                    <div class="summary-icon bg-success">
                        <i class="bi bi-arrow-up"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value" id="totalAdded">0 VNĐ</div>
                        <div class="summary-label">Tổng Nạp</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card spent-card">
                    <div class="summary-icon bg-danger">
                        <i class="bi bi-arrow-down"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value" id="totalSpent">0 VNĐ</div>
                        <div class="summary-label">Tổng Chi</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card net-card">
                    <div class="summary-icon bg-info">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value" id="netAmount">0 VNĐ</div>
                        <div class="summary-label">Thay Đổi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction List -->
    <div class="transaction-list-card">
        <div class="transaction-list-header">
            <div class="list-header-left">
                <h5 class="list-title">
                    <i class="bi bi-journal-text me-2"></i>
                    Danh Sách Giao Dịch
                </h5>
                <div class="list-subtitle" id="transactionCount">
                    Đang tải...
                </div>
            </div>
            <div class="list-header-right">
                <div class="list-controls">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-secondary" id="refreshBtn" title="Làm mới">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="exportBtn" title="Xuất Excel">
                            <i class="bi bi-download"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" title="Xem dạng khác">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="changeView('list')">
                                <i class="bi bi-list-ul me-2"></i>Danh sách
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeView('card')">
                                <i class="bi bi-grid-3x3 me-2"></i>Thẻ
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeView('timeline')">
                                <i class="bi bi-clock-history me-2"></i>Timeline
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="transaction-list-body">
            <!-- Loading State -->
            <div class="loading-state" id="loadingState">
                <div class="loading-content">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <div class="loading-text mt-2">Đang tải giao dịch...</div>
                </div>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-content">
                    <i class="bi bi-inbox empty-icon"></i>
                    <h6 class="empty-title">Không có giao dịch nào</h6>
                    <p class="empty-text">Thử thay đổi bộ lọc hoặc thêm giao dịch mới</p>
                    <button class="btn btn-primary" onclick="showAddFundModal()">
                        <i class="bi bi-plus-circle me-1"></i>
                        Nạp quỹ ngay
                    </button>
                </div>
            </div>

            <!-- Transaction List Views -->
            <div class="transaction-views" id="transactionViews" style="display: none;">
                <!-- List View (Default) -->
                <div class="list-view active" id="listView">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="5%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAllTransactions">
                                            <label class="form-check-label" for="selectAllTransactions"></label>
                                        </div>
                                    </th>
                                    <th width="15%" class="sortable" data-sort="date">
                                        <div class="th-content">
                                            <span>Ngày</span>
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </div>
                                    </th>
                                    <th width="10%" class="sortable" data-sort="type">
                                        <div class="th-content">
                                            <span>Loại</span>
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </div>
                                    </th>
                                    <th width="30%">Mô tả</th>
                                    <th width="15%" class="sortable text-end" data-sort="amount">
                                        <div class="th-content justify-content-end">
                                            <span>Số tiền</span>
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </div>
                                    </th>
                                    <th width="15%" class="text-end">Số dư sau GD</th>
                                    <th width="10%" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="transactionTableBody">
                                <!-- Transaction rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card View -->
                <div class="card-view" id="cardView" style="display: none;">
                    <div class="transaction-cards" id="transactionCards">
                        <!-- Transaction cards will be inserted here -->
                    </div>
                </div>

                <!-- Timeline View -->
                <div class="timeline-view" id="timelineView" style="display: none;">
                    <div class="transaction-timeline" id="transactionTimeline">
                        <!-- Timeline items will be inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="transaction-pagination" id="paginationContainer" style="display: none;">
            <div class="pagination-info">
                <span class="pagination-text" id="paginationInfo">
                    Hiển thị 1-20 trên 100 giao dịch
                </span>
            </div>
            <nav class="pagination-nav">
                <ul class="pagination pagination-sm" id="paginationList">
                    <!-- Pagination items will be inserted here -->
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div class="modal fade" id="bulkActionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-gear me-2"></i>
                        Thao Tác Hàng Loạt
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="selected-count mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        Đã chọn <span id="selectedCount">0</span> giao dịch
                    </div>
                    <div class="bulk-actions">
                        <button class="btn btn-outline-primary w-100 mb-2" onclick="exportSelected()">
                            <i class="bi bi-download me-2"></i>
                            Xuất Excel
                        </button>
                        <button class="btn btn-outline-secondary w-100 mb-2" onclick="printSelected()">
                            <i class="bi bi-printer me-2"></i>
                            In
                        </button>
                        <button class="btn btn-outline-info w-100" onclick="shareSelected()">
                            <i class="bi bi-share me-2"></i>
                            Chia sẻ
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Transaction List Styles */
.transaction-list-container {
    padding: 0;
}

/* Filters Card */
.transaction-filters-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.filters-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filters-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.filters-body {
    padding: 1.5rem;
}

.quick-filters {
    padding: 0 1.5rem 1.5rem;
    border-top: 1px solid #f1f3f4;
    margin-top: 1rem;
    padding-top: 1rem;
}

.quick-filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.quick-filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    background: white;
    color: #6c757d;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quick-filter-btn:hover {
    border-color: var(--bs-primary);
    color: var(--bs-primary);
    background: rgba(13, 110, 253, 0.05);
}

.quick-filter-btn.active {
    border-color: var(--bs-primary);
    background: var(--bs-primary);
    color: white;
}

.quick-filter-btn i {
    font-size: 1rem;
}

/* Summary Cards */
.transaction-summary {
    margin-bottom: 1.5rem;
}

.summary-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.summary-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--bs-primary), var(--bs-success));
}

.summary-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
}

.summary-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--bs-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.summary-icon.bg-success {
    background: var(--bs-success) !important;
    color: white;
}

.summary-icon.bg-danger {
    background: var(--bs-danger) !important;
    color: white;
}

.summary-icon.bg-info {
    background: var(--bs-info) !important;
    color: white;
}

.summary-content {
    flex-grow: 1;
}

.summary-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.25rem;
}

.summary-label {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Transaction List Card */
.transaction-list-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.transaction-list-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.list-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    margin: 0 0 0.25rem 0;
}

.list-subtitle {
    font-size: 0.875rem;
    color: #6c757d;
}

.list-controls .btn-group {
    border-radius: 8px;
    overflow: hidden;
}

.transaction-list-body {
    position: relative;
    min-height: 400px;
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    padding: 1rem 0.75rem;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-color: #f1f3f4;
}

.sortable {
    cursor: pointer;
    user-select: none;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sort-icon {
    color: #adb5bd;
    transition: all 0.2s ease;
}

.sortable:hover .sort-icon {
    color: #6c757d;
}

.sortable.asc .sort-icon {
    color: var(--bs-primary);
    transform: rotate(180deg);
}

.sortable.desc .sort-icon {
    color: var(--bs-primary);
    transform: rotate(0deg);
}

/* Transaction Type Badges */
.transaction-type {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.transaction-type.add {
    background: #d1e7dd;
    color: #0f5132;
}

.transaction-type.subtract {
    background: #f8d7da;
    color: #721c24;
}

.transaction-amount {
    font-weight: 700;
}

.transaction-amount.positive {
    color: #198754;
}

.transaction-amount.negative {
    color: #dc3545;
}

/* Loading and Empty States */
.loading-state, .empty-state {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.9);
}

.loading-content, .empty-content {
    text-align: center;
    padding: 2rem;
}

.loading-text {
    color: #6c757d;
    font-size: 0.875rem;
}

.empty-icon {
    font-size: 3rem;
    color: #adb5bd;
    margin-bottom: 1rem;
}

.empty-title {
    color: #495057;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: #6c757d;
    margin-bottom: 1.5rem;
}

/* Card View */
.transaction-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    padding: 1.5rem;
}

.transaction-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.transaction-card:hover {
    border-color: var(--bs-primary);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
}

/* Timeline View */
.transaction-timeline {
    padding: 1.5rem;
}

.timeline-item {
    position: relative;
    padding-left: 3rem;
    padding-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: -2rem;
    width: 2px;
    background: #e9ecef;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: 0.5rem;
    top: 0.5rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: white;
    border: 3px solid var(--bs-primary);
}

.timeline-content {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-left: 1rem;
}

/* Pagination */
.transaction-pagination {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.pagination-text {
    color: #6c757d;
    font-size: 0.875rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .transaction-filters-card .filters-header,
    .transaction-list-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .quick-filter-buttons {
        justify-content: center;
    }

    .transaction-summary .row {
        --bs-gutter-x: 0.75rem;
    }

    .summary-card {
        padding: 1rem;
    }

    .table-responsive {
        font-size: 0.875rem;
    }

    .transaction-cards {
        grid-template-columns: 1fr;
        padding: 1rem;
        gap: 0.75rem;
    }
}

/* Dark Theme Support */
@media (prefers-color-scheme: dark) {
    .transaction-filters-card,
    .transaction-list-card,
    .summary-card {
        background: #2b3035;
        color: #f8f9fa;
    }

    .filters-header,
    .transaction-list-header {
        background: linear-gradient(135deg, #1a1d20 0%, #2b3035 100%);
        border-bottom-color: #495057;
    }

    .table-light {
        background-color: #495057;
        color: #f8f9fa;
    }

    .table th,
    .table td {
        border-color: #495057;
        color: #f8f9fa;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeTransactionList();
});

function initializeTransactionList() {
    // Initialize variables
    let transactions = [];
    let filteredTransactions = [];
    let currentView = 'list';
    let currentPage = 1;
    let itemsPerPage = 20;
    let sortColumn = 'date';
    let sortDirection = 'desc';
    let selectedTransactions = new Set();

    // DOM elements
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const dateRangeFilter = document.getElementById('dateRangeFilter');
    const minAmountFilter = document.getElementById('minAmountFilter');
    const maxAmountFilter = document.getElementById('maxAmountFilter');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    const quickFilterBtns = document.querySelectorAll('.quick-filter-btn');
    const refreshBtn = document.getElementById('refreshBtn');
    const exportBtn = document.getElementById('exportBtn');
    const selectAllCheckbox = document.getElementById('selectAllTransactions');

    // Initialize
    loadTransactions();
    setupEventListeners();

    function setupEventListeners() {
        // Search and filters
        searchInput.addEventListener('input', debounce(applyFilters, 300));
        typeFilter.addEventListener('change', applyFilters);
        dateRangeFilter.addEventListener('change', applyFilters);
        minAmountFilter.addEventListener('input', debounce(applyFilters, 500));
        maxAmountFilter.addEventListener('input', debounce(applyFilters, 500));

        // Quick filters
        quickFilterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                quickFilterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                applyQuickFilter(this.dataset.filter);
            });
        });

        // Clear filters
        clearFiltersBtn.addEventListener('click', clearAllFilters);

        // Refresh
        refreshBtn.addEventListener('click', function() {
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="bi bi-arrow-clockwise"></i>';
            this.disabled = true;

            loadTransactions().finally(() => {
                this.innerHTML = originalContent;
                this.disabled = false;
            });
        });

        // Export
        exportBtn.addEventListener('click', exportTransactions);

        // Select all
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.transaction-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
                if (this.checked) {
                    selectedTransactions.add(cb.value);
                } else {
                    selectedTransactions.delete(cb.value);
                }
            });
            updateBulkActionsVisibility();
        });

        // Listen for fund updates
        window.addEventListener('fundAdded', function() {
            setTimeout(loadTransactions, 1000);
        });

        // Table sorting
        document.addEventListener('click', function(e) {
            if (e.target.closest('.sortable')) {
                const th = e.target.closest('.sortable');
                const column = th.dataset.sort;

                if (sortColumn === column) {
                    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    sortColumn = column;
                    sortDirection = 'desc';
                }

                // Update sort indicators
                document.querySelectorAll('.sortable').forEach(el => {
                    el.classList.remove('asc', 'desc');
                });
                th.classList.add(sortDirection);

                sortTransactions();
                renderTransactions();
            }
        });
    }

    async function loadTransactions() {
        try {
            showLoadingState();

            // Load from API
            const response = await fetch('/api/funds/history', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Failed to load transactions');

            const result = await response.json();

            if (result.success) {
                transactions = result.data || [];
                applyFilters();
                updateSummaryStats();
            } else {
                throw new Error(result.message || 'Failed to load transactions');
            }

        } catch (error) {
            console.error('Error loading transactions:', error);
            showErrorState('Không thể tải danh sách giao dịch. Vui lòng thử lại.');
            transactions = [];
        }
    }

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const type = typeFilter.value;
        const dateRange = dateRangeFilter.value;
        const minAmount = parseFloat(minAmountFilter.value) || 0;
        const maxAmount = parseFloat(maxAmountFilter.value) || Infinity;

        filteredTransactions = transactions.filter(transaction => {
            // Search filter
            if (searchTerm && !transaction.description.toLowerCase().includes(searchTerm)) {
                return false;
            }

            // Type filter
            if (type !== 'all' && transaction.type !== type) {
                return false;
            }

            // Date range filter
            if (!passesDateFilter(transaction.created_at, dateRange)) {
                return false;
            }

            // Amount range filter
            const amount = Math.abs(transaction.amount);
            if (amount < minAmount || amount > maxAmount) {
                return false;
            }

            return true;
        });

        sortTransactions();
        renderTransactions();
        updateSummaryStats();
    }

    function applyQuickFilter(filter) {
        // Reset other filters
        typeFilter.value = 'all';
        dateRangeFilter.value = 'month';
        minAmountFilter.value = '';
        maxAmountFilter.value = '';
        searchInput.value = '';

        switch (filter) {
            case 'all':
                // No additional filtering
                break;
            case 'add':
                typeFilter.value = 'add';
                break;
            case 'subtract':
                typeFilter.value = 'subtract';
                break;
            case 'large':
                minAmountFilter.value = '500000';
                break;
            case 'shopping':
                searchInput.value = 'đi chợ';
                break;
        }

        applyFilters();
    }

    function passesDateFilter(dateString, range) {
        const transactionDate = new Date(dateString);
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        switch (range) {
            case 'today':
                return transactionDate >= today;
            case 'week':
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                return transactionDate >= weekAgo;
            case 'month':
                const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
                return transactionDate >= monthStart;
            case '3months':
                const threeMonthsAgo = new Date(now.getFullYear(), now.getMonth() - 3, 1);
                return transactionDate >= threeMonthsAgo;
            case 'year':
                const yearStart = new Date(now.getFullYear(), 0, 1);
                return transactionDate >= yearStart;
            case 'all':
            default:
                return true;
        }
    }

    function sortTransactions() {
        filteredTransactions.sort((a, b) => {
            let aValue, bValue;

            switch (sortColumn) {
                case 'date':
                    aValue = new Date(a.created_at);
                    bValue = new Date(b.created_at);
                    break;
                case 'type':
                    aValue = a.type;
                    bValue = b.type;
                    break;
                case 'amount':
                    aValue = Math.abs(a.amount);
                    bValue = Math.abs(b.amount);
                    break;
                default:
                    return 0;
            }

            if (aValue < bValue) return sortDirection === 'asc' ? -1 : 1;
            if (aValue > bValue) return sortDirection === 'asc' ? 1 : -1;
            return 0;
        });
    }

    function renderTransactions() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageTransactions = filteredTransactions.slice(startIndex, endIndex);

        if (pageTransactions.length === 0 && filteredTransactions.length === 0) {
            showEmptyState();
            return;
        }

        hideLoadingAndEmptyStates();

        // Update transaction count
        document.getElementById('transactionCount').textContent =
            `${filteredTransactions.length} giao dịch`;

        // Render based on current view
        switch (currentView) {
            case 'list':
                renderListView(pageTransactions);
                break;
            case 'card':
                renderCardView(pageTransactions);
                break;
            case 'timeline':
                renderTimelineView(pageTransactions);
                break;
        }

        renderPagination();
    }

    function renderListView(pageTransactions) {
        const tbody = document.getElementById('transactionTableBody');

        tbody.innerHTML = pageTransactions.map(transaction => {
            const isAdd = transaction.type === 'add';
            const date = new Date(transaction.created_at);
            const formattedDate = date.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            return `
                <tr class="transaction-row" data-id="${transaction.id}">
                    <td>
                        <div class="form-check">
                            <input class="form-check-input transaction-checkbox"
                                   type="checkbox"
                                   value="${transaction.id}"
                                   onchange="handleTransactionSelect(this)">
                        </div>
                    </td>
                    <td>
                        <div class="transaction-date">
                            <div class="date-main">${formattedDate.split(' ')[0]}</div>
                            <div class="date-time text-muted">${formattedDate.split(' ')[1]}</div>
                        </div>
                    </td>
                    <td>
                        <span class="transaction-type ${transaction.type}">
                            <i class="bi bi-${isAdd ? 'plus' : 'dash'}-circle"></i>
                            ${isAdd ? 'Nạp' : 'Chi'}
                        </span>
                    </td>
                    <td>
                        <div class="transaction-description">
                            <div class="description-main">${transaction.description}</div>
                            ${transaction.shopping_trip ? `
                                <div class="description-sub text-muted">
                                    <i class="bi bi-cart me-1"></i>
                                    Đi chợ ngày ${transaction.shopping_trip.date}
                                </div>
                            ` : ''}
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="transaction-amount ${isAdd ? 'positive' : 'negative'}">
                            ${isAdd ? '+' : '-'}${formatCurrency(Math.abs(transaction.amount))}
                        </div>
                    </td>
                    <td class="text-end">
                        <div class="balance-after text-muted">
                            ${formatCurrency(transaction.balance_after || 0)}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            ${transaction.shopping_trip ? `
                                <a href="/shopping/${transaction.shopping_trip.id}"
                                   class="btn btn-outline-info btn-sm"
                                   title="Xem chi tiết đi chợ">
                                    <i class="bi bi-eye"></i>
                                </a>
                            ` : ''}
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="viewTransactionDetails('${transaction.id}')"
                                    title="Chi tiết">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderCardView(pageTransactions) {
        const container = document.getElementById('transactionCards');

        container.innerHTML = pageTransactions.map(transaction => {
            const isAdd = transaction.type === 'add';
            const date = new Date(transaction.created_at);
            const formattedDate = date.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            return `
                <div class="transaction-card" data-id="${transaction.id}">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span class="transaction-type ${transaction.type}">
                            <i class="bi bi-${isAdd ? 'plus' : 'dash'}-circle"></i>
                            ${isAdd ? 'Nạp tiền' : 'Chi tiêu'}
                        </span>
                        <small class="text-muted">${formattedDate}</small>
                    </div>
                    <div class="card-body">
                        <div class="transaction-amount ${isAdd ? 'positive' : 'negative'} mb-2">
                            ${isAdd ? '+' : '-'}${formatCurrency(Math.abs(transaction.amount))}
                        </div>
                        <div class="transaction-description mb-2">
                            ${transaction.description}
                        </div>
                        ${transaction.shopping_trip ? `
                            <div class="shopping-info">
                                <i class="bi bi-cart me-1"></i>
                                <small>Đi chợ ngày ${transaction.shopping_trip.date}</small>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-footer">
                        <div class="form-check">
                            <input class="form-check-input transaction-checkbox"
                                   type="checkbox"
                                   value="${transaction.id}"
                                   onchange="handleTransactionSelect(this)">
                            <label class="form-check-label">Chọn</label>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function renderTimelineView(pageTransactions) {
        const container = document.getElementById('transactionTimeline');

        // Group transactions by date
        const groupedTransactions = groupTransactionsByDate(pageTransactions);

        container.innerHTML = Object.entries(groupedTransactions).map(([date, dayTransactions]) => `
            <div class="timeline-day">
                <div class="timeline-date-header">
                    <h6 class="date-title">${formatDateHeader(date)}</h6>
                    <span class="date-count">${dayTransactions.length} giao dịch</span>
                </div>
                <div class="timeline-items">
                    ${dayTransactions.map(transaction => {
                        const isAdd = transaction.type === 'add';
                        return `
                            <div class="timeline-item">
                                <div class="timeline-marker ${isAdd ? 'bg-success' : 'bg-danger'}"></div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <span class="transaction-type ${transaction.type}">
                                            <i class="bi bi-${isAdd ? 'plus' : 'dash'}-circle"></i>
                                            ${isAdd ? 'Nạp tiền' : 'Chi tiêu'}
                                        </span>
                                        <div class="transaction-amount ${isAdd ? 'positive' : 'negative'}">
                                            ${isAdd ? '+' : '-'}${formatCurrency(Math.abs(transaction.amount))}
                                        </div>
                                    </div>
                                    <div class="timeline-description">
                                        ${transaction.description}
                                    </div>
                                    ${transaction.shopping_trip ? `
                                        <div class="timeline-extra">
                                            <i class="bi bi-cart me-1"></i>
                                            Đi chợ ngày ${transaction.shopping_trip.date}
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        `).join('');
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredTransactions.length / itemsPerPage);

        if (totalPages <= 1) {
            document.getElementById('paginationContainer').style.display = 'none';
            return;
        }

        document.getElementById('paginationContainer').style.display = 'flex';

        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, filteredTransactions.length);

        document.getElementById('paginationInfo').textContent =
            `Hiển thị ${startIndex}-${endIndex} trên ${filteredTransactions.length} giao dịch`;

        const paginationList = document.getElementById('paginationList');
        let paginationHTML = '';

        // Previous button
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        `;

        // Page numbers
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        }

        // Next button
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        `;

        paginationList.innerHTML = paginationHTML;
    }

    function updateSummaryStats() {
        const totalTransactions = filteredTransactions.length;
        const totalAdded = filteredTransactions
            .filter(t => t.type === 'add')
            .reduce((sum, t) => sum + t.amount, 0);
        const totalSpent = Math.abs(filteredTransactions
            .filter(t => t.type === 'subtract')
            .reduce((sum, t) => sum + t.amount, 0));
        const netAmount = totalAdded - totalSpent;

        document.getElementById('totalTransactions').textContent = totalTransactions;
        document.getElementById('totalAdded').textContent = formatCurrency(totalAdded);
        document.getElementById('totalSpent').textContent = formatCurrency(totalSpent);
        document.getElementById('netAmount').textContent = formatCurrency(netAmount);

        // Update net amount color
        const netAmountElement = document.getElementById('netAmount');
        netAmountElement.classList.remove('text-success', 'text-danger', 'text-secondary');
        if (netAmount > 0) {
            netAmountElement.classList.add('text-success');
        } else if (netAmount < 0) {
            netAmountElement.classList.add('text-danger');
        } else {
            netAmountElement.classList.add('text-secondary');
        }
    }

    function clearAllFilters() {
        searchInput.value = '';
        typeFilter.value = 'all';
        dateRangeFilter.value = 'month';
        minAmountFilter.value = '';
        maxAmountFilter.value = '';

        // Reset quick filter buttons
        quickFilterBtns.forEach(btn => btn.classList.remove('active'));
        document.querySelector('[data-filter="all"]').classList.add('active');

        applyFilters();
    }

    function showLoadingState() {
        document.getElementById('loadingState').style.display = 'flex';
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('transactionViews').style.display = 'none';
    }

    function showEmptyState() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('emptyState').style.display = 'flex';
        document.getElementById('transactionViews').style.display = 'none';
        document.getElementById('paginationContainer').style.display = 'none';
    }

    function hideLoadingAndEmptyStates() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('transactionViews').style.display = 'block';
    }

    function showErrorState(message) {
        document.getElementById('loadingState').innerHTML = `
            <div class="loading-content">
                <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <div class="loading-text text-danger">${message}</div>
                <button class="btn btn-primary mt-3" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Thử lại
                </button>
            </div>
        `;
    }

    // Helper functions
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
    }

    function formatDateHeader(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const yesterday = new Date(today.getTime() - 24 * 60 * 60 * 1000);

        if (date.toDateString() === today.toDateString()) {
            return 'Hôm nay';
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'Hôm qua';
        } else {
            return date.toLocaleDateString('vi-VN', {
                weekday: 'long',
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }
    }

    function groupTransactionsByDate(transactions) {
        return transactions.reduce((groups, transaction) => {
            const date = new Date(transaction.created_at).toDateString();
            if (!groups[date]) {
                groups[date] = [];
            }
            groups[date].push(transaction);
            return groups;
        }, {});
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Global functions
    window.changePage = function(page) {
        currentPage = page;
        renderTransactions();
    };

    window.changeView = function(view) {
        currentView = view;

        // Hide all views
        document.querySelectorAll('[id$="View"]').forEach(el => {
            el.style.display = 'none';
            el.classList.remove('active');
        });

        // Show selected view
        document.getElementById(view + 'View').style.display = 'block';
        document.getElementById(view + 'View').classList.add('active');

        renderTransactions();
    };

    window.handleTransactionSelect = function(checkbox) {
        if (checkbox.checked) {
            selectedTransactions.add(checkbox.value);
        } else {
            selectedTransactions.delete(checkbox.value);
        }
        updateBulkActionsVisibility();
    };

    window.viewTransactionDetails = function(transactionId) {
        const transaction = transactions.find(t => t.id == transactionId);
        if (!transaction) return;

        // Show transaction details in a modal (implement as needed)
        alert(`Chi tiết giao dịch:\n\nMô tả: ${transaction.description}\nSố tiền: ${formatCurrency(Math.abs(transaction.amount))}\nLoại: ${transaction.type === 'add' ? 'Nạp tiền' : 'Chi tiêu'}\nNgày: ${new Date(transaction.created_at).toLocaleString('vi-VN')}`);
    };

    function updateBulkActionsVisibility() {
        const selectedCount = selectedTransactions.size;
        if (selectedCount > 0) {
            // Show bulk actions (implement modal or toolbar as needed)
            document.getElementById('selectedCount').textContent = selectedCount;
        }
    }

    function exportTransactions() {
        const dataToExport = filteredTransactions.map(t => ({
            'Ngày': new Date(t.created_at).toLocaleString('vi-VN'),
            'Loại': t.type === 'add' ? 'Nạp tiền' : 'Chi tiêu',
            'Mô tả': t.description,
            'Số tiền': t.amount,
            'Số dư sau giao dịch': t.balance_after || 0
        }));

        const csv = convertToCSV(dataToExport);
        downloadFile(csv, `giao-dich-${new Date().toISOString().slice(0, 10)}.csv`, 'text/csv');

        showToast('Xuất danh sách giao dịch thành công!', 'success');
    }

    function convertToCSV(data) {
        if (!data.length) return '';

        const headers = Object.keys(data[0]);
        const csvContent = [
            headers.join(','),
            ...data.map(row =>
                headers.map(header => `"${row[header]}"`).join(',')
            )
        ].join('\n');

        return csvContent;
    }

    function downloadFile(content, filename, type) {
        const blob = new Blob([content], { type: type });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    // Expose functions globally
    window.exportSelected = function() {
        const selected = transactions.filter(t => selectedTransactions.has(t.id.toString()));
        // Implement export selected transactions
        console.log('Export selected:', selected);
    };

    window.printSelected = function() {
        // Implement print selected transactions
        console.log('Print selected transactions');
    };

    window.shareSelected = function() {
        // Implement share selected transactions
        console.log('Share selected transactions');
    };
}

// Auto refresh every 10 minutes
setInterval(function() {
    if (document.getElementById('refreshBtn') && document.visibilityState === 'visible') {
        document.getElementById('refreshBtn').click();
    }
}, 10 * 60 * 1000);
</script>

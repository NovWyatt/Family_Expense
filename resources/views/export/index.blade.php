@extends('layouts.app')

@section('title', 'Xuất Excel')
@section('body-class', 'export-page')

@section('content')
<div class="export-container">
    {{-- Export Header --}}
    <div class="export-header">
        <div class="header-content">
            <div class="page-title">
                <div class="title-icon">
                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                </div>
                <div class="title-text">
                    <h1>Xuất Báo Cáo Excel</h1>
                    <p>Tạo và tải xuống báo cáo chi tiêu</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline-primary btn-sm" onclick="refreshData()">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span class="d-none d-md-inline">Làm mới</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Quick Export Actions --}}
    <div class="quick-actions-section">
        <div class="section-header">
            <h3>
                <i class="bi bi-lightning-fill"></i>
                Xuất Nhanh
            </h3>
            <p>Các báo cáo thông dụng nhất</p>
        </div>
        <div class="quick-actions-grid">
            <div class="quick-action-card" onclick="exportCurrentMonth()">
                <div class="action-icon">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <div class="action-content">
                    <h4>Tháng Hiện Tại</h4>
                    <p>{{ \Carbon\Carbon::now()->format('m/Y') }}</p>
                    <span class="action-label">{{ number_format($currentMonthTrips ?? 0) }} chuyến đi chợ</span>
                </div>
                <div class="action-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>

            <div class="quick-action-card" onclick="exportLastMonth()">
                <div class="action-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="action-content">
                    <h4>Tháng Trước</h4>
                    <p>{{ \Carbon\Carbon::now()->subMonth()->format('m/Y') }}</p>
                    <span class="action-label">{{ number_format($lastMonthTrips ?? 0) }} chuyến đi chợ</span>
                </div>
                <div class="action-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>

            <div class="quick-action-card" onclick="showCustomExportModal()">
                <div class="action-icon">
                    <i class="bi bi-sliders"></i>
                </div>
                <div class="action-content">
                    <h4>Tùy Chỉnh</h4>
                    <p>Chọn khoảng thời gian</p>
                    <span class="action-label">Linh hoạt theo nhu cầu</span>
                </div>
                <div class="action-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Reports --}}
    <div class="monthly-reports-section">
        <div class="section-header">
            <h3>
                <i class="bi bi-graph-up"></i>
                Báo Cáo Theo Tháng
            </h3>
            <p>Dữ liệu chi tiết từng tháng trong năm</p>
        </div>
        <div class="monthly-grid">
            @php
                $currentYear = date('Y');
                $currentMonth = date('n');
                $months = [
                    1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4',
                    5 => 'Tháng 5', 6 => 'Tháng 6', 7 => 'Tháng 7', 8 => 'Tháng 8',
                    9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
                ];
            @endphp

            @for($month = 1; $month <= 12; $month++)
                @php
                    $isPastMonth = $month < $currentMonth || ($month == $currentMonth && date('d') > 1);
                    $isCurrentMonth = $month == $currentMonth;
                    $isFutureMonth = $month > $currentMonth;

                    // Mock data - trong thực tế sẽ lấy từ database
                    $monthlyStats = [
                        'trips' => $isPastMonth ? rand(8, 25) : ($isCurrentMonth ? rand(3, 12) : 0),
                        'total_amount' => $isPastMonth ? rand(500000, 2000000) : ($isCurrentMonth ? rand(200000, 800000) : 0)
                    ];
                @endphp

                <div class="monthly-card {{ $isCurrentMonth ? 'current-month' : '' }} {{ $isFutureMonth ? 'future-month' : '' }}"
                     {{ !$isFutureMonth ? 'onclick=exportMonth(' . $month . ',' . $currentYear . ')' : '' }}>
                    <div class="month-header">
                        <div class="month-name">{{ $months[$month] }}</div>
                        @if($isCurrentMonth)
                            <span class="current-badge">Hiện tại</span>
                        @endif
                    </div>

                    @if(!$isFutureMonth && $monthlyStats['trips'] > 0)
                        <div class="month-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($monthlyStats['trips']) }}</div>
                                <div class="stat-label">chuyến</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($monthlyStats['total_amount'] / 1000) }}K</div>
                                <div class="stat-label">tổng chi</div>
                            </div>
                        </div>
                        <div class="month-actions">
                            <button class="btn-export" onclick="event.stopPropagation(); exportMonth({{ $month }}, {{ $currentYear }})">
                                <i class="bi bi-download"></i>
                                Xuất Excel
                            </button>
                            <button class="btn-preview" onclick="event.stopPropagation(); previewMonth({{ $month }}, {{ $currentYear }})">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    @elseif($isFutureMonth)
                        <div class="month-empty">
                            <i class="bi bi-calendar-x"></i>
                            <span>Chưa có dữ liệu</span>
                        </div>
                    @else
                        <div class="month-empty">
                            <i class="bi bi-inbox"></i>
                            <span>Không có chuyến đi chợ</span>
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    {{-- Export History --}}
    <div class="export-history-section">
        <div class="section-header">
            <h3>
                <i class="bi bi-clock-history"></i>
                Lịch Sử Xuất File
            </h3>
            <p>Các file đã tạo gần đây</p>
        </div>
        <div class="history-list">
            {{-- Mock history data - trong thực tế sẽ lưu trong database --}}
            @php
                $exportHistory = [
                    [
                        'name' => 'Báo cáo tháng ' . \Carbon\Carbon::now()->subMonth()->format('m/Y'),
                        'type' => 'monthly',
                        'size' => '245 KB',
                        'created_at' => \Carbon\Carbon::now()->subDays(2)->format('d/m/Y H:i'),
                        'file_path' => '#'
                    ],
                    [
                        'name' => 'Tổng hợp quý 3/2024',
                        'type' => 'quarterly',
                        'size' => '512 KB',
                        'created_at' => \Carbon\Carbon::now()->subDays(7)->format('d/m/Y H:i'),
                        'file_path' => '#'
                    ],
                    [
                        'name' => 'Chi tiết tháng 8/2024',
                        'type' => 'detailed',
                        'size' => '189 KB',
                        'created_at' => \Carbon\Carbon::now()->subDays(15)->format('d/m/Y H:i'),
                        'file_path' => '#'
                    ]
                ];
            @endphp

            @forelse($exportHistory as $item)
                <div class="history-item">
                    <div class="history-icon">
                        <i class="bi bi-file-earmark-excel"></i>
                    </div>
                    <div class="history-info">
                        <div class="history-name">{{ $item['name'] }}</div>
                        <div class="history-meta">
                            <span class="history-size">{{ $item['size'] }}</span>
                            <span class="history-date">{{ $item['created_at'] }}</span>
                        </div>
                    </div>
                    <div class="history-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="downloadFile('{{ $item['file_path'] }}')">
                            <i class="bi bi-download"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteExportFile('{{ $item['file_path'] }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="history-empty">
                    <div class="empty-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="empty-text">
                        <h4>Chưa có file nào được xuất</h4>
                        <p>Hãy tạo báo cáo đầu tiên của bạn</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Custom Export Modal --}}
<div class="modal fade" id="customExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-sliders"></i>
                    Xuất Báo Cáo Tùy Chỉnh
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="customExportForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại báo cáo</label>
                        <div class="form-check-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reportType" id="detailedReport" value="detailed" checked>
                                <label class="form-check-label" for="detailedReport">
                                    <strong>Chi tiết</strong> - Tất cả chuyến đi chợ và mặt hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reportType" id="summaryReport" value="summary">
                                <label class="form-check-label" for="summaryReport">
                                    <strong>Tóm tắt</strong> - Chỉ tổng hợp theo ngày
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tùy chọn bổ sung</label>
                        <div class="form-check-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="includeCharts" checked>
                                <label class="form-check-label" for="includeCharts">
                                    Bao gồm biểu đồ
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="includeAnalysis" checked>
                                <label class="form-check-label" for="includeAnalysis">
                                    Phân tích chi tiêu
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="processCustomExport()">
                    <i class="bi bi-download"></i>
                    Xuất Báo Cáo
                </button>
            </div>
        </div>
    </div>
</div>

@include('layouts.components.loading', ['overlay' => true])
@endsection

@push('styles')
<style>
/* Export Page Styles */
.export-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* Export Header */
.export-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.page-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.title-icon {
    font-size: 2.5rem;
    opacity: 0.9;
}

.title-text h1 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
}

.title-text p {
    margin: 0.25rem 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.header-actions .btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    backdrop-filter: blur(10px);
}

.header-actions .btn:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
}

/* Section Styles */
.section-header {
    margin-bottom: 1.5rem;
}

.section-header h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.section-header p {
    color: #718096;
    margin: 0;
    font-size: 0.9rem;
}

/* Quick Actions */
.quick-actions-section {
    margin-bottom: 3rem;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.quick-action-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.action-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.action-content {
    flex: 1;
}

.action-content h4 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: #2d3748;
    font-size: 1.1rem;
}

.action-content p {
    margin: 0;
    color: #4a5568;
    font-weight: 500;
}

.action-label {
    display: block;
    font-size: 0.85rem;
    color: #718096;
    margin-top: 0.25rem;
}

.action-arrow {
    color: #cbd5e0;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.quick-action-card:hover .action-arrow {
    color: #667eea;
    transform: translateX(4px);
}

/* Monthly Reports */
.monthly-reports-section {
    margin-bottom: 3rem;
}

.monthly-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
}

.monthly-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.monthly-card:not(.future-month):hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    border-color: #667eea;
}

.monthly-card.current-month {
    border-color: #48bb78;
    box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
}

.monthly-card.future-month {
    opacity: 0.6;
    cursor: not-allowed;
}

.month-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.month-name {
    font-weight: 600;
    color: #2d3748;
    font-size: 1.1rem;
}

.current-badge {
    background: #48bb78;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.month-stats {
    padding: 1.25rem;
    display: flex;
    justify-content: space-between;
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
    color: #718096;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.month-actions {
    padding: 0 1.25rem 1.25rem;
    display: flex;
    gap: 0.75rem;
}

.btn-export {
    flex: 1;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-export:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-preview {
    width: 40px;
    height: 40px;
    background: #f7fafc;
    color: #4a5568;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-preview:hover {
    background: #edf2f7;
    color: #2d3748;
}

.month-empty {
    padding: 2rem 1.25rem;
    text-align: center;
    color: #a0aec0;
}

.month-empty i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

/* Export History */
.export-history-section {
    margin-bottom: 2rem;
}

.history-list {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.history-item {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    border-bottom: 1px solid #f7fafc;
    transition: all 0.2s ease;
}

.history-item:last-child {
    border-bottom: none;
}

.history-item:hover {
    background: #f7fafc;
}

.history-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-right: 1rem;
}

.history-info {
    flex: 1;
}

.history-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.history-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: #718096;
}

.history-actions {
    display: flex;
    gap: 0.5rem;
}

.history-empty {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-text h4 {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.empty-text p {
    color: #a0aec0;
    margin: 0;
}

/* Custom Export Modal */
.form-check-group .form-check {
    margin-bottom: 0.75rem;
    padding: 0.75rem;
    background: #f7fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

.form-check-group .form-check:hover {
    background: #edf2f7;
}

.form-check-group .form-check-input:checked + .form-check-label {
    color: #667eea;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .export-header {
        padding: 1.5rem;
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .page-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .title-icon {
        font-size: 2rem;
    }

    .title-text h1 {
        font-size: 1.5rem;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }

    .monthly-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }

    .month-actions {
        flex-direction: column;
    }

    .history-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .history-actions {
        align-self: flex-end;
    }
}

@media (max-width: 480px) {
    .export-container {
        padding: 0 0.75rem;
    }

    .monthly-grid {
        grid-template-columns: 1fr;
    }

    .quick-action-card {
        padding: 1rem;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Export functions
function exportCurrentMonth() {
    const now = new Date();
    exportMonth(now.getMonth() + 1, now.getFullYear());
}

function exportLastMonth() {
    const lastMonth = new Date();
    lastMonth.setMonth(lastMonth.getMonth() - 1);
    exportMonth(lastMonth.getMonth() + 1, lastMonth.getFullYear());
}

function exportMonth(month, year) {
    showLoading();

    // Format month with leading zero
    const formattedMonth = month.toString().padStart(2, '0');

    // Create download URL
    const url = `{{ route('export.monthly', ['month' => ':month', 'year' => ':year']) }}`
        .replace(':month', formattedMonth)
        .replace(':year', year);

    // Trigger download
    window.location.href = url;

    // Hide loading after a delay
    setTimeout(hideLoading, 2000);
}

function previewMonth(month, year) {
    // Implementation for previewing month data
    alert(`Xem trước dữ liệu tháng ${month}/${year}`);
}

function showCustomExportModal() {
    const modal = new bootstrap.Modal(document.getElementById('customExportModal'));

    // Set default dates
    const now = new Date();
    const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
    const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

    document.getElementById('startDate').value = firstDay.toISOString().split('T')[0];
    document.getElementById('endDate').value = lastDay.toISOString().split('T')[0];

    modal.show();
}

function processCustomExport() {
    const form = document.getElementById('customExportForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const reportType = document.querySelector('input[name="reportType"]:checked').value;
    const includeCharts = document.getElementById('includeCharts').checked;
    const includeAnalysis = document.getElementById('includeAnalysis').checked;

    // Validate date range
    if (new Date(startDate) > new Date(endDate)) {
        alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
        return;
    }

    showLoading();

    // Create form data
    const formData = new FormData();
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);
    formData.append('report_type', reportType);
    formData.append('include_charts', includeCharts);
    formData.append('include_analysis', includeAnalysis);

    // Submit export request
    fetch('{{ route('export.index') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            return response.blob();
        }
        throw new Error('Export failed');
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `bao_cao_${startDate}_${endDate}.xlsx`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('customExportModal'));
        modal.hide();

        // Show success message
        showSuccessMessage('Báo cáo đã được xuất thành công!');
    })
    .catch(error => {
        console.error('Export error:', error);
        alert('Có lỗi xảy ra khi xuất báo cáo. Vui lòng thử lại.');
    })
    .finally(() => {
        hideLoading();
    });
}

function downloadFile(filePath) {
    if (filePath === '#') {
        alert('File này chỉ là dữ liệu mẫu');
        return;
    }

    showLoading();
    window.location.href = filePath;
    setTimeout(hideLoading, 1500);
}

function deleteExportFile(filePath) {
    if (filePath === '#') {
        alert('File này chỉ là dữ liệu mẫu');
        return;
    }

    if (!confirm('Bạn có chắc chắn muốn xóa file này?')) {
        return;
    }

    // Implementation for deleting export file
    showLoading();

    fetch('/api/export/delete', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ file_path: filePath })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra khi xóa file');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        alert('Có lỗi xảy ra khi xóa file');
    })
    .finally(() => {
        hideLoading();
    });
}

function refreshData() {
    showLoading();
    location.reload();
}

// Loading functions
function showLoading() {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) {
        overlay.classList.remove('hidden');
    }
}

function hideLoading() {
    const overlay = document.getElementById('pageLoadingOverlay');
    if (overlay) {
        overlay.classList.add('hidden');
    }
}

function showSuccessMessage(message) {
    // Create success alert
    const alertContainer = document.querySelector('.content-wrapper');
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show';
    alert.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    alertContainer.insertBefore(alert, alertContainer.firstChild);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set current dates in quick actions
    updateQuickActionDates();

    // Initialize modals
    const customExportModal = document.getElementById('customExportModal');
    if (customExportModal) {
        customExportModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('startDate').focus();
        });
    }

    // Handle page loading
    hideLoading();
});

function updateQuickActionDates() {
    const now = new Date();
    const currentMonthCard = document.querySelector('.quick-action-card:first-child .action-content p');
    const lastMonthCard = document.querySelector('.quick-action-card:nth-child(2) .action-content p');

    if (currentMonthCard) {
        currentMonthCard.textContent = String(now.getMonth() + 1).padStart(2, '0') + '/' + now.getFullYear();
    }

    const lastMonth = new Date(now);
    lastMonth.setMonth(lastMonth.getMonth() - 1);

    if (lastMonthCard) {
        lastMonthCard.textContent = String(lastMonth.getMonth() + 1).padStart(2, '0') + '/' + lastMonth.getFullYear();
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 'e':
                e.preventDefault();
                exportCurrentMonth();
                break;
            case 'r':
                e.preventDefault();
                refreshData();
                break;
            case 'n':
                e.preventDefault();
                showCustomExportModal();
                break;
        }
    }
});

// Service Worker for offline functionality (if available)
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.ready.then(registration => {
        // Handle offline export caching if needed
        if (registration.sync) {
            // Background sync for export requests when back online
        }
    });
}

// Auto-refresh data every 5 minutes
setInterval(() => {
    // Refresh stats in background without full page reload
    fetch('{{ route('export.index') }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update stats if needed
        if (data.currentMonthTrips !== undefined) {
            const currentMonthLabel = document.querySelector('.quick-action-card:first-child .action-label');
            if (currentMonthLabel) {
                currentMonthLabel.textContent = `${data.currentMonthTrips} chuyến đi chợ`;
            }
        }

        if (data.lastMonthTrips !== undefined) {
            const lastMonthLabel = document.querySelector('.quick-action-card:nth-child(2) .action-label');
            if (lastMonthLabel) {
                lastMonthLabel.textContent = `${data.lastMonthTrips} chuyến đi chợ`;
            }
        }
    })
    .catch(error => {
        console.log('Background refresh failed:', error);
    });
}, 5 * 60 * 1000); // 5 minutes
</script>
@endpush

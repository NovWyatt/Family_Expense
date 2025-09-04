@extends('layouts.app')

@section('title', 'Cài đặt')

@section('content')
<div class="settings-container">
    <!-- Settings Header -->
    <div class="settings-header">
        <div class="header-content">
            <h1><i class="bi bi-gear-fill me-2"></i>Cài đặt</h1>
            <p>Quản lý thông tin và tùy chỉnh ứng dụng</p>
        </div>
    </div>

    <!-- Settings Sections -->
    <div class="settings-content">
        <!-- Account Settings -->
        <div class="settings-section">
            <div class="section-header">
                <h3><i class="bi bi-person-circle me-2"></i>Tài khoản</h3>
            </div>
            <div class="settings-items">
                <!-- Change Password -->
                <div class="setting-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <div class="setting-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Đổi mật khẩu</h5>
                        <p>Thay đổi mật khẩu truy cập ứng dụng</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-info-circle-fill text-info"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Bảo mật</h5>
                        <p>Ứng dụng được bảo vệ bằng mật khẩu</p>
                    </div>
                    <div class="setting-action">
                        <div class="status-badge success">
                            <i class="bi bi-check-circle-fill me-1"></i>Đã bật
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- App Settings -->
        <div class="settings-section">
            <div class="section-header">
                <h3><i class="bi bi-app me-2"></i>Ứng dụng</h3>
            </div>
            <div class="settings-items">
                <!-- Theme Toggle -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-palette-fill"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Giao diện tối</h5>
                        <p>Chuyển đổi giữa chế độ sáng và tối</p>
                    </div>
                    <div class="setting-action">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="themeToggle">
                        </div>
                    </div>
                </div>

                <!-- Language -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-translate"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Ngôn ngữ</h5>
                        <p>Tiếng Việt</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Thông báo</h5>
                        <p>Nhận thông báo khi có giao dịch mới</p>
                    </div>
                    <div class="setting-action">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="notificationToggle" checked>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Settings -->
        <div class="settings-section">
            <div class="section-header">
                <h3><i class="bi bi-database-fill me-2"></i>Dữ liệu</h3>
            </div>
            <div class="settings-items">
                <!-- Export Data -->
                <div class="setting-item" onclick="window.location.href='{{ route('export.index') }}'">
                    <div class="setting-icon">
                        <i class="bi bi-download"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Xuất dữ liệu</h5>
                        <p>Tải về file Excel báo cáo chi tiêu</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>

                <!-- Data Summary -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-bar-chart-fill text-success"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Thống kê dữ liệu</h5>
                        <p id="dataStats">Đang tải...</p>
                    </div>
                    <div class="setting-action">
                        <button class="btn btn-sm btn-outline-primary" onclick="loadDataStats()">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                </div>

                <!-- Clear Cache -->
                <div class="setting-item" onclick="clearAppCache()">
                    <div class="setting-icon">
                        <i class="bi bi-trash3-fill text-warning"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Xóa bộ nhớ đệm</h5>
                        <p>Làm mới dữ liệu ứng dụng</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="settings-section">
            <div class="section-header">
                <h3><i class="bi bi-info-circle me-2"></i>Thông tin</h3>
            </div>
            <div class="settings-items">
                <!-- App Version -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-app-indicator"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Phiên bản ứng dụng</h5>
                        <p>v1.0.0 - Cập nhật {{ date('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- Developer -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-code-slash"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Phát triển</h5>
                        <p>Ứng dụng quản lý quỹ đi chợ</p>
                    </div>
                </div>

                <!-- Support -->
                <div class="setting-item">
                    <div class="setting-icon">
                        <i class="bi bi-question-circle-fill text-primary"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Trợ giúp & Hỗ trợ</h5>
                        <p>Hướng dẫn sử dụng và báo lỗi</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="settings-section">
            <div class="settings-items">
                <div class="setting-item danger" onclick="confirmLogout()">
                    <div class="setting-icon">
                        <i class="bi bi-box-arrow-right"></i>
                    </div>
                    <div class="setting-content">
                        <h5>Đăng xuất</h5>
                        <p>Thoát khỏi ứng dụng</p>
                    </div>
                    <div class="setting-action">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="changePasswordForm" method="POST" action="{{ route('change.password') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock-fill me-2"></i>Đổi mật khẩu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password"
                                   name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" required minlength="6">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password"
                                   name="new_password_confirmation" required minlength="6">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-box-arrow-right me-2"></i>Xác nhận đăng xuất
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn đăng xuất khỏi ứng dụng?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right me-1"></i>Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .settings-container {
        max-width: 100%;
        padding: 0;
    }

    /* Settings Header */
    .settings-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 1.5rem;
        margin: -1rem -1rem 2rem -1rem;
        border-radius: 0 0 20px 20px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .settings-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .settings-header .header-content {
        position: relative;
        z-index: 2;
    }

    .settings-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .settings-header p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Settings Content */
    .settings-content {
        padding: 0 1rem;
    }

    .settings-section {
        background: white;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .section-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .section-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }

    .settings-items {
        padding: 0;
    }

    .setting-item {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-item:hover {
        background: #f8f9ff;
    }

    .setting-item.danger:hover {
        background: #fef8f8;
    }

    .setting-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .setting-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .setting-item.danger .setting-icon {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
    }

    .setting-content {
        flex: 1;
        margin-right: 1rem;
    }

    .setting-content h5 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }

    .setting-item.danger .setting-content h5 {
        color: #dc3545;
    }

    .setting-content p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }

    .setting-action {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }

    .setting-action i {
        color: #999;
        font-size: 1rem;
    }

    .status-badge {
        background: #e8f5e8;
        color: #28a745;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .status-badge.success {
        background: #e8f5e8;
        color: #28a745;
    }

    .status-badge.warning {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.danger {
        background: #f8d7da;
        color: #721c24;
    }

    /* Form Switches */
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-input:focus {
        border-color: #667eea;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }

    /* Modal Customization */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }

    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        border-radius: 16px 16px 0 0;
    }

    .modal-title {
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }

    .input-group .btn {
        border-color: #ced4da;
    }

    .input-group .btn:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .settings-header {
            padding: 1.5rem 1rem;
            margin: -1rem -1rem 1.5rem -1rem;
        }

        .settings-header h1 {
            font-size: 1.8rem;
        }

        .settings-content {
            padding: 0 0.5rem;
        }

        .setting-item {
            padding: 0.875rem 1rem;
        }

        .setting-icon {
            width: 36px;
            height: 36px;
            margin-right: 0.875rem;
        }

        .setting-content h5 {
            font-size: 0.95rem;
        }

        .setting-content p {
            font-size: 0.85rem;
        }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
        .settings-section {
            background: #1a1a1a;
            border-color: rgba(255,255,255,0.1);
        }

        .section-header {
            background: #2a2a2a;
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .section-header h3 {
            color: #f0f0f0;
        }

        .setting-item {
            background: #1a1a1a;
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .setting-item:hover {
            background: #2a2a2a;
        }

        .setting-content h5 {
            color: #f0f0f0;
        }

        .setting-content p {
            color: #b0b0b0;
        }

        .modal-content {
            background: #1a1a1a;
            color: #f0f0f0;
        }

        .modal-header {
            background: #2a2a2a;
            border-bottom-color: rgba(255,255,255,0.1);
        }

        .form-control {
            background: #2a2a2a;
            border-color: rgba(255,255,255,0.2);
            color: #f0f0f0;
        }

        .form-control:focus {
            background: #2a2a2a;
            border-color: #667eea;
            color: #f0f0f0;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize settings
    initializeSettings();
    loadDataStats();

    // Setup form validation
    setupPasswordForm();
});

function initializeSettings() {
    // Load theme preference
    const savedTheme = localStorage.getItem('app-theme');
    const themeToggle = document.getElementById('themeToggle');

    if (savedTheme === 'dark') {
        themeToggle.checked = true;
        document.body.classList.add('dark-theme');
    }

    // Theme toggle handler
    themeToggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark-theme');
            localStorage.setItem('app-theme', 'dark');
        } else {
            document.body.classList.remove('dark-theme');
            localStorage.setItem('app-theme', 'light');
        }
    });

    // Load notification preference
    const savedNotification = localStorage.getItem('notifications-enabled');
    const notificationToggle = document.getElementById('notificationToggle');

    if (savedNotification === 'false') {
        notificationToggle.checked = false;
    }

    notificationToggle.addEventListener('change', function() {
        localStorage.setItem('notifications-enabled', this.checked.toString());

        if (this.checked && 'Notification' in window) {
            // Request notification permission
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    new Notification('Quỹ Đi Chợ', {
                        body: 'Thông báo đã được bật thành công!',
                        icon: '/icon-192x192.png'
                    });
                }
            });
        }
    });
}

function loadDataStats() {
    const statsElement = document.getElementById('dataStats');

    // Simulate loading data stats
    statsElement.textContent = 'Đang tải...';

    // In a real app, you would make API calls here
    setTimeout(() => {
        // Mock data - replace with actual API calls
        const mockStats = {
            totalTrips: Math.floor(Math.random() * 50) + 10,
            totalAmount: Math.floor(Math.random() * 5000000) + 1000000,
            thisMonth: Math.floor(Math.random() * 500000) + 100000
        };

        statsElement.innerHTML = `
            ${mockStats.totalTrips} chuyến đi chợ •
            ${mockStats.totalAmount.toLocaleString('vi-VN')}đ tổng chi •
            ${mockStats.thisMonth.toLocaleString('vi-VN')}đ tháng này
        `;
    }, 1000);
}

function setupPasswordForm() {
    const form = document.getElementById('changePasswordForm');
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    // Password confirmation validation
    function validatePasswords() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Mật khẩu xác nhận không khớp');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    newPassword.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);

    form.addEventListener('submit', function(e) {
        validatePasswords();

        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }

        form.classList.add('was-validated');
    });
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        button.classList.remove('bi-eye');
        button.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        button.classList.remove('bi-eye-slash');
        button.classList.add('bi-eye');
    }
}

function confirmLogout() {
    const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
    modal.show();
}

function clearAppCache() {
    // Show confirmation dialog
    if (confirm('Bạn có chắc chắn muốn xóa bộ nhớ đệm? Hành động này sẽ làm mới toàn bộ dữ liệu ứng dụng.')) {
        // Clear localStorage
        const keysToKeep = ['app-theme', 'notifications-enabled'];
        const keysToRemove = [];

        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (!keysToKeep.includes(key)) {
                keysToRemove.push(key);
            }
        }

        keysToRemove.forEach(key => localStorage.removeItem(key));

        // Clear sessionStorage
        sessionStorage.clear();

        // Clear caches if available
        if ('caches' in window) {
            caches.keys().then(cacheNames => {
                return Promise.all(
                    cacheNames.map(cacheName => caches.delete(cacheName))
                );
            });
        }

        // Show success message and refresh
        alert('Bộ nhớ đệm đã được xóa thành công. Trang sẽ được làm mới.');
        window.location.reload();
    }
}

// Handle settings interactions
document.addEventListener('click', function(e) {
    const settingItem = e.target.closest('.setting-item');
    if (!settingItem) return;

    // Don't handle clicks on form controls
    if (e.target.closest('.form-check, .btn, .setting-action button')) return;

    // Handle specific setting items
    if (settingItem.dataset.bsToggle === 'modal') return; // Let Bootstrap handle modals

    // Add ripple effect
    const ripple = document.createElement('div');
    ripple.className = 'ripple-effect';
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    `;

    const rect = settingItem.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
    ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';

    settingItem.style.position = 'relative';
    settingItem.appendChild(ripple);

    setTimeout(() => {
        ripple.remove();
    }, 600);
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Handle back button
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal.show');
        if (openModals.length > 0) {
            const modal = bootstrap.Modal.getInstance(openModals[openModals.length - 1]);
            if (modal) modal.hide();
        }
    }
});

// Auto-save preferences
function savePreference(key, value) {
    localStorage.setItem(`settings_${key}`, JSON.stringify(value));
}

function loadPreference(key, defaultValue = null) {
    const saved = localStorage.getItem(`settings_${key}`);
    return saved ? JSON.parse(saved) : defaultValue;
}

// Performance monitoring
function trackSettingsUsage(action, setting) {
    // In a real app, you might send this to analytics
    console.log(`Settings action: ${action} on ${setting}`);

    // Store usage stats locally
    const usage = loadPreference('usage_stats', {});
    const today = new Date().toISOString().split('T')[0];

    if (!usage[today]) usage[today] = {};
    if (!usage[today][setting]) usage[today][setting] = 0;

    usage[today][setting]++;
    savePreference('usage_stats', usage);
}

// Export settings
function exportSettings() {
    const settings = {
        theme: localStorage.getItem('app-theme'),
        notifications: localStorage.getItem('notifications-enabled'),
        viewMode: localStorage.getItem('shopping-view-mode'),
        exportedAt: new Date().toISOString(),
        version: '1.0.0'
    };

    const blob = new Blob([JSON.stringify(settings, null, 2)], {
        type: 'application/json'
    });

    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `quy-di-cho-settings-${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Import settings
function importSettings(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const settings = JSON.parse(e.target.result);

            // Validate settings format
            if (!settings.version || !settings.exportedAt) {
                throw new Error('Invalid settings file format');
            }

            // Apply settings
            if (settings.theme) {
                localStorage.setItem('app-theme', settings.theme);
                document.getElementById('themeToggle').checked = settings.theme === 'dark';

                if (settings.theme === 'dark') {
                    document.body.classList.add('dark-theme');
                } else {
                    document.body.classList.remove('dark-theme');
                }
            }

            if (settings.notifications) {
                localStorage.setItem('notifications-enabled', settings.notifications);
                document.getElementById('notificationToggle').checked = settings.notifications === 'true';
            }

            if (settings.viewMode) {
                localStorage.setItem('shopping-view-mode', settings.viewMode);
            }

            alert('Cài đặt đã được nhập thành công!');

        } catch (error) {
            alert('Lỗi khi nhập cài đặt: ' + error.message);
        }
    };

    reader.readAsText(file);
}

// Initialize tooltips
if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Service Worker registration for PWA
if ('serviceWorker' in navigator && window.location.protocol === 'https:') {
    navigator.serviceWorker.register('/sw.js')
        .then(function(registration) {
            console.log('ServiceWorker registration successful');
        })
        .catch(function(err) {
            console.log('ServiceWorker registration failed');
        });
}

// Check for app updates
function checkForUpdates() {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.ready.then(function(registration) {
            registration.update();
        });
    }

    // Simple version check (in a real app, you'd check against server)
    const currentVersion = '1.0.0';
    const lastChecked = localStorage.getItem('last_update_check');
    const now = Date.now();

    // Check once per day
    if (!lastChecked || (now - parseInt(lastChecked)) > 24 * 60 * 60 * 1000) {
        localStorage.setItem('last_update_check', now.toString());

        // Simulate update check
        setTimeout(() => {
            const hasUpdate = Math.random() > 0.8; // 20% chance of update
            if (hasUpdate) {
                showUpdateNotification();
            }
        }, 2000);
    }
}

function showUpdateNotification() {
    const notification = document.createElement('div');
    notification.className = 'alert alert-info alert-dismissible fade show position-fixed';
    notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;

    notification.innerHTML = `
        <i class="bi bi-info-circle-fill me-2"></i>
        <strong>Cập nhật có sẵn!</strong>
        <p class="mb-2">Có phiên bản mới của ứng dụng. Tải lại trang để cập nhật.</p>
        <button type="button" class="btn btn-sm btn-primary me-2" onclick="window.location.reload()">
            Cập nhật ngay
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto dismiss after 10 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 10000);
}

// Initialize update checker
checkForUpdates();

// Memory usage monitoring (for development)
if (typeof performance !== 'undefined' && performance.memory) {
    setInterval(() => {
        const memory = performance.memory;
        const usage = {
            used: Math.round(memory.usedJSHeapSize / 1048576 * 100) / 100,
            total: Math.round(memory.totalJSHeapSize / 1048576 * 100) / 100,
            limit: Math.round(memory.jsHeapSizeLimit / 1048576 * 100) / 100
        };

        // Log if usage is high
        if (usage.used > 50) {
            console.warn('High memory usage:', usage);
        }
    }, 30000); // Check every 30 seconds
}
</script>
@endpush

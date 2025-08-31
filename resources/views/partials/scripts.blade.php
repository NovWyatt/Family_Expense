{{-- Scripts Partial - JavaScript Libraries and Common Functions --}}

{{-- jQuery (if needed for legacy components) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{-- Bootstrap 5 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

{{-- Axios for HTTP requests --}}
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.2/dist/axios.min.js"></script>

{{-- SweetAlert2 for beautiful alerts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Chart.js for data visualization --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Moment.js for date formatting --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/vi.min.js"></script>

{{-- Global Variables --}}
<script>
    // Set global variables
    window.App = {
        csrf: '{{ csrf_token() }}',
        url: '{{ url("/") }}',
        user: @auth{!! json_encode(auth()->user()) !!}@else null @endauth,
        locale: 'vi',
        routes: {
            dashboard: '{{ route("dashboard") }}',
            login: '{{ route("login") }}',
            logout: '{{ route("logout") }}',
            funds: {
                index: '{{ route("funds.index") }}',
                add: '{{ route("funds.add") }}',
                history: '{{ route("funds.history") }}',
                balance: '{{ route("funds.api.balance") }}',
            },
            shopping: {
                index: '{{ route("shopping.index") }}',
                create: '{{ route("shopping.create") }}',
                store: '{{ route("shopping.store") }}',
                apiSuggestions: '{{ route("shopping.api.item.suggestions") }}',
                apiPrice: '{{ route("shopping.api.item.price") }}',
                apiCheckBalance: '{{ route("shopping.api.check.balance") }}'
            },
            export: {
                index: '{{ route("export.index") }}'
            }
        }
    };

    // Set Axios defaults
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = window.App.csrf;

    // Set moment.js locale
    moment.locale('vi');
</script>

{{-- Common JavaScript Functions --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize global functions
    initializeGlobalFunctions();
    initializeNotifications();
    initializeFormValidation();
    initializePWA();
    initializeKeyboardShortcuts();
});

/**
 * Initialize global utility functions
 */
function initializeGlobalFunctions() {
    // Format currency Vietnamese style
    window.formatCurrency = function(amount, currency = 'VNĐ') {
        if (amount === null || amount === undefined) return '0 ' + currency;
        return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + ' ' + currency;
    };

    // Format date Vietnamese style
    window.formatDate = function(date, format = 'DD/MM/YYYY') {
        if (!date) return '';
        return moment(date).format(format);
    };

    // Format datetime Vietnamese style
    window.formatDateTime = function(date, format = 'DD/MM/YYYY HH:mm') {
        if (!date) return '';
        return moment(date).format(format);
    };

    // Parse currency input
    window.parseCurrency = function(value) {
        if (!value) return 0;
        return parseInt(value.toString().replace(/[^\d]/g, '')) || 0;
    };

    // Validate Vietnamese phone number
    window.validatePhone = function(phone) {
        const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
        return phoneRegex.test(phone);
    };

    // Validate email
    window.validateEmail = function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    };

    // Debounce function
    window.debounce = function(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    };

    // Throttle function
    window.throttle = function(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    // Generate random ID
    window.generateId = function(prefix = 'id') {
        return prefix + '_' + Math.random().toString(36).substr(2, 9);
    };

    // Storage helpers with error handling
    window.storage = {
        get: function(key, defaultValue = null) {
            try {
                const item = localStorage.getItem(key);
                return item ? JSON.parse(item) : defaultValue;
            } catch (error) {
                console.warn('Storage get error:', error);
                return defaultValue;
            }
        },
        set: function(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
                return true;
            } catch (error) {
                console.warn('Storage set error:', error);
                return false;
            }
        },
        remove: function(key) {
            try {
                localStorage.removeItem(key);
                return true;
            } catch (error) {
                console.warn('Storage remove error:', error);
                return false;
            }
        }
    };
}

/**
 * Initialize notification system
 */
function initializeNotifications() {
    // Enhanced toast notifications with SweetAlert2
    window.showToast = function(message, type = 'info', duration = 3000) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const iconMap = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info',
            'danger': 'error'
        };

        Toast.fire({
            icon: iconMap[type] || 'info',
            title: message
        });
    };

    // Enhanced alert with SweetAlert2
    window.showAlert = function(title, message, type = 'info') {
        const iconMap = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info',
            'danger': 'error'
        };

        return Swal.fire({
            title: title,
            text: message,
            icon: iconMap[type] || 'info',
            confirmButtonText: 'OK',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    };

    // Confirmation dialog
    window.showConfirm = function(title, message, confirmText = 'Xác nhận', cancelText = 'Hủy') {
        return Swal.fire({
            title: title,
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-secondary'
            }
        });
    };
}

/**
 * Initialize form validation and enhancements
 */
function initializeFormValidation() {
    // Auto-format currency inputs
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('currency-input')) {
            const value = parseCurrency(e.target.value);
            e.target.value = value.toLocaleString('vi-VN');
            e.target.dataset.value = value;
        }
    });

    // Auto-format phone inputs
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('phone-input')) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('84')) {
                value = '0' + value.substring(2);
            }
            e.target.value = value;
        }
    });

    // Bootstrap form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                // Focus on first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
            form.classList.add('was-validated');
        });
    });

    // Real-time validation
    document.addEventListener('blur', function(e) {
        if (e.target.matches('.form-control, .form-select')) {
            if (e.target.checkValidity()) {
                e.target.classList.remove('is-invalid');
                e.target.classList.add('is-valid');
            } else {
                e.target.classList.remove('is-valid');
                e.target.classList.add('is-invalid');
            }
        }
    }, true);
}

/**
 * Initialize PWA functionality
 */
function initializePWA() {
    let deferredPrompt;

    // PWA install prompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;

        // Show custom install button if available
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'block';
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;

                    if (outcome === 'accepted') {
                        showToast('App đã được cài đặt thành công!', 'success');
                    }

                    deferredPrompt = null;
                    installBtn.style.display = 'none';
                }
            });
        }
    });

    // PWA update available
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            showToast('App đã được cập nhật! Tải lại trang để áp dụng.', 'info', 5000);
        });
    }
}

/**
 * Initialize keyboard shortcuts
 */
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.focus();
            }
        }

        // Ctrl/Cmd + N for new/create actions
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const createBtn = document.querySelector('.btn-create, .btn-add');
            if (createBtn) {
                createBtn.click();
            }
        }

        // Escape to close modals
        if (e.key === 'Escape') {
            const modal = document.querySelector('.modal.show');
            if (modal) {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
        }

        // Ctrl/Cmd + S to save forms
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            const form = document.querySelector('form:not([data-no-shortcut])');
            if (form) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.click();
                }
            }
        }
    });
}

/**
 * AJAX Helper Functions
 */
window.ajax = {
    get: function(url, config = {}) {
        return axios.get(url, config).catch(this.handleError);
    },

    post: function(url, data = {}, config = {}) {
        return axios.post(url, data, config).catch(this.handleError);
    },

    put: function(url, data = {}, config = {}) {
        return axios.put(url, data, config).catch(this.handleError);
    },

    delete: function(url, config = {}) {
        return axios.delete(url, config).catch(this.handleError);
    },

    handleError: function(error) {
        console.error('AJAX Error:', error);

        if (error.response) {
            const status = error.response.status;
            const message = error.response.data?.message || 'Có lỗi xảy ra';

            switch (status) {
                case 401:
                    showAlert('Phiên đăng nhập hết hạn', 'Vui lòng đăng nhập lại', 'warning')
                        .then(() => {
                            window.location.href = window.App.routes.login;
                        });
                    break;
                case 403:
                    showAlert('Không có quyền truy cập', message, 'error');
                    break;
                case 404:
                    showAlert('Không tìm thấy', 'Trang hoặc dữ liệu không tồn tại', 'error');
                    break;
                case 422:
                    // Validation errors
                    if (error.response.data?.errors) {
                        const errors = Object.values(error.response.data.errors).flat();
                        showAlert('Dữ liệu không hợp lệ', errors.join('\n'), 'warning');
                    } else {
                        showAlert('Dữ liệu không hợp lệ', message, 'warning');
                    }
                    break;
                case 500:
                    showAlert('Lỗi máy chủ', 'Có lỗi xảy ra trên máy chủ. Vui lòng thử lại sau.', 'error');
                    break;
                default:
                    showAlert('Có lỗi xảy ra', message, 'error');
            }
        } else if (error.request) {
            showAlert('Lỗi kết nối', 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối internet.', 'error');
        } else {
            showAlert('Lỗi', error.message, 'error');
        }

        throw error;
    }
};

/**
 * Loading Overlay Functions
 */
window.loading = {
    show: function(message = 'Đang xử lý...') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    },

    hide: function() {
        Swal.close();
    },

    showOnButton: function(button, message = 'Đang xử lý...') {
        if (!button) return;

        button.dataset.originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            ${message}
        `;
    },

    hideOnButton: function(button) {
        if (!button) return;

        const originalText = button.dataset.originalText;
        if (originalText) {
            button.innerHTML = originalText;
            delete button.dataset.originalText;
        }
        button.disabled = false;
    }
};

/**
 * Auto-refresh balance display
 */
function initializeBalanceRefresh() {
    if (typeof window.App.routes.funds?.balance === 'string') {
        setInterval(async () => {
            try {
                const response = await axios.get(window.App.routes.funds.balance);
                if (response.data.formatted_balance) {
                    const balanceElements = document.querySelectorAll('.current-balance, #currentBalance, #navBalance, #sidebarBalance');
                    balanceElements.forEach(el => {
                        el.textContent = response.data.formatted_balance;
                    });
                }
            } catch (error) {
                console.warn('Balance refresh failed:', error);
            }
        }, 60000); // Every minute
    }
}

/**
 * Initialize tooltips and popovers
 */
function initializeBootstrapComponents() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

/**
 * Auto-save form data to localStorage
 */
function initializeAutoSave() {
    const forms = document.querySelectorAll('[data-autosave]');
    forms.forEach(form => {
        const key = form.dataset.autosave;

        // Load saved data
        const savedData = window.storage.get(key);
        if (savedData) {
            Object.keys(savedData).forEach(name => {
                const field = form.querySelector(`[name="${name}"]`);
                if (field) {
                    field.value = savedData[name];
                }
            });
        }

        // Save data on change
        const debouncedSave = debounce(() => {
            const formData = new FormData(form);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            window.storage.set(key, data);
        }, 1000);

        form.addEventListener('input', debouncedSave);

        // Clear saved data on successful submit
        form.addEventListener('submit', () => {
            window.storage.remove(key);
        });
    });
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeBootstrapComponents();
    initializeBalanceRefresh();
    initializeAutoSave();

    // Initialize any page-specific functions
    if (typeof window.initializePage === 'function') {
        window.initializePage();
    }
});
</script>

{{-- Page specific scripts from stack --}}
@stack('scripts')

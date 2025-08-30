{{-- Alert Messages Component --}}
@if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
<div class="alerts-container" id="alertsContainer">
    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert-custom alert-success" role="alert" data-auto-dismiss="5000">
            <div class="alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Thành công!</div>
                <div class="alert-message">{{ session('success') }}</div>
            </div>
            <button type="button" class="alert-close" onclick="dismissAlert(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="alert-progress"></div>
        </div>
    @endif

    <!-- Error Alert -->
    @if (session('error'))
        <div class="alert-custom alert-error" role="alert" data-auto-dismiss="7000">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Có lỗi xảy ra!</div>
                <div class="alert-message">{{ session('error') }}</div>
            </div>
            <button type="button" class="alert-close" onclick="dismissAlert(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="alert-progress"></div>
        </div>
    @endif

    <!-- Warning Alert -->
    @if (session('warning'))
        <div class="alert-custom alert-warning" role="alert" data-auto-dismiss="6000">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Cảnh báo!</div>
                <div class="alert-message">{{ session('warning') }}</div>
            </div>
            <button type="button" class="alert-close" onclick="dismissAlert(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="alert-progress"></div>
        </div>
    @endif

    <!-- Info Alert -->
    @if (session('info'))
        <div class="alert-custom alert-info" role="alert" data-auto-dismiss="5000">
            <div class="alert-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Thông tin</div>
                <div class="alert-message">{{ session('info') }}</div>
            </div>
            <button type="button" class="alert-close" onclick="dismissAlert(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="alert-progress"></div>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert-custom alert-error" role="alert" data-auto-dismiss="10000">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Vui lòng kiểm tra lại!</div>
                <div class="alert-message">
                    @if($errors->count() == 1)
                        {{ $errors->first() }}
                    @else
                        <ul class="alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <button type="button" class="alert-close" onclick="dismissAlert(this)">
                <i class="bi bi-x"></i>
            </button>
            <div class="alert-progress"></div>
        </div>
    @endif
</div>
@endif

<!-- Toast Container for JavaScript alerts -->
<div class="toast-container" id="toastContainer"></div>

<style>
/* Alerts Container */
.alerts-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    max-width: 400px;
    width: 100%;
    pointer-events: none;
}

/* Alert Custom Styles */
.alert-custom {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.15);
    border: none;
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    pointer-events: auto;
    transform: translateX(100%);
    opacity: 0;
    animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* Alert Types */
.alert-success {
    border-left: 4px solid #28a745;
}

.alert-success .alert-icon {
    color: #28a745;
}

.alert-success .alert-progress {
    background: linear-gradient(90deg, #28a745, #20c997);
}

.alert-error {
    border-left: 4px solid #dc3545;
}

.alert-error .alert-icon {
    color: #dc3545;
}

.alert-error .alert-progress {
    background: linear-gradient(90deg, #dc3545, #e74c3c);
}

.alert-warning {
    border-left: 4px solid #ffc107;
}

.alert-warning .alert-icon {
    color: #ffc107;
}

.alert-warning .alert-progress {
    background: linear-gradient(90deg, #ffc107, #f39c12);
}

.alert-info {
    border-left: 4px solid #17a2b8;
}

.alert-info .alert-icon {
    color: #17a2b8;
}

.alert-info .alert-progress {
    background: linear-gradient(90deg, #17a2b8, #3498db);
}

/* Alert Icon */
.alert-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.2rem;
    margin-top: 0.1rem;
}

/* Alert Content */
.alert-content {
    flex: 1;
    min-width: 0;
}

.alert-title {
    font-weight: 600;
    font-size: 0.95rem;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.alert-message {
    font-size: 0.85rem;
    color: #495057;
    line-height: 1.4;
    word-wrap: break-word;
}

.alert-list {
    margin: 0.5rem 0 0 0;
    padding-left: 1.25rem;
}

.alert-list li {
    margin-bottom: 0.25rem;
}

/* Alert Close Button */
.alert-close {
    width: 24px;
    height: 24px;
    border: none;
    background: rgba(0, 0, 0, 0.1);
    color: #6c757d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
    font-size: 0.9rem;
}

.alert-close:hover {
    background: rgba(0, 0, 0, 0.2);
    color: #495057;
    transform: scale(1.1);
}

/* Progress Bar */
.alert-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    border-radius: 0 0 12px 12px;
    transform: scaleX(0);
    transform-origin: left;
    animation: progressBar linear forwards;
}

/* Toast Container */
.toast-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    max-width: 350px;
    width: 100%;
    pointer-events: none;
}

/* Toast Styles */
.toast-custom {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    pointer-events: auto;
    transform: translateY(100%);
    opacity: 0;
    animation: slideUp 0.3s ease-out forwards;
}

.toast-custom.toast-success {
    border-left: 3px solid #28a745;
}

.toast-custom.toast-error {
    border-left: 3px solid #dc3545;
}

.toast-custom.toast-warning {
    border-left: 3px solid #ffc107;
}

.toast-custom.toast-info {
    border-left: 3px solid #17a2b8;
}

.toast-icon {
    font-size: 1.1rem;
    flex-shrink: 0;
}

.toast-success .toast-icon {
    color: #28a745;
}

.toast-error .toast-icon {
    color: #dc3545;
}

.toast-warning .toast-icon {
    color: #ffc107;
}

.toast-info .toast-icon {
    color: #17a2b8;
}

.toast-message {
    flex: 1;
    font-size: 0.85rem;
    color: #495057;
    line-height: 1.4;
}

.toast-close {
    width: 20px;
    height: 20px;
    border: none;
    background: none;
    color: #6c757d;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: color 0.3s ease;
}

.toast-close:hover {
    color: #495057;
}

/* Animations */
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideDown {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(100%);
        opacity: 0;
    }
}

@keyframes progressBar {
    from {
        transform: scaleX(1);
    }
    to {
        transform: scaleX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .alerts-container {
        top: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }

    .toast-container {
        bottom: 10px;
        right: 10px;
        left: 10px;
        max-width: none;
    }

    .alert-custom,
    .toast-custom {
        margin: 0;
    }
}

@media (max-width: 576px) {
    .alert-custom {
        padding: 0.75rem;
        gap: 0.5rem;
    }

    .alert-title {
        font-size: 0.9rem;
    }

    .alert-message {
        font-size: 0.8rem;
    }

    .toast-custom {
        padding: 0.6rem 0.75rem;
    }

    .toast-message {
        font-size: 0.8rem;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .alert-custom,
    .toast-custom {
        border: 2px solid #000000;
    }

    .alert-close,
    .toast-close {
        background: #ffffff;
        border: 1px solid #000000;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .alert-custom,
    .toast-custom {
        background: #2d2d2d;
        color: #ffffff;
    }

    .alert-title {
        color: #ffffff;
    }

    .alert-message,
    .toast-message {
        color: #cccccc;
    }

    .alert-close,
    .toast-close {
        background: rgba(255, 255, 255, 0.1);
        color: #cccccc;
    }

    .alert-close:hover,
    .toast-close:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .alert-custom,
    .toast-custom {
        animation: none;
        transform: translateX(0);
        opacity: 1;
    }

    .alert-progress {
        animation: none;
    }
}

/* Print styles */
@media print {
    .alerts-container,
    .toast-container {
        display: none !important;
    }
}

/* Blur background when many alerts */
.alerts-container:has(.alert-custom:nth-child(3)) {
    backdrop-filter: blur(2px);
    background: rgba(0, 0, 0, 0.05);
    padding: 1rem;
    border-radius: 15px;
    margin: -1rem;
    margin-right: 0;
}

/* Stack limit indicator */
.alerts-container:has(.alert-custom:nth-child(4)) .alert-custom:nth-child(4) {
    opacity: 0.7;
    transform: scale(0.95);
}

.alerts-container:has(.alert-custom:nth-child(5)) .alert-custom:nth-child(n+5) {
    display: none;
}

.alerts-container:has(.alert-custom:nth-child(5))::after {
    content: '+' attr(data-more-count) ' thông báo khác';
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    text-align: center;
    margin-top: 0.5rem;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize alerts
    initializeAlerts();

    // Initialize global toast function
    window.showToast = showToast;
    window.showAlert = showAlert;
    window.dismissAlert = dismissAlert;
});

function initializeAlerts() {
    const alerts = document.querySelectorAll('.alert-custom');

    alerts.forEach((alert, index) => {
        // Stagger animation
        alert.style.animationDelay = `${index * 100}ms`;

        // Auto dismiss
        const autoDismiss = alert.getAttribute('data-auto-dismiss');
        if (autoDismiss) {
            const duration = parseInt(autoDismiss);

            // Start progress bar
            const progressBar = alert.querySelector('.alert-progress');
            if (progressBar) {
                progressBar.style.animationDuration = `${duration}ms`;
            }

            // Auto dismiss after delay
            setTimeout(() => {
                dismissAlert(alert);
            }, duration);
        }

        // Add swipe to dismiss on mobile
        if (window.innerWidth <= 768) {
            addSwipeToDismiss(alert);
        }
    });

    // Update more count
    updateMoreCount();
}

function dismissAlert(element) {
    // If element is the close button, get the parent alert
    const alert = element.classList?.contains('alert-custom') ? element : element.closest('.alert-custom');

    if (!alert) return;

    // Add exit animation
    alert.style.animation = 'slideOut 0.3s ease-in forwards';

    // Remove element after animation
    setTimeout(() => {
        alert.remove();
        updateMoreCount();
        reorganizeAlerts();
    }, 300);
}

function showAlert(message, type = 'info', title = null, duration = 5000) {
    const alertsContainer = document.getElementById('alertsContainer') || createAlertsContainer();

    const alertElement = document.createElement('div');
    alertElement.className = `alert-custom alert-${type}`;
    alertElement.setAttribute('role', 'alert');
    alertElement.setAttribute('data-auto-dismiss', duration);

    const icons = {
        success: 'bi-check-circle-fill',
        error: 'bi-exclamation-triangle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill'
    };

    const titles = {
        success: title || 'Thành công!',
        error: title || 'Có lỗi xảy ra!',
        warning: title || 'Cảnh báo!',
        info: title || 'Thông tin'
    };

    alertElement.innerHTML = `
        <div class="alert-icon">
            <i class="bi ${icons[type]}"></i>
        </div>
        <div class="alert-content">
            <div class="alert-title">${titles[type]}</div>
            <div class="alert-message">${message}</div>
        </div>
        <button type="button" class="alert-close" onclick="dismissAlert(this)">
            <i class="bi bi-x"></i>
        </button>
        <div class="alert-progress"></div>
    `;

    alertsContainer.appendChild(alertElement);

    // Initialize the new alert
    setTimeout(() => {
        const progressBar = alertElement.querySelector('.alert-progress');
        if (progressBar && duration > 0) {
            progressBar.style.animationDuration = `${duration}ms`;
        }

        if (duration > 0) {
            setTimeout(() => {
                dismissAlert(alertElement);
            }, duration);
        }

        if (window.innerWidth <= 768) {
            addSwipeToDismiss(alertElement);
        }
    }, 100);

    updateMoreCount();
}

function showToast(message, type = 'info', duration = 3000) {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();

    const toastElement = document.createElement('div');
    toastElement.className = `toast-custom toast-${type}`;

    const icons = {
        success: 'bi-check-circle-fill',
        error: 'bi-exclamation-triangle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill'
    };

    toastElement.innerHTML = `
        <div class="toast-icon">
            <i class="bi ${icons[type]}"></i>
        </div>
        <div class="toast-message">${message}</div>
        <button type="button" class="toast-close" onclick="dismissToast(this)">
            <i class="bi bi-x"></i>
        </button>
    `;

    toastContainer.appendChild(toastElement);

    // Auto dismiss
    if (duration > 0) {
        setTimeout(() => {
            dismissToast(toastElement);
        }, duration);
    }

    // Add swipe to dismiss on mobile
    if (window.innerWidth <= 768) {
        addSwipeToDismiss(toastElement, 'toast');
    }
}

function dismissToast(element) {
    const toast = element.classList?.contains('toast-custom') ? element : element.closest('.toast-custom');

    if (!toast) return;

    toast.style.animation = 'slideDown 0.3s ease-in forwards';

    setTimeout(() => {
        toast.remove();
    }, 300);
}

function createAlertsContainer() {
    const container = document.createElement('div');
    container.className = 'alerts-container';
    container.id = 'alertsContainer';
    document.body.appendChild(container);
    return container;
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    container.id = 'toastContainer';
    document.body.appendChild(container);
    return container;
}

function updateMoreCount() {
    const alertsContainer = document.getElementById('alertsContainer');
    if (!alertsContainer) return;

    const alerts = alertsContainer.querySelectorAll('.alert-custom');
    const visibleAlerts = Array.from(alerts).slice(0, 4);
    const hiddenCount = Math.max(0, alerts.length - 4);

    alertsContainer.setAttribute('data-more-count', hiddenCount);
}

function reorganizeAlerts() {
    const alertsContainer = document.getElementById('alertsContainer');
    if (!alertsContainer) return;

    const alerts = alertsContainer.querySelectorAll('.alert-custom');

    alerts.forEach((alert, index) => {
        if (index < 4) {
            alert.style.display = 'flex';
            alert.style.opacity = index === 3 ? '0.7' : '1';
            alert.style.transform = index === 3 ? 'scale(0.95)' : 'scale(1)';
        } else {
            alert.style.display = 'none';
        }
    });
}

function addSwipeToDismiss(element, type = 'alert') {
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    element.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });

    element.addEventListener('touchmove', (e) => {
        if (!isDragging) return;

        currentX = e.touches[0].clientX;
        const deltaX = currentX - startX;

        if (deltaX > 0) {
            element.style.transform = `translateX(${deltaX}px)`;
            element.style.opacity = Math.max(0.3, 1 - (deltaX / 200));
        }
    });

    element.addEventListener('touchend', () => {
        if (!isDragging) return;

        const deltaX = currentX - startX;

        if (deltaX > 100) {
            // Dismiss
            if (type === 'toast') {
                dismissToast(element);
            } else {
                dismissAlert(element);
            }
        } else {
            // Snap back
            element.style.transform = 'translateX(0)';
            element.style.opacity = '1';
        }

        isDragging = false;
        startX = 0;
        currentX = 0;
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape to dismiss all alerts
    if (e.key === 'Escape') {
        const alerts = document.querySelectorAll('.alert-custom, .toast-custom');
        alerts.forEach(alert => {
            if (alert.classList.contains('toast-custom')) {
                dismissToast(alert);
            } else {
                dismissAlert(alert);
            }
        });
    }
});

// Prevent too many alerts from overwhelming the user
let alertCount = 0;
const maxAlerts = 5;

const originalShowAlert = window.showAlert;
window.showAlert = function(...args) {
    if (alertCount >= maxAlerts) {
        console.warn('Too many alerts. Suppressing additional alerts.');
        return;
    }

    alertCount++;
    setTimeout(() => alertCount--, 5000); // Reset counter after 5 seconds

    return originalShowAlert?.apply(this, args);
};

// Auto-clear old alerts periodically
setInterval(() => {
    const container = document.getElementById('alertsContainer');
    if (container) {
        const alerts = container.querySelectorAll('.alert-custom');
        if (alerts.length > 10) {
            // Remove oldest alerts
            for (let i = 0; i < alerts.length - 10; i++) {
                dismissAlert(alerts[i]);
            }
        }
    }
}, 30000); // Every 30 seconds
</script>

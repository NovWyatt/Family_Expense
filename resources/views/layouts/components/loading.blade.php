{{-- Loading Spinner Component --}}
@php
    $size = $size ?? 'medium'; // small, medium, large
    $type = $type ?? 'spinner'; // spinner, dots, bars, pulse
    $message = $message ?? 'Đang tải...';
    $overlay = $overlay ?? false;
    $color = $color ?? 'primary'; // primary, secondary, success, warning, danger, info
@endphp

@if($overlay)
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-backdrop"></div>
        <div class="loading-content">
            @include('layouts.components.loading', ['overlay' => false, 'size' => 'large'])
        </div>
    </div>
@else
    <div class="loading-container loading-{{ $size }} loading-{{ $color }}" role="status" aria-label="{{ $message }}">
        @if($type === 'spinner')
            <div class="loading-spinner">
                <div class="spinner-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        @elseif($type === 'dots')
            <div class="loading-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        @elseif($type === 'bars')
            <div class="loading-bars">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        @elseif($type === 'pulse')
            <div class="loading-pulse">
                <div class="pulse-circle"></div>
            </div>
        @endif

        @if($message)
            <div class="loading-message">{{ $message }}</div>
        @endif
    </div>
@endif

<style>
/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loading-overlay.active {
    opacity: 1;
    visibility: visible;
}

.loading-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.loading-content {
    position: relative;
    z-index: 1;
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    text-align: center;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

/* Loading Container */
.loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 1rem;
}

.loading-container.loading-small {
    gap: 0.5rem;
    padding: 0.5rem;
}

.loading-container.loading-large {
    gap: 1.5rem;
    padding: 2rem;
}

/* Loading Message */
.loading-message {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
    text-align: center;
    animation: fadeInOut 2s ease-in-out infinite;
}

.loading-small .loading-message {
    font-size: 0.8rem;
}

.loading-large .loading-message {
    font-size: 1rem;
}

/* Spinner Type */
.loading-spinner {
    position: relative;
}

.spinner-ring {
    position: relative;
    width: 40px;
    height: 40px;
}

.loading-small .spinner-ring {
    width: 24px;
    height: 24px;
}

.loading-large .spinner-ring {
    width: 60px;
    height: 60px;
}

.spinner-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    border: 3px solid transparent;
    border-radius: 50%;
    animation: spinnerRotate 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
}

.loading-small .spinner-ring div {
    border-width: 2px;
}

.loading-large .spinner-ring div {
    border-width: 4px;
}

.spinner-ring div:nth-child(1) {
    animation-delay: -0.45s;
}

.spinner-ring div:nth-child(2) {
    animation-delay: -0.3s;
}

.spinner-ring div:nth-child(3) {
    animation-delay: -0.15s;
}

/* Dots Type */
.loading-dots {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: dotPulse 1.4s ease-in-out infinite both;
}

.loading-small .dot {
    width: 6px;
    height: 6px;
}

.loading-large .dot {
    width: 12px;
    height: 12px;
}

.dot:nth-child(1) {
    animation-delay: -0.32s;
}

.dot:nth-child(2) {
    animation-delay: -0.16s;
}

/* Bars Type */
.loading-bars {
    display: flex;
    gap: 0.25rem;
    align-items: end;
    height: 30px;
}

.loading-small .loading-bars {
    height: 20px;
}

.loading-large .loading-bars {
    height: 45px;
}

.bar {
    width: 4px;
    min-height: 4px;
    border-radius: 2px;
    animation: barScale 1s ease-in-out infinite;
}

.loading-small .bar {
    width: 3px;
}

.loading-large .bar {
    width: 6px;
}

.bar:nth-child(1) {
    animation-delay: -0.4s;
}

.bar:nth-child(2) {
    animation-delay: -0.3s;
}

.bar:nth-child(3) {
    animation-delay: -0.2s;
}

.bar:nth-child(4) {
    animation-delay: -0.1s;
}

/* Pulse Type */
.loading-pulse {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pulse-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    animation: pulseScale 2s ease-in-out infinite;
}

.loading-small .pulse-circle {
    width: 24px;
    height: 24px;
}

.loading-large .pulse-circle {
    width: 60px;
    height: 60px;
}

.pulse-circle::before,
.pulse-circle::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    animation: pulseRipple 2s ease-in-out infinite;
}

.pulse-circle::after {
    animation-delay: 1s;
}

/* Color Variants */
.loading-primary .spinner-ring div {
    border-top-color: #667eea;
    border-bottom-color: #667eea;
}

.loading-primary .dot {
    background: #667eea;
}

.loading-primary .bar {
    background: #667eea;
}

.loading-primary .pulse-circle {
    background: #667eea;
}

.loading-primary .pulse-circle::before,
.loading-primary .pulse-circle::after {
    border: 2px solid #667eea;
}

.loading-secondary .spinner-ring div {
    border-top-color: #6c757d;
    border-bottom-color: #6c757d;
}

.loading-secondary .dot {
    background: #6c757d;
}

.loading-secondary .bar {
    background: #6c757d;
}

.loading-secondary .pulse-circle {
    background: #6c757d;
}

.loading-secondary .pulse-circle::before,
.loading-secondary .pulse-circle::after {
    border: 2px solid #6c757d;
}

.loading-success .spinner-ring div {
    border-top-color: #28a745;
    border-bottom-color: #28a745;
}

.loading-success .dot {
    background: #28a745;
}

.loading-success .bar {
    background: #28a745;
}

.loading-success .pulse-circle {
    background: #28a745;
}

.loading-success .pulse-circle::before,
.loading-success .pulse-circle::after {
    border: 2px solid #28a745;
}

.loading-warning .spinner-ring div {
    border-top-color: #ffc107;
    border-bottom-color: #ffc107;
}

.loading-warning .dot {
    background: #ffc107;
}

.loading-warning .bar {
    background: #ffc107;
}

.loading-warning .pulse-circle {
    background: #ffc107;
}

.loading-warning .pulse-circle::before,
.loading-warning .pulse-circle::after {
    border: 2px solid #ffc107;
}

.loading-danger .spinner-ring div {
    border-top-color: #dc3545;
    border-bottom-color: #dc3545;
}

.loading-danger .dot {
    background: #dc3545;
}

.loading-danger .bar {
    background: #dc3545;
}

.loading-danger .pulse-circle {
    background: #dc3545;
}

.loading-danger .pulse-circle::before,
.loading-danger .pulse-circle::after {
    border: 2px solid #dc3545;
}

.loading-info .spinner-ring div {
    border-top-color: #17a2b8;
    border-bottom-color: #17a2b8;
}

.loading-info .dot {
    background: #17a2b8;
}

.loading-info .bar {
    background: #17a2b8;
}

.loading-info .pulse-circle {
    background: #17a2b8;
}

.loading-info .pulse-circle::before,
.loading-info .pulse-circle::after {
    border: 2px solid #17a2b8;
}

/* Animations */
@keyframes spinnerRotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

@keyframes dotPulse {
    0%, 80%, 100% {
        transform: scale(0);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes barScale {
    0%, 40%, 100% {
        transform: scaleY(0.4);
        opacity: 0.7;
    }
    20% {
        transform: scaleY(1);
        opacity: 1;
    }
}

@keyframes pulseScale {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.7;
    }
}

@keyframes pulseRipple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(2);
        opacity: 0;
    }
}

@keyframes fadeInOut {
    0%, 100% {
        opacity: 0.7;
    }
    50% {
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 576px) {
    .loading-content {
        padding: 1.5rem;
        margin: 1rem;
        border-radius: 15px;
    }

    .loading-message {
        font-size: 0.85rem;
    }
}

/* Dark Mode */
@media (prefers-color-scheme: dark) {
    .loading-backdrop {
        background: rgba(0, 0, 0, 0.8);
    }

    .loading-content {
        background: #2d2d2d;
        border-color: #404040;
    }

    .loading-message {
        color: #cccccc;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    .spinner-ring div,
    .dot,
    .bar,
    .pulse-circle,
    .pulse-circle::before,
    .pulse-circle::after,
    .loading-message {
        animation: none;
    }

    .loading-container {
        opacity: 0.8;
    }
}

/* High Contrast */
@media (prefers-contrast: high) {
    .loading-content {
        border: 3px solid #000000;
    }

    .spinner-ring div {
        border-top-color: #000000;
        border-bottom-color: #000000;
    }

    .dot,
    .bar,
    .pulse-circle {
        background: #000000;
    }
}

/* Print */
@media print {
    .loading-overlay,
    .loading-container {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize global loading functions
    window.showLoading = showLoading;
    window.hideLoading = hideLoading;
    window.showOverlay = showOverlay;
    window.hideOverlay = hideOverlay;
    window.createLoadingButton = createLoadingButton;
});

/**
 * Show loading overlay
 */
function showOverlay(message = 'Đang tải...', type = 'spinner') {
    // Remove existing overlay
    hideOverlay();

    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay active';
    overlay.id = 'loadingOverlay';

    overlay.innerHTML = `
        <div class="loading-backdrop"></div>
        <div class="loading-content">
            <div class="loading-container loading-large loading-primary">
                ${getLoadingHTML(type)}
                ${message ? `<div class="loading-message">${message}</div>` : ''}
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    // Prevent body scroll
    document.body.style.overflow = 'hidden';

    // Auto-hide after 30 seconds (safety)
    setTimeout(() => {
        hideOverlay();
    }, 30000);

    return overlay;
}

/**
 * Hide loading overlay
 */
function hideOverlay() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.classList.remove('active');
        setTimeout(() => {
            overlay.remove();
            document.body.style.overflow = '';
        }, 300);
    }
}

/**
 * Show loading state on button
 */
function showLoading(button, message = 'Đang xử lý...') {
    if (!button) return;

    // Store original content
    button.dataset.originalContent = button.innerHTML;
    button.disabled = true;

    // Add loading content
    button.innerHTML = `
        <div class="loading-container loading-small loading-primary">
            <div class="loading-spinner">
                <div class="spinner-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <span>${message}</span>
        </div>
    `;

    button.classList.add('loading-state');
}

/**
 * Hide loading state on button
 */
function hideLoading(button, customContent = null) {
    if (!button) return;

    const originalContent = customContent || button.dataset.originalContent;
    if (originalContent) {
        button.innerHTML = originalContent;
        delete button.dataset.originalContent;
    }

    button.disabled = false;
    button.classList.remove('loading-state');
}

/**
 * Create a loading button with built-in loading state
 */
function createLoadingButton(options = {}) {
    const {
        text = 'Submit',
        loadingText = 'Processing...',
        className = 'btn btn-primary',
        onClick = null,
        type = 'button'
    } = options;

    const button = document.createElement('button');
    button.type = type;
    button.className = className;
    button.innerHTML = text;

    // Add click handler
    if (onClick) {
        button.addEventListener('click', async function(e) {
            e.preventDefault();

            showLoading(this, loadingText);

            try {
                await onClick(e);
            } catch (error) {
                console.error('Button click error:', error);
            } finally {
                hideLoading(this);
            }
        });
    }

    return button;
}

/**
 * Get loading HTML based on type
 */
function getLoadingHTML(type = 'spinner') {
    switch (type) {
        case 'dots':
            return `
                <div class="loading-dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            `;
        case 'bars':
            return `
                <div class="loading-bars">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            `;
        case 'pulse':
            return `
                <div class="loading-pulse">
                    <div class="pulse-circle"></div>
                </div>
            `;
        default:
            return `
                <div class="loading-spinner">
                    <div class="spinner-ring">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            `;
    }
}

/**
 * Show inline loading for any element
 */
function showInlineLoading(element, type = 'spinner', message = '') {
    if (!element) return;

    // Store original content
    element.dataset.originalContent = element.innerHTML;

    // Create loading container
    const loadingContainer = document.createElement('div');
    loadingContainer.className = 'loading-container loading-small loading-primary';
    loadingContainer.innerHTML = getLoadingHTML(type) + (message ? `<div class="loading-message">${message}</div>` : '');

    // Replace content
    element.innerHTML = '';
    element.appendChild(loadingContainer);
    element.classList.add('loading-state');
}

/**
 * Hide inline loading
 */
function hideInlineLoading(element) {
    if (!element) return;

    const originalContent = element.dataset.originalContent;
    if (originalContent) {
        element.innerHTML = originalContent;
        delete element.dataset.originalContent;
    }

    element.classList.remove('loading-state');
}

/**
 * Create a promise that shows loading overlay
 */
function withLoadingOverlay(promise, message = 'Đang xử lý...', type = 'spinner') {
    showOverlay(message, type);

    return promise
        .then(result => {
            hideOverlay();
            return result;
        })
        .catch(error => {
            hideOverlay();
            throw error;
        });
}

/**
 * Debounced loading for search/input scenarios
 */
function debouncedLoading(element, callback, delay = 500) {
    let timeout;

    return function(...args) {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {
            showInlineLoading(element, 'dots', 'Đang tìm...');

            try {
                await callback.apply(this, args);
            } catch (error) {
                console.error('Debounced loading error:', error);
            } finally {
                hideInlineLoading(element);
            }
        }, delay);
    };
}

/**
 * Loading state for forms
 */
function handleFormLoading(form, options = {}) {
    if (!form) return;

    const {
        submitSelector = 'button[type="submit"], input[type="submit"]',
        loadingMessage = 'Đang xử lý...',
        disableFields = true
    } = options;

    form.addEventListener('submit', function() {
        // Show loading on submit button
        const submitBtn = form.querySelector(submitSelector);
        if (submitBtn) {
            showLoading(submitBtn, loadingMessage);
        }

        // Disable all form fields if requested
        if (disableFields) {
            const fields = form.querySelectorAll('input, select, textarea, button');
            fields.forEach(field => {
                if (field !== submitBtn) {
                    field.disabled = true;
                    field.classList.add('loading-disabled');
                }
            });
        }

        form.classList.add('form-loading');
    });
}

/**
 * Progress loading (for uploads, etc.)
 */
function createProgressLoading(element, initialProgress = 0) {
    if (!element) return null;

    const progressContainer = document.createElement('div');
    progressContainer.className = 'loading-progress-container';

    progressContainer.innerHTML = `
        <div class="loading-progress-bar">
            <div class="loading-progress-fill" style="width: ${initialProgress}%"></div>
        </div>
        <div class="loading-progress-text">${initialProgress}%</div>
    `;

    element.appendChild(progressContainer);

    return {
        update: (progress) => {
            const fill = progressContainer.querySelector('.loading-progress-fill');
            const text = progressContainer.querySelector('.loading-progress-text');

            if (fill) fill.style.width = `${progress}%`;
            if (text) text.textContent = `${progress}%`;
        },
        remove: () => {
            progressContainer.remove();
        }
    };
}

// Auto-handle form loading for common forms
document.addEventListener('DOMContentLoaded', function() {
    // Auto-handle forms with loading attribute
    document.querySelectorAll('form[data-loading]').forEach(form => {
        handleFormLoading(form, {
            loadingMessage: form.dataset.loadingMessage || 'Đang xử lý...',
            disableFields: form.dataset.disableFields !== 'false'
        });
    });

    // Auto-handle buttons with loading attribute
    document.querySelectorAll('button[data-loading], input[type="submit"][data-loading]').forEach(button => {
        const loadingMessage = button.dataset.loadingMessage || 'Đang xử lý...';

        button.addEventListener('click', function(e) {
            // Only show loading if it's not already in loading state
            if (!this.classList.contains('loading-state')) {
                showLoading(this, loadingMessage);

                // Auto-hide after 10 seconds (safety)
                setTimeout(() => {
                    hideLoading(this);
                }, 10000);
            }
        });
    });

    // Handle page navigation loading
    window.addEventListener('beforeunload', function() {
        showOverlay('Đang chuyển trang...', 'pulse');
    });

    // Hide loading when page loads
    window.addEventListener('load', function() {
        hideOverlay();
    });
});

// Expose functions globally
window.showInlineLoading = showInlineLoading;
window.hideInlineLoading = hideInlineLoading;
window.withLoadingOverlay = withLoadingOverlay;
window.debouncedLoading = debouncedLoading;
window.handleFormLoading = handleFormLoading;
window.createProgressLoading = createProgressLoading;

// Add CSS for additional loading states
const additionalCSS = `
.loading-state {
    pointer-events: none;
    position: relative;
}

.loading-disabled {
    opacity: 0.6;
}

.form-loading {
    pointer-events: none;
}

.loading-progress-container {
    margin: 1rem 0;
    text-align: center;
}

.loading-progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.loading-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 4px;
    transition: width 0.3s ease;
    position: relative;
    overflow: hidden;
}

.loading-progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: progressShine 2s ease-in-out infinite;
}

.loading-progress-text {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

@keyframes progressShine {
    0% { left: -100%; }
    100% { left: 100%; }
}
`;

// Inject additional CSS
const styleSheet = document.createElement('style');
styleSheet.textContent = additionalCSS;
document.head.appendChild(styleSheet);

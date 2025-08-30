@extends('layouts.auth')

@section('title', 'Đăng nhập')

@push('styles')
<style>
    /* Additional styles specific to login */
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        font-size: 1.1rem;
        padding: 0.25rem;
        cursor: pointer;
        transition: color 0.3s ease;
        z-index: 10;
    }

    .password-toggle:hover {
        color: #667eea;
    }

    .form-floating.password-field {
        position: relative;
    }

    .form-floating.password-field .form-control {
        padding-right: 3rem;
    }

    .remember-section {
        margin: 1.5rem 0;
        padding: 1rem;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 12px;
        border-left: 4px solid #667eea;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 4px;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-label {
        font-size: 0.9rem;
        color: #495057;
        margin: 0;
        cursor: pointer;
        user-select: none;
    }

    .security-info {
        background: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: #2d5a3d;
    }

    .security-info i {
        color: #28a745;
        margin-right: 0.5rem;
    }

    .demo-hint {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
        color: #856404;
    }

    .demo-hint .demo-password {
        background: rgba(255, 193, 7, 0.2);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        margin: 0 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .demo-hint .demo-password:hover {
        background: rgba(255, 193, 7, 0.3);
        transform: scale(1.05);
    }

    .form-control.error-shake {
        animation: shake 0.5s ease-in-out;
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15) !important;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    .login-attempts {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.5rem;
        text-align: center;
    }

    .caps-lock-warning {
        position: absolute;
        top: -35px;
        right: 0;
        background: #ffc107;
        color: #856404;
        padding: 0.25rem 0.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        opacity: 0;
        transform: translateY(5px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .caps-lock-warning.show {
        opacity: 1;
        transform: translateY(0);
    }

    .caps-lock-warning::after {
        content: '';
        position: absolute;
        bottom: -5px;
        right: 15px;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #ffc107;
    }

    @media (max-width: 576px) {
        .remember-section {
            margin: 1rem 0;
            padding: 0.75rem;
        }

        .demo-hint {
            margin-bottom: 1rem;
            padding: 0.75rem;
        }
    }

</style>
@endpush

@section('content')
<!-- Demo Hint -->
<div class="demo-hint">
    <i class="bi bi-info-circle-fill me-1"></i>
    <strong>Demo:</strong> Mật khẩu mặc định là
    <span class="demo-password" onclick="fillDemoPassword()">2771211</span>
</div>

<form method="POST" action="{{ route('auth.login') }}" class="auth-form needs-validation" id="loginForm" novalidate>
    @csrf

    <!-- Password Field -->
    <div class="form-floating password-field">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nhập mật khẩu..." autocomplete="current-password" required autofocus>
        <label for="password">
            <i class="bi bi-shield-lock me-2"></i>Mật khẩu
        </label>
        <button type="button" class="password-toggle" onclick="togglePassword()">
            <i class="bi bi-eye" id="toggleIcon"></i>
        </button>

        <!-- Caps Lock Warning -->
        <div class="caps-lock-warning" id="capsLockWarning">
            <i class="bi bi-exclamation-triangle"></i> Caps Lock đang bật!
        </div>

        @error('password')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <!-- Remember Session -->
    <div class="remember-section">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="rememberDevice" name="remember_device" {{ old('remember_device') ? 'checked' : '' }}>
            <label class="form-check-label" for="rememberDevice">
                <strong>Ghi nhớ thiết bị này</strong><br>
                <small class="text-muted">Không cần nhập lại trong 30 ngày</small>
            </label>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn-auth" id="loginBtn">
        <i class="bi bi-box-arrow-in-right me-2"></i>
        <span>Đăng nhập</span>
    </button>

    <!-- Login Attempts Counter -->
    <div class="login-attempts" id="loginAttempts"></div>
</form>

<!-- Security Information -->
<div class="security-info">
    <i class="bi bi-shield-check"></i>
    <strong>Bảo mật:</strong> Phiên đăng nhập tự động hết hạn sau 24 giờ để bảo vệ dữ liệu gia đình.
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const passwordInput = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');
        const capsLockWarning = document.getElementById('capsLockWarning');
        const loginAttempts = document.getElementById('loginAttempts');

        let attemptCount = parseInt(localStorage.getItem('loginAttempts') || '0');
        let lastAttemptTime = parseInt(localStorage.getItem('lastAttemptTime') || '0');

        // Reset attempts after 15 minutes
        if (Date.now() - lastAttemptTime > 900000) {
            attemptCount = 0;
            localStorage.removeItem('loginAttempts');
            localStorage.removeItem('lastAttemptTime');
        }

        // Show attempt counter if there are previous attempts
        updateAttemptsDisplay();

        // Form submission
        loginForm.addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                passwordInput.classList.add('error-shake');
                setTimeout(() => passwordInput.classList.remove('error-shake'), 500);
                return;
            }

            const originalContent = loginBtn.innerHTML;
            showLoading(loginBtn, 'Đang đăng nhập...');

            // Store attempt info
            attemptCount++;
            localStorage.setItem('loginAttempts', attemptCount.toString());
            localStorage.setItem('lastAttemptTime', Date.now().toString());

            // Form will submit normally, but if there's an error on page reload,
            // we'll show the attempt counter
            setTimeout(() => {
                hideLoading(loginBtn, originalContent);
            }, 30000); // Safety timeout
        });

        // Caps Lock detection
        passwordInput.addEventListener('keyup', function(e) {
            const capsLockOn = e.getModifierState && e.getModifierState('CapsLock');
            capsLockWarning.classList.toggle('show', capsLockOn);
        });

        // Hide caps lock warning when field loses focus
        passwordInput.addEventListener('blur', function() {
            capsLockWarning.classList.remove('show');
        });

        // Clear error state on typing
        passwordInput.addEventListener('input', function() {
            this.classList.remove('is-invalid', 'error-shake');
            const feedback = this.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.style.display = 'none';
            }
        });

        // Auto-clear attempts on successful interaction
        passwordInput.addEventListener('focus', function() {
            if (attemptCount > 0 && Date.now() - lastAttemptTime > 60000) {
                attemptCount = 0;
                localStorage.removeItem('loginAttempts');
                localStorage.removeItem('lastAttemptTime');
                updateAttemptsDisplay();
            }
        });

        function updateAttemptsDisplay() {
            if (attemptCount > 0) {
                const timeLeft = Math.ceil((900000 - (Date.now() - lastAttemptTime)) / 60000);
                loginAttempts.innerHTML = `
                <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                Đã thử ${attemptCount} lần. ${timeLeft > 0 ? `Reset sau ${timeLeft} phút.` : 'Có thể reset ngay.'}
            `;
            } else {
                loginAttempts.innerHTML = '';
            }
        }

        // Show success message if redirected from logout
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('logout') === 'success') {
            showToast('Đã đăng xuất thành công. Hãy đăng nhập lại.', 'success');
            // Clean up URL
            const newUrl = window.location.pathname;
            window.history.replaceState({}, '', newUrl);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                loginForm.querySelector('button[type="submit"]').click();
            }

            // Escape to clear form
            if (e.key === 'Escape') {
                passwordInput.value = '';
                passwordInput.focus();
            }
        });
    });

    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            toggleIcon.className = 'bi bi-eye';
        }

        // Maintain focus
        passwordInput.focus();
    }

    // Fill demo password
    function fillDemoPassword() {
        const passwordInput = document.getElementById('password');
        passwordInput.value = '2771211';
        passwordInput.focus();

        // Add visual feedback
        passwordInput.style.background = 'rgba(102, 126, 234, 0.1)';
        setTimeout(() => {
            passwordInput.style.background = '';
        }, 1000);

        showToast('Đã điền mật khẩu demo!', 'info');
    }

    // Toast notification function (if not already defined)
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} position-fixed`;
        toast.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 250px;
        animation: slideIn 0.3s ease-out;
    `;
        toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${type === 'success' ? 'bi-check-circle' : type === 'danger' ? 'bi-exclamation-triangle' : 'bi-info-circle'} me-2"></i>
            ${message}
        </div>
    `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Add slide animations
    const style = document.createElement('style');
    style.textContent = `
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100%); }
    }
`;
    document.head.appendChild(style);

</script>
@endpush

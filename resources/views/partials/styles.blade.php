{{-- Styles Partial - CSS Links and Framework --}}

{{-- Bootstrap 5 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

{{-- Font Awesome (Alternative icons) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">

{{-- Animate.css for animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

{{-- Custom Styles --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;

        /* Safe areas for mobile devices */
        --safe-area-top: env(safe-area-inset-top, 0px);
        --safe-area-bottom: env(safe-area-inset-bottom, 0px);
        --safe-area-left: env(safe-area-inset-left, 0px);
        --safe-area-right: env(safe-area-inset-right, 0px);

        /* Border radius */
        --border-radius-sm: 8px;
        --border-radius: 12px;
        --border-radius-lg: 16px;
        --border-radius-xl: 20px;

        /* Shadows */
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        --shadow-xl: 0 16px 40px rgba(0, 0, 0, 0.16);

        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition: 0.3s ease;
        --transition-slow: 0.5s ease;

        /* Z-index layers */
        --z-dropdown: 1000;
        --z-sticky: 1020;
        --z-fixed: 1030;
        --z-modal-backdrop: 1040;
        --z-modal: 1050;
        --z-popover: 1060;
        --z-tooltip: 1070;
        --z-toast: 9999;
    }

    /* Global Styles */
    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: var(--light-color);
        color: #2c3e50;
        line-height: 1.6;
        padding-top: var(--safe-area-top);
        padding-bottom: var(--safe-area-bottom);
        padding-left: var(--safe-area-left);
        padding-right: var(--safe-area-right);
    }

    /* Typography */
    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
    }

    h1 { font-size: 2.25rem; }
    h2 { font-size: 1.875rem; }
    h3 { font-size: 1.5rem; }
    h4 { font-size: 1.25rem; }
    h5 { font-size: 1.125rem; }
    h6 { font-size: 1rem; }

    p {
        margin-bottom: 1rem;
        color: #495057;
    }

    /* Links */
    a {
        color: #667eea;
        text-decoration: none;
        transition: color var(--transition-fast);
    }

    a:hover {
        color: #5a67d8;
        text-decoration: none;
    }

    /* Buttons */
    .btn {
        border-radius: var(--border-radius);
        font-weight: 600;
        padding: 0.625rem 1.25rem;
        transition: all var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn:focus {
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: #212529;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
        transition: all var(--transition);
        overflow: hidden;
        background: white;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-weight: 600;
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background: rgba(248, 249, 250, 0.5);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }

    /* Forms */
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        transition: all var(--transition);
        background: rgba(248, 249, 250, 0.5);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        background: white;
    }

    .form-floating > label {
        padding: 1rem;
        font-weight: 500;
    }

    /* Alerts */
    .alert {
        border: none;
        border-radius: var(--border-radius);
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left-color: #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left-color: #dc3545;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        color: #856404;
        border-left-color: #ffc107;
    }

    .alert-info {
        background: linear-gradient(135deg, #cce7ff, #b8daff);
        color: #0c5460;
        border-left-color: #17a2b8;
    }

    /* Modals */
    .modal-content {
        border: none;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-xl);
    }

    .modal-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
    }

    /* Dropdowns */
    .dropdown-menu {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        padding: 0.5rem 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        transition: all var(--transition-fast);
        border-radius: var(--border-radius-sm);
        margin: 0 0.5rem;
    }

    .dropdown-item:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        transform: translateX(4px);
    }

    /* Tables */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .table tbody tr {
        transition: all var(--transition-fast);
    }

    .table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(2px);
    }

    /* Progress bars */
    .progress {
        height: 8px;
        border-radius: var(--border-radius);
        background: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        background: var(--primary-gradient);
        transition: width 0.6s ease;
    }

    /* Badges */
    .badge {
        border-radius: var(--border-radius);
        font-weight: 600;
        padding: 0.375rem 0.75rem;
    }

    /* List groups */
    .list-group {
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all var(--transition-fast);
    }

    .list-group-item:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(4px);
    }

    /* Utility Classes */
    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 600;
    }

    .shadow-soft {
        box-shadow: var(--shadow) !important;
    }

    .shadow-strong {
        box-shadow: var(--shadow-lg) !important;
    }

    .border-radius-lg {
        border-radius: var(--border-radius-lg) !important;
    }

    .bg-gradient-primary {
        background: var(--primary-gradient) !important;
    }

    .bg-glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Animations */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideLeft {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideRight {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Animation utility classes */
    .animate-slide-up {
        animation: slideUp 0.6s ease-out;
    }

    .animate-slide-down {
        animation: slideDown 0.6s ease-out;
    }

    .animate-slide-left {
        animation: slideLeft 0.6s ease-out;
    }

    .animate-slide-right {
        animation: slideRight 0.6s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .container-xl, .container-lg, .container-md, .container-sm, .container {
            max-width: 100%;
            padding: 0 1rem;
        }
    }

    @media (max-width: 768px) {
        h1 { font-size: 1.875rem; }
        h2 { font-size: 1.5rem; }
        h3 { font-size: 1.25rem; }
        h4 { font-size: 1.125rem; }

        .card {
            margin-bottom: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
        }
    }

    @media (max-width: 576px) {
        body {
            font-size: 0.9rem;
        }

        .card-body {
            padding: 1rem;
        }

        .modal-content {
            margin: 0.5rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        body {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .card {
            background: #2d2d2d;
            color: #ffffff;
        }

        .card-header {
            background: linear-gradient(135deg, #404040, #2d2d2d);
        }

        .form-control {
            background: #404040;
            border-color: #495057;
            color: #ffffff;
        }

        .form-control:focus {
            background: #495057;
        }

        .table thead th {
            background: linear-gradient(135deg, #404040, #2d2d2d);
            color: #ffffff;
        }

        .dropdown-menu {
            background: rgba(45, 45, 45, 0.95);
        }

        .modal-content {
            background: #2d2d2d;
            color: #ffffff;
        }

        .modal-header {
            background: linear-gradient(135deg, #404040, #2d2d2d);
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* High contrast */
    @media (prefers-contrast: high) {
        .card, .modal-content, .dropdown-menu {
            border: 2px solid #000000;
        }

        .form-control {
            border: 2px solid #000000;
        }
    }

    /* Print styles */
    @media print {
        body {
            background: white;
            color: black;
        }

        .card {
            box-shadow: none;
            border: 1px solid #000000;
        }

        .btn, .modal, .dropdown-menu {
            display: none !important;
        }
    }
</style>

{{-- Page specific styles from stack --}}
@stack('styles')

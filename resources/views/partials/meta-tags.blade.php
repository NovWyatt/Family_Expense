{{-- SEO and Meta Tags Partial --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Basic Meta Tags --}}
<meta name="description" content="Ứng dụng quản lý quỹ gia đình - Theo dõi thu chi, quản lý tiền đi chợ một cách dễ dàng và hiệu quả. Phù hợp cho các gia đình Việt Nam.">
<meta name="keywords" content="quản lý chi tiêu, quỹ gia đình, đi chợ, thu chi, tài chính cá nhân, family app, expense tracker">
<meta name="author" content="Family Expense Manager">
<meta name="robots" content="index, follow">
<meta name="language" content="vi-VN">
<meta name="revisit-after" content="7 days">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $pageTitle ?? 'Quỹ Đi Chợ' }} - Family App">
<meta property="og:description" content="{{ $pageDescription ?? 'Ứng dụng quản lý quỹ gia đình - Theo dõi thu chi, quản lý tiền đi chợ một cách dễ dàng và hiệu quả.' }}">
<meta property="og:image" content="{{ asset('images/og-image.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Quỹ Đi Chợ - Family App">
<meta property="og:locale" content="vi_VN">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $pageTitle ?? 'Quỹ Đi Chợ' }} - Family App">
<meta name="twitter:description" content="{{ $pageDescription ?? 'Ứng dụng quản lý quỹ gia đình - Theo dõi thu chi, quản lý tiền đi chợ một cách dễ dàng và hiệu quả.' }}">
<meta name="twitter:image" content="{{ asset('images/twitter-card.png') }}">

{{-- PWA Meta Tags --}}
<meta name="application-name" content="Quỹ Đi Chợ">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Quỹ Đi Chợ">
<meta name="format-detection" content="telephone=no">
<meta name="mobile-web-app-capable" content="yes">
<meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
<meta name="msapplication-TileColor" content="#667eea">
<meta name="msapplication-tap-highlight" content="no">
<meta name="theme-color" content="#667eea">
<meta name="apple-touch-fullscreen" content="yes">

{{-- Additional Mobile Meta --}}
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<meta name="full-screen" content="yes">
<meta name="x5-fullscreen" content="true">
<meta name="browsermode" content="application">
<meta name="x5-page-mode" content="app">

{{-- Performance and Preload --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//fonts.googleapis.com">

{{-- Icons and Manifest --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">

{{-- Apple Touch Icons --}}
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('images/icons/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('images/icons/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/icons/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/icons/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('images/icons/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/icons/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/icons/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/icons/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icons/apple-icon-180x180.png') }}">

{{-- Favicon --}}
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icons/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/icons/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icons/favicon-16x16.png') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

{{-- Microsoft Tiles --}}
<meta name="msapplication-TileImage" content="{{ asset('images/icons/ms-icon-144x144.png') }}">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ url()->current() }}">

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "Quỹ Đi Chợ - Family App",
  "description": "Ứng dụng quản lý quỹ gia đình - Theo dõi thu chi, quản lý tiền đi chợ một cách dễ dàng và hiệu quả",
  "url": "{{ url('/') }}",
  "applicationCategory": "FinanceApplication",
  "operatingSystem": "Any",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "VND"
  },
  "creator": {
    "@type": "Organization",
    "name": "Family Expense Manager Team"
  }
}
</script>

{{-- PWA Manifest and Service Worker Setup --}}

{{-- Web App Manifest --}}
<script>
// Generate manifest.json dynamically
const manifestData = {
    "name": "Quỹ Đi Chợ - Family App",
    "short_name": "Quỹ Đi Chợ",
    "description": "Ứng dụng quản lý quỹ gia đình - Theo dõi thu chi, quản lý tiền đi chợ một cách dễ dàng và hiệu quả",
    "start_url": "{{ route('dashboard') }}",
    "display": "standalone",
    "background_color": "#667eea",
    "theme_color": "#667eea",
    "orientation": "portrait-primary",
    "scope": "{{ url('/') }}",
    "lang": "vi",
    "dir": "ltr",
    "categories": ["finance", "productivity", "lifestyle"],
    "shortcuts": [
        {
            "name": "Nạp Quỹ",
            "short_name": "Nạp Quỹ",
            "description": "Nạp tiền vào quỹ gia đình",
            "url": "{{ route('funds.index') }}?action=add",
            "icons": [
                {
                    "src": "/images/icons/shortcut-add-funds-96x96.png",
                    "sizes": "96x96",
                    "type": "image/png"
                }
            ]
        },
        {
            "name": "Đi Chợ",
            "short_name": "Đi Chợ",
            "description": "Thêm lần đi chợ mới",
            "url": "{{ route('shopping.create') }}",
            "icons": [
                {
                    "src": "/images/icons/shortcut-shopping-96x96.png",
                    "sizes": "96x96",
                    "type": "image/png"
                }
            ]
        },
        {
            "name": "Lịch Sử",
            "short_name": "Lịch Sử",
            "description": "Xem lịch sử giao dịch",
            "url": "{{ route('funds.history') }}",
            "icons": [
                {
                    "src": "/images/icons/shortcut-history-96x96.png",
                    "sizes": "96x96",
                    "type": "image/png"
                }
            ]
        },
        {
            "name": "Xuất Excel",
            "short_name": "Excel",
            "description": "Xuất báo cáo Excel",
            "url": "{{ route('export.index') }}",
            "icons": [
                {
                    "src": "/images/icons/shortcut-export-96x96.png",
                    "sizes": "96x96",
                    "type": "image/png"
                }
            ]
        }
    ],
    "icons": [
        {
            "src": "/images/icons/android-icon-36x36.png",
            "sizes": "36x36",
            "type": "image/png",
            "density": "0.75"
        },
        {
            "src": "/images/icons/android-icon-48x48.png",
            "sizes": "48x48",
            "type": "image/png",
            "density": "1.0"
        },
        {
            "src": "/images/icons/android-icon-72x72.png",
            "sizes": "72x72",
            "type": "image/png",
            "density": "1.5"
        },
        {
            "src": "/images/icons/android-icon-96x96.png",
            "sizes": "96x96",
            "type": "image/png",
            "density": "2.0"
        },
        {
            "src": "/images/icons/android-icon-144x144.png",
            "sizes": "144x144",
            "type": "image/png",
            "density": "3.0"
        },
        {
            "src": "/images/icons/android-icon-192x192.png",
            "sizes": "192x192",
            "type": "image/png",
            "density": "4.0",
            "purpose": "maskable any"
        },
        {
            "src": "/images/icons/android-icon-512x512.png",
            "sizes": "512x512",
            "type": "image/png",
            "purpose": "maskable any"
        }
    ],
    "screenshots": [
        {
            "src": "/images/screenshots/dashboard-mobile.png",
            "sizes": "390x844",
            "type": "image/png",
            "form_factor": "narrow",
            "label": "Dashboard chính"
        },
        {
            "src": "/images/screenshots/shopping-mobile.png",
            "sizes": "390x844",
            "type": "image/png",
            "form_factor": "narrow",
            "label": "Quản lý đi chợ"
        },
        {
            "src": "/images/screenshots/funds-mobile.png",
            "sizes": "390x844",
            "type": "image/png",
            "form_factor": "narrow",
            "label": "Quản lý quỹ"
        },
        {
            "src": "/images/screenshots/dashboard-desktop.png",
            "sizes": "1280x720",
            "type": "image/png",
            "form_factor": "wide",
            "label": "Dashboard desktop"
        }
    ],
    "related_applications": [],
    "prefer_related_applications": false,
    "protocol_handlers": [
        {
            "protocol": "web+quydicho",
            "url": "{{ url('/') }}?action=%s"
        }
    ],
    "edge_side_panel": {
        "preferred_width": 400
    },
    "launch_handler": {
        "client_mode": "navigate-existing"
    }
};

// Create and inject manifest link
const manifestBlob = new Blob([JSON.stringify(manifestData, null, 2)], {
    type: 'application/json'
});
const manifestURL = URL.createObjectURL(manifestBlob);

const manifestLink = document.createElement('link');
manifestLink.rel = 'manifest';
manifestLink.href = manifestURL;
document.head.appendChild(manifestLink);
</script>

{{-- Service Worker Registration --}}
<script>
// Service Worker for PWA functionality
const serviceWorkerCode = `
const CACHE_NAME = 'quy-di-cho-v1.0.0';
const OFFLINE_URL = '/offline.html';

// Files to cache for offline functionality
const CACHE_FILES = [
    '/',
    '/dashboard',
    '/funds',
    '/shopping',
    '/offline.html',
    '/css/app.css',
    '/js/app.js',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
];

// Install event - cache resources
self.addEventListener('install', (event) => {
    console.log('Service Worker installing...');

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('Caching app shell');
                return cache.addAll(CACHE_FILES.filter(url => !url.includes('http')));
            })
            .then(() => {
                console.log('Service Worker installed');
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('Service Worker install failed:', error);
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('Service Worker activating...');

    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames.map((cacheName) => {
                        if (cacheName !== CACHE_NAME) {
                            console.log('Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
            .then(() => {
                console.log('Service Worker activated');
                return self.clients.claim();
            })
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    const request = event.request;
    const url = new URL(request.url);

    // Handle navigation requests
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .catch(() => {
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }

    // Handle other requests
    event.respondWith(
        caches.match(request)
            .then((response) => {
                if (response) {
                    return response;
                }

                return fetch(request)
                    .then((response) => {
                        // Don't cache non-successful responses
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Cache successful responses
                        const responseToCache = response.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                cache.put(request, responseToCache);
                            });

                        return response;
                    })
                    .catch((error) => {
                        console.error('Fetch failed:', error);

                        // Return offline page for navigation requests
                        if (request.mode === 'navigate') {
                            return caches.match(OFFLINE_URL);
                        }

                        throw error;
                    });
            })
    );
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
    console.log('Background sync:', event.tag);

    if (event.tag === 'background-sync-funds') {
        event.waitUntil(syncFunds());
    }

    if (event.tag === 'background-sync-shopping') {
        event.waitUntil(syncShopping());
    }
});

// Push notifications
self.addEventListener('push', (event) => {
    console.log('Push notification received:', event);

    const options = {
        body: event.data ? event.data.text() : 'Bạn có thông báo mới từ Quỹ Đi Chợ',
        icon: '/images/icons/android-icon-192x192.png',
        badge: '/images/icons/badge-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'Xem chi tiết',
                icon: '/images/icons/checkmark.png'
            },
            {
                action: 'close',
                title: 'Đóng',
                icon: '/images/icons/xmark.png'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification('Quỹ Đi Chợ', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    console.log('Notification click received:', event);

    event.notification.close();

    if (event.action === 'explore') {
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Sync functions
async function syncFunds() {
    try {
        const pendingFunds = await getStoredData('pending-funds');
        if (pendingFunds && pendingFunds.length > 0) {
            for (const fund of pendingFunds) {
                await fetch('/api/funds/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': fund.csrf_token
                    },
                    body: JSON.stringify(fund.data)
                });
            }
            await clearStoredData('pending-funds');
        }
    } catch (error) {
        console.error('Sync funds failed:', error);
    }
}

async function syncShopping() {
    try {
        const pendingShopping = await getStoredData('pending-shopping');
        if (pendingShopping && pendingShopping.length > 0) {
            for (const shopping of pendingShopping) {
                await fetch('/api/shopping/trips', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': shopping.csrf_token
                    },
                    body: JSON.stringify(shopping.data)
                });
            }
            await clearStoredData('pending-shopping');
        }
    } catch (error) {
        console.error('Sync shopping failed:', error);
    }
}

// IndexedDB helpers
async function getStoredData(key) {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('QuyDiChoOfflineDB', 1);

        request.onerror = () => reject(request.error);
        request.onsuccess = () => {
            const db = request.result;
            const transaction = db.transaction(['offline_data'], 'readonly');
            const store = transaction.objectStore('offline_data');
            const getRequest = store.get(key);

            getRequest.onsuccess = () => resolve(getRequest.result?.data);
            getRequest.onerror = () => reject(getRequest.error);
        };

        request.onupgradeneeded = () => {
            const db = request.result;
            if (!db.objectStoreNames.contains('offline_data')) {
                db.createObjectStore('offline_data', { keyPath: 'key' });
            }
        };
    });
}

async function clearStoredData(key) {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('QuyDiChoOfflineDB', 1);

        request.onerror = () => reject(request.error);
        request.onsuccess = () => {
            const db = request.result;
            const transaction = db.transaction(['offline_data'], 'readwrite');
            const store = transaction.objectStore('offline_data');
            const deleteRequest = store.delete(key);

            deleteRequest.onsuccess = () => resolve();
            deleteRequest.onerror = () => reject(deleteRequest.error);
        };
    });
}
`;

// Register service worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', async () => {
        try {
            // Create service worker blob
            const swBlob = new Blob([serviceWorkerCode], { type: 'application/javascript' });
            const swUrl = URL.createObjectURL(swBlob);

            // Register service worker
            const registration = await navigator.serviceWorker.register(swUrl);
            console.log('Service Worker registered successfully:', registration.scope);

            // Check for updates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                if (newWorker) {
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New version available
                            if (window.showToast) {
                                window.showToast(
                                    'Có phiên bản mới! Nhấn để cập nhật.',
                                    'info',
                                    0
                                );
                            }
                        }
                    });
                }
            });

            // Listen for controller change (new SW took over)
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                window.location.reload();
            });

        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    });
}
</script>

{{-- Offline Support --}}
<script>
// Create offline page content
const offlineHTML = `
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không có kết nối - Quỹ Đi Chợ</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .offline-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem 2rem;
            max-width: 400px;
            width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .offline-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .offline-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .offline-message {
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        .retry-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .retry-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        .features {
            margin-top: 2rem;
            text-align: left;
        }
        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .feature-icon {
            width: 20px;
            margin-right: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <div class="offline-icon">📱</div>
        <h1 class="offline-title">Không có kết nối</h1>
        <p class="offline-message">
            Bạn đang ở chế độ offline. Một số tính năng có thể bị giới hạn.
        </p>
        <button class="retry-btn" onclick="window.location.reload()">
            Thử lại kết nối
        </button>

        <div class="features">
            <div class="feature">
                <span class="feature-icon">✓</span>
                Xem dữ liệu đã lưu
            </div>
            <div class="feature">
                <span class="feature-icon">✓</span>
                Lưu thao tác khi có mạng
            </div>
            <div class="feature">
                <span class="feature-icon">✓</span>
                Tự động đồng bộ
            </div>
        </div>
    </div>

    <script>
        // Auto retry connection
        setInterval(() => {
            if (navigator.onLine) {
                window.location.reload();
            }
        }, 30000);

        // Listen for online event
        window.addEventListener('online', () => {
            window.location.reload();
        });
    </script>
</body>
</html>
`;

// Store offline page in cache when online
if ('caches' in window) {
    caches.open('quy-di-cho-v1.0.0').then(cache => {
        const offlineResponse = new Response(offlineHTML, {
            headers: { 'Content-Type': 'text/html' }
        });
        cache.put('/offline.html', offlineResponse);
    });
}
</script>

{{-- Push Notifications Setup --}}
<script>
// Push notification support
async function initializePushNotifications() {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        console.warn('Push messaging is not supported');
        return;
    }

    try {
        const registration = await navigator.serviceWorker.ready;

        // Check if already subscribed
        let subscription = await registration.pushManager.getSubscription();

        if (!subscription) {
            // Create new subscription
            const vapidPublicKey = '{{ config("app.vapid_public_key", "") }}';
            if (vapidPublicKey) {
                subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(vapidPublicKey)
                });

                // Send subscription to server
                await fetch('/api/push/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.App.csrf
                    },
                    body: JSON.stringify(subscription)
                });

                console.log('Push subscription created');
            }
        }
    } catch (error) {
        console.error('Failed to initialize push notifications:', error);
    }
}

// Helper function for VAPID key conversion
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

// Initialize push notifications when ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePushNotifications);
} else {
    initializePushNotifications();
}
</script>

{{-- Network Status Detection --}}
<script>
// Network status monitoring
function initializeNetworkStatus() {
    const updateNetworkStatus = () => {
        if (navigator.onLine) {
            document.body.classList.remove('offline');
            document.body.classList.add('online');

            // Show reconnection message
            if (window.wasOffline) {
                if (window.showToast) {
                    window.showToast('Đã kết nối lại internet!', 'success');
                }
                window.wasOffline = false;

                // Trigger background sync if available
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.ready.then(registration => {
                        if (registration.sync) {
                            registration.sync.register('background-sync-funds');
                            registration.sync.register('background-sync-shopping');
                        }
                    });
                }
            }
        } else {
            document.body.classList.remove('online');
            document.body.classList.add('offline');

            if (window.showToast) {
                window.showToast('Mất kết nối internet. Chế độ offline được kích hoạt.', 'warning', 0);
            }
            window.wasOffline = true;
        }
    };

    // Initial check
    updateNetworkStatus();

    // Listen for network events
    window.addEventListener('online', updateNetworkStatus);
    window.addEventListener('offline', updateNetworkStatus);
}

// CSS for network status
const networkStatusCSS = `
<style>
.offline .btn:not(.btn-offline-allowed) {
    opacity: 0.6;
    pointer-events: none;
}

.offline .btn:not(.btn-offline-allowed)::after {
    content: ' (Offline)';
    font-size: 0.8em;
    opacity: 0.7;
}

.network-status {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 9999;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.network-status.online {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    opacity: 0;
    transform: translateY(-100%);
}

.network-status.offline {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    opacity: 1;
    transform: translateY(0);
}

.offline-indicator {
    position: relative;
}

.offline-indicator::before {
    content: '⚠️';
    position: absolute;
    top: -5px;
    right: -5px;
    font-size: 0.8rem;
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', networkStatusCSS);

// Add network status indicator
const networkStatusDiv = document.createElement('div');
networkStatusDiv.className = 'network-status';
networkStatusDiv.id = 'networkStatus';
document.body.appendChild(networkStatusDiv);

// Initialize network status monitoring
initializeNetworkStatus();
</script>

{{-- App Install Button --}}
<div id="pwa-install-banner" style="display: none;" class="position-fixed bottom-0 start-0 end-0 p-3 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <strong>Cài đặt App</strong><br>
                <small>Thêm Quỹ Đi Chợ vào màn hình chính để trải nghiệm tốt hơn</small>
            </div>
            <div class="col-auto">
                <button class="btn btn-light btn-sm me-2" id="pwa-install-btn">
                    <i class="bi bi-download"></i> Cài đặt
                </button>
                <button class="btn btn-outline-light btn-sm" id="pwa-dismiss-btn">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    </div>
</div>

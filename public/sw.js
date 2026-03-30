const CACHE_NAME = 'icodedev-v1';
const OFFLINE_URL = '/offline.html';
const PRECACHE_URLS = [
    '/',
    '/offline.html',
];

// Install: cache critical assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_URLS);
        })
    );
    self.skipWaiting();
});

// Activate: clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        })
    );
    self.clients.claim();
});

// Fetch: network-first with offline fallback
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    // Skip API/auth requests
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/api') ||
        url.pathname.startsWith('/login') ||
        url.pathname.startsWith('/register') ||
        url.pathname.startsWith('/admin') ||
        url.pathname.startsWith('/client') ||
        url.pathname.startsWith('/developer')) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Cache successful GET responses for static assets
                if (response.status === 200 &&
                    (url.pathname.startsWith('/build/') ||
                     url.pathname.match(/\.(css|js|png|jpg|jpeg|gif|svg|ico|woff2?)$/))) {
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return response;
            })
            .catch(() => {
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) return cachedResponse;
                    if (event.request.destination === 'document') {
                        return caches.match(OFFLINE_URL);
                    }
                });
            })
    );
});

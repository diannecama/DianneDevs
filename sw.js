// Simple Service Worker for Evacuation System
const CACHE_NAME = 'evacuation-system-v8';
const TILE_CACHE_NAME = 'map-tiles-v8';
const urlsToCache = [
    './',
    './index.php',
    './manifest.json',
    './data/shelters_offline.min.json',
    './js/evacuation-system.js',
    './app/apiCurrentLocation.php',
    './app/apiShelters.php'
    // Removed login.php and admin/index.php - session-based pages shouldn't be pre-cached
    // Removed saveCurrentLocation.php - it's a POST endpoint, not cacheable
];

// Install event - cache resources
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                // Cache files individually to prevent one failure from breaking all
                return Promise.allSettled(
                    urlsToCache.map(url => 
                        cache.add(url).catch(err => {
                            console.warn('Failed to cache:', url, err.message);
                            return null;
                        })
                    )
                );
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME && cacheName !== TILE_CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch event - serve from cache when offline
self.addEventListener('fetch', function(event) {
    const url = new URL(event.request.url);
    
    // Skip caching for POST requests (like saveCurrentLocation.php)
    if (event.request.method !== 'GET') {
        return event.respondWith(fetch(event.request));
    }
    
    // Check if this is a map tile request
    const isTileRequest = url.hostname.includes('tile.openstreetmap.org') ||
                         url.hostname.includes('basemaps.cartocdn.com') ||
                         url.hostname.includes('arcgisonline.com') ||
                         (url.pathname.match(/\/\d+\/\d+\/\d+\.(png|jpg|jpeg)/));
    
    if (isTileRequest) {
        // Cache-first strategy for map tiles
        event.respondWith(
            caches.open(TILE_CACHE_NAME).then(function(cache) {
                return cache.match(event.request).then(function(cachedResponse) {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    
                    // Not in cache, fetch from network
                    return fetch(event.request, {
                        mode: 'cors',
                        credentials: 'omit'
                    }).then(function(networkResponse) {
                        // Cache the tile for future offline use
                        if (networkResponse && networkResponse.status === 200) {
                            cache.put(event.request, networkResponse.clone());
                        }
                        return networkResponse;
                    }).catch(function(error) {
                        // Return a blank/placeholder tile when offline (no console logging)
                        return new Response(
                            '<svg width="256" height="256" xmlns="http://www.w3.org/2000/svg"><rect width="256" height="256" fill="#f0f0f0"/><text x="128" y="128" text-anchor="middle" font-family="Arial" font-size="14" fill="#999">Offline</text></svg>',
                            { headers: { 'Content-Type': 'image/svg+xml' } }
                        );
                    });
                });
            })
        );
    } else {
        // Regular cache strategy for non-tile requests
        event.respondWith(
            caches.match(event.request)
                .then(function(response) {
                    // Return cached version or fetch from network
                    if (response) {
                        return response;
                    }
                    
                    return fetch(event.request).catch(function(error) {
                        // Only log errors for non-tile requests
                        console.warn('Fetch failed for:', event.request.url);
                        
                        // Return a basic offline response for HTML pages
                        if (event.request.headers.get('accept').includes('text/html')) {
                            return new Response(
                                '<html><body><h1>Offline</h1><p>You are currently offline. Some features may be limited.</p></body></html>',
                                { headers: { 'Content-Type': 'text/html' } }
                            );
                        }
                        
                        // Return empty response for other requests
                        return new Response('', { status: 503, statusText: 'Service Unavailable' });
                    });
                })
        );
    }
});
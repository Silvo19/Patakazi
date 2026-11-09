// PataKazi service worker: makes the site installable and keeps the app shell available offline.
// Pages that contain private data are never cached - only static files.
const V = 'pk-v1';
const scope = self.registration.scope;
const ASSETS = ['assets/css/style.css', 'assets/js/app.js', 'assets/images/icon-192.png', 'offline.html'].map(a => new URL(a, scope).href);

self.addEventListener('install', e => { e.waitUntil(caches.open(V).then(c => c.addAll(ASSETS)).then(() => self.skipWaiting())); });
self.addEventListener('activate', e => {
  e.waitUntil(caches.keys().then(keys => Promise.all(keys.filter(k => k !== V).map(k => caches.delete(k)))).then(() => self.clients.claim()));
});
self.addEventListener('fetch', e => {
  const req = e.request;
  if (req.method !== 'GET') return;
  const url = new URL(req.url);
  if (url.origin !== location.origin) return;
  if (req.mode === 'navigate') {
    e.respondWith(fetch(req).catch(() => caches.match(new URL('offline.html', scope).href)));
    return;
  }
  if (url.pathname.includes('/assets/')) {
    e.respondWith(caches.match(req).then(hit => {
      const net = fetch(req).then(res => { const copy = res.clone(); caches.open(V).then(c => c.put(req, copy)); return res; }).catch(() => hit);
      return hit || net;
    }));
  }
});

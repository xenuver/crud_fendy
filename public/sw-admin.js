// Service Worker untuk Notifikasi Melayang Background Admin (Native Web Push)
self.addEventListener('push', function(event) {
    let data = {
        title: 'Pengingat Laporan Pending',
        body: 'Terdapat laporan mingguan kreator yang belum diverifikasi.',
        url: '/admin/laporan'
    };

    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data.body = event.data.text();
        }
    }

    const options = {
        body: data.body,
        icon: '/assets/img/bloodstrike_actual.jpg',
        badge: '/assets/img/bloodstrike_actual.jpg',
        vibrate: [100, 50, 100],
        data: {
            url: data.url || '/admin/laporan'
        },
        actions: [
            { action: 'open', title: 'Verifikasi Sekarang' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const targetUrl = (event.notification.data && event.notification.data.url) 
        ? event.notification.data.url 
        : '/admin/laporan';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if (client.url.includes('/admin/laporan') && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});

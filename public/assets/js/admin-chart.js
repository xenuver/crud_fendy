document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('kpiTrendChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    
    // Konfigurasi Gradien TikTok (Hitam-Abu)
    const ttGradient = ctx.createLinearGradient(0, 0, 0, 400);
    ttGradient.addColorStop(0, 'rgba(0, 0, 0, 0.4)');
    ttGradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

    // Konfigurasi Gradien YouTube (Merah)
    const ytGradient = ctx.createLinearGradient(0, 0, 0, 400);
    ytGradient.addColorStop(0, 'rgba(234, 25, 23, 0.3)');
    ytGradient.addColorStop(1, 'rgba(234, 25, 23, 0)');

    // Ambil data dari attributes canvas
    const labels = JSON.parse(canvas.getAttribute('data-labels') || '[]');
    const ytData = JSON.parse(canvas.getAttribute('data-yt') || '[]');
    const ttData = JSON.parse(canvas.getAttribute('data-tt') || '[]');
    const ccvData = JSON.parse(canvas.getAttribute('data-ccv') || '[]');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'TIKTOK VIEWS',
                    data: ttData,
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    borderWidth: 2,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'YOUTUBE VIEWS',
                    data: ytData,
                    borderColor: '#ea1917',
                    backgroundColor: 'rgba(234, 25, 23, 0.1)',
                    borderWidth: 2,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'PEAK CCV (MAX)',
                    data: ccvData,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.05)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
                    fill: false,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#94a3b8',
                        font: { family: "'Orbitron', sans-serif", size: 10 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: 'Orbitron', size: 13 },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    borderColor: '#ea1917',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: "'Orbitron', sans-serif", size: 9 },
                        callback: function(value) { return value.toLocaleString(); }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: {
                        color: '#ffc107',
                        font: { family: "'Orbitron', sans-serif", size: 9 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { family: "'Orbitron', sans-serif", size: 9 }
                    }
                }
            }
        }
    });
});

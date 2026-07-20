document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('kreatorChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    // Data dari attributes canvas (JSON.parse)
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
                    type: 'line',
                    label: 'Total Views YouTube',
                    data: ytData,
                    borderColor: '#ea1917',
                    backgroundColor: 'rgba(234, 25, 23, 0.1)',
                    borderWidth: 2,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Total Views TikTok',
                    data: ttData,
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    borderWidth: 2,
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Peak CCV (Live)',
                    data: ccvData,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#1e293b',
                    tension: 0,
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
                    labels: { color: '#cbd5e1', font: { family: 'Inter' } }
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
                x: {
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#94a3b8' }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: { color: '#94a3b8' }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: '#ffc107' }
                }
            }
        }
    });
});

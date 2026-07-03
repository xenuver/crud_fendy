<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sinyal Terputus | 404 Not Found</title>

    <!-- Font Kustom -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --bs-red: #ea1917;
            --bs-dark: #0f172a;
            --bs-accent-glow: rgba(234, 25, 23, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bs-dark);
            background-image: radial-gradient(circle at center, rgba(234, 25, 23, 0.05) 0%, transparent 70%);
            font-family: 'Inter', sans-serif;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .container {
            text-align: center;
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        /* Glitch Effect 404 */
        .error-code {
            font-family: 'Orbitron', sans-serif;
            font-size: 10rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            position: relative;
            text-shadow: 0 0 20px var(--bs-accent-glow);
            margin-bottom: 20px;
        }

        .error-code::before, .error-code::after {
            content: '404';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bs-dark);
        }

        .error-code::before {
            left: 2px;
            text-shadow: -2px 0 #ff00c1;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim 5s infinite linear alternate-reverse;
        }

        .error-code::after {
            left: -2px;
            text-shadow: -2px 0 #00fff9, 2px 2px #ff00c1;
            animation: glitch-anim2 1s infinite linear alternate-reverse;
        }

        /* Tactical HUD Card */
        .hud-msg {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 5px solid var(--bs-red);
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            clip-path: polygon(0 0, 95% 0, 100% 15%, 100% 100%, 5% 100%, 0 85%);
            animation: slideUp 0.8s ease-out;
        }

        .label-status {
            font-family: 'Orbitron', sans-serif;
            color: var(--bs-red);
            font-size: 0.7rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        p {
            color: #94a3b8;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        /* Tactical Button */
        .btn-hq {
            display: inline-block;
            background: var(--bs-red);
            color: #fff;
            text-decoration: none;
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 15px 35px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            clip-path: polygon(10% 0%, 100% 0%, 90% 100%, 0% 100%);
            transition: 0.3s;
            letter-spacing: 1px;
        }

        .btn-hq:hover {
            background: #fff;
            color: var(--bs-red);
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
            transform: scale(1.05);
        }

        /* Animations */
        @keyframes glitch-anim {
            0% { clip: rect(31px, 9999px, 94px, 0); }
            20% { clip: rect(62px, 9999px, 42px, 0); }
            40% { clip: rect(11px, 9999px, 78px, 0); }
            60% { clip: rect(87px, 9999px, 23px, 0); }
            80% { clip: rect(45px, 9999px, 56px, 0); }
            100% { clip: rect(10px, 9999px, 89px, 0); }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Scanline Overlay */
        .scanlines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03));
            background-size: 100% 4px, 3px 100%;
            pointer-events: none;
            z-index: 10;
        }

    </style>
</head>
<body>

    <div class="scanlines"></div>

    <div class="container">
        <div class="error-code">404</div>
        
        <div class="hud-msg shadow-lg">
            <span class="label-status"><i class="fas fa-satellite-dish me-2"></i> ERROR: SIGNAL_LOST</span>
            <h2>KOORDINAT TIDAK DITEMUKAN</h2>
            <p>
                Maaf Kreator, halaman yang Anda tuju tidak terdeteksi dalam radar MiminBS. Kemungkinan halaman telah dipindahkan atau tautan yang Anda gunakan tidak valid.
            </p>
            <a href="/" class="btn-hq">
                <i class="fas fa-home me-2"></i> KEMBALI KE HALAMAN
            </a>
        </div>

        <div class="mt-5 small orbitron text-secondary" style="font-size: 0.6rem; opacity: 0.4;">
            SISTEM DETEKSI INTRUSI AKTIF | KEAMANAN LEVEL 5
        </div>
    </div>

</body>
</html>

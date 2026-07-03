<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AKUN DITANGGUHKAN - BLOODSTRIKE CREATOR HUB</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/bloodstrike_actual.jpg') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #0f172a;
            color: #fff;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .container {
            text-align: center;
            padding: 40px;
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid #ea1917;
            max-width: 500px;
            box-shadow: 0 0 50px rgba(234, 25, 23, 0.2);
            clip-path: polygon(5% 0, 100% 0, 95% 100%, 0 100%);
        }
        .orbitron { font-family: 'Orbitron', sans-serif; }
        .icon-box {
            font-size: 80px;
            color: #ea1917;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 10px rgba(234, 25, 23, 0.5));
        }
        h1 { font-size: 1.5rem; letter-spacing: 2px; margin-bottom: 15px; text-transform: uppercase; }
        p { color: #94a3b8; line-height: 1.6; margin-bottom: 25px; }
        .btn-logout {
            display: inline-block;
            background: #ea1917;
            color: #fff;
            text-decoration: none;
            padding: 12px 30px;
            font-family: 'Orbitron', sans-serif;
            font-weight: bold;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
        }
        .btn-logout:hover {
            background: #fff;
            color: #ea1917;
            box-shadow: 0 0 20px rgba(234, 25, 23, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-box">
            <i class="fas fa-user-slash"></i>
        </div>
        <h1 class="orbitron">Akses Ditangguhkan</h1>
        <p>Maaf, akun kreator Anda saat ini sedang dalam status <b>SUSPENDED</b> oleh Admin. Anda tidak diizinkan untuk mengakses dashboard atau mengirim laporan mingguan.</p>
        <p>Jika ini adalah kesalahan atau Anda ingin mengajukan banding, silakan hubungi tim dukungan melalui grup komunitas.</p>
        <a href="<?= base_url('logout') ?>" class="btn-logout">KELUAR DARI SISTEM</a>
    </div>
</body>
</html>

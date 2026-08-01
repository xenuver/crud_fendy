# Panduan Deploy CodeIgniter 4 ke VPS via Coolify (Docker Compose)

Berikut adalah panduan lengkap untuk men-deploy project CodeIgniter 4 ini ke VPS Anda menggunakan Coolify dengan tipe **Docker Compose**. 

Project ini telah disiapkan dengan `Dockerfile`, `docker-compose.yml`, dan `.env` yang terkonfigurasi khusus untuk skenario ini, termasuk penanganan _storage link_ (symlink) dan auto-import database awal.

---

## 1. Persiapan Repositori (Git)

Pastikan semua file terbaru sudah di-commit dan di-push ke repositori Git Anda (GitHub, GitLab, atau Gitea).
File penting yang **wajib ada** di repositori:
- `Dockerfile`
- `docker-compose.yml`
- Folder `app/Database/` (memuat Migrations & Seeds)

> **Catatan:** File `.env` biasanya diabaikan oleh `.gitignore`. Kita akan memasukkan konfigurasi variabel environment langsung melalui Dashboard Coolify nantinya.

---

## 2. Setup di Coolify

1. Login ke Dashboard Coolify Anda.
2. Buat Project & Environment baru (atau gunakan yang sudah ada).
3. Klik **+ Add Resource** -> Pilih **Git Repository** (Public atau Private sesuai setting Anda).
4. Pilih repositori dan branch project CodeIgniter 4 ini.
5. Pada bagian **Build Pack**, pilih **Docker Compose**.
6. Klik **Save / Continue**.

---

## 3. Konfigurasi Environment Variables

Sebelum melakukan deploy, Anda perlu mengatur Environment Variables (Env) agar database dan aplikasi bisa saling terhubung.

1. Di halaman konfigurasi aplikasi Coolify, masuk ke tab **Environment Variables**.
2. Masukkan list variabel berikut (sesuaikan value-nya dengan VPS / Domain Anda):

```env
# Konfigurasi Database (Untuk Container MariaDB & CI4)
DB_DATABASE=nama_database
DB_USERNAME=username_db
DB_PASSWORD=password_db
DB_ROOT_PASSWORD=root_password_db

# Konfigurasi App CI4
CI_ENVIRONMENT=production
APP_BASEURL=https://domain-anda.com

# (Opsional) Notifikasi Web Push OneSignal (Pengingat Admin 19:00 WIB)
ONESIGNAL_APP_ID=masukkan_app_id_onesignal_disini
ONESIGNAL_REST_KEY=masukkan_rest_api_key_onesignal_disini
```

> **Catatan Penting**: Variabel `database.default.hostname` tidak perlu ditambahkan di Coolify karena sudah di-_hardcode_ menunjuk ke service `db` di dalam `docker-compose.yml`.

---

## 4. Cron Job Jam 19:00 WIB (Pengingat Laporan Admin)

Untuk menjalankan pengingat otomatis jam 19:00 WIB ke HP/Laptop Admin:
1. Masuk ke halaman Resource / Aplikasi Anda di **Coolify**.
2. Pilih tab **Scheduled Tasks** (atau Cron Jobs).
3. Tambahkan Cron Job baru:
   - **Name**: `Pengingat Admin Jam 19:00`
   - **Frequency (Cron Expression)**: `0 19 * * *`
   - **Command**: `php spark remind:admin`
4. Simpan. Sistem akan otomatis mengecek laporan pending setiap jam 19:00 WIB. Jika ada laporan pending > 0, notifikasi akan terkirim ke Admin. Jika 0, notifikasi dilewati (bebas spam).

---

## 4. Inisialisasi Database (Migrate & Seed)

Karena kita menggunakan metode Seeder bawaan CodeIgniter 4 (bukan file `.sql` mentah), kita perlu melakukan migrate & seed setelah aplikasi berhasil berjalan.

**Bagaimana ini bekerja?**
Seeder yang saya buatkan (`MainSeeder.php`) sudah dilengkapi dengan kondisi pintar: ia **hanya** akan memasukkan data ke tabel jika tabel tersebut masih kosong (jumlah data = 0). Jika data sudah ada, ia akan men-skip tabel tersebut agar tidak terjadi overwrite/duplikasi data.

**Cara Eksekusi (Setelah Deploy Selesai):**
1. Di Dashboard Coolify, masuk ke aplikasi/container Anda.
2. Buka tab **Terminal** (atau Execute Command).
3. Jalankan perintah berikut untuk membuat struktur tabel:
   ```bash
   php spark migrate
   ```
4. Jalankan perintah berikut untuk memasukkan data awal:
   ```bash
   php spark db:seed MainSeeder
   ```
   
> **Tips:** Anda juga bisa menjalankan ini berulang kali saat redeploy. Data lama akan tetap aman dan tidak terhapus.

---

## 5. Storage Link (Symlink) untuk Uploads

Pada Laravel terdapat fitur `php artisan storage:link`. Di CodeIgniter 4, kita harus melakukan symlink secara manual agar file yang diupload ke folder `writable/uploads` bisa diakses secara publik melalui URL (contoh: `domain.com/uploads/foto.jpg`).

Hal ini sudah **diselesaikan secara otomatis** di dalam `Dockerfile` pada baris berikut:
```dockerfile
# Create storage link (symlink) from writable/uploads to public/uploads
RUN ln -s /var/www/html/writable/uploads /var/www/html/public/uploads
```
Jadi, Anda bisa menyimpan file upload di CodeIgniter ke folder `writable/uploads`, dan file tersebut akan langsung bisa diakses lewat public directory! Folder `writable` ini juga sudah kita persist (simpan permanen) menggunakan volume di `docker-compose.yml` agar file upload tidak hilang saat re-deploy.

---

## 6. Deploy!

1. Pastikan port domain Anda di Coolify diarahkan ke **Port 80**.
2. Klik tombol **Deploy** pada Coolify.
3. Coolify akan:
   - Membangun (Build) image Docker berdasarkan `Dockerfile`.
   - Menginstal library via Composer.
   - Mengatur Symlink storage.
   - Menyalakan service `db` (MariaDB).
   - Menyalakan service `app` (CodeIgniter).
4. Tunggu hingga proses deploy berstatus **Healthy / Success**.
5. **PENTING**: Jangan lupa jalankan instruksi di **Langkah 4** (Migrate & Seed) lewat terminal Coolify!

Aplikasi Anda kini sudah mengudara dengan aman!

# Panduan Deploy CodeIgniter 4 ke VPS via Coolify (Docker Compose)

Berikut adalah panduan lengkap untuk men-deploy project CodeIgniter 4 ini ke VPS Anda menggunakan Coolify dengan tipe **Docker Compose**. 

Project ini telah disiapkan dengan `Dockerfile`, `docker-compose.yml`, dan `.env` yang terkonfigurasi khusus untuk skenario ini, termasuk penanganan _storage link_ (symlink) dan auto-import database awal.

---

## 1. Persiapan Repositori (Git)

Pastikan semua file terbaru sudah di-commit dan di-push ke repositori Git Anda (GitHub, GitLab, atau Gitea).
File penting yang **wajib ada** di repositori:
- `Dockerfile`
- `docker-compose.yml`
- `rw_ci4.sql` (File database awal)

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

# (Opsional) Jika menggunakan R2 / S3 Storage
R2_ACCESS_KEY_ID=masukkan_access_key_disini
R2_SECRET_ACCESS_KEY=masukkan_secret_access_key_disini
# ... tambahkan sisa config S3 lainnya jika perlu
```

> **Catatan Penting**: Variabel `database.default.hostname` tidak perlu ditambahkan di Coolify karena sudah di-_hardcode_ menunjuk ke service `db` di dalam `docker-compose.yml`.

---

## 4. Mekanisme Database Auto-Import & Skip Overwrite

Anda merequest agar database `rw_ci4.sql` diimport secara otomatis **HANYA JIKA** database masih kosong, dan di-skip jika sudah ada datanya agar tidak tertimpa. 

**Bagaimana ini bekerja?**
Di `docker-compose.yml`, kita memetakan file SQL ke folder inisialisasi MariaDB:
```yaml
volumes:
  - db_data:/var/lib/mysql
  - ./rw_ci4.sql:/docker-entrypoint-initdb.d/init.sql
```
Image resmi Docker untuk MySQL/MariaDB memiliki sistem pintar: ia **hanya** akan mengeksekusi script di folder `/docker-entrypoint-initdb.d/` apabila volume database (`/var/lib/mysql`) **masih kosong sama sekali** (yakni saat pertama kali container dibuat).

- **Deploy Pertama**: Database kosong -> Script `rw_ci4.sql` dieksekusi -> Data awal masuk.
- **Redeploy / Restart Berikutnya**: Volume `db_data` sudah terisi -> Script **diabaikan** (skip) -> Data Anda aman dan tidak ter-overwrite.

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
   - Menyalakan service `db` (MariaDB) dan mengeksekusi `rw_ci4.sql` karena DB masih kosong.
   - Menyalakan service `app` (CodeIgniter).
4. Tunggu hingga proses deploy berstatus **Healthy / Success**.

Aplikasi Anda kini sudah mengudara dengan aman!

# FZN NEWS — Portal Berita & Media Digital (ENT Project)

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

## 📌 Deskripsi Project

**FZN NEWS (ENT Project)** adalah aplikasi web portal berita dan media digital modern yang dirancang responsif, dinamis, dan intuitif. Aplikasi ini dibangun untuk menyajikan berita terkini (*Breaking News*), berita populer (*Trending News*), serta navigasi kategori yang lengkap bagi pembaca.

Selain halaman publik untuk pembaca, aplikasi ini dilengkapi dengan **Dashboard Admin & Content Management System (CMS)** yang memungkinkan redaksi/admin mengelola artikel berita, mengunggah gambar sampul, memantau statistik pembaca, serta mengatur pemetaan tata letak artikel utama (*Hero Layout Slot Mapping* FOTO 1 - FOTO 8).

### 🚀 Fitur Utama

- **Public Landing Page**:
  - **Breaking News Ticker**: Menampilkan berita terbaru & mendesak yang berjalan secara dinamis.
  - **Dynamic Hero Grid (FOTO 1 - FOTO 8)**: Layout grid visual interaktif untuk 8 artikel unggulan terbaru.
  - **Filter Kategori**: Pembaca dapat memfilter berita berdasarkan kategori (National, Ekonomi, Tekno, Olahraga, Hiburan, Gaya Hidup).
  - **Berita Lainnya (Pagination)**: Penayangan berita lanjutan dengan tata letak responsif (*Tall Card* & *Grid Cards*).
  - **Detail Artikel & Views Counter**: Halaman baca artikel lengkap dengan pelacakan jumlah pembaca (*views count*) dan daftar artikel terkait (*related news*).

- **Admin & Management Panel (`/admin`)**:
  - **Analytics & Dashboard Overview**: Ringkasan jumlah artikel harian, bulanan, tahunan, serta grafik statistik distribusi kategori.
  - **Post Berita Baru**: Formulir pembuatan artikel berita dengan opsi upload gambar/sampul, tag breaking news, dan penetapan kategori.
  - **Kelola & Edit Berita**: Manajemen tabel artikel berita (Draft/Published/Archived), fitur pencarian, penyuntingan isi/gambar, dan penghapusan artikel.
  - **Layout Slot Mapping**: Pengaturan posisi penayangan berita utama pada 8 slot hero (FOTO_1 s.d. FOTO_8) secara manual maupun otomatis.

### 🛠️ Teknologi & Environment

- **Backend Framework**: Laravel `^12.0`
- **Bahasa Pemrograman**: PHP `^8.2`
- **Frontend Assets**: Blade Templating Engine, Tailwind CSS `^4.0`, Vite `^7.0`, Axios
- **Database**: MySQL (Database Name: `fzn_news`)

---

## 🛠️ Tahapan Instalasi

Ikuti langkah-langkah berikut untuk memasang project di lingkungan lokal (*local development environment*):

### 1. Prasyarat Sistem
Pastikan perangkat Anda sudah terinstal software berikut:
- **PHP** `>= 8.2` (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`)
- **MySQL Database Server** (XAMPP / Laragon / MySQL Service)
- **Composer** `>= 2.x`
- **Node.js** `>= 18.x` dan **NPM**
- **Git** (opsional)

### 2. Clone / Unduh Repository
```bash
git clone <repository-url>
cd ENT-PROJECT
```

### 3. Salin Berkas Konfigurasi Lingkungan (`.env`)
Buat salinan berkas `.env` dari `.env.example`:
```bash
# Di Windows (PowerShell / Command Prompt)
copy .env.example .env

# Di Linux / macOS
cp .env.example .env
```

### 4. Install Dependency Backend (Composer)
Jalankan paket dependensi PHP melalui Composer:
```bash
composer install
```

### 5. Install Dependency Frontend (NPM)
Jalankan instalasi paket Node.js/Vite & Tailwind CSS:
```bash
npm install
```

### 6. Generate Application Key
Buat kunci enkripsi aplikasi Laravel:
```bash
php artisan key:generate
```

### 7. Pengaturan Database MySQL & Migrasi

1. **Buat Database MySQL**:
   Buat database baru dengan nama `fzn_news` di MySQL Server Anda (melalui phpMyAdmin, Laragon, DBeaver, atau MySQL CLI):
   ```sql
   CREATE DATABASE fzn_news;
   ```

2. **Konfigurasi File `.env`**:
   Pastikan pengaturan database pada berkas `.env` sudah sesuai:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fzn_news
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Jalankan Migrasi & Database Seeder**:
   Jalankan perintah berikut untuk membuat struktur tabel dan mengisikan data awal (Kategori, User Admin, & Hero Slots):
   ```bash
   php artisan migrate --seed
   ```

### 8. Buat Storage Symbolic Link
Buat link simbolik folder `storage` ke `public` agar berkas gambar berita yang diunggah dapat diakses publik:
```bash
php artisan storage:link
```

---

## 🟢 Tahapan Menjalankan

Anda dapat menjalankan aplikasi menggunakan salah satu dari 2 opsi di bawah ini:

### Opsi 1: Menjalankan Sekaligus (`composer run dev`) — *Direkomendasikan*
Perintah ini akan menjalankan server Laravel, listener antrean, pail log, dan Vite dev server secara bersamaan menggunakan `concurrently`:
```bash
composer run dev
```

### Opsi 2: Menjalankan Secara Terpisah
Jika ingin menjalankan service secara manual di terminal terpisah:

1. **Jalankan Backend Server**:
   ```bash
   php artisan serve
   ```
   *Server backend akan berjalan di `http://127.0.0.1:8000`*

2. **Jalankan Vite Frontend Compiler** *(buka terminal baru)*:
   ```bash
   npm run dev
   ```

---

## 🌐 Akses Aplikasi & Kredensial Default

Setelah server berhasil dijalankan, buka browser dan akses URL berikut:

- **Halaman Utama (Public Portal)**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Login Admin**: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)
- **Panel Admin**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin) (Membutuhkan akses otentikasi/login)

### 🔑 Akun Admin Default (Database Seeder)
Gunakan kredensial berikut pada halaman Login untuk mengakses Dashboard:
- **Email**: `admin@fznnews.com`
- **Password**: `password`
- **Role**: `superadmin`

---

## 📄 Lisensi
Project ini berada di bawah lisensi Open Source [MIT License](https://opensource.org/licenses/MIT).

# ENT
# ENT

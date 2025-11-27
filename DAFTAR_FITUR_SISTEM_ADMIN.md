# DAFTAR FITUR SISTEM ADMIN DENTATIME
## List Deskriptif Fitur dari Dashboard hingga Laporan

---

## 1. DASHBOARD ADMIN

### Deskripsi
Halaman utama sistem admin yang menampilkan overview dan ringkasan data penting untuk monitoring aktivitas klinik gigi.

### Fitur-Fitur:
- **Overview Statistik**: Menampilkan ringkasan data penting seperti total pasien, total dokter, total janji temu, dan statistik lainnya
- **Quick Access**: Akses cepat ke modul-modul utama sistem
- **Recent Activity**: Menampilkan aktivitas terbaru dalam sistem
- **Visual Dashboard**: Tampilan dashboard dengan grafik atau chart untuk visualisasi data

---

## 2. MANAJEMEN PASIEN

### Deskripsi
Modul untuk mengelola data pasien secara lengkap, mulai dari pendaftaran pasien baru hingga menghapus data pasien yang sudah tidak aktif.

### Fitur-Fitur:

#### **2.1. Tambah Pasien Baru**
- Form pendaftaran pasien dengan validasi lengkap
- Input data user: NIK (16 digit, unique), Nama Lengkap, Email (unique), Password (min 8 karakter), Jenis Kelamin (L/P), Tanggal Lahir, Nomor Telepon, Alamat
- Input data medis pasien: Alergi, Golongan Darah (A/B/AB/O), Riwayat Penyakit
- Upload foto profil (opsional, format: jpeg/png/jpg/gif, max 2MB)
- Sistem menggunakan database transaction untuk memastikan konsistensi data
- Auto-generate UUID untuk ID pasien
- Password di-hash menggunakan Laravel Hash untuk keamanan

#### **2.2. Daftar Pasien**
- Menampilkan semua pasien terdaftar dengan pagination (15 data per halaman)
- **Fitur Pencarian (Search)**:
  - Pencarian berdasarkan nama lengkap pasien
  - Pencarian berdasarkan email pasien
  - Pencarian berdasarkan NIK pasien
- **Fitur Filter**:
  - Filter berdasarkan jenis kelamin (Laki-laki/Perempuan)
- **Fitur Sorting**:
  - Sort berdasarkan nama lengkap (A-Z / Z-A)
  - Sort berdasarkan email (A-Z / Z-A)
  - Sort berdasarkan NIK (Ascending/Descending)
  - Sort berdasarkan tanggal daftar (Terbaru/Terlama)
- **Statistik Dashboard**:
  - Total jumlah pasien terdaftar
  - Jumlah pasien laki-laki
  - Jumlah pasien perempuan
- Tampilan tabel dengan informasi: Nama, Email, NIK, Jenis Kelamin, Nomor Telepon, Tanggal Daftar
- Tombol aksi: Lihat Detail, Edit, Hapus

#### **2.3. Detail Pasien**
- Menampilkan informasi lengkap pasien:
  - **Data User**: NIK, Nama Lengkap, Email, Nomor Telepon, Alamat, Jenis Kelamin, Tanggal Lahir, Foto Profil
  - **Data Medis**: Alergi, Golongan Darah, Riwayat Penyakit
- **Daftar Janji Temu Pasien**: Menampilkan semua janji temu yang pernah dibuat oleh pasien
- **Statistik Pasien**:
  - Total janji temu pasien
  - Jumlah janji temu bulan ini
- Tombol aksi: Edit Data, Kembali ke Daftar

#### **2.4. Edit Data Pasien**
- Form edit dengan data yang sudah terisi
- Update data user (nama, email, NIK, alamat, telepon, dll)
- Update data medis pasien (alergi, golongan darah, riwayat penyakit)
- Update foto profil (dengan hapus foto lama otomatis)
- Update password (opsional, hanya jika diisi)
- Validasi data menggunakan Form Request
- Database transaction untuk konsistensi

#### **2.5. Hapus Pasien**
- Validasi sebelum hapus: cek apakah pasien memiliki janji temu aktif (status pending/confirmed)
- Jika ada janji temu aktif, tampilkan error dan tidak bisa dihapus
- Jika valid, hapus pasien dengan cascade delete ke:
  - Semua janji temu pasien
  - Semua rekam medis terkait
  - Semua resep obat terkait
- Hapus foto profil dari storage jika ada
- Hapus user jika tidak digunakan di tabel lain
- Database transaction untuk keamanan data

---

## 3. MANAJEMEN DOKTER

### Deskripsi
Modul untuk mengelola data dokter dan jadwal praktek mereka. Admin dapat menambah dokter baru, mengedit data dokter, mengatur jadwal praktek, dan menghapus dokter yang sudah tidak aktif.

### Fitur-Fitur:

#### **3.1. Tambah Dokter Baru**
- Form pendaftaran dokter dengan validasi lengkap
- **Input Data User**: NIK, Nama Lengkap, Email (unique), Password, Jenis Kelamin, Tanggal Lahir, Nomor Telepon, Alamat, Foto Profil
- **Input Data Profesional Dokter**:
  - Nomor STR (Surat Tanda Registrasi) - unique, wajib diisi
  - Pendidikan (contoh: S1 Kedokteran Gigi)
  - Pengalaman (dalam tahun)
  - Spesialisasi Gigi (contoh: Ortodonti, Endodonti, dll)
  - Status Ketersediaan (Tersedia/Tidak Tersedia)
- Upload foto profil (opsional)
- Auto-generate UUID untuk ID dokter
- Database transaction untuk konsistensi data

#### **3.2. Daftar Dokter**
- Menampilkan semua dokter terdaftar dengan pagination (15 data per halaman)
- **Fitur Pencarian (Search)**:
  - Pencarian berdasarkan nama dokter
  - Pencarian berdasarkan email dokter
  - Pencarian berdasarkan NIK dokter
- **Fitur Filter**:
  - Filter berdasarkan status ketersediaan (Tersedia/Tidak Tersedia)
  - Filter berdasarkan spesialisasi gigi
- **Fitur Sorting**:
  - Sort berdasarkan nomor STR
  - Sort berdasarkan spesialisasi
  - Sort berdasarkan pengalaman (tahun)
  - Sort berdasarkan status
  - Sort berdasarkan nama
  - Sort berdasarkan email
- **Statistik Dashboard**:
  - Total jumlah dokter terdaftar
  - Jumlah dokter tersedia
  - Jumlah dokter tidak tersedia
- Tampilan tabel dengan informasi: Nama, Email, Spesialisasi, No. STR, Status, Pengalaman
- Tombol aksi: Lihat Detail, Kelola Jadwal, Edit, Hapus

#### **3.3. Detail Dokter**
- Menampilkan informasi lengkap dokter:
  - **Data User**: NIK, Nama Lengkap, Email, Nomor Telepon, Alamat, Jenis Kelamin, Tanggal Lahir, Foto Profil
  - **Data Profesional**: No. STR, Pendidikan, Pengalaman, Spesialisasi, Status
- **Daftar Jadwal Praktek**: Menampilkan semua jadwal praktek dokter
- **Daftar Janji Temu**: Menampilkan semua janji temu yang ditangani dokter
- **Statistik Dokter**:
  - Total janji temu yang ditangani
  - Jumlah janji temu bulan ini
- Tombol aksi: Edit Data, Kelola Jadwal, Kembali ke Daftar

#### **3.4. Edit Data Dokter**
- Form edit dengan data yang sudah terisi
- Update data user dan data profesional dokter
- Update foto profil (dengan hapus foto lama otomatis)
- Update password (opsional)
- Validasi data menggunakan Form Request
- Database transaction untuk konsistensi

#### **3.5. Hapus Dokter**
- Validasi sebelum hapus: cek apakah dokter memiliki janji temu aktif
- Jika ada janji temu aktif, tampilkan error dan tidak bisa dihapus
- Jika valid, hapus dokter dengan cascade delete ke:
  - Semua jadwal praktek dokter
  - Semua janji temu dokter
  - Semua rekam medis terkait
  - Semua resep obat terkait
- Hapus foto profil dari storage jika ada
- Hapus user jika tidak digunakan
- Database transaction untuk keamanan data

---

## 4. JADWAL PRAKTEK DOKTER

### Deskripsi
Sub-modul dari Manajemen Dokter untuk mengatur jadwal ketersediaan dokter praktek. Admin dapat menambah, mengedit, dan menghapus jadwal praktek dokter dengan validasi konflik waktu.

### Fitur-Fitur:

#### **4.1. Tambah Jadwal Praktek**
- Form input jadwal praktek baru
- **Input Data**:
  - Tanggal praktek (harus hari ini atau setelahnya, tidak boleh tanggal kemarin)
  - Jam mulai (format: HH:mm)
  - Jam selesai (format: HH:mm, harus setelah jam mulai)
  - Status (Available/Booked)
- **Validasi Konflik Waktu**:
  - Cek duplikasi: tidak boleh ada jadwal dengan tanggal dan jam yang sama
  - Cek overlap waktu: tidak boleh ada jadwal yang bertabrakan dengan jadwal lain pada tanggal yang sama
  - Sistem mengecek 3 kondisi overlap:
    1. Jam mulai baru berada di antara jam mulai-selesai jadwal yang ada
    2. Jam selesai baru berada di antara jam mulai-selesai jadwal yang ada
    3. Jadwal baru sepenuhnya berada di dalam jadwal yang ada
- Jika valid, simpan jadwal dengan UUID
- Redirect dengan pesan sukses

#### **4.2. Daftar Jadwal Praktek**
- Menampilkan semua jadwal praktek dokter tertentu
- Diurutkan berdasarkan tanggal dan jam mulai (ascending - dari yang terdekat)
- Menampilkan informasi: Tanggal, Jam Mulai, Jam Selesai, Status (Available/Booked)
- Tombol aksi: Edit, Hapus
- Filter berdasarkan status (opsional)

#### **4.3. Edit Jadwal Praktek**
- Form edit dengan data jadwal yang sudah terisi
- Validasi sama seperti tambah jadwal
- Cek konflik dengan jadwal lain (kecuali jadwal yang sedang diedit)
- Update jadwal jika valid
- Redirect dengan pesan sukses

#### **4.4. Hapus Jadwal Praktek**
- Konfirmasi hapus jadwal
- Hapus jadwal langsung (tidak ada validasi khusus)
- Redirect dengan pesan sukses

---

## 5. JANJI TEMU

### Deskripsi
Modul untuk memantau dan mengelola semua janji temu yang dibuat oleh pasien. Admin dapat melihat detail janji temu, mengubah status janji temu, dan memantau alur dari pending hingga completed.

### Fitur-Fitur:

#### **5.1. Daftar Janji Temu**
- Menampilkan semua janji temu dengan pagination (15 data per halaman)
- **Fitur Pencarian (Search)**:
  - Pencarian berdasarkan nama pasien
  - Pencarian berdasarkan nama dokter
- **Fitur Filter**:
  - Filter berdasarkan status:
    - Pending (Menunggu konfirmasi)
    - Confirmed (Sudah dikonfirmasi)
    - Completed (Selesai)
    - Canceled (Dibatalkan)
  - Filter berdasarkan tanggal tertentu
  - Filter berdasarkan bulan tertentu
- **Fitur Sorting**:
  - Sort berdasarkan field apapun (default: created_at desc - terbaru dulu)
  - Sort berdasarkan tanggal janji
  - Sort berdasarkan status
  - Sort berdasarkan nama pasien/dokter
- **Statistik Dashboard**:
  - Total janji temu pending
  - Total janji temu confirmed
  - Total janji temu completed
  - Total janji temu canceled
- Tampilan tabel dengan informasi: Pasien, Dokter, Tanggal, Jam, Keluhan, Status
- Tombol aksi: Lihat Detail, Ubah Status

#### **5.2. Detail Janji Temu**
- Menampilkan informasi lengkap janji temu:
  - **Data Pasien**: Nama Lengkap, Email, Nomor Telepon
  - **Data Dokter**: Nama Lengkap, Spesialisasi
  - **Data Janji Temu**:
    - Tanggal janji temu
    - Jam mulai dan jam selesai
    - Keluhan pasien (text)
    - Foto gigi (jika ada, ditampilkan dengan preview)
    - Status janji temu (dengan badge warna)
  - **Rekam Medis Terkait**: 
    - Jika sudah ada rekam medis, tampilkan link ke detail rekam medis
    - Jika belum ada, tampilkan informasi "Belum ada rekam medis"
- Tombol aksi: Ubah Status, Kembali ke Daftar

#### **5.3. Ubah Status Janji Temu**
- Form untuk mengubah status janji temu
- **Status yang Dapat Dipilih**:
  - Pending → Menunggu konfirmasi dari admin/dokter
  - Confirmed → Janji temu sudah dikonfirmasi
  - Completed → Janji temu sudah selesai (otomatis setelah dokter membuat rekam medis)
  - Canceled → Janji temu dibatalkan
- Validasi: status harus salah satu dari enum values
- Update status dan simpan
- Redirect ke detail janji temu dengan pesan sukses
- Flash message untuk notifikasi

### Alur Janji Temu:
1. Pasien membuat janji temu → Status: "pending"
2. Admin melihat daftar janji temu di halaman "Janji Temu"
3. Admin dapat:
   - Melihat detail janji temu
   - Mengubah status menjadi "confirmed" (mengkonfirmasi)
   - Mengubah status menjadi "canceled" (membatalkan)
4. Setelah janji temu selesai (dokter membuat rekam medis):
   - Status otomatis menjadi "completed"
5. Admin dapat melihat rekam medis terkait di halaman "Rekam Medis"

---

## 6. REKAM MEDIS

### Deskripsi
Modul untuk melihat dan mengelola rekam medis yang dibuat oleh dokter setelah pemeriksaan. Admin dapat melihat detail rekam medis lengkap dan mengexport ke PDF untuk keperluan dokumentasi.

### Fitur-Fitur:

#### **6.1. Daftar Rekam Medis**
- Menampilkan semua rekam medis dengan pagination (15 data per halaman)
- **Fitur Pencarian (Search)**:
  - Pencarian berdasarkan nama pasien
  - Pencarian berdasarkan nama dokter
  - Pencarian berdasarkan diagnosa
  - Pencarian berdasarkan tindakan
  - Pencarian berdasarkan NIK pasien
- **Fitur Filter**:
  - Filter berdasarkan rentang tanggal (dari tanggal - sampai tanggal)
- **Fitur Sorting**:
  - Sort berdasarkan tanggal janji temu
  - Sort berdasarkan created_at (tanggal dibuat rekam medis)
- **Statistik Dashboard**:
  - Total rekam medis
  - Total biaya dari semua rekam medis
  - Jumlah rekam medis bulan ini
- Tampilan tabel dengan informasi: Pasien, Dokter, Tanggal, Diagnosa, Tindakan, Biaya
- Tombol aksi: Lihat Detail, Export PDF

#### **6.2. Detail Rekam Medis**
- Menampilkan informasi lengkap rekam medis:
  - **Data Pasien**: Nama Lengkap, Email, Nomor Telepon, NIK
  - **Data Dokter**: Nama Lengkap, Spesialisasi, No. STR
  - **Data Janji Temu**: Tanggal janji temu, Jam, Keluhan
  - **Data Rekam Medis**:
    - Diagnosa (text lengkap)
    - Tindakan yang dilakukan (text lengkap)
    - Catatan tambahan (jika ada)
    - Biaya pengobatan (format rupiah)
    - Tanggal dibuat rekam medis
  - **Resep Obat** (jika ada):
    - Daftar resep obat yang diberikan
    - Informasi: Nama Obat, Jumlah, Dosis, Aturan Pakai
    - Jika aturan pakai/dosis kosong, sistem mengambil dari master_obat
- Tombol aksi: Export PDF, Kembali ke Daftar

#### **6.3. Export Rekam Medis ke PDF**
- Generate PDF menggunakan library DomPDF
- Format kertas: A4 Portrait
- Template PDF dengan styling profesional:
  - Header dengan logo/nama klinik
  - Informasi pasien dan dokter
  - Detail rekam medis lengkap
  - Daftar resep obat (jika ada)
  - Footer dengan tanggal dan tanda tangan
- Nama file PDF: `Rekam_Medis_{ID}.pdf`
- Download file PDF langsung ke browser
- PDF dapat dicetak atau disimpan untuk dokumentasi

---

## 7. RESEP OBAT

### Deskripsi
Modul untuk melihat semua resep obat yang diberikan oleh dokter kepada pasien. Admin hanya dapat melihat resep obat (read-only), tidak dapat membuat atau mengedit karena resep dibuat oleh dokter saat membuat rekam medis.

### Fitur-Fitur:

#### **7.1. Daftar Resep Obat**
- Menampilkan semua resep obat dengan pagination (15 data per halaman)
- **Fitur Pencarian (Search)**:
  - Pencarian berdasarkan nama obat
  - Pencarian berdasarkan nama pasien
  - Pencarian berdasarkan nama dokter
- **Fitur Filter**:
  - Filter berdasarkan rentang tanggal resep (dari tanggal - sampai tanggal)
  - Filter berdasarkan dokter tertentu (dropdown pilih dokter)
- **Fitur Sorting**:
  - Sort berdasarkan tanggal resep (default: desc - terbaru dulu)
  - Sort berdasarkan nama obat
  - Sort berdasarkan nama pasien
- **Statistik Dashboard**:
  - Total resep obat
  - Total obat unik (jumlah jenis obat berbeda)
  - Jumlah resep obat bulan ini
- Tampilan tabel dengan informasi: Pasien, Dokter, Tanggal Resep, Nama Obat, Jumlah, Dosis, Aturan Pakai
- Tombol aksi: Lihat Detail

#### **7.2. Detail Resep Obat**
- Menampilkan informasi lengkap resep obat:
  - **Data Pasien**: Nama Lengkap, Email, Nomor Telepon
  - **Data Dokter**: Nama Lengkap, Spesialisasi, No. STR
  - **Data Resep Obat**:
    - Tanggal resep
    - Nama obat
    - Jumlah obat
    - Dosis (contoh: 500 mg)
    - Aturan pakai (contoh: 3x1 sehari setelah makan)
  - **Rekam Medis Terkait**: 
    - Link ke detail rekam medis yang terkait dengan resep ini
    - Informasi diagnosa dan tindakan
- Tombol aksi: Kembali ke Daftar

### Catatan:
- Admin hanya dapat **melihat** resep obat
- Resep obat dibuat oleh dokter saat membuat rekam medis
- Resep obat terhubung dengan rekam medis (one-to-many)
- Jika aturan pakai/dosis kosong, sistem mengambil dari master_obat sebagai referensi

---

## 8. LAPORAN (EXPORT EXCEL & PDF)

### Deskripsi
Modul untuk membuat dan mengexport berbagai jenis laporan dalam format View (web), PDF, atau Excel. Laporan digunakan untuk keperluan dokumentasi, analisis data, dan pelaporan manajemen.

### Fitur-Fitur:

#### **8.1. Laporan Jumlah Pasien Terdaftar**

**Deskripsi**: Laporan yang menampilkan data lengkap semua pasien yang terdaftar di sistem beserta statistiknya.

**Data yang Ditampilkan**:
- **Statistik**:
  - Total jumlah pasien terdaftar
  - Jumlah pasien laki-laki
  - Jumlah pasien perempuan
- **Daftar Pasien**: 
  - No. Urut
  - Nama Lengkap
  - Email
  - Nomor Telepon
  - Jenis Kelamin
  - Tanggal Daftar

**Format Export**:
- **View (Web)**: Tampilan laporan di browser dengan styling Tailwind CSS
- **PDF**: Export ke PDF menggunakan DomPDF, format A4 Portrait
- **Excel**: Export ke Excel (.xlsx) menggunakan Maatwebsite Excel dengan:
  - Header laporan di baris 1-3
  - Statistik di baris 5-8
  - Tabel data mulai baris 10
  - Styling profesional: border, warna header, alignment

**Route**: `GET /admin/laporan/pasien?format={view|pdf|excel}`

#### **8.2. Laporan Jadwal Kunjungan**

**Deskripsi**: Laporan yang menampilkan data janji temu/kunjungan pasien pada tanggal tertentu.

**Data yang Ditampilkan**:
- **Parameter**: Tanggal kunjungan (wajib dipilih)
- **Statistik**:
  - Total kunjungan pada tanggal tersebut
  - Jumlah kunjungan per status:
    - Pending
    - Confirmed
    - Completed
    - Canceled
- **Daftar Janji Temu**:
  - No. Urut
  - Nama Pasien
  - Nama Dokter
  - Jam Janji
  - Status
  - Keluhan

**Format Export**:
- **View (Web)**: Tampilan laporan dengan filter tanggal
- **PDF**: Export ke PDF, format A4 Portrait
- **Excel**: Export ke Excel dengan styling profesional

**Route**: `GET /admin/laporan/jadwal-kunjungan?format={view|pdf|excel}&tanggal={YYYY-MM-DD}`

#### **8.3. Laporan Daftar Dokter Aktif**

**Deskripsi**: Laporan yang menampilkan data semua dokter yang aktif (status: tersedia) beserta statistik performa mereka.

**Data yang Ditampilkan**:
- **Statistik**:
  - Total dokter aktif
- **Daftar Dokter**:
  - No. Urut
  - Nama Lengkap
  - Email
  - Spesialisasi
  - Status
  - No. STR
- **Statistik Per Dokter**:
  - Total janji temu yang ditangani
  - Jumlah janji temu bulan ini

**Format Export**:
- **View (Web)**: Tampilan laporan dengan statistik lengkap
- **PDF**: Export ke PDF, format A4 Portrait
- **Excel**: Export ke Excel dengan styling profesional

**Route**: `GET /admin/laporan/dokter-aktif?format={view|pdf|excel}`

### Fitur Umum Export:

#### **Export PDF**:
- Menggunakan library **barryvdh/laravel-dompdf** (v3.1)
- Format kertas: A4 Portrait
- Template dengan styling inline CSS
- Header dengan logo/nama klinik
- Footer dengan tanggal laporan
- Download langsung ke browser

#### **Export Excel**:
- Menggunakan library **maatwebsite/excel** (v3.1) dengan PhpSpreadsheet
- Format file: .xlsx (Excel 2007+)
- Fitur styling:
  - Custom header laporan
  - Statistik di baris terpisah
  - Border pada semua cell
  - Warna header sesuai tema (#005248 - hijau tua)
  - Alignment text (center/left)
  - Column width otomatis
- Nama file dinamis berdasarkan tanggal (contoh: `laporan-pasien-2025-01-15.xlsx`)

---

## 9. PROFILE ADMIN & LOGOUT

### Deskripsi
Modul untuk mengelola profil admin yang sedang login dan fitur logout untuk keluar dari sistem dengan keamanan yang baik.

### Fitur-Fitur:

#### **9.1. Edit Profile Admin**

**Deskripsi**: Admin dapat mengubah data profil mereka sendiri.

**Data yang Dapat Diubah**:
- Nama Lengkap (required)
- Email (required, unique)
- NIK (opsional)
- Alamat (opsional)
- Nomor Telepon (opsional)
- Tanggal Lahir (opsional)
- Jenis Kelamin (opsional)
- Foto Profil (opsional, image max 2MB)

**Proses Update**:
1. Validasi data input menggunakan Laravel validation
2. Update data user di database
3. Jika ada upload foto profil baru:
   - Hapus foto profil lama dari storage (jika ada)
   - Simpan foto baru ke `storage/app/public/foto_profil`
4. Redirect kembali dengan pesan sukses
5. Flash message untuk notifikasi

**Validasi**:
- Nama lengkap: required, string, max 255 karakter
- Email: required, email format, unique (kecuali email sendiri)
- Alamat: nullable, string
- Nomor telepon: nullable, string, max 15 karakter
- Tanggal lahir: nullable, format date
- Jenis kelamin: nullable, string
- Foto profil: nullable, image (jpeg/png/jpg/gif), max 2048 KB

**Route**: 
- `GET /profile` → Form edit profile
- `PATCH /profile` → Update profile

#### **9.2. Logout**

**Deskripsi**: Fitur untuk keluar dari sistem dengan keamanan yang baik.

**Proses Logout**:
1. Admin klik tombol "Logout" di sidebar
2. Form POST ke route `/logout` dengan CSRF token
3. Laravel Breeze handle proses logout:
   - Invalidate session user
   - Regenerate CSRF token untuk keamanan
   - Clear semua data session
4. Redirect ke halaman login

**Keamanan**:
- Menggunakan CSRF token untuk mencegah CSRF attack
- Session di-invalidate setelah logout
- Token di-regenerate untuk keamanan
- Tidak ada data yang tersisa di session setelah logout

**Lokasi Menu**:
- Profile: Link di bagian bawah sidebar (di atas tombol logout)
- Logout: Tombol di bagian paling bawah sidebar

**Styling**:
- Profile link: Hover effect dengan background semi-transparent
- Logout button: Hover effect dengan background merah semi-transparent
- Icon SVG untuk visual yang menarik

---

## RINGKASAN TOTAL FITUR

### Modul Utama: 9 Modul
1. Dashboard Admin
2. Manajemen Pasien (5 fitur: Create, Read, Update, Delete, Detail)
3. Manajemen Dokter (5 fitur: Create, Read, Update, Delete, Detail)
4. Jadwal Praktek Dokter (4 fitur: Create, Read, Update, Delete)
5. Janji Temu (3 fitur: Daftar, Detail, Update Status)
6. Rekam Medis (3 fitur: Daftar, Detail, Export PDF)
7. Resep Obat (2 fitur: Daftar, Detail - Read Only)
8. Laporan (3 jenis laporan × 3 format = 9 kombinasi export)
9. Profile & Logout (2 fitur: Edit Profile, Logout)

### Total Fitur: 30+ Fitur Utama

### Teknologi yang Digunakan:
- **Backend**: Laravel 12.0, PHP 8.2+
- **Frontend**: Tailwind CSS 3.1.0, Alpine.js 3.4.2, Vite 7.0.7
- **Database**: MySQL/MariaDB dengan UUID sebagai primary key
- **Export**: DomPDF (PDF), Maatwebsite Excel (Excel)
- **Authentication**: Laravel Breeze

---

**Dokumen ini dibuat untuk dokumentasi lengkap fitur Sistem Admin DentaTime.**


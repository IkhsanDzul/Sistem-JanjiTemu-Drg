# PENJELASAN SISTEM ADMIN - DENTATIME
## Dokumentasi Lengkap untuk Presentasi

---

## 1. TEKNOLOGI YANG DIGUNAKAN

### Framework Backend
- **Laravel Framework**: Versi **12.0** (Laravel 12)
- **PHP**: Versi **8.2** atau lebih tinggi
- **Database**: MySQL/MariaDB (menggunakan Eloquent ORM)

### Frontend Framework & Tools
- **Tailwind CSS**: Versi **3.1.0** - Utility-first CSS framework untuk styling
- **Alpine.js**: Versi **3.4.2** - JavaScript framework ringan untuk interaktivitas
- **Vite**: Versi **7.0.7** - Build tool modern untuk development
- **PostCSS**: Versi **8.4.31** - CSS processor
- **Autoprefixer**: Versi **10.4.2** - Menambahkan vendor prefixes otomatis

### Plugins & Packages
1. **barryvdh/laravel-dompdf** (v3.1)
   - Untuk export laporan ke format PDF
   - Menggunakan DomPDF engine

2. **maatwebsite/excel** (v3.1)
   - Untuk export laporan ke format Excel
   - Menggunakan PhpSpreadsheet library

3. **laravel/breeze** (v2.3)
   - Authentication scaffolding
   - Sistem login/logout

4. **@tailwindcss/forms** (v0.5.2)
   - Plugin Tailwind untuk styling form

5. **@tailwindcss/vite** (v4.0.0)
   - Plugin Vite untuk integrasi Tailwind CSS

---

## 2. DATABASE SCHEMA SISTEM ADMIN

### Struktur Database (Relasi dari Awal hingga Akhir)

#### **Tabel `roles`** (Tabel Master)
- `id` (string, primary key) - ID role (admin, dokter, pasien)
- `nama_role` (string) - Nama role

#### **Tabel `users`** (Tabel Utama)
- `id` (UUID, primary key)
- `role_id` (string, foreign key → `roles.id`)
- `nik` (string, unique, nullable) - Nomor Induk Kependudukan
- `nama_lengkap` (string, 100)
- `email` (string, unique)
- `password` (string, hashed)
- `foto_profil` (string, nullable) - Path foto profil
- `alamat` (text, nullable)
- `jenis_kelamin` (enum: 'L', 'P', nullable)
- `tanggal_lahir` (date, nullable)
- `nomor_telp` (string, 20, nullable)
- `created_at`, `updated_at` (timestamps)

**Relasi**: Satu user memiliki satu role (admin, dokter, atau pasien)

#### **Tabel `admin`** (Tabel Admin)
- `id` (UUID, primary key)
- `user_id` (string, foreign key → `users.id`)

**Relasi**: Satu admin memiliki satu user

#### **Tabel `pasien`** (Tabel Pasien)
- `id` (UUID, primary key)
- `user_id` (string, foreign key → `users.id`)
- `alergi` (string, nullable)
- `golongan_darah` (string, 5, not null)
- `riwayat_penyakit` (string, 100, not null)

**Relasi**: Satu pasien memiliki satu user

#### **Tabel `dokter`** (Tabel Dokter)
- `id` (UUID, primary key)
- `user_id` (string, foreign key → `users.id`)
- `no_str` (string, 50, unique) - Nomor STR (Surat Tanda Registrasi)
- `pendidikan` (string, not null)
- `pengalaman_tahun` (string, 100, not null)
- `spesialisasi_gigi` (string, 100, not null)
- `status` (enum: 'tersedia', 'tidak tersedia', not null)

**Relasi**: Satu dokter memiliki satu user

#### **Tabel `jadwal_praktek`** (Jadwal Praktek Dokter)
- `id` (UUID, primary key)
- `dokter_id` (string, foreign key → `dokter.id`, cascade delete)
- `tanggal` (date, not null)
- `jam_mulai` (time, not null)
- `jam_selesai` (time, not null)
- `status` (enum: 'available', 'booked', not null)

**Relasi**: Satu dokter memiliki banyak jadwal praktek

#### **Tabel `janji_temu`** (Janji Temu)
- `id` (UUID, primary key)
- `pasien_id` (string, foreign key → `pasien.id`, cascade delete)
- `dokter_id` (string, foreign key → `dokter.id`, cascade delete)
- `tanggal` (date, not null)
- `jam_mulai` (time, not null)
- `jam_selesai` (time, nullable)
- `foto_gigi` (string, nullable) - Path foto keluhan gigi
- `keluhan` (string, not null)
- `status` (enum: 'pending', 'confirmed', 'completed', 'canceled', not null)
- `created_at`, `updated_at` (timestamps)

**Relasi**: 
- Satu pasien memiliki banyak janji temu
- Satu dokter memiliki banyak janji temu
- Satu janji temu memiliki satu pasien dan satu dokter

#### **Tabel `rekam_medis`** (Rekam Medis)
- `id` (UUID, primary key)
- `janji_temu_id` (string, foreign key → `janji_temu.id`, cascade delete)
- `diagnosa` (text, not null)
- `tindakan` (text, not null)
- `catatan` (text, nullable)
- `biaya` (float, not null)
- `created_at`, `updated_at` (timestamps)

**Relasi**: Satu janji temu memiliki satu rekam medis

#### **Tabel `master_obat`** (Master Data Obat)
- `id` (UUID, primary key)
- `nama_obat` (string, unique)
- `satuan` (string, default: 'mg')
- `dosis_default` (integer, nullable)
- `aturan_pakai_default` (text, nullable)
- `deskripsi` (text, nullable)
- `aktif` (boolean, default: true)
- `created_at`, `updated_at` (timestamps)

#### **Tabel `resep_obat`** (Resep Obat)
- `id` (UUID, primary key)
- `rekam_medis_id` (string, foreign key → `rekam_medis.id`, cascade delete)
- `dokter_id` (string, foreign key → `dokter.id`, cascade delete)
- `tanggal_resep` (date)
- `nama_obat` (string, not null)
- `jumlah` (integer, not null)
- `dosis` (integer, not null)
- `aturan_pakai` (text, not null)
- `created_at`, `updated_at` (timestamps)

**Relasi**: 
- Satu rekam medis memiliki banyak resep obat
- Satu dokter memiliki banyak resep obat

### Alur Relasi Database
```
roles → users → admin/pasien/dokter
dokter → jadwal_praktek
pasien + dokter → janji_temu → rekam_medis → resep_obat
master_obat (referensi untuk resep_obat)
```

---

## 3. LAYOUT FRONTEND & TAILWIND CSS

### Struktur Layout Admin

#### **Layout Utama** (`layouts/admin.blade.php`)
- Menggunakan **Tailwind CSS** untuk styling
- Menggunakan **Alpine.js** untuk interaktivitas
- Struktur: Sidebar (kiri) + Header (atas) + Main Content (tengah)

#### **Komponen Sidebar** (`components/admin-sidebar.blade.php`)

**Desktop View:**
- Sidebar tetap terlihat di kiri dengan lebar `w-64` (256px)
- Background warna `bg-[#005248]` (hijau tua)
- Menu items dengan hover effect
- Active menu item dengan background `bg-[#FFA700]` (orange)

**Mobile View:**
- Sidebar tersembunyi secara default (`-translate-x-full`)
- Muncul saat tombol menu diklik (`translate-x-0`)
- Menggunakan Alpine.js directive `x-data="{ open: false }"` untuk toggle
- Overlay gelap muncul saat sidebar terbuka (`bg-gray-900 bg-opacity-50`)
- Sidebar fixed position dengan z-index tinggi (`z-50`)

**Kode Tailwind untuk Responsive:**
```blade
<!-- Sidebar dengan responsive -->
<aside :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="w-64 bg-[#005248] flex flex-col h-screen fixed left-0 top-0 z-50 transition-transform duration-300 ease-in-out">
```

**Penjelasan:**
- `-translate-x-full`: Sidebar tersembunyi di kiri (mobile)
- `lg:translate-x-0`: Sidebar terlihat di desktop (≥1024px)
- `transition-transform duration-300`: Animasi smooth saat toggle
- `fixed left-0 top-0`: Posisi fixed di kiri atas
- `z-50`: Z-index tinggi agar di atas konten lain

#### **Komponen Header** (`components/admin-header.blade.php`)

**Desktop View:**
- Header sticky di atas (`sticky top-0 z-40`)
- Menampilkan title halaman dan tanggal/waktu
- Tombol menu tersembunyi (`lg:hidden`)

**Mobile View:**
- Tombol menu hamburger terlihat (`lg:hidden`)
- Title dan info lainnya tetap terlihat

**Kode Tailwind untuk Responsive:**
```blade
<!-- Mobile menu button -->
<button @click="$dispatch('toggle-sidebar')" class="lg:hidden p-2 ...">
```

#### **Main Content Area**

**Desktop View:**
- Margin kiri `lg:ml-64` untuk memberi ruang sidebar
- Padding `p-6` untuk spacing konten

**Mobile View:**
- Margin kiri `0` (sidebar overlay)
- Padding tetap `p-6`

**Kode Tailwind:**
```blade
<div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
```

### Utility Classes Tailwind yang Digunakan

1. **Responsive Breakpoints:**
   - `lg:` - Large screens (≥1024px)
   - `md:` - Medium screens (≥768px)
   - Default - Mobile first (< 768px)

2. **Layout:**
   - `flex`, `flex-col`, `flex-1` - Flexbox layout
   - `grid`, `grid-cols-1`, `md:grid-cols-2` - Grid layout responsive
   - `fixed`, `sticky` - Positioning

3. **Spacing:**
   - `p-6`, `px-4`, `py-3` - Padding
   - `m-4`, `ml-64` - Margin
   - `gap-4`, `space-y-6` - Gap spacing

4. **Colors:**
   - `bg-[#005248]` - Custom color (hijau tua)
   - `bg-[#FFA700]` - Custom color (orange)
   - `text-white`, `text-gray-600` - Text colors

5. **Effects:**
   - `hover:bg-gray-100` - Hover effect
   - `transition-colors`, `transition-transform` - Smooth transitions
   - `shadow-md`, `shadow-lg` - Box shadows

---

## 4. FITUR JANJI TEMU & ALUR UNTUK ADMIN

### Fitur-Fitur Janji Temu

1. **Daftar Janji Temu** (`admin/janji-temu/index`)
   - Menampilkan semua janji temu dengan pagination (15 per halaman)
   - Filter berdasarkan:
     - Status (pending, confirmed, completed, canceled)
     - Tanggal
     - Bulan
   - Search berdasarkan nama pasien atau dokter
   - Sorting berdasarkan field (default: created_at desc)
   - Statistik: Total pending, confirmed, completed, canceled

2. **Detail Janji Temu** (`admin/janji-temu/{id}`)
   - Menampilkan informasi lengkap:
     - Data pasien (nama, email, telepon)
     - Data dokter (nama, spesialisasi)
     - Tanggal dan jam janji
     - Keluhan pasien
     - Foto gigi (jika ada)
     - Status janji temu
     - Rekam medis terkait (jika sudah ada)

3. **Update Status Janji Temu** (`admin/janji-temu/{id}/status`)
   - Admin dapat mengubah status:
     - `pending` → Menunggu konfirmasi
     - `confirmed` → Dikonfirmasi
     - `completed` → Selesai
     - `canceled` → Dibatalkan

### Alur Janji Temu untuk Admin

```
1. Pasien membuat janji temu → Status: "pending"
   ↓
2. Admin melihat daftar janji temu di halaman "Janji Temu"
   ↓
3. Admin dapat:
   - Melihat detail janji temu
   - Mengubah status menjadi "confirmed" (mengkonfirmasi)
   - Mengubah status menjadi "canceled" (membatalkan)
   ↓
4. Setelah janji temu selesai (dokter membuat rekam medis):
   - Status otomatis menjadi "completed"
   ↓
5. Admin dapat melihat rekam medis terkait di halaman "Rekam Medis"
```

### Controller: `Admin\JanjiTemuController`

**Method `index()`:**
- Query dengan eager loading (`with(['pasien.user', 'dokter.user'])`)
- Filter, search, dan sorting
- Pagination 15 per halaman
- Statistik status

**Method `show($id)`:**
- Menampilkan detail dengan relasi lengkap
- Termasuk rekam medis dan resep obat jika ada

**Method `updateStatus()`:**
- Validasi status (pending, confirmed, completed, canceled)
- Update status dan redirect dengan pesan sukses

---

## 5. MANAJEMEN PASIEN (CRUD)

### Fitur CRUD Pasien

#### **1. CREATE (Tambah Pasien)**

**Route:** `GET /admin/pasien/create` → Form tambah pasien
**Route:** `POST /admin/pasien` → Simpan data pasien

**Proses:**
1. Admin mengisi form:
   - Data User: NIK, Nama Lengkap, Email, Password, Jenis Kelamin, Tanggal Lahir, Nomor Telp, Alamat, Foto Profil
   - Data Pasien: Alergi, Golongan Darah, Riwayat Penyakit
2. Validasi data menggunakan `StorePasienRequest`
3. Upload foto profil (jika ada) ke `storage/app/public/foto_profil`
4. Buat user baru dengan `role_id = 'pasien'`
5. Buat data pasien dengan `user_id` dari user yang baru dibuat
6. Menggunakan **Database Transaction** untuk memastikan konsistensi data

**Controller Method:** `PasienController@store()`

#### **2. READ (Lihat Daftar & Detail Pasien)**

**Route:** `GET /admin/pasien` → Daftar pasien
**Route:** `GET /admin/pasien/{id}` → Detail pasien

**Fitur Daftar Pasien:**
- Pagination 15 per halaman
- Search: Nama, Email, NIK
- Filter: Jenis Kelamin
- Sorting: Nama, Email, NIK, atau Created At
- Statistik: Total Pasien, Pasien Laki-laki, Pasien Perempuan

**Fitur Detail Pasien:**
- Informasi lengkap user dan pasien
- Daftar janji temu pasien
- Statistik: Total janji temu, Janji temu bulan ini

**Controller Method:** `PasienController@index()`, `PasienController@show()`

#### **3. UPDATE (Edit Pasien)**

**Route:** `GET /admin/pasien/{id}/edit` → Form edit pasien
**Route:** `PUT /admin/pasien/{id}` → Update data pasien

**Proses:**
1. Admin mengisi form edit
2. Validasi menggunakan `UpdatePasienRequest`
3. Update data user (jika ada perubahan)
4. Update foto profil (hapus foto lama jika ada, simpan foto baru)
5. Update password (jika diisi)
6. Update data pasien
7. Menggunakan **Database Transaction**

**Controller Method:** `PasienController@edit()`, `PasienController@update()`

#### **4. DELETE (Hapus Pasien)**

**Route:** `DELETE /admin/pasien/{id}` → Hapus pasien

**Proses:**
1. Cek apakah pasien memiliki janji temu aktif (pending/confirmed)
2. Jika ada, tampilkan error (tidak bisa hapus)
3. Jika tidak ada, hapus pasien terlebih dahulu
4. Cek apakah user masih digunakan di tabel lain
5. Jika tidak digunakan, hapus user juga
6. Menggunakan **Database Transaction**

**Controller Method:** `PasienController@destroy()`

### Keamanan & Validasi

- **Form Request Validation:** `StorePasienRequest`, `UpdatePasienRequest`
- **Database Transaction:** Memastikan data konsisten
- **File Storage:** Foto profil disimpan di `storage/app/public/foto_profil`
- **Cascade Delete:** Hapus pasien akan cascade ke janji_temu, rekam_medis, resep_obat

---

## 6. MANAJEMEN DOKTER (CRUD + JADWAL PRAKTEK)

### Fitur CRUD Dokter

#### **1. CREATE (Tambah Dokter)**

**Route:** `GET /admin/dokter/create` → Form tambah dokter
**Route:** `POST /admin/dokter` → Simpan data dokter

**Proses:**
1. Admin mengisi form:
   - Data User: NIK, Nama Lengkap, Email, Password, Jenis Kelamin, Tanggal Lahir, Nomor Telp, Alamat, Foto Profil
   - Data Dokter: No. STR (unique), Pendidikan, Pengalaman (tahun), Spesialisasi Gigi, Status (tersedia/tidak tersedia)
2. Validasi menggunakan `StoreDokterRequest`
3. Upload foto profil
4. Buat user dengan `role_id = 'dokter'`
5. Buat data dokter
6. **Database Transaction**

**Controller Method:** `DokterController@store()`

#### **2. READ (Lihat Daftar & Detail Dokter)**

**Route:** `GET /admin/dokter` → Daftar dokter
**Route:** `GET /admin/dokter/{id}` → Detail dokter

**Fitur Daftar Dokter:**
- Pagination 15 per halaman
- Filter: Status (tersedia/tidak tersedia), Spesialisasi
- Search: Nama, Email, NIK
- Sorting: No. STR, Spesialisasi, Pengalaman, Status, Nama, Email
- Statistik: Total Dokter, Dokter Tersedia, Dokter Tidak Tersedia

**Fitur Detail Dokter:**
- Informasi lengkap user dan dokter
- Daftar jadwal praktek
- Daftar janji temu
- Statistik: Total janji temu, Janji temu bulan ini

**Controller Method:** `DokterController@index()`, `DokterController@show()`

#### **3. UPDATE (Edit Dokter)**

**Route:** `GET /admin/dokter/{id}/edit` → Form edit dokter
**Route:** `PUT /admin/dokter/{id}` → Update data dokter

**Proses:** Sama seperti edit pasien, dengan tambahan update data dokter

**Controller Method:** `DokterController@edit()`, `DokterController@update()`

#### **4. DELETE (Hapus Dokter)**

**Route:** `DELETE /admin/dokter/{id}` → Hapus dokter

**Proses:**
1. Cek janji temu aktif
2. Jika ada, tampilkan error
3. Hapus dokter (cascade ke jadwal_praktek)
4. Hapus user jika tidak digunakan
5. **Database Transaction**

**Controller Method:** `DokterController@destroy()`

### JADWAL PRAKTEK DOKTER

#### **1. CREATE (Tambah Jadwal Praktek)**

**Route:** `GET /admin/dokter/{dokterId}/jadwal-praktek/create` → Form tambah jadwal
**Route:** `POST /admin/dokter/{dokterId}/jadwal-praktek` → Simpan jadwal

**Proses:**
1. Admin mengisi form:
   - Tanggal (harus hari ini atau setelahnya)
   - Jam Mulai
   - Jam Selesai (harus setelah jam mulai)
   - Status (available/booked)
2. Validasi:
   - Cek apakah jadwal untuk tanggal dan jam yang sama sudah ada
   - Cek konflik waktu dengan jadwal lain pada tanggal yang sama
3. Jika valid, simpan jadwal
4. Redirect dengan pesan sukses

**Controller Method:** `JadwalPraktekController@create()`, `JadwalPraktekController@store()`

#### **2. READ (Lihat Jadwal Praktek)**

**Route:** `GET /admin/dokter/{dokterId}/jadwal-praktek` → Daftar jadwal

**Fitur:**
- Menampilkan semua jadwal praktek dokter
- Diurutkan berdasarkan tanggal dan jam mulai (ascending)
- Menampilkan status (available/booked)

**Controller Method:** `JadwalPraktekController@index()`

#### **3. UPDATE (Edit Jadwal Praktek)**

**Route:** `GET /admin/dokter/{dokterId}/jadwal-praktek/{id}/edit` → Form edit jadwal
**Route:** `PUT /admin/dokter/{dokterId}/jadwal-praktek/{id}` → Update jadwal

**Proses:**
1. Validasi sama seperti create
2. Cek konflik dengan jadwal lain (kecuali jadwal yang sedang diedit)
3. Update jadwal

**Controller Method:** `JadwalPraktekController@edit()`, `JadwalPraktekController@update()`

#### **4. DELETE (Hapus Jadwal Praktek)**

**Route:** `DELETE /admin/dokter/{dokterId}/jadwal-praktek/{id}` → Hapus jadwal

**Proses:**
1. Hapus jadwal langsung (tidak ada validasi khusus)
2. Redirect dengan pesan sukses

**Controller Method:** `JadwalPraktekController@destroy()`

### Validasi Jadwal Praktek

- **Tanggal:** Harus hari ini atau setelahnya (`after_or_equal:today`)
- **Jam Selesai:** Harus setelah jam mulai (`after:jam_mulai`)
- **Konflik Waktu:** Tidak boleh overlap dengan jadwal lain pada tanggal yang sama
- **Duplikasi:** Tidak boleh ada jadwal dengan tanggal dan jam mulai yang sama

---

## 7. REKAM MEDIS & RESEP OBAT

### REKAM MEDIS

#### **Sumber Data Rekam Medis**

Rekam medis dibuat dari **janji temu** yang sudah dikonfirmasi atau selesai. Admin dapat melihat rekam medis yang sudah dibuat oleh dokter.

**Relasi Database:**
```
janji_temu → rekam_medis (one-to-one)
rekam_medis → resep_obat (one-to-many)
```

#### **Fitur Rekam Medis untuk Admin**

1. **Daftar Rekam Medis** (`admin/rekam-medis/index`)
   - Menampilkan semua rekam medis dengan pagination
   - Search: Nama pasien, dokter, diagnosa, tindakan, NIK
   - Filter: Tanggal dari - sampai
   - Sorting: Tanggal atau Created At
   - Statistik: Total rekam medis, Total biaya, Rekam medis bulan ini

2. **Detail Rekam Medis** (`admin/rekam-medis/{id}`)
   - Informasi lengkap:
     - Data pasien dan dokter
     - Tanggal janji temu
     - Diagnosa
     - Tindakan
     - Catatan
     - Biaya
     - Resep obat (jika ada)

3. **Export PDF** (`admin/rekam-medis/{id}/pdf`)
   - Generate PDF menggunakan **DomPDF**
   - Template: `admin/rekam-medis/pdf.blade.php`
   - Format: A4 Portrait
   - Download file PDF

**Controller:** `Admin\RekamMedisController`

**Method `index()`:**
- Query dengan eager loading
- Filter, search, sorting
- Pagination 15 per halaman

**Method `show($id)`:**
- Menampilkan detail dengan relasi lengkap
- Jika resep obat ada tapi aturan pakai/dosis kosong, ambil dari `master_obat`

**Method `export($id)`:**
- Load rekam medis dengan relasi
- Generate PDF menggunakan `Barryvdh\DomPDF\Facade\Pdf`
- Download dengan nama file `Rekam_Medis_{id}.pdf`

### RESEP OBAT

#### **Sumber Data Resep Obat**

Resep obat dibuat bersamaan dengan rekam medis oleh dokter. Admin hanya dapat **melihat** resep obat, tidak dapat membuat atau mengedit.

**Relasi Database:**
```
rekam_medis → resep_obat (one-to-many)
dokter → resep_obat (one-to-many)
master_obat → (referensi untuk nama_obat, dosis_default, aturan_pakai_default)
```

#### **Fitur Resep Obat untuk Admin**

1. **Daftar Resep Obat** (`admin/resep-obat/index`)
   - Menampilkan semua resep obat dengan pagination
   - Search: Nama obat, nama pasien, nama dokter
   - Filter: Tanggal resep (dari - sampai), Dokter
   - Sorting: Tanggal resep (default desc)
   - Statistik: Total resep obat, Total obat unik, Resep obat bulan ini

2. **Detail Resep Obat** (`admin/resep-obat/{id}`)
   - Informasi lengkap:
     - Data pasien dan dokter
     - Tanggal resep
     - Nama obat
     - Jumlah
     - Dosis
     - Aturan pakai
     - Rekam medis terkait

**Controller:** `Admin\ResepObatController`

**Method `index()`:**
- Query dengan eager loading relasi lengkap
- Filter, search, sorting
- Pagination 15 per halaman
- Ambil daftar dokter untuk filter dropdown

**Method `show($id)`:**
- Menampilkan detail resep obat dengan relasi lengkap

### Alur Rekam Medis & Resep Obat

```
1. Pasien membuat janji temu → Status: "pending"
   ↓
2. Dokter mengkonfirmasi → Status: "confirmed"
   ↓
3. Dokter melakukan pemeriksaan → Status: "completed"
   ↓
4. Dokter membuat rekam medis:
   - Input diagnosa, tindakan, catatan, biaya
   - (Opsional) Tambahkan resep obat:
     * Pilih dari master_obat atau input manual
     * Input jumlah, dosis, aturan pakai
   ↓
5. Admin dapat melihat rekam medis dan resep obat di halaman masing-masing
   ↓
6. Admin dapat export rekam medis ke PDF
```

---

## 8. LAPORAN (EXPORT EXCEL & PDF)

### Fitur Laporan

Admin dapat melihat dan export 3 jenis laporan:

1. **Laporan Jumlah Pasien Terdaftar**
2. **Laporan Jadwal Kunjungan** (per tanggal)
3. **Laporan Daftar Dokter Aktif**

### Format Export

Setiap laporan dapat diekspor dalam 3 format:
- **View** (tampilan web)
- **PDF** (menggunakan DomPDF)
- **Excel** (menggunakan Maatwebsite Excel)

### Cara Kerja Export

#### **1. Export PDF**

**Library:** `barryvdh/laravel-dompdf` (v3.1)

**Proses:**
1. User klik tombol "Export PDF"
2. Controller memanggil method `exportPDF()`
3. Load data yang diperlukan
4. Generate PDF menggunakan `Pdf::loadView()`
5. Set paper size: A4 Portrait
6. Enable local file access (untuk gambar/asset)
7. Download file dengan nama sesuai format

**Contoh Kode:**
```php
private function exportPDF($view, $data, $filename)
{
    $pdf = Pdf::loadView($view, $data);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption('enable-local-file-access', true);
    return $pdf->download($filename);
}
```

**Template PDF:**
- Menggunakan Blade template khusus untuk PDF
- Styling dengan CSS inline
- Format: A4 Portrait

#### **2. Export Excel**

**Library:** `maatwebsite/excel` (v3.1) menggunakan PhpSpreadsheet

**Proses:**
1. User klik tombol "Export Excel"
2. Controller memanggil `Excel::download()`
3. Menggunakan Export Class yang implement interface:
   - `FromCollection` - Data source
   - `WithHeadings` - Header kolom
   - `WithMapping` - Mapping data per row
   - `WithStyles` - Styling cells
   - `WithColumnWidths` - Lebar kolom
   - `WithCustomStartCell` - Start cell (bukan A1)
   - `WithEvents` - Event untuk custom styling

**Contoh Export Class:** `PasienExport`

**Fitur Excel Export:**
- Header laporan (judul, tanggal, statistik)
- Table dengan header yang di-style
- Border untuk semua cell
- Auto-width kolom
- Center alignment untuk kolom tertentu
- Warna background untuk header (hijau tua #005248)
- Text color putih untuk header

**Contoh Kode:**
```php
return Excel::download(
    new PasienExport($pasien, $totalPasien, $pasienLaki, $pasienPerempuan),
    'laporan-pasien-' . date('Y-m-d') . '.xlsx'
);
```

**File Excel:**
- Format: `.xlsx` (Excel 2007+)
- Nama file: `laporan-{jenis}-{tanggal}.xlsx`

### Detail Setiap Laporan

#### **1. Laporan Jumlah Pasien Terdaftar**

**Route:** `GET /admin/laporan/pasien?format={view|pdf|excel}`

**Data yang Ditampilkan:**
- Total pasien
- Pasien laki-laki
- Pasien perempuan
- Daftar pasien (Nama, Email, No. Telepon, Jenis Kelamin, Tanggal Daftar)

**Export Class:** `PasienExport`

#### **2. Laporan Jadwal Kunjungan**

**Route:** `GET /admin/laporan/jadwal-kunjungan?format={view|pdf|excel}&tanggal={YYYY-MM-DD}`

**Data yang Ditampilkan:**
- Tanggal kunjungan
- Total kunjungan
- Status count (pending, confirmed, completed, canceled)
- Daftar janji temu (Pasien, Dokter, Jam, Status)

**Export Class:** `JadwalKunjunganExport`

#### **3. Laporan Daftar Dokter Aktif**

**Route:** `GET /admin/laporan/dokter-aktif?format={view|pdf|excel}`

**Data yang Ditampilkan:**
- Total dokter aktif
- Daftar dokter (Nama, Email, Spesialisasi, Status)
- Statistik per dokter (Total janji temu, Janji temu bulan ini)

**Export Class:** `DokterAktifExport`

### Controller: `Admin\LaporanController`

**Method `index()`:**
- Menampilkan halaman pilihan laporan

**Method `pasien()`:**
- Query data pasien
- Hitung statistik
- Return view/PDF/Excel sesuai parameter `format`

**Method `jadwalKunjungan()`:**
- Query janji temu per tanggal
- Hitung statistik status
- Return view/PDF/Excel

**Method `dokterAktif()`:**
- Query dokter dengan status 'tersedia'
- Hitung statistik per dokter
- Return view/PDF/Excel

**Method `exportPDF()`:**
- Helper method untuk generate PDF
- Digunakan oleh semua method laporan

---

## 9. PROFILE ADMIN & LOGOUT

### PROFILE ADMIN

#### **Fitur Profile**

**Route:** `GET /profile` → Form edit profile
**Route:** `PATCH /profile` → Update profile

**Data yang Dapat Diubah:**
- Nama Lengkap
- Email
- NIK
- Alamat
- Nomor Telepon
- Tanggal Lahir
- Jenis Kelamin
- Foto Profil

**Proses Update:**
1. Validasi data input
2. Update data user
3. Upload foto profil baru (jika ada):
   - Hapus foto lama dari storage
   - Simpan foto baru ke `storage/app/public/foto_profil`
4. Redirect back dengan pesan sukses

**Controller:** `ProfileController`

**Method `edit()`:**
- Menampilkan form edit profile
- Data user dari `Auth::user()`

**Method `update()`:**
- Validasi input
- Update user data
- Handle upload foto profil
- Update/create pasien data (jika role pasien)

**Validasi:**
- Nama lengkap: required, string, max 255
- Alamat: nullable, string
- Nomor telp: nullable, string, max 15
- Tanggal lahir: nullable, date
- Jenis kelamin: nullable, string
- Foto profil: nullable, image, max 2048 KB

### LOGOUT

#### **Fitur Logout**

**Route:** `POST /logout` (dari Laravel Breeze)

**Proses:**
1. User klik tombol "Logout" di sidebar
2. Form POST ke route `/logout` dengan CSRF token
3. Laravel Breeze handle logout:
   - Invalidate session
   - Regenerate CSRF token
   - Redirect ke halaman login

**Kode di Sidebar:**
```blade
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="...">
        <svg>...</svg>
        <span>Logout</span>
    </button>
</form>
```

**Keamanan:**
- Menggunakan CSRF token untuk mencegah CSRF attack
- Session di-invalidate setelah logout
- Token di-regenerate untuk keamanan

### Lokasi Menu

- **Profile:** Link di bagian bawah sidebar (atas tombol logout)
- **Logout:** Tombol di bagian bawah sidebar

**Styling:**
- Profile link: Hover effect dengan background `bg-[#005248]/80`
- Logout button: Hover effect dengan background `bg-red-600/20`
- Icon SVG untuk visual

---

## KESIMPULAN

Sistem Admin DentaTime adalah sistem manajemen klinik gigi yang lengkap dengan fitur:

1. **Teknologi Modern:** Laravel 12, Tailwind CSS, Alpine.js
2. **Database Terstruktur:** Relasi yang jelas antara user, pasien, dokter, janji temu, rekam medis, dan resep obat
3. **Responsive Design:** Layout yang adaptif untuk desktop dan mobile
4. **CRUD Lengkap:** Manajemen pasien dan dokter dengan validasi dan keamanan
5. **Jadwal Praktek:** Sistem jadwal dengan validasi konflik waktu
6. **Rekam Medis & Resep Obat:** Integrasi dengan janji temu dan master obat
7. **Laporan & Export:** Export ke PDF dan Excel dengan styling profesional
8. **Profile & Logout:** Manajemen profile dan keamanan logout

Sistem ini dirancang dengan prinsip **clean code**, **security**, dan **user experience** yang baik.

---

**Dokumen ini dibuat untuk keperluan presentasi proyek Sistem Janji Temu Dokter (DentaTime).**


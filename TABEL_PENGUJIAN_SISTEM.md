# DOKUMENTASI PENGUJIAN SISTEM JANJI TEMU DOKTER GIGI

---

## A. CONTROLLER ADMIN

### 1. AdminController

#### Test Case 1: Admin Mengakses Dashboard
- **Class**: `AdminController`
- **Method**: `index()`
- **Data Input**: User dengan role 'admin' sudah login
- **Expected Result**: Menampilkan dashboard dengan statistik: total pasien, dokter, admin, janji temu, pendapatan, dan data terbaru
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Mengakses Dashboard Tanpa Data
- **Class**: `AdminController`
- **Method**: `index()`
- **Data Input**: Database kosong, user admin login
- **Expected Result**: Menampilkan dashboard dengan nilai 0 untuk semua statistik
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 2. Admin\DokterController

#### Test Case 1: Admin Melihat Daftar Dokter
- **Class**: `Admin\DokterController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search, status, spesialisasi, sort_by, sort_order
- **Expected Result**: Menampilkan daftar dokter dengan pagination, filter, dan sorting berfungsi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Daftar Dokter Tanpa Filter
- **Class**: `Admin\DokterController`
- **Method**: `index()`
- **Data Input**: Request tanpa parameter
- **Expected Result**: Menampilkan semua dokter dengan pagination default
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Membuka Form Tambah Dokter
- **Class**: `Admin\DokterController`
- **Method**: `create()`
- **Data Input**: User admin login
- **Expected Result**: Menampilkan form untuk menambah dokter baru
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Menambah Dokter Baru (Valid)
- **Class**: `Admin\DokterController`
- **Method**: `store()`
- **Data Input**: Data valid: nama_lengkap, email, password, nik, no_str, spesialisasi_gigi, dll
- **Expected Result**: Dokter berhasil ditambahkan, redirect ke index dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Menambah Dokter Baru (Invalid - Email Duplikat)
- **Class**: `Admin\DokterController`
- **Method**: `store()`
- **Data Input**: Email sudah ada di database
- **Expected Result**: Redirect back dengan error message, data tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Admin Menambah Dokter Baru (Invalid - NIK Duplikat)
- **Class**: `Admin\DokterController`
- **Method**: `store()`
- **Data Input**: NIK sudah ada di database
- **Expected Result**: Redirect back dengan error message, data tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Admin Melihat Detail Dokter
- **Class**: `Admin\DokterController`
- **Method**: `show($id)`
- **Data Input**: ID dokter yang valid
- **Expected Result**: Menampilkan detail dokter dengan statistik janji temu
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Admin Melihat Detail Dokter (ID Tidak Ada)
- **Class**: `Admin\DokterController`
- **Method**: `show($id)`
- **Data Input**: ID dokter yang tidak ada
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Admin Membuka Form Edit Dokter
- **Class**: `Admin\DokterController`
- **Method**: `edit($id)`
- **Data Input**: ID dokter yang valid
- **Expected Result**: Menampilkan form edit dengan data dokter terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Admin Update Data Dokter (Valid)
- **Class**: `Admin\DokterController`
- **Method**: `update()`
- **Data Input**: Data valid dengan ID dokter yang ada
- **Expected Result**: Data dokter berhasil diupdate, redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 11: Admin Update Data Dokter (Password Kosong)
- **Class**: `Admin\DokterController`
- **Method**: `update()`
- **Data Input**: Update tanpa password
- **Expected Result**: Password tidak diupdate, field lain berhasil diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 12: Admin Update Data Dokter (Foto Profil Baru)
- **Class**: `Admin\DokterController`
- **Method**: `update()`
- **Data Input**: Upload foto profil baru
- **Expected Result**: Foto lama dihapus, foto baru tersimpan, path diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 13: Admin Hapus Dokter (Tanpa Janji Aktif)
- **Class**: `Admin\DokterController`
- **Method**: `destroy($id)`
- **Data Input**: Dokter tanpa janji temu pending/confirmed
- **Expected Result**: Dokter dan user berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 14: Admin Hapus Dokter (Dengan Janji Aktif)
- **Class**: `Admin\DokterController`
- **Method**: `destroy($id)`
- **Data Input**: Dokter dengan janji temu pending/confirmed
- **Expected Result**: Redirect back dengan error, dokter tidak dihapus
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 3. Admin\PasienController

#### Test Case 1: Admin Melihat Daftar Pasien
- **Class**: `Admin\PasienController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search, jenis_kelamin, sort_by, sort_order
- **Expected Result**: Menampilkan daftar pasien dengan pagination, filter, dan sorting berfungsi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Daftar Pasien Tanpa Filter
- **Class**: `Admin\PasienController`
- **Method**: `index()`
- **Data Input**: Request tanpa parameter
- **Expected Result**: Menampilkan semua pasien dengan pagination default
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Membuka Form Tambah Pasien
- **Class**: `Admin\PasienController`
- **Method**: `create()`
- **Data Input**: User admin login
- **Expected Result**: Menampilkan form untuk menambah pasien baru
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Menambah Pasien Baru (Valid)
- **Class**: `Admin\PasienController`
- **Method**: `store()`
- **Data Input**: Data valid: nama_lengkap, email, password, nik, alergi, golongan_darah, dll
- **Expected Result**: Pasien berhasil ditambahkan, redirect ke index dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Menambah Pasien Baru (Invalid - Email Duplikat)
- **Class**: `Admin\PasienController`
- **Method**: `store()`
- **Data Input**: Email sudah ada di database
- **Expected Result**: Redirect back dengan error message, data tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Admin Melihat Detail Pasien
- **Class**: `Admin\PasienController`
- **Method**: `show($id)`
- **Data Input**: ID pasien yang valid
- **Expected Result**: Menampilkan detail pasien dengan statistik janji temu
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Admin Membuka Form Edit Pasien
- **Class**: `Admin\PasienController`
- **Method**: `edit($id)`
- **Data Input**: ID pasien yang valid
- **Expected Result**: Menampilkan form edit dengan data pasien terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Admin Update Data Pasien (Valid)
- **Class**: `Admin\PasienController`
- **Method**: `update()`
- **Data Input**: Data valid dengan ID pasien yang ada
- **Expected Result**: Data pasien berhasil diupdate, redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Admin Hapus Pasien (Tanpa Janji Aktif)
- **Class**: `Admin\PasienController`
- **Method**: `destroy($id)`
- **Data Input**: Pasien tanpa janji temu pending/confirmed
- **Expected Result**: Pasien dan user berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Admin Hapus Pasien (Dengan Janji Aktif)
- **Class**: `Admin\PasienController`
- **Method**: `destroy($id)`
- **Data Input**: Pasien dengan janji temu pending/confirmed
- **Expected Result**: Redirect back dengan error, pasien tidak dihapus
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 4. Admin\JanjiTemuController

#### Test Case 1: Admin Melihat Daftar Janji Temu
- **Class**: `Admin\JanjiTemuController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter status, tanggal, bulan, search, sort_by, sort_order
- **Expected Result**: Menampilkan daftar janji temu dengan filter dan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Daftar Janji Temu Tanpa Filter
- **Class**: `Admin\JanjiTemuController`
- **Method**: `index()`
- **Data Input**: Request tanpa parameter
- **Expected Result**: Menampilkan semua janji temu dengan pagination default
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Melihat Detail Janji Temu
- **Class**: `Admin\JanjiTemuController`
- **Method**: `show($id)`
- **Data Input**: ID janji temu yang valid
- **Expected Result**: Menampilkan detail janji temu dengan data pasien, dokter, dan rekam medis
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Update Status Janji Temu (Valid)
- **Class**: `Admin\JanjiTemuController`
- **Method**: `updateStatus()`
- **Data Input**: Status: pending/confirmed/completed/canceled, ID valid
- **Expected Result**: Status janji temu berhasil diupdate, redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Update Status Janji Temu (Invalid Status)
- **Class**: `Admin\JanjiTemuController`
- **Method**: `updateStatus()`
- **Data Input**: Status tidak valid (selain pending/confirmed/completed/canceled)
- **Expected Result**: Validation error, status tidak diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 5. Admin\RekamMedisController

#### Test Case 1: Admin Melihat Daftar Rekam Medis
- **Class**: `Admin\RekamMedisController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search, tanggal_dari, tanggal_sampai, sort_by, sort_order
- **Expected Result**: Menampilkan daftar rekam medis dengan filter dan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Daftar Rekam Medis Tanpa Filter
- **Class**: `Admin\RekamMedisController`
- **Method**: `index()`
- **Data Input**: Request tanpa parameter
- **Expected Result**: Menampilkan semua rekam medis dengan pagination default
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Membuka Form Tambah Rekam Medis
- **Class**: `Admin\RekamMedisController`
- **Method**: `create()`
- **Data Input**: Request dengan/ tanpa parameter janji_temu_id
- **Expected Result**: Menampilkan form dengan daftar janji temu yang belum punya rekam medis
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Melihat Detail Rekam Medis
- **Class**: `Admin\RekamMedisController`
- **Method**: `show($id)`
- **Data Input**: ID rekam medis yang valid
- **Expected Result**: Menampilkan detail rekam medis dengan data pasien, dokter, dan resep obat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Membuka Form Edit Rekam Medis
- **Class**: `Admin\RekamMedisController`
- **Method**: `edit($id)`
- **Data Input**: ID rekam medis yang valid
- **Expected Result**: Menampilkan form edit dengan data rekam medis terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Admin Update Rekam Medis (Valid)
- **Class**: `Admin\RekamMedisController`
- **Method**: `update()`
- **Data Input**: Data valid: diagnosa, tindakan, catatan, biaya
- **Expected Result**: Rekam medis berhasil diupdate, redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Admin Update Rekam Medis Dengan Resep Obat Baru
- **Class**: `Admin\RekamMedisController`
- **Method**: `update()`
- **Data Input**: Data valid + resep_obat_nama, resep_obat_jumlah, resep_obat_dosis, resep_obat_aturan_pakai
- **Expected Result**: Rekam medis dan resep obat berhasil diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Admin Update Rekam Medis Hapus Resep Obat
- **Class**: `Admin\RekamMedisController`
- **Method**: `update()`
- **Data Input**: Data valid + hapus_resep_obat = true
- **Expected Result**: Resep obat dihapus, rekam medis diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Admin Hapus Rekam Medis
- **Class**: `Admin\RekamMedisController`
- **Method**: `destroy($id)`
- **Data Input**: ID rekam medis yang valid
- **Expected Result**: Rekam medis berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Admin Export Rekam Medis Ke PDF
- **Class**: `Admin\RekamMedisController`
- **Method**: `export($id)`
- **Data Input**: ID rekam medis yang valid
- **Expected Result**: File PDF berhasil didownload dengan nama "Rekam_Medis_{id}.pdf"
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 6. Admin\JadwalPraktekController

#### Test Case 1: Admin Melihat Jadwal Praktek Dokter
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `index($dokterId)`
- **Data Input**: ID dokter yang valid
- **Expected Result**: Menampilkan daftar jadwal praktek dokter
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Membuka Form Tambah Jadwal Praktek
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `create($dokterId)`
- **Data Input**: ID dokter yang valid
- **Expected Result**: Menampilkan form untuk menambah jadwal praktek
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Menambah Jadwal Praktek (Valid)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Data valid: tanggal (>= today), jam_mulai, jam_selesai (after jam_mulai), status
- **Expected Result**: Jadwal praktek berhasil ditambahkan, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Menambah Jadwal Praktek (Tanggal Kemarin)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Tanggal sebelum hari ini
- **Expected Result**: Validation error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Menambah Jadwal Praktek (Jam Selesai <= Jam Mulai)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Jam selesai <= jam mulai
- **Expected Result**: Validation error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Admin Menambah Jadwal Praktek (Konflik Waktu)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Jadwal bertabrakan dengan jadwal yang sudah ada
- **Expected Result**: Redirect back dengan error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Admin Menambah Jadwal Praktek (Duplikat)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Tanggal dan jam_mulai sama dengan jadwal yang sudah ada
- **Expected Result**: Redirect back dengan error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Admin Membuka Form Edit Jadwal Praktek
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `edit($dokterId, $id)`
- **Data Input**: ID dokter dan ID jadwal yang valid
- **Expected Result**: Menampilkan form edit dengan data jadwal terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Admin Update Jadwal Praktek (Valid)
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `update()`
- **Data Input**: Data valid dengan ID yang ada
- **Expected Result**: Jadwal praktek berhasil diupdate, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Admin Hapus Jadwal Praktek
- **Class**: `Admin\JadwalPraktekController`
- **Method**: `destroy($dokterId, $id)`
- **Data Input**: ID dokter dan ID jadwal yang valid
- **Expected Result**: Jadwal praktek berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 7. Admin\LaporanController

#### Test Case 1: Admin Melihat Halaman Laporan
- **Class**: `Admin\LaporanController`
- **Method**: `index()`
- **Data Input**: User admin login
- **Expected Result**: Menampilkan halaman pilihan laporan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Laporan Pasien (View)
- **Class**: `Admin\LaporanController`
- **Method**: `pasien()`
- **Data Input**: Format = 'view' (default)
- **Expected Result**: Menampilkan laporan pasien dengan statistik
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Export Laporan Pasien Ke PDF
- **Class**: `Admin\LaporanController`
- **Method**: `pasien()`
- **Data Input**: Format = 'pdf'
- **Expected Result**: File PDF berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Admin Export Laporan Pasien Ke Excel
- **Class**: `Admin\LaporanController`
- **Method**: `pasien()`
- **Data Input**: Format = 'excel'
- **Expected Result**: File Excel berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Admin Melihat Laporan Jadwal Kunjungan (View)
- **Class**: `Admin\LaporanController`
- **Method**: `jadwalKunjungan()`
- **Data Input**: Format = 'view', tanggal = today (default)
- **Expected Result**: Menampilkan laporan jadwal kunjungan hari ini
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Admin Melihat Laporan Jadwal Kunjungan (Tanggal Tertentu)
- **Class**: `Admin\LaporanController`
- **Method**: `jadwalKunjungan()`
- **Data Input**: Format = 'view', tanggal = '2024-01-15'
- **Expected Result**: Menampilkan laporan jadwal kunjungan tanggal tertentu
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Admin Export Laporan Jadwal Kunjungan Ke PDF
- **Class**: `Admin\LaporanController`
- **Method**: `jadwalKunjungan()`
- **Data Input**: Format = 'pdf'
- **Expected Result**: File PDF berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Admin Export Laporan Jadwal Kunjungan Ke Excel
- **Class**: `Admin\LaporanController`
- **Method**: `jadwalKunjungan()`
- **Data Input**: Format = 'excel'
- **Expected Result**: File Excel berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Admin Melihat Laporan Dokter Aktif (View)
- **Class**: `Admin\LaporanController`
- **Method**: `dokterAktif()`
- **Data Input**: Format = 'view'
- **Expected Result**: Menampilkan laporan dokter aktif dengan statistik
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Admin Export Laporan Dokter Aktif Ke PDF
- **Class**: `Admin\LaporanController`
- **Method**: `dokterAktif()`
- **Data Input**: Format = 'pdf'
- **Expected Result**: File PDF berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 11: Admin Export Laporan Dokter Aktif Ke Excel
- **Class**: `Admin\LaporanController`
- **Method**: `dokterAktif()`
- **Data Input**: Format = 'excel'
- **Expected Result**: File Excel berhasil didownload
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 8. Admin\ResepObatController

#### Test Case 1: Admin Melihat Daftar Resep Obat
- **Class**: `Admin\ResepObatController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search, tanggal_dari, tanggal_sampai, dokter_id, sort_by, sort_order
- **Expected Result**: Menampilkan daftar resep obat dengan filter dan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Admin Melihat Daftar Resep Obat Tanpa Filter
- **Class**: `Admin\ResepObatController`
- **Method**: `index()`
- **Data Input**: Request tanpa parameter
- **Expected Result**: Menampilkan semua resep obat dengan pagination default
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Admin Melihat Detail Resep Obat
- **Class**: `Admin\ResepObatController`
- **Method**: `show($id)`
- **Data Input**: ID resep obat yang valid
- **Expected Result**: Menampilkan detail resep obat dengan data pasien dan dokter
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 9. ProfileController

#### Test Case 1: User Melihat Form Edit Profile
- **Class**: `ProfileController`
- **Method**: `edit()`
- **Data Input**: User sudah login
- **Expected Result**: Menampilkan form edit profile dengan data user dan pasien
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: User Update Profile (Valid)
- **Class**: `ProfileController`
- **Method**: `update()`
- **Data Input**: Data valid: nama_lengkap, alamat, nomor_telp, tanggal_lahir, jenis_kelamin, alergi, riwayat_penyakit, golongan_darah
- **Expected Result**: Profile berhasil diupdate, redirect back dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: User Update Profile Dengan Foto Baru
- **Class**: `ProfileController`
- **Method**: `update()`
- **Data Input**: Data valid + upload foto_profil
- **Expected Result**: Foto lama dihapus, foto baru tersimpan, path diupdate
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: User Update Profile Tanpa Foto
- **Class**: `ProfileController`
- **Method**: `update()`
- **Data Input**: Data valid tanpa foto_profil
- **Expected Result**: Profile diupdate, foto tidak berubah
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: User Hapus Akun (Password Benar)
- **Class**: `ProfileController`
- **Method**: `destroy()`
- **Data Input**: Password benar
- **Expected Result**: User logout, akun dihapus, session invalidate, redirect ke home
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: User Hapus Akun (Password Salah)
- **Class**: `ProfileController`
- **Method**: `destroy()`
- **Data Input**: Password salah
- **Expected Result**: Validation error, akun tidak dihapus
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

## B. CONTROLLER DOKTER

### 1. DokterController

#### Test Case 1: Dokter Mengakses Dashboard
- **Class**: `DokterController`
- **Method**: `index()`
- **Data Input**: User dengan role 'dokter' sudah login, memiliki relasi dokter
- **Expected Result**: Menampilkan dashboard dengan statistik: total pasien, janji temu hari ini, status pending/selesai, janji temu terbaru, jadwal praktek terdekat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Mengakses Dashboard Tanpa Relasi Dokter
- **Class**: `DokterController`
- **Method**: `index()`
- **Data Input**: User dokter login tapi tidak punya relasi dokter
- **Expected Result**: Menampilkan dashboard dengan nilai 0 untuk semua statistik
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 2. Dokter\DaftarPasienController

#### Test Case 1: Dokter Melihat Daftar Pasien
- **Class**: `Dokter\DaftarPasienController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search (optional)
- **Expected Result**: Menampilkan daftar pasien yang pernah berjanji temu dengan dokter ini, dengan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Mencari Pasien
- **Class**: `Dokter\DaftarPasienController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search = 'nama pasien'
- **Expected Result**: Menampilkan pasien yang namanya mengandung keyword
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Dokter Melihat Detail Pasien
- **Class**: `Dokter\DaftarPasienController`
- **Method**: `show($id)`
- **Data Input**: ID pasien yang valid dan pernah berjanji temu dengan dokter ini
- **Expected Result**: Menampilkan detail pasien dengan rekam medis
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Dokter Melihat Detail Pasien (Tidak Pernah Berjanji)
- **Class**: `Dokter\DaftarPasienController`
- **Method**: `show($id)`
- **Data Input**: ID pasien yang tidak pernah berjanji temu dengan dokter ini
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 3. Dokter\JanjiTemuController

#### Test Case 1: Dokter Melihat Daftar Janji Temu
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `index()`
- **Data Input**: User dokter login
- **Expected Result**: Menampilkan daftar janji temu dokter dengan data pasien
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Melihat Detail Janji Temu
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `show($id)`
- **Data Input**: ID janji temu yang valid dan milik dokter ini
- **Expected Result**: Menampilkan detail janji temu
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Dokter Melihat Detail Janji Temu (Bukan Miliknya)
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `show($id)`
- **Data Input**: ID janji temu milik dokter lain
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Dokter Approve Janji Temu
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `approve($id)`
- **Data Input**: ID janji temu yang valid dan milik dokter ini
- **Expected Result**: Status janji temu menjadi 'confirmed', redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Dokter Reject Janji Temu
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `reject($id)`
- **Data Input**: ID janji temu yang valid dan milik dokter ini
- **Expected Result**: Status janji temu menjadi 'canceled', redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Dokter Complete Janji Temu
- **Class**: `Dokter\JanjiTemuController`
- **Method**: `complete($id)`
- **Data Input**: ID janji temu yang valid dan milik dokter ini
- **Expected Result**: Status janji temu menjadi 'completed', redirect ke show dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 4. Dokter\RekamMedisController

#### Test Case 1: Dokter Melihat Daftar Rekam Medis
- **Class**: `Dokter\RekamMedisController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search, tanggal (optional)
- **Expected Result**: Menampilkan daftar rekam medis pasien dokter ini dengan pagination dan statistik
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Melihat Detail Rekam Medis
- **Class**: `Dokter\RekamMedisController`
- **Method**: `show($id)`
- **Data Input**: ID rekam medis yang valid dan milik dokter ini
- **Expected Result**: Menampilkan detail rekam medis dengan data pasien dan resep obat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Dokter Membuka Form Tambah Rekam Medis
- **Class**: `Dokter\RekamMedisController`
- **Method**: `create()`
- **Data Input**: Request dengan/ tanpa parameter janji_temu_id
- **Expected Result**: Menampilkan form dengan daftar janji temu yang belum punya rekam medis
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Dokter Menambah Rekam Medis (Valid)
- **Class**: `Dokter\RekamMedisController`
- **Method**: `store()`
- **Data Input**: Data valid: janji_temu_id, diagnosa, tindakan, catatan, biaya
- **Expected Result**: Rekam medis berhasil ditambahkan, status janji temu menjadi 'completed', redirect ke show
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Dokter Menambah Rekam Medis Dengan Resep Obat
- **Class**: `Dokter\RekamMedisController`
- **Method**: `store()`
- **Data Input**: Data valid + resep_obat_nama, resep_obat_jumlah, resep_obat_dosis, resep_obat_aturan_pakai
- **Expected Result**: Rekam medis dan resep obat berhasil ditambahkan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Dokter Menambah Rekam Medis (Janji Temu Sudah Punya Rekam Medis)
- **Class**: `Dokter\RekamMedisController`
- **Method**: `store()`
- **Data Input**: Janji temu yang sudah punya rekam medis
- **Expected Result**: Redirect back dengan error, rekam medis tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Dokter Membuka Form Edit Rekam Medis
- **Class**: `Dokter\RekamMedisController`
- **Method**: `edit($id)`
- **Data Input**: ID rekam medis yang valid dan milik dokter ini
- **Expected Result**: Menampilkan form edit dengan data rekam medis terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Dokter Update Rekam Medis (Valid)
- **Class**: `Dokter\RekamMedisController`
- **Method**: `update()`
- **Data Input**: Data valid: diagnosa, tindakan, catatan, biaya
- **Expected Result**: Rekam medis berhasil diupdate, redirect back dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Dokter Update Rekam Medis (Bukan Miliknya)
- **Class**: `Dokter\RekamMedisController`
- **Method**: `update()`
- **Data Input**: ID rekam medis milik dokter lain
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Dokter Hapus Rekam Medis
- **Class**: `Dokter\RekamMedisController`
- **Method**: `destroy($id)`
- **Data Input**: ID rekam medis yang valid dan milik dokter ini
- **Expected Result**: Rekam medis berhasil dihapus, redirect back dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 11: Dokter Export Rekam Medis Ke PDF
- **Class**: `Dokter\RekamMedisController`
- **Method**: `export($id)`
- **Data Input**: ID rekam medis yang valid
- **Expected Result**: File PDF berhasil didownload dengan nama "Rekam_Medis_{id}.pdf"
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 5. Dokter\JadwalPraktekController

#### Test Case 1: Dokter Melihat Jadwal Praktek
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `index()`
- **Data Input**: User dokter login
- **Expected Result**: Menampilkan jadwal praktek yang akan datang, dikelompokkan berdasarkan hari
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Membuka Form Tambah Jadwal Praktek
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `create()`
- **Data Input**: User dokter login
- **Expected Result**: Menampilkan form untuk menambah jadwal praktek
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Dokter Menambah Jadwal Praktek (Valid)
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Data valid: tanggal (>= today), jam_mulai, jam_selesai (after jam_mulai), status
- **Expected Result**: Jadwal praktek berhasil ditambahkan, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Dokter Menambah Jadwal Praktek (Tanggal Kemarin)
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Tanggal sebelum hari ini
- **Expected Result**: Validation error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Dokter Menambah Jadwal Praktek (Konflik Waktu)
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Jadwal bertabrakan dengan jadwal yang sudah ada
- **Expected Result**: Redirect back dengan error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Dokter Menambah Jadwal Praktek (Duplikat)
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `store()`
- **Data Input**: Tanggal dan jam_mulai sama dengan jadwal yang sudah ada
- **Expected Result**: Redirect back dengan error, jadwal tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Dokter Membuka Form Edit Jadwal Praktek
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `edit($id)`
- **Data Input**: ID jadwal yang valid dan milik dokter ini
- **Expected Result**: Menampilkan form edit dengan data jadwal terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Dokter Update Jadwal Praktek (Valid)
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `update()`
- **Data Input**: Data valid dengan ID yang ada
- **Expected Result**: Jadwal praktek berhasil diupdate, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Dokter Hapus Jadwal Praktek
- **Class**: `Dokter\JadwalPraktekController`
- **Method**: `destroy($id)`
- **Data Input**: ID jadwal yang valid dan milik dokter ini
- **Expected Result**: Jadwal praktek berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 6. Dokter\ResepObatController

#### Test Case 1: Dokter Melihat Daftar Resep Obat
- **Class**: `Dokter\ResepObatController`
- **Method**: `index()`
- **Data Input**: User dokter login
- **Expected Result**: Menampilkan daftar master obat, statistik obat tersedia, dan semua resep obat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Dokter Menambah Resep Obat (Valid)
- **Class**: `Dokter\ResepObatController`
- **Method**: `store()`
- **Data Input**: Data valid: rekam_medis_id, nama_obat, jumlah, dosis, aturan_pakai
- **Expected Result**: Resep obat berhasil ditambahkan, redirect ke index dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Dokter Menambah Resep Obat (Rekam Medis Tidak Ada)
- **Class**: `Dokter\ResepObatController`
- **Method**: `store()`
- **Data Input**: rekam_medis_id tidak ada di database
- **Expected Result**: Validation error, resep tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Dokter Membuka Form Tambah Master Obat
- **Class**: `Dokter\ResepObatController`
- **Method**: `create()`
- **Data Input**: User dokter login
- **Expected Result**: Menampilkan form untuk menambah master obat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Dokter Menambah Master Obat (Valid)
- **Class**: `Dokter\ResepObatController`
- **Method**: `storeMasterObat()`
- **Data Input**: Data valid: nama_obat (unique), satuan, dosis_default, aturan_pakai_default, deskripsi
- **Expected Result**: Master obat berhasil ditambahkan, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Dokter Menambah Master Obat (Nama Duplikat)
- **Class**: `Dokter\ResepObatController`
- **Method**: `storeMasterObat()`
- **Data Input**: Nama obat sudah ada di database
- **Expected Result**: Validation error, master obat tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Dokter Membuka Form Edit Resep Obat
- **Class**: `Dokter\ResepObatController`
- **Method**: `edit($id)`
- **Data Input**: ID resep obat yang valid dan milik dokter ini
- **Expected Result**: Menampilkan form edit dengan data resep terisi
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Dokter Edit Resep Obat (Bukan Miliknya)
- **Class**: `Dokter\ResepObatController`
- **Method**: `edit($id)`
- **Data Input**: ID resep obat milik dokter lain
- **Expected Result**: Redirect ke index dengan error
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 9: Dokter Update Resep Obat (Valid)
- **Class**: `Dokter\ResepObatController`
- **Method**: `update()`
- **Data Input**: Data valid dengan ID resep yang valid dan milik dokter ini
- **Expected Result**: Resep obat berhasil diupdate, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 10: Dokter Hapus Resep Obat
- **Class**: `Dokter\ResepObatController`
- **Method**: `destroy($id)`
- **Data Input**: ID resep obat yang valid dan milik dokter ini
- **Expected Result**: Resep obat berhasil dihapus, redirect ke index
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 11: Dokter Hapus Resep Obat (Bukan Miliknya)
- **Class**: `Dokter\ResepObatController`
- **Method**: `destroy($id)`
- **Data Input**: ID resep obat milik dokter lain
- **Expected Result**: Redirect ke index dengan error
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

## C. CONTROLLER PASIEN

### 1. Pasien\PasienController

#### Test Case 1: Pasien Mengakses Dashboard
- **Class**: `Pasien\PasienController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search (optional)
- **Expected Result**: Menampilkan dashboard dengan daftar dokter tersedia, janji temu mendatang, dan janji temu confirmed
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Pasien Mencari Dokter
- **Class**: `Pasien\PasienController`
- **Method**: `index()`
- **Data Input**: Request dengan parameter search = 'nama dokter'
- **Expected Result**: Menampilkan dokter yang namanya atau spesialisasinya mengandung keyword
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Pasien Melihat Detail Dokter
- **Class**: `Pasien\PasienController`
- **Method**: `detailDokter($id)`
- **Data Input**: ID dokter yang valid, parameter tanggal (optional)
- **Expected Result**: Menampilkan detail dokter dengan jadwal praktek 7 hari ke depan, dan jam tersedia jika tanggal dipilih
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Pasien Membuat Janji Temu (Valid)
- **Class**: `Pasien\PasienController`
- **Method**: `store()`
- **Data Input**: Data valid: dokter_id, pasien_id, tanggal, jam_mulai, keluhan, foto_gigi (image), status = 'pending'
- **Expected Result**: Janji temu berhasil dibuat, foto tersimpan, redirect ke dashboard dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Pasien Membuat Janji Temu (Jam Sudah Terpakai)
- **Class**: `Pasien\PasienController`
- **Method**: `store()`
- **Data Input**: Jam yang sudah ada janji temu dengan status pending/confirmed/completed
- **Expected Result**: Redirect back dengan error, janji temu tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Pasien Membuat Janji Temu (Jam Tidak Ada Di Jadwal)
- **Class**: `Pasien\PasienController`
- **Method**: `store()`
- **Data Input**: Jam yang tidak ada dalam jadwal praktek dokter
- **Expected Result**: Redirect back dengan error, janji temu tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Pasien Membuat Janji Temu (Foto Bukan Image)
- **Class**: `Pasien\PasienController`
- **Method**: `store()`
- **Data Input**: File foto_gigi bukan format image
- **Expected Result**: Validation error, janji temu tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 8: Pasien Membuat Janji Temu (Foto Terlalu Besar)
- **Class**: `Pasien\PasienController`
- **Method**: `store()`
- **Data Input**: File foto_gigi > 2048 KB
- **Expected Result**: Validation error, janji temu tidak tersimpan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 2. Pasien\JanjiTemuController

#### Test Case 1: Pasien Melihat Daftar Janji Temu
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `show()`
- **Data Input**: Request dengan parameter status (default: 'pending')
- **Expected Result**: Menampilkan daftar janji temu pasien dengan status tertentu, dengan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Pasien Melihat Detail Janji Temu
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `index($id)`
- **Data Input**: ID janji temu yang valid dan milik pasien ini
- **Expected Result**: Menampilkan detail janji temu dengan format tanggal Indonesia
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Pasien Melihat Detail Janji Temu (Bukan Miliknya)
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `index($id)`
- **Data Input**: ID janji temu milik pasien lain
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Pasien Membatalkan Janji Temu (Status Pending)
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `cancel()`
- **Data Input**: ID janji temu dengan status 'pending'
- **Expected Result**: Status janji temu menjadi 'canceled', redirect ke index dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Pasien Membatalkan Janji Temu (Status Confirmed)
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `cancel()`
- **Data Input**: ID janji temu dengan status 'confirmed'
- **Expected Result**: Status janji temu menjadi 'canceled', redirect ke index dengan pesan success
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 6: Pasien Membatalkan Janji Temu (Status Completed)
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `cancel()`
- **Data Input**: ID janji temu dengan status 'completed'
- **Expected Result**: Redirect ke index dengan error, janji temu tidak bisa dibatalkan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 7: Pasien Membatalkan Janji Temu (Status Canceled)
- **Class**: `Pasien\JanjiTemuController`
- **Method**: `cancel()`
- **Data Input**: ID janji temu dengan status 'canceled'
- **Expected Result**: Redirect ke index dengan error, janji temu tidak bisa dibatalkan
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 3. Pasien\RekamMedisController

#### Test Case 1: Pasien Melihat Daftar Rekam Medis
- **Class**: `Pasien\RekamMedisController`
- **Method**: `index()`
- **Data Input**: User pasien login
- **Expected Result**: Menampilkan daftar rekam medis pasien dengan pagination
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Pasien Melihat Detail Rekam Medis
- **Class**: `Pasien\RekamMedisController`
- **Method**: `detail($id)`
- **Data Input**: ID rekam medis yang valid dan milik pasien ini
- **Expected Result**: Menampilkan detail rekam medis dengan data dokter dan resep obat
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Pasien Melihat Detail Rekam Medis (Bukan Miliknya)
- **Class**: `Pasien\RekamMedisController`
- **Method**: `detail($id)`
- **Data Input**: ID rekam medis milik pasien lain
- **Expected Result**: Error 404 Not Found
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Pasien Export Rekam Medis Ke PDF
- **Class**: `Pasien\RekamMedisController`
- **Method**: `export($id)`
- **Data Input**: ID rekam medis yang valid dan milik pasien ini
- **Expected Result**: File PDF berhasil didownload dengan nama "Rekam_Medis_{id}.pdf"
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 5: Pasien Export Rekam Medis Ke PDF (Bukan Miliknya)
- **Class**: `Pasien\RekamMedisController`
- **Method**: `export($id)`
- **Data Input**: ID rekam medis milik pasien lain
- **Expected Result**: Error 403 Forbidden
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

### 4. Pasien\ResepObatController

#### Test Case 1: Pasien Melihat Resep Obat
- **Class**: `Pasien\ResepObatController`
- **Method**: `show($rekam_id)`
- **Data Input**: ID rekam medis yang valid dan milik pasien ini
- **Expected Result**: Menampilkan resep obat dari rekam medis tersebut
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 2: Pasien Melihat Resep Obat (Bukan Miliknya)
- **Class**: `Pasien\ResepObatController`
- **Method**: `show($rekam_id)`
- **Data Input**: ID rekam medis milik pasien lain
- **Expected Result**: Error 403 Forbidden
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 3: Pasien Export Resep Obat Ke PDF
- **Class**: `Pasien\ResepObatController`
- **Method**: `export($rekam_id)`
- **Data Input**: ID rekam medis yang valid dan milik pasien ini
- **Expected Result**: File PDF berhasil didownload dengan nama "Resep_Obat_{id}.pdf"
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

#### Test Case 4: Pasien Export Resep Obat Ke PDF (Bukan Miliknya)
- **Class**: `Pasien\ResepObatController`
- **Method**: `export($rekam_id)`
- **Data Input**: ID rekam medis milik pasien lain
- **Expected Result**: Error 403 Forbidden
- **Actual Result**: [Isi saat pengujian]
- **Status**: Pending

---

## CATATAN PENGUJIAN

### Status Pengujian:
- **Pending**: Belum dilakukan pengujian
- **Pass**: Pengujian berhasil, hasil sesuai expected
- **Fail**: Pengujian gagal, hasil tidak sesuai expected
- **Skip**: Pengujian dilewati (tidak relevan atau tidak bisa diuji)

### Cara Mengisi Actual Result:
1. Jalankan test case sesuai Data Input/Test Case
2. Catat hasil yang didapat (response, error message, dll)
3. Bandingkan dengan Expected Result
4. Isi Status dengan Pass/Fail/Skip

### Tips Pengujian:
- Pastikan database sudah diisi dengan data dummy yang cukup
- Test positive case (data valid) dan negative case (data invalid)
- Test edge case (boundary values, null values, dll)
- Test authorization (akses user yang tidak berhak)
- Test validation (input tidak valid)
- Test error handling (ID tidak ada, dll)

---

**Total Test Case: 150+ skenario pengujian**

**Dibuat:** [Tanggal Pembuatan]  
**Diperbarui:** [Tanggal Update]



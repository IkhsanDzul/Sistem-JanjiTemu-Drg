# PENJELASAN SISTEM ADMIN - DENTATIME
## Dokumentasi Lengkap untuk Presentasi

---

## 1. TEKNOLOGI YANG DIGUNAKAN

### Framework Backend

#### **Laravel Framework: Versi 12.0**
Aplikasi ini dibangun menggunakan **Laravel Framework versi 12.0**, yang merupakan framework PHP modern dengan fitur-fitur terbaru. Laravel 12 menggunakan PHP 8.2+ dan mendukung fitur-fitur seperti:
- Eloquent ORM untuk database operations
- Blade templating engine untuk views
- Artisan CLI untuk development tools
- Middleware untuk request filtering
- Route model binding untuk clean URLs

**Source Code `composer.json`:**
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "barryvdh/laravel-dompdf": "^3.1",
        "maatwebsite/excel": "^3.1"
    }
}
```

#### **PHP: Versi 8.2+**
PHP 8.2 menyediakan:
- Improved performance dengan JIT compiler
- Union types dan named arguments
- Match expressions
- Constructor property promotion

#### **Database: MySQL/MariaDB**
Database menggunakan MySQL/MariaDB dengan Eloquent ORM yang menyediakan:
- Active Record pattern
- Query builder yang powerful
- Relationship management (hasOne, hasMany, belongsTo, belongsToMany)
- Migration system untuk version control database

### Frontend Framework & Tools

#### **Tailwind CSS: Versi 3.1.0**
Utility-first CSS framework yang memungkinkan styling cepat dengan class utilities. Menggunakan JIT (Just-In-Time) compiler untuk optimalisasi.

**Source Code `package.json`:**
```json
{
    "devDependencies": {
        "tailwindcss": "^3.1.0",
        "@tailwindcss/forms": "^0.5.2",
        "@tailwindcss/vite": "^4.0.0"
    }
}
```

**Konfigurasi `tailwind.config.js`:**
```javascript
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#005248',
                secondary: '#FFA700',
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
```

#### **Alpine.js: Versi 3.4.2**
JavaScript framework ringan untuk interaktivitas tanpa build step. Digunakan untuk:
- Toggle sidebar mobile
- Dropdown menus
- Form interactions
- Reactive data binding

**Penggunaan di Blade:**
```blade
<div x-data="{ open: false }" @click="open = !open">
    <div x-show="open">Content</div>
</div>
```

#### **Vite: Versi 7.0.7**
Build tool modern yang menggantikan Laravel Mix. Menyediakan:
- Hot Module Replacement (HMR) untuk development
- Fast builds dengan esbuild
- Optimized production builds

**Source Code `vite.config.js`:**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

#### **PostCSS & Autoprefixer**
- **PostCSS**: CSS processor untuk transform CSS dengan plugins
- **Autoprefixer**: Menambahkan vendor prefixes otomatis untuk browser compatibility

### Plugins & Packages

#### **1. barryvdh/laravel-dompdf (v3.1)**
Package untuk generate PDF dari HTML/Blade templates.

**Penggunaan:**
```php
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('admin.rekam-medis.pdf', $data);
$pdf->setPaper('a4', 'portrait');
return $pdf->download('rekam-medis.pdf');
```

**Fitur:**
- Convert HTML/Blade ke PDF
- Support CSS styling
- Custom paper size dan orientation
- Download atau stream PDF

#### **2. maatwebsite/excel (v3.1)**
Package untuk export data ke Excel menggunakan PhpSpreadsheet.

**Penggunaan:**
```php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasienExport;

return Excel::download(
    new PasienExport($data),
    'laporan-pasien.xlsx'
);
```

**Fitur:**
- Export ke .xlsx, .xls, .csv
- Import dari Excel
- Styling cells (colors, borders, fonts)
- Multiple sheets
- Custom headers dan footers

#### **3. laravel/breeze (v2.3)**
Authentication scaffolding yang menyediakan:
- Login/Register pages
- Password reset
- Email verification
- Session management
- CSRF protection

**Routes yang disediakan:**
```php
// routes/auth.php (auto-generated)
Route::get('/login', [AuthenticatedSessionController::class, 'create']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
```

#### **4. @tailwindcss/forms (v0.5.2)**
Plugin untuk styling form elements dengan Tailwind utilities.

#### **5. @tailwindcss/vite (v4.0.0)**
Plugin untuk integrasi Tailwind CSS dengan Vite build system.

---

## 2. DATABASE SCHEMA SISTEM ADMIN

### Struktur Database (Relasi dari Awal hingga Akhir)

Sistem menggunakan **UUID** sebagai primary key untuk semua tabel (kecuali `roles`), yang memberikan keamanan lebih baik dan menghindari masalah dengan auto-increment. Semua relasi menggunakan **foreign key constraints** dengan cascade delete untuk menjaga integritas data.

#### **Tabel `roles`** (Tabel Master)

Tabel ini menyimpan role/level akses dalam sistem. Setiap user memiliki satu role.

**Migration File: `database/migrations/2025_11_05_035222_role.php`**
```php
Schema::create('roles', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('nama_role');
});
```

**Data Seeder:**
- `id: 'admin'` → Admin sistem
- `id: 'dokter'` → Dokter
- `id: 'pasien'` → Pasien

**Model Relationship:**
```php
// app/Models/Role.php
public function users()
{
    return $this->hasMany(User::class, 'role_id', 'id');
}
```

#### **Tabel `users`** (Tabel Utama)

Tabel ini adalah tabel pusat untuk semua user dalam sistem (admin, dokter, pasien). Menggunakan **polymorphic relationship** pattern dimana satu user bisa menjadi admin, dokter, atau pasien berdasarkan `role_id`.

**Migration File: `database/migrations/2025_11_05_035233_user.php`**
```php
Schema::create('users', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('role_id');
    $table->string('nik', 16)->unique()->nullable();
    $table->string('nama_lengkap', 100);
    $table->string('email')->unique();
    $table->string('password');
    $table->string('foto_profil')->nullable();
    $table->text('alamat')->nullable();
    $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
    $table->date('tanggal_lahir')->nullable();
    $table->string('nomor_telp', 20)->nullable();
    $table->timestamps();
    
    $table->foreign('role_id')
          ->references('id')
          ->on('roles')
          ->onDelete('cascade')
          ->onUpdate('cascade');
});
```

**Model: `app/Models/User.php`**
```php
class User extends Authenticatable
{
    use HasUuids; // UUID sebagai primary key
    
    protected $fillable = [
        'id', 'role_id', 'nik', 'nama_lengkap', 'email', 'password',
        'foto_profil', 'alamat', 'jenis_kelamin', 'tanggal_lahir', 'nomor_telp'
    ];
    
    // Relasi polymorphic
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id', 'id');
    }
    
    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'user_id', 'id');
    }
    
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }
}
```

**Relasi**: Satu user memiliki satu role (admin, dokter, atau pasien), dan bisa memiliki relasi ke salah satu tabel: `admin`, `dokter`, atau `pasien`.

#### **Tabel `admin`** (Tabel Admin)
- `id` (UUID, primary key)
- `user_id` (string, foreign key → `users.id`)

**Relasi**: Satu admin memiliki satu user

#### **Tabel `pasien`** (Tabel Pasien)

Tabel ini menyimpan data khusus pasien yang tidak ada di tabel `users`.

**Migration File: `database/migrations/2025_11_05_035328_pasien.php`**
```php
Schema::create('pasien', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('user_id');
    $table->string('alergi')->nullable();
    $table->string('golongan_darah', 5)->notnull();
    $table->string('riwayat_penyakit', 100)->notnull();
    
    $table->foreign('user_id')
          ->references('id')
          ->on('users');
    // Note: Tidak ada cascade delete untuk mencegah accidental deletion
});
```

**Model: `app/Models/Pasien.php`**
```php
class Pasien extends Model
{
    use HasUuids;
    
    protected $table = 'pasien';
    public $timestamps = false; // Tabel ini tidak memiliki timestamps
    
    protected $fillable = [
        'id', 'user_id', 'alergi', 'golongan_darah', 'riwayat_penyakit'
    ];
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    // Relasi ke JanjiTemu (one-to-many)
    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'pasien_id', 'id');
    }
    
    // Relasi ke RekamMedis melalui JanjiTemu (has-many-through)
    public function rekamMedis()
    {
        return $this->hasManyThrough(
            RekamMedis::class,
            JanjiTemu::class,
            'pasien_id',      // Foreign key di janji_temu
            'janji_temu_id',  // Foreign key di rekam_medis
            'id',             // Local key di pasien
            'id'              // Local key di janji_temu
        );
    }
}
```

**Relasi**: 
- Satu pasien memiliki satu user (belongsTo)
- Satu pasien memiliki banyak janji temu (hasMany)
- Satu pasien memiliki banyak rekam medis melalui janji temu (hasManyThrough)

#### **Tabel `dokter`** (Tabel Dokter)

Tabel ini menyimpan data khusus dokter seperti STR, spesialisasi, dan status ketersediaan.

**Migration File: `database/migrations/2025_11_05_035331_dokter.php`**
```php
Schema::create('dokter', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('user_id');
    $table->string('no_str', 50)->unique(); // Nomor STR harus unique
    $table->string('pendidikan')->notnull();
    $table->string('pengalaman_tahun', 100)->notnull();
    $table->string('spesialisasi_gigi', 100)->notnull();
    $table->enum('status', ['tersedia', 'tidak tersedia'])->notnull();
    
    $table->foreign('user_id')
          ->references('id')
          ->on('users');
});
```

**Model: `app/Models/Dokter.php`**
```php
class Dokter extends Model
{
    use HasUuids;
    
    protected $table = 'dokter';
    public $timestamps = false;
    
    protected $fillable = [
        'id', 'user_id', 'no_str', 'pendidikan', 
        'pengalaman_tahun', 'spesialisasi_gigi', 'status'
    ];
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    // Relasi ke JadwalPraktek (one-to-many)
    public function jadwalPraktek()
    {
        return $this->hasMany(JadwalPraktek::class, 'dokter_id', 'id');
    }
    
    // Relasi ke JanjiTemu (one-to-many)
    public function janjiTemu()
    {
        return $this->hasMany(JanjiTemu::class, 'dokter_id', 'id');
    }
}
```

**Relasi**: 
- Satu dokter memiliki satu user (belongsTo)
- Satu dokter memiliki banyak jadwal praktek (hasMany)
- Satu dokter memiliki banyak janji temu (hasMany)

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

#### **Diagram Alur Relasi (Simplified)**
```
roles → users → admin/pasien/dokter
dokter → jadwal_praktek
pasien + dokter → janji_temu → rekam_medis → resep_obat
master_obat (referensi untuk resep_obat)
```

#### **Penjelasan Detail Alur Relasi Database**

##### **1. Alur Hierarki User & Role (Autentikasi & Authorization)**

**`roles` → `users` → `admin` / `pasien` / `dokter`**

**Penjelasan:**
- **Tabel `roles`** adalah tabel master yang menyimpan 3 jenis role: `admin`, `dokter`, dan `pasien`
- **Tabel `users`** adalah tabel pusat yang menyimpan data umum semua user (admin, dokter, pasien)
  - Setiap user memiliki `role_id` yang merujuk ke tabel `roles`
  - Data yang disimpan: NIK, nama lengkap, email, password, foto profil, alamat, jenis kelamin, tanggal lahir, nomor telepon
  - Foreign key: `role_id` → `roles.id` (cascade delete/update)
- **Tabel `admin`, `pasien`, `dokter`** adalah tabel khusus yang menyimpan data spesifik untuk masing-masing role
  - Setiap tabel memiliki `user_id` yang merujuk ke `users.id`
  - **Tabel `admin`**: Hanya menyimpan `user_id` (data lengkap ada di `users`)
  - **Tabel `pasien`**: Menyimpan data medis pasien (alergi, golongan darah, riwayat penyakit)
  - **Tabel `dokter`**: Menyimpan data profesional dokter (no. STR, pendidikan, pengalaman, spesialisasi, status)

**Relasi:**
- `roles` **hasMany** `users` (satu role memiliki banyak user)
- `users` **belongsTo** `roles` (satu user memiliki satu role)
- `users` **hasOne** `admin` / `pasien` / `dokter` (satu user bisa menjadi salah satu: admin, pasien, atau dokter)
- `admin` / `pasien` / `dokter` **belongsTo** `users` (satu admin/pasien/dokter memiliki satu user)

**Contoh Alur:**
```
1. Sistem membuat role "dokter" di tabel roles
2. User baru mendaftar dengan role_id = "dokter"
3. Data user disimpan di tabel users (nama, email, password, dll)
4. Data khusus dokter disimpan di tabel dokter (no_str, spesialisasi, dll)
5. Relasi: users.id = dokter.user_id
```

##### **2. Alur Jadwal Praktek Dokter**

**`dokter` → `jadwal_praktek`**

**Penjelasan:**
- **Tabel `jadwal_praktek`** menyimpan jadwal ketersediaan dokter untuk praktek
- Setiap jadwal memiliki `dokter_id` yang merujuk ke `dokter.id`
- Data yang disimpan: tanggal, jam mulai, jam selesai, status (available/booked)
- Foreign key: `dokter_id` → `dokter.id` (cascade delete/update)

**Relasi:**
- `dokter` **hasMany** `jadwal_praktek` (satu dokter memiliki banyak jadwal praktek)
- `jadwal_praktek` **belongsTo** `dokter` (satu jadwal praktek dimiliki oleh satu dokter)

**Contoh Alur:**
```
1. Dokter dengan id "abc-123" dibuat di tabel dokter
2. Admin membuat jadwal praktek untuk dokter tersebut:
   - Tanggal: 2025-01-15
   - Jam: 08:00 - 12:00
   - Status: available
3. Data disimpan di jadwal_praktek dengan dokter_id = "abc-123"
4. Jika dokter dihapus, semua jadwal prakteknya otomatis terhapus (cascade delete)
```

##### **3. Alur Janji Temu (Core Business Process)**

**`pasien` + `dokter` → `janji_temu`**

**Penjelasan:**
- **Tabel `janji_temu`** adalah tabel inti yang menghubungkan pasien dan dokter untuk membuat janji temu
- Setiap janji temu memiliki:
  - `pasien_id` yang merujuk ke `pasien.id`
  - `dokter_id` yang merujuk ke `dokter.id`
- Data yang disimpan: tanggal, jam mulai, jam selesai, foto gigi (keluhan), keluhan, status (pending/confirmed/completed/canceled)
- Foreign keys: 
  - `pasien_id` → `pasien.id` (cascade delete/update)
  - `dokter_id` → `dokter.id` (cascade delete/update)

**Relasi:**
- `pasien` **hasMany** `janji_temu` (satu pasien bisa membuat banyak janji temu)
- `dokter` **hasMany** `janji_temu` (satu dokter bisa menerima banyak janji temu)
- `janji_temu` **belongsTo** `pasien` (satu janji temu dimiliki oleh satu pasien)
- `janji_temu` **belongsTo** `dokter` (satu janji temu ditangani oleh satu dokter)

**Contoh Alur:**
```
1. Pasien dengan id "pasien-001" membuat janji temu
2. Pasien memilih dokter dengan id "dokter-001"
3. Data janji temu disimpan:
   - pasien_id = "pasien-001"
   - dokter_id = "dokter-001"
   - tanggal = 2025-01-15
   - jam_mulai = 09:00
   - keluhan = "Sakit gigi geraham"
   - status = "pending"
4. Jika pasien dihapus, semua janji temunya otomatis terhapus (cascade delete)
5. Jika dokter dihapus, semua janji temunya otomatis terhapus (cascade delete)
```

##### **4. Alur Rekam Medis & Resep Obat (Medical Records)**

**`janji_temu` → `rekam_medis` → `resep_obat`**

**Penjelasan:**

**A. Rekam Medis:**
- **Tabel `rekam_medis`** menyimpan hasil pemeriksaan dokter setelah janji temu selesai
- Setiap rekam medis memiliki `janji_temu_id` yang merujuk ke `janji_temu.id`
- Data yang disimpan: diagnosa, tindakan, catatan, biaya
- Foreign key: `janji_temu_id` → `janji_temu.id` (cascade delete/update)
- **Relasi One-to-One**: Satu janji temu hanya memiliki satu rekam medis

**B. Resep Obat:**
- **Tabel `resep_obat`** menyimpan resep obat yang diberikan dokter setelah pemeriksaan
- Setiap resep obat memiliki:
  - `rekam_medis_id` yang merujuk ke `rekam_medis.id`
  - `dokter_id` yang merujuk ke `dokter.id` (untuk tracking dokter yang meresepkan)
- Data yang disimpan: tanggal resep, nama obat, jumlah, dosis, aturan pakai
- Foreign keys:
  - `rekam_medis_id` → `rekam_medis.id` (cascade delete/update)
  - `dokter_id` → `dokter.id` (cascade delete/update)
- **Relasi One-to-Many**: Satu rekam medis bisa memiliki banyak resep obat

**Relasi:**
- `janji_temu` **hasOne** `rekam_medis` (satu janji temu memiliki satu rekam medis)
- `rekam_medis` **belongsTo** `janji_temu` (satu rekam medis dimiliki oleh satu janji temu)
- `rekam_medis` **hasMany** `resep_obat` (satu rekam medis bisa memiliki banyak resep obat)
- `resep_obat` **belongsTo** `rekam_medis` (satu resep obat dimiliki oleh satu rekam medis)
- `resep_obat` **belongsTo** `dokter` (satu resep obat dibuat oleh satu dokter)

**Contoh Alur Lengkap:**
```
1. Janji temu dengan id "janji-001" dibuat (status: "pending")
2. Dokter mengkonfirmasi → status menjadi "confirmed"
3. Pasien datang, dokter melakukan pemeriksaan → status menjadi "completed"
4. Dokter membuat rekam medis:
   - janji_temu_id = "janji-001"
   - diagnosa = "Karies gigi geraham"
   - tindakan = "Tambal gigi"
   - biaya = 500000
5. Dokter menambahkan resep obat ke rekam medis:
   - rekam_medis_id = "rekam-001"
   - dokter_id = "dokter-001"
   - nama_obat = "Paracetamol"
   - jumlah = 10
   - dosis = 500
   - aturan_pakai = "3x1 sehari setelah makan"
6. Jika janji temu dihapus, rekam medis dan resep obat otomatis terhapus (cascade delete)
```

##### **5. Master Obat (Reference Data)**

**`master_obat` (referensi untuk `resep_obat`)**

**Penjelasan:**
- **Tabel `master_obat`** adalah tabel referensi/master data yang menyimpan informasi standar tentang obat-obatan
- Tabel ini **TIDAK memiliki foreign key** ke `resep_obat`, melainkan digunakan sebagai **referensi** saat membuat resep
- Data yang disimpan: nama obat (unique), satuan (mg/ml/tablet), dosis default, aturan pakai default, deskripsi, status aktif
- **Relasi Logis (bukan database constraint)**: 
  - `resep_obat.nama_obat` bisa merujuk ke `master_obat.nama_obat`
  - Saat dokter membuat resep, bisa memilih dari `master_obat` atau input manual
  - Jika memilih dari master, dosis dan aturan pakai default bisa diambil dari `master_obat`

**Contoh Alur:**
```
1. Admin menambahkan obat ke master_obat:
   - nama_obat = "Paracetamol 500mg"
   - satuan = "mg"
   - dosis_default = 500
   - aturan_pakai_default = "3x1 sehari setelah makan"
2. Dokter membuat resep obat:
   - Bisa memilih "Paracetamol 500mg" dari master_obat
   - Sistem otomatis mengisi dosis_default dan aturan_pakai_default
   - Dokter bisa mengubah jika diperlukan
3. Data disimpan di resep_obat dengan nama_obat = "Paracetamol 500mg"
```

#### **Ringkasan Cascade Delete (Data Integrity)**

Untuk menjaga integritas data, sistem menggunakan **cascade delete** pada foreign key:

1. **Hapus Role** → Semua user dengan role tersebut terhapus → Semua admin/pasien/dokter terkait terhapus
2. **Hapus User** → Tidak otomatis hapus admin/pasien/dokter (tidak ada cascade), tapi data menjadi orphan
3. **Hapus Pasien** → Semua janji temu terhapus → Semua rekam medis terhapus → Semua resep obat terhapus
4. **Hapus Dokter** → Semua jadwal praktek terhapus → Semua janji temu terhapus → Semua rekam medis terhapus → Semua resep obat terhapus
5. **Hapus Janji Temu** → Rekam medis terhapus → Semua resep obat terhapus
6. **Hapus Rekam Medis** → Semua resep obat terhapus

#### **Diagram Relasi Lengkap (ERD Simplified)**

```
┌─────────┐
│  roles  │
└────┬────┘
     │ 1
     │
     │ N
┌────▼────┐
│  users  │
└────┬────┘
     │ 1
     │
     ├─────────┬─────────┐
     │ 1        │ 1        │ 1
┌────▼───┐ ┌───▼────┐ ┌───▼────┐
│ admin  │ │ pasien │ │ dokter │
└────────┘ └────┬───┘ └───┬─────┘
                │         │
                │ N       │ N
                │         │
                │         ├──────────┐
                │         │          │
                │         │ N        │ N
                │         │          │
         ┌──────▼─────────▼──┐      │
         │   janji_temu      │      │
         └──────┬────────────┘      │
                │ 1                 │
                │                   │
                │ N                 │
         ┌──────▼────────────┐      │
         │  rekam_medis      │      │
         └──────┬────────────┘      │
                │ 1                 │
                │                   │
                │ N                 │
         ┌──────▼────────────┐      │
         │   resep_obat      │◄─────┘
         └──────────────────┘
                │
                │ (referensi logis)
                │
         ┌──────▼────────────┐
         │  master_obat       │
         └───────────────────┘
                │
                │ N
         ┌──────▼────────────┐
         │ jadwal_praktek    │
         └───────────────────┘
```

---

## 3. LAYOUT FRONTEND & TAILWIND CSS

### Struktur Layout Admin

#### **Layout Utama** (`layouts/admin.blade.php`)

**Source Code Lengkap:**

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Admin') - DentaTime</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts - Vite untuk build assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Component -->
        <x-admin-sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
            <!-- Header Component -->
            <x-admin-header :title="$title ?? 'Dashboard'" />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6" style="background-color: #f9fafb;">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
```

**Penjelasan:**
- **Blade Components**: Menggunakan `<x-admin-sidebar />` dan `<x-admin-header />` untuk reusable components
- **Alpine.js**: `x-data="{ sidebarOpen: false }"` untuk state management sidebar
- **Tailwind Classes**: 
  - `flex h-screen` - Flexbox layout dengan tinggi full screen
  - `lg:ml-64` - Margin kiri 256px di desktop untuk sidebar
  - `overflow-hidden` - Prevent scroll pada container
  - `overflow-y-auto` - Vertical scroll pada main content
- **Vite Integration**: `@vite()` directive untuk load compiled CSS dan JS
- **CSRF Token**: Meta tag untuk AJAX requests

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

**Source Code Lengkap:**

**File: `app/Http/Controllers/Admin/JanjiTemuController.php`**

#### **Method `index()` - Daftar Janji Temu**

```php
public function index(Request $request)
{
    // Eager loading untuk menghindari N+1 query problem
    $query = JanjiTemu::with(['pasien.user', 'dokter.user']);

    // Filter berdasarkan status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan tanggal
    if ($request->has('tanggal') && $request->tanggal != '') {
        $query->whereDate('tanggal', $request->tanggal);
    }

    // Filter berdasarkan bulan
    if ($request->has('bulan') && $request->bulan != '') {
        $query->whereMonth('tanggal', $request->bulan)
              ->whereYear('tanggal', Carbon::now()->year);
    }

    // Search menggunakan whereHas untuk relasi nested
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->whereHas('pasien.user', function($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%");
        })->orWhereHas('dokter.user', function($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%");
        });
    }

    // Sorting dengan default created_at desc
    $sortBy = $request->get('sort_by', 'created_at');
    $sortOrder = $request->get('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);

    // Pagination 15 per halaman
    $janjiTemu = $query->paginate(15);

    // Statistik untuk filter (dihitung terpisah untuk performa)
    $totalPending = JanjiTemu::where('status', 'pending')->count();
    $totalConfirmed = JanjiTemu::where('status', 'confirmed')->count();
    $totalCompleted = JanjiTemu::where('status', 'completed')->count();
    $totalCanceled = JanjiTemu::where('status', 'canceled')->count();

    return view('admin.janji-temu.index', compact(
        'janjiTemu', 'totalPending', 'totalConfirmed', 
        'totalCompleted', 'totalCanceled'
    ))->with('title', 'Kelola Janji Temu');
}
```

**Penjelasan:**
- **Eager Loading**: Menggunakan `with()` untuk load relasi sekaligus, menghindari N+1 query problem
- **Dynamic Query**: Query builder yang fleksibel untuk filter dan search
- **Pagination**: Menggunakan Laravel pagination untuk performa dan UX yang baik
- **Statistik**: Dihitung terpisah untuk menghindari query yang kompleks

#### **Method `show($id)` - Detail Janji Temu**

```php
public function show($id)
{
    // Load dengan relasi lengkap termasuk rekam medis dan resep obat
    $janjiTemu = JanjiTemu::with([
        'pasien.user', 
        'dokter.user', 
        'rekamMedis.resepObat'
    ])->findOrFail($id);

    return view('admin.janji-temu.show', compact('janjiTemu'))
        ->with('title', 'Detail Janji Temu');
}
```

**Penjelasan:**
- **Nested Eager Loading**: Load relasi bertingkat (`rekamMedis.resepObat`)
- **findOrFail**: Otomatis return 404 jika tidak ditemukan

#### **Method `updateStatus()` - Update Status**

```php
public function updateStatus(Request $request, $id)
{
    // Validasi status harus salah satu dari enum values
    $request->validate([
        'status' => 'required|in:pending,confirmed,completed,canceled'
    ]);

    $janjiTemu = JanjiTemu::findOrFail($id);
    $janjiTemu->status = $request->status;
    $janjiTemu->save();

    return redirect()->route('admin.janji-temu.show', $id)
        ->with('success', 'Status janji temu berhasil diperbarui.');
}
```

**Penjelasan:**
- **Validation**: Memastikan status yang diinput valid
- **Mass Assignment Protection**: Menggunakan `fill()` atau assign langsung
- **Flash Message**: Menggunakan session flash untuk notifikasi

---

## 5. MANAJEMEN PASIEN (CRUD)

### Fitur CRUD Pasien

#### **1. CREATE (Tambah Pasien)**

**Route:** 
- `GET /admin/pasien/create` → Form tambah pasien
- `POST /admin/pasien` → Simpan data pasien

**Source Code Controller: `app/Http/Controllers/Admin/PasienController.php`**

```php
public function store(StorePasienRequest $request)
{
    // Mulai database transaction untuk memastikan konsistensi
    DB::beginTransaction();
    
    try {
        // Handle upload foto profil
        $fotoProfilPath = null;
        if ($request->hasFile('foto_profil')) {
            // Simpan ke storage/app/public/foto_profil
            $fotoProfilPath = $request->file('foto_profil')
                ->store('foto_profil', 'public');
        }

        // Buat user baru dengan UUID
        $user = User::create([
            'id' => Str::uuid(), // Generate UUID
            'role_id' => 'pasien',
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nomor_telp' => $request->nomor_telp,
            'alamat' => $request->alamat,
            'foto_profil' => $fotoProfilPath,
        ]);

        // Buat data pasien dengan user_id dari user yang baru dibuat
        $pasien = Pasien::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'alergi' => $request->alergi,
            'golongan_darah' => $request->golongan_darah,
            'riwayat_penyakit' => $request->riwayat_penyakit,
        ]);

        // Commit transaction jika semua berhasil
        DB::commit();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');

    } catch (\Exception $e) {
        // Rollback jika ada error
        DB::rollBack();
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
}
```

**Form Request Validation: `app/Http/Requests/Admin/StorePasienRequest.php`**

```php
public function rules(): array
{
    return [
        // Data User
        'nik' => 'required|string|size:16|unique:users,nik',
        'nama_lengkap' => 'required|string|max:100',
        'email' => 'required|email|max:50|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'jenis_kelamin' => 'required|in:L,P',
        'tanggal_lahir' => 'required|date|before:today',
        'nomor_telp' => 'required|string|max:20',
        'alamat' => 'required|string',
        
        // Data Pasien
        'alergi' => 'nullable|string|max:255',
        'golongan_darah' => 'nullable|string|max:3|in:A,B,AB,O',
        'riwayat_penyakit' => 'nullable|string|max:500',
        
        // Foto Profil
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
}
```

**Penjelasan Proses:**
1. **Form Request Validation**: Validasi otomatis sebelum masuk ke controller
2. **File Upload**: Menggunakan Laravel Storage untuk upload foto
3. **Password Hashing**: Menggunakan `Hash::make()` untuk keamanan
4. **UUID Generation**: Menggunakan `Str::uuid()` untuk generate unique ID
5. **Database Transaction**: Memastikan jika ada error, semua perubahan di-rollback
6. **Error Handling**: Try-catch untuk handle exception dengan graceful error message

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

**Source Code Controller:**

```php
public function destroy($id)
{
    DB::beginTransaction();
    
    try {
        $pasien = Pasien::with('user')->findOrFail($id);
        $user = $pasien->user;
        
        // Validasi: Cek apakah pasien memiliki janji temu aktif
        $janjiTemuAktif = $pasien->janjiTemu()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        if ($janjiTemuAktif > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus pasien yang masih memiliki janji temu aktif.');
        }

        // Simpan user_id sebelum menghapus pasien
        $userId = $user->id;
        
        // Hapus pasien terlebih dahulu
        // Cascade delete akan menghapus janji_temu, rekam_medis, resep_obat
        $pasien->delete();
        
        // Cek apakah user masih digunakan di tabel lain
        $userStillUsed = Dokter::where('user_id', $userId)->exists() ||
                       Admin::where('user_id', $userId)->exists();
        
        // Jika user tidak digunakan lagi, hapus user
        if (!$userStillUsed) {
            // Hapus foto profil dari storage jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->delete();
        }

        DB::commit();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
    }
}
```

**Penjelasan:**
- **Business Logic Validation**: Cek janji temu aktif sebelum hapus
- **Cascade Delete**: Foreign key dengan cascade delete akan otomatis hapus data terkait
- **File Cleanup**: Hapus foto profil dari storage saat hapus user
- **Safety Check**: Cek apakah user masih digunakan sebelum hapus
- **Transaction Safety**: Semua operasi dalam transaction untuk konsistensi

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

**Source Code Validasi di Controller:**

```php
public function store(Request $request, $dokterId)
{
    // Validasi input
    $request->validate([
        'tanggal' => 'required|date|after_or_equal:today',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'status' => 'required|in:available,booked',
    ]);

    // Cek duplikasi: jadwal dengan tanggal dan jam yang sama
    $jadwalExist = JadwalPraktek::where('dokter_id', $dokterId)
        ->where('tanggal', $request->tanggal)
        ->where('jam_mulai', $request->jam_mulai)
        ->first();

    if ($jadwalExist) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah ada.');
    }

    // Cek konflik waktu: overlap dengan jadwal lain
    $konflik = JadwalPraktek::where('dokter_id', $dokterId)
        ->where('tanggal', $request->tanggal)
        ->where('status', 'available')
        ->where(function($q) use ($request) {
            // Cek apakah jam baru overlap dengan jadwal yang ada
            $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
              ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
              ->orWhere(function($q2) use ($request) {
                  // Cek jika jadwal baru berada di dalam jadwal yang ada
                  $q2->where('jam_mulai', '<=', $request->jam_mulai)
                     ->where('jam_selesai', '>=', $request->jam_selesai);
              });
        })
        ->exists();

    if ($konflik) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Jadwal bertabrakan dengan jadwal yang sudah ada.');
    }

    // Simpan jadwal jika valid
    JadwalPraktek::create([
        'id' => Str::uuid(),
        'dokter_id' => $dokterId,
        'tanggal' => $request->tanggal,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.dokter.jadwal-praktek.index', $dokterId)
        ->with('success', 'Jadwal praktek berhasil ditambahkan.');
}
```

**Penjelasan Validasi:**
- **Tanggal:** `after_or_equal:today` - Tidak boleh tanggal kemarin
- **Jam Selesai:** `after:jam_mulai` - Harus setelah jam mulai
- **Duplikasi Check:** Query untuk cek jadwal dengan tanggal dan jam yang sama
- **Konflik Check:** Query kompleks untuk cek overlap waktu dengan 3 kondisi:
  1. Jam mulai baru berada di antara jam mulai-selesai jadwal yang ada
  2. Jam selesai baru berada di antara jam mulai-selesai jadwal yang ada
  3. Jadwal baru sepenuhnya berada di dalam jadwal yang ada

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

**Method `export($id)` - Export PDF:**

```php
public function export($id)
{
    // Load rekam medis dengan semua relasi yang diperlukan
    $rekam = RekamMedis::with([
        'janjiTemu.dokter.user',
        'janjiTemu.pasien.user',
        'resepObat'
    ])->findOrFail($id);

    // Generate PDF menggunakan DomPDF
    $pdf = Pdf::loadView('admin.rekam-medis.pdf', compact('rekam'))
        ->setPaper('A4', 'portrait');

    // Download dengan nama file yang dinamis
    return $pdf->download("Rekam_Medis_{$rekam->id}.pdf");
}
```

**Penjelasan:**
- **Eager Loading**: Load semua relasi sekaligus untuk menghindari N+1 query
- **Blade Template**: Menggunakan view `admin.rekam-medis.pdf` untuk template PDF
- **Paper Setting**: A4 Portrait untuk format standar
- **Dynamic Filename**: Nama file menggunakan ID rekam medis

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

**Source Code Controller: `app/Http/Controllers/Admin/LaporanController.php`**

```php
/**
 * Export ke PDF menggunakan DomPDF
 */
private function exportPDF($view, $data, $filename)
{
    // Load view Blade dan convert ke PDF
    $pdf = Pdf::loadView($view, $data);
    
    // Set ukuran kertas A4 Portrait
    $pdf->setPaper('a4', 'portrait');
    
    // Enable local file access untuk gambar/asset
    $pdf->setOption('enable-local-file-access', true);
    
    // Download file dengan nama yang ditentukan
    return $pdf->download($filename);
}
```

**Contoh Penggunaan di Method Laporan:**

```php
public function pasien(Request $request)
{
    $format = $request->get('format', 'view');
    
    // Query data pasien
    $pasien = Pasien::with('user')->get();
    
    // Hitung statistik
    $totalPasien = $pasien->count();
    $pasienLaki = $pasien->filter(function($p) {
        return $p->user->jenis_kelamin === 'L';
    })->count();
    
    $data = [
        'title' => 'Laporan Jumlah Pasien Terdaftar',
        'totalPasien' => $totalPasien,
        'pasienLaki' => $pasienLaki,
        'pasien' => $pasien,
        'tanggalLaporan' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
    ];

    // Jika format PDF, export ke PDF
    if ($format === 'pdf') {
        return $this->exportPDF('admin.laporan.pasien-pdf', $data, 'laporan-pasien.pdf');
    }
    
    // Default: return view
    return view('admin.laporan.pasien', $data);
}
```

**Template PDF: `resources/views/admin/rekam-medis/pdf.blade.php`**

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekam Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #005248;
        }
        .header h1 {
            color: #005248;
            font-size: 20px;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #005248;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>REKAM MEDIS</h1>
        <p>DentaTime - Sistem Manajemen Klinik Gigi</p>
    </div>
    
    <!-- Content rekam medis -->
    <div class="section">
        <div class="label">Pasien:</div>
        <div class="value">{{ $rekam->janjiTemu->pasien->user->nama_lengkap }}</div>
    </div>
    
    <!-- ... konten lainnya ... -->
</body>
</html>
```

**Penjelasan:**
- **Blade Template**: Menggunakan Blade untuk generate HTML
- **Inline CSS**: CSS ditulis inline karena DomPDF tidak support external CSS dengan baik
- **Paper Size**: A4 Portrait untuk format standar
- **File Download**: Browser akan download file PDF langsung

#### **2. Export Excel**

**Library:** `maatwebsite/excel` (v3.1) menggunakan PhpSpreadsheet

**Source Code Export Class: `app/Exports/PasienExport.php`**

```php
namespace App\Exports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class PasienExport implements 
    FromCollection, 
    WithHeadings, 
    WithStyles, 
    WithTitle, 
    WithMapping, 
    WithColumnWidths, 
    WithCustomStartCell, 
    WithEvents
{
    protected $pasien;
    protected $totalPasien;
    protected $pasienLaki;
    protected $pasienPerempuan;

    public function __construct($pasien, $totalPasien, $pasienLaki, $pasienPerempuan)
    {
        $this->pasien = $pasien;
        $this->totalPasien = $totalPasien;
        $this->pasienLaki = $pasienLaki;
        $this->pasienPerempuan = $pasienPerempuan;
    }

    // Data source
    public function collection()
    {
        return $this->pasien;
    }

    // Start cell untuk data (bukan A1)
    public function startCell(): string
    {
        return 'A10'; // Data dimulai dari baris 10
    }

    // Header kolom
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Jenis Kelamin',
            'Tanggal Daftar'
        ];
    }

    // Mapping data per row
    public function map($p): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $p->user->nama_lengkap ?? '-',
            $p->user->email ?? '-',
            $p->user->nomor_telp ?? '-',
            $p->user->jenis_kelamin ?? '-',
            $p->user->created_at ? Carbon::parse($p->user->created_at)->format('d/m/Y') : '-',
        ];
    }

    // Lebar kolom
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 25,  // Nama
            'C' => 30,  // Email
            'D' => 15,  // Telepon
            'E' => 15,  // Jenis Kelamin
            'F' => 15,  // Tanggal
        ];
    }

    // Event untuk custom styling
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Tambahkan header laporan di baris 1-3
                $sheet->setCellValue('A1', 'LAPORAN JUMLAH PASIEN TERDAFTAR');
                $sheet->setCellValue('A2', 'DentaTime - Sistem Manajemen Klinik Gigi');
                $sheet->setCellValue('A3', 'Tanggal Laporan: ' . Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY'));
                
                // Statistik di baris 5-8
                $sheet->setCellValue('A5', 'STATISTIK');
                $sheet->setCellValue('A6', 'Total Pasien: ' . $this->totalPasien);
                $sheet->setCellValue('A7', 'Pasien Laki-laki: ' . $this->pasienLaki);
                $sheet->setCellValue('A8', 'Pasien Perempuan: ' . $this->pasienPerempuan);
                
                // Merge cells untuk header
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');
                
                // Style header laporan
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                
                // Style header table (baris 10)
                $sheet->getStyle('A10:F10')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '005248'], // Hijau tua
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
                
                // Border untuk semua data
                $lastRow = $sheet->getHighestRow();
                if ($lastRow >= 11) {
                    $sheet->getStyle('A10:F' . $lastRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000'],
                            ],
                        ],
                    ]);
                }
            },
        ];
    }
}
```

**Penggunaan di Controller:**

```php
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PasienExport;

public function pasien(Request $request)
{
    $format = $request->get('format', 'view');
    
    // ... query data ...
    
    if ($format === 'excel') {
        return Excel::download(
            new PasienExport($pasien, $totalPasien, $pasienLaki, $pasienPerempuan),
            'laporan-pasien-' . date('Y-m-d') . '.xlsx'
        );
    }
    
    // ... return view ...
}
```

**Penjelasan:**
- **Interface Implementation**: Export class implement multiple interfaces untuk fitur lengkap
- **Custom Start Cell**: Data dimulai dari A10, baris 1-9 untuk header dan statistik
- **Event System**: Menggunakan `AfterSheet` event untuk styling setelah sheet dibuat
- **PhpSpreadsheet API**: Menggunakan PhpSpreadsheet untuk styling cells, borders, colors
- **File Format**: `.xlsx` (Excel 2007+) dengan nama file dinamis berdasarkan tanggal

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

**Method `update()` - Update Profile:**

```php
public function update(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'alamat' => 'nullable|string',
        'nomor_telp' => 'nullable|string|max:15',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|string',
        'foto_profil' => 'nullable|image|max:2048',
    ]);

    $user = $request->user(); // Get authenticated user

    // Update data user
    $user->update([
        'nama_lengkap' => $request->nama_lengkap,
        'email' => $request->email,
        'nik' => $request->nik,
        'alamat' => $request->alamat,
        'nomor_telp' => $request->nomor_telp,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
    ]);

    // Handle upload foto profil
    if ($request->hasFile('foto_profil')) {
        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }
        
        // Simpan foto baru
        $path = $request->file('foto_profil')->store('foto_profil', 'public');
        $user->update(['foto_profil' => $path]);
    }

    return back()->with('status', 'Profile updated');
}
```

**Penjelasan:**
- **Auth Helper**: `$request->user()` untuk get authenticated user
- **File Storage**: Menggunakan Laravel Storage untuk upload file
- **File Cleanup**: Hapus foto lama sebelum simpan foto baru
- **Flash Message**: Menggunakan session flash untuk notifikasi

**Validasi:**
- Nama lengkap: required, string, max 255
- Alamat: nullable, string
- Nomor telp: nullable, string, max 15
- Tanggal lahir: nullable, date
- Jenis kelamin: nullable, string
- Foto profil: nullable, image, max 2048 KB (2MB)

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


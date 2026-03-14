# Blueprint Sistem Informasi Sekolah

## 1. Ringkasan Tujuan

Dokumen ini menjadi blueprint awal untuk membangun aplikasi **Sistem Informasi Sekolah** berbasis:

- **Laravel 12**
- **Filament 4**
- **PostgreSQL** sebagai database utama
- **Spatie Media Library** untuk manajemen file
- **Filament Shield** untuk role dan permission
- **TinyMCE editor** untuk editor dokumen/surat
- **Template surat custom** buatan sendiri
- **Export PDF** untuk dokumen kompleks

Fokus aplikasi mengikuti topologi pada gambar:

1. **Modul Guru**
2. **Modul Siswa**
3. **Modul Surat Dinas**

Target utama sistem:

- memusatkan data guru, siswa, kelas, alumni, dan surat dalam satu panel admin
- memisahkan akses berdasarkan peran admin, operator guru, dan operator siswa
- menyediakan pembuatan surat dengan template dinamis, penomoran otomatis, lampiran, tanda tangan, dan export PDF
- menjaga struktur data tetap rapi sehingga mudah dikembangkan ke integrasi Dapodik
- mendukung struktur akademik untuk sekolah **SMA** maupun **SMK**
- memungkinkan tipe sekolah dipilih saat pertama kali sistem dikonfigurasi
- menggunakan **Bahasa Indonesia** sebagai bahasa utama admin panel Filament, dashboard, form, notifikasi, dan dokumen

---

## 2. Rekomendasi Stack Implementasi

### Backend dan Admin Panel

- **Laravel 12** sebagai fondasi aplikasi
- **Filament 4** sebagai admin panel dan CRUD builder
- **PostgreSQL** sebagai database utama aplikasi
- **Filament Shield** untuk generate permission berbasis resource/page/widget
- bahasa antarmuka admin menggunakan **Bahasa Indonesia**

### File Management

- **spatie/laravel-medialibrary**
- Alasan:
  - cocok untuk menyimpan logo sekolah, tanda tangan pejabat, lampiran surat, foto guru, foto siswa, dan dokumen pendukung
  - mendukung disk lokal atau object storage
  - relasi file lebih fleksibel daripada kolom file manual

### Editor Dokumen

- **TinyMCE** di dalam form Filament
- Dipakai untuk:
  - isi badan surat
  - catatan internal
  - template surat berbasis placeholder

### Rekomendasi PDF

Untuk kebutuhan **dokumen kompleks** yang memuat **logo, tabel, tanda tangan, header/footer, dan layout surat resmi**, keputusan yang dipakai pada blueprint ini adalah:

- **spatie/laravel-pdf** dipanggil dari custom action di Filament

Alasan:

- kualitas render HTML/CSS lebih baik untuk dokumen surat formal
- lebih aman untuk layout kompleks dibanding generator PDF ringan berbasis HTML lama
- tetap mudah dipakai dari Blade template surat custom

Catatan penting:

- Ini **bukan plugin Filament murni**, tetapi paling cocok untuk kualitas output
- Integrasi dilakukan lewat **Filament Action** yang merender **Blade template surat** lalu mengekspor PDF
- Opsi fallback seperti `barryvdh/laravel-dompdf` tetap memungkinkan, tetapi **bukan pilihan utama proyek ini**

Standar implementasi PDF:

- **Standar final:** Filament Action + Blade Template + `spatie/laravel-pdf`
- Pola ini dipakai untuk semua surat resmi yang membutuhkan layout kompleks dan hasil cetak rapi

### Rekomendasi Export Excel

Untuk kebutuhan export data tabel ke **Excel/XLSX** pada setiap modul, keputusan yang dipakai pada blueprint ini adalah:

- **Filament ExportAction** untuk export cepat dari tabel/resource
- **maatwebsite/excel** untuk kebutuhan export Excel yang lebih fleksibel, custom, dan bertahap

Alasan:

- Filament 4 sudah menyediakan export action bawaan untuk `CSV` dan `XLSX`
- `maatwebsite/excel` tetap menjadi pilihan kuat untuk export terstruktur, multi-sheet, heading custom, dan format data yang lebih kompleks
- kombinasi ini cocok untuk kebutuhan admin harian maupun export laporan formal

Standar implementasi Excel:

- export standar dari halaman resource menggunakan **Filament ExportAction**
- export lanjutan atau laporan custom menggunakan **Laravel Excel (`maatwebsite/excel`)**
- format utama yang diprioritaskan adalah **XLSX**, dengan opsi **CSV** bila dibutuhkan
- export default sebaiknya mengikuti **kolom yang sedang tampil/visible pada table Filament**
- jika user mengubah toggle kolom pada tabel, hasil export default ikut menyesuaikan tampilan tersebut
- untuk laporan tertentu, sistem tetap boleh menambahkan kolom wajib yang tidak sedang tampil bila dibutuhkan oleh proses bisnis

### Kolom Export Default per Modul

#### Modul Guru

`TeacherProfileResource`

- `full_name`
- `employee_number`
- `nip`
- `nuptk`
- `gender`
- `phone`
- `email`
- `employment_status`
- `teacher_status`
- `join_date`
- `is_active`

`SubjectResource`

- `name`
- `code`
- `education_level`
- `school_type_scope`
- `subject_group`
- `major`
- `is_productive`

`TeachingAssignmentResource`

- `teacher_name`
- `subject_name`
- `classroom_name`
- `academic_year`
- `semester`
- `hours_per_week`
- `assignment_status`
- `start_date`
- `end_date`

#### Modul Siswa

`StudentProfileResource`

- `full_name`
- `nis`
- `nisn`
- `registration_number`
- `major`
- `gender`
- `phone`
- `guardian_name`
- `guardian_phone`
- `entry_year`
- `student_status`
- `is_alumni`

`PpdbRegistrationResource`

- `registration_number`
- `registration_date`
- `student_name`
- `origin_school`
- `entry_path`
- `status`
- `documents_verified_at`

`ClassroomResource`

- `name`
- `grade_level`
- `major`
- `academic_year`
- `homeroom_teacher`
- `capacity`
- `is_active`

`AlumniProfileResource`

- `student_name`
- `nis`
- `major`
- `graduation_year`
- `certificate_number`
- `destination_after_graduation`

#### Modul Surat

`LetterResource`

- `letter_number`
- `agenda_number`
- `category`
- `subject`
- `direction`
- `letter_date`
- `status`
- `sender_name`
- `recipient_name`
- `signed_by`
- `created_by`

`IncomingLetterDispositionResource`

- `letter_number`
- `from_user`
- `to_user`
- `instruction`
- `due_date`
- `status`
- `read_at`
- `completed_at`

#### Master Data

`MajorResource`

- `name`
- `code`
- `short_name`
- `department_group`
- `is_active`

`AcademicYearResource`

- `name`
- `start_date`
- `end_date`
- `is_active`

`LetterTemplateResource`

- `name`
- `code`
- `category`
- `paper_size`
- `orientation`
- `is_active`

Catatan:

- kolom export default mengikuti filter aktif dan kolom yang sedang visible di table Filament
- jika ada kolom wajib laporan, kolom tersebut dapat ditambahkan sebagai override export khusus
- export default dapat diperluas menjadi export custom sesuai kebutuhan sekolah

### Format Nama File Export

Format nama file yang disarankan:

- `data-guru-{tanggal}.xlsx`
- `penugasan-mengajar-{tanggal}.xlsx`
- `data-siswa-{tanggal}.xlsx`
- `ppdb-{tanggal}.xlsx`
- `kelas-rombel-{tanggal}.xlsx`
- `alumni-{tanggal}.xlsx`
- `surat-{kategori}-{tanggal}.xlsx`
- `template-surat-{tanggal}.xlsx`

Catatan:

- `{tanggal}` menggunakan format lokal yang aman untuk nama file, misalnya `2026-03-14`
- nama file dapat ditambah suffix filter aktif, misalnya `data-siswa-xi-ipa-2026-03-14.xlsx`

---

## 3. Modul Aplikasi

## 3.1 Modul Guru

Cakupan:

- profil/biodata guru
- identitas referensi guru seperti NUPTK, NIP, dan ID Dapodik
- jabatan guru
- mata pelajaran
- tugas tambahan, misalnya wali kelas

Fitur utama:

- master data guru
- status aktif/nonaktif
- riwayat penugasan
- mapping guru ke mata pelajaran
- penugasan guru mengajar per kelas/rombel
- mapping guru ke jabatan
- mapping guru ke kelas sebagai wali kelas
- penyimpanan dokumen guru
- export data guru ke Excel

Catatan kompatibilitas SMA/SMK:

- level pertama: guru dipetakan ke mapel yang dapat diampu
- level kedua: guru ditugaskan mengajar mapel tersebut pada rombel tertentu
- pola ini kompatibel untuk SMA maupun SMK karena rombel bisa terkait jurusan, peminatan, atau program keahlian
- filter mapel, rombel, dan struktur akademik harus mengikuti `school_type` aktif

## 3.2 Modul Siswa

Cakupan:

- data PPDB sebagai data induk siswa
- data siswa aktif
- data struktur akademik seperti jurusan, peminatan, atau program keahlian
- pengelompokan ke kelas X, XI, XII sesuai struktur sekolah
- data wali kelas per rombel
- data alumni

Fitur utama:

- master data siswa
- master data struktur akademik
- pembagian rombel per tahun ajaran
- riwayat mutasi status siswa
- perpindahan status aktif menjadi alumni
- dokumen siswa
- export data siswa ke Excel

Catatan kompatibilitas SMA/SMK:

- struktur akademik pada siswa harus mengikuti `school_type` aktif
- pada SMA, istilah dapat tampil sebagai `Jurusan` atau `Peminatan`
- pada SMK, istilah dapat tampil sebagai `Program Keahlian` atau `Jurusan`
- validasi field siswa dan rombel sebaiknya menyesuaikan tipe sekolah saat konfigurasi awal

## 3.3 Modul Surat Dinas

Kategori guru:

- surat tugas
- surat keterangan
- surat keluar
- surat masuk

Kategori siswa:

- surat dispensasi
- surat keterangan

Fitur utama:

- template surat
- penomoran otomatis
- editor isi surat
- generate PDF
- export data surat ke Excel
- lampiran file
- tanda tangan pejabat
- log status surat

Catatan kompatibilitas SMA/SMK:

- template surat dapat memakai placeholder yang sama, tetapi pilihan data akademik harus menyesuaikan `school_type`
- label seperti `jurusan`, `peminatan`, atau `program keahlian` pada surat diambil dari konfigurasi aktif sekolah

---

## 4. Peran dan Hak Akses

Struktur role yang disarankan:

- **Super Admin**
- **Admin**
- **Operator Guru**
- **Operator Siswa**
- **Kepala Sekolah**
- **Tata Usaha**

Hak akses ringkas:

- **Super Admin**: akses penuh seluruh modul dan pengaturan
- **Admin**: akses penuh operasional seluruh modul
- **Operator Guru**: kelola modul guru dan surat kategori guru
- **Operator Siswa**: kelola modul siswa dan surat kategori siswa
- **Kepala Sekolah**: review, approval, dan tanda tangan surat tertentu
- **Tata Usaha**: registrasi surat masuk/keluar, verifikasi nomor surat, arsip

Dengan **Filament Shield**, permission dapat dipecah menjadi:

- view any
- view
- create
- update
- delete
- delete any
- approve
- publish
- generate pdf
- manage numbering
- manage templates

---

## 5. Arsitektur Data Utama

Prinsip desain:

- gunakan tabel master untuk data referensi
- gunakan tabel transaksi untuk surat dan penugasan
- gunakan tabel pivot untuk relasi many-to-many
- simpan file di Media Library, bukan menambah banyak kolom file
- semua tabel penting memakai `uuid` atau `bigint unsigned` secara konsisten

Rekomendasi umum:

- pakai `id` bigint untuk kemudahan Filament
- tambahkan `school_id` bila aplikasi berpotensi menjadi multi-sekolah
- semua tabel operasional punya `created_by`, `updated_by` bila perlu audit
- untuk soft delete, gunakan hanya pada tabel master/transaksi yang aman diarsipkan

---

## 6. Struktur Tabel dan Relasi

## 6.1 Tabel Pengguna dan Otorisasi

### `users`

Fungsi:

- akun login semua pengguna internal

Kolom inti:

- `id`
- `name`
- `email`
- `username`
- `password`
- `is_active`
- `last_login_at`
- `email_verified_at`
- `remember_token`
- `created_at`
- `updated_at`

Relasi:

- `users` ke `teacher_profiles`: one-to-one, jika user adalah guru/internal guru
- `users` ke `student_profiles`: opsional, biasanya tidak dipakai kecuali portal siswa
- `users` ke banyak data transaksi sebagai `created_by`, `updated_by`, `approved_by`

### Tabel Shield / Spatie Permission

Tabel standar:

- `roles`
- `permissions`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`

Relasi:

- `users` many-to-many ke `roles`
- `roles` many-to-many ke `permissions`

---

## 6.2 Tabel Master Sekolah

### `schools`

Fungsi:

- profil lembaga untuk kop surat dan identitas sistem

Kolom inti:

- `id`
- `name`
- `school_type`
- `npsn`
- `address`
- `village`
- `district`
- `city`
- `province`
- `postal_code`
- `phone`
- `email`
- `website`
- `principal_name`
- `principal_nip`
- `created_at`
- `updated_at`

Catatan:

- logo sekolah disimpan lewat Media Library
- `school_type` disarankan memakai enum sederhana: `SMA`, `SMK`
- nilai `school_type` menjadi dasar perilaku label, form, dan menu akademik di panel admin
- nilai ini dipilih saat konfigurasi awal aplikasi dan dapat diubah hanya oleh admin tertentu

### `system_settings`

Fungsi:

- menyimpan konfigurasi global aplikasi yang dibutuhkan sejak pertama kali sistem digunakan

Kolom inti:

- `id`
- `key`
- `value` json nullable
- `type`
- `is_public`
- `created_at`
- `updated_at`

Contoh key penting:

- `app_initialized`
- `active_school_id`
- `default_locale`
- `allow_school_type_change`
- `academic_label_overrides`

Catatan:

- tabel ini dipakai untuk wizard konfigurasi awal
- `school_type` tetap menjadi milik `schools`, tetapi status setup dan aturan global disimpan di `system_settings`

### `academic_years`

Fungsi:

- master tahun ajaran

Kolom inti:

- `id`
- `name`
- `start_date`
- `end_date`
- `is_active`
- `created_at`
- `updated_at`

Relasi:

- one-to-many ke `classrooms`
- one-to-many ke `student_class_histories`
- one-to-many ke `letters`

### `semesters`

Fungsi:

- master semester

Kolom inti:

- `id`
- `academic_year_id`
- `name`
- `code`
- `is_active`
- `created_at`
- `updated_at`

Relasi:

- many-to-one ke `academic_years`

---

## 6.3 Modul Guru

### `teacher_profiles`

Fungsi:

- biodata induk guru

Kolom inti:

- `id`
- `user_id` nullable
- `employee_number`
- `nip`
- `nuptk`
- `dapodik_id` nullable
- `full_name`
- `birth_place`
- `birth_date`
- `gender`
- `religion`
- `phone`
- `email`
- `address`
- `education_last`
- `employment_status`
- `teacher_status`
- `join_date`
- `is_active`
- `notes`
- `created_at`
- `updated_at`
- `deleted_at`

Relasi:

- many-to-one ke `users` melalui `user_id`
- many-to-many ke `subjects` melalui `subject_teacher`
- many-to-many ke `positions` melalui `teacher_positions`
- one-to-many ke `additional_assignments`
- one-to-many ke `classrooms` sebagai wali kelas
- polymorphic ke Media Library untuk foto, SK, dan dokumen guru

### `subjects`

Fungsi:

- master mata pelajaran yang dapat dipakai untuk SMA maupun SMK

Kolom inti:

- `id`
- `name`
- `code`
- `education_level`
- `school_type_scope`
- `subject_group`
- `major_id` nullable
- `is_productive` default false
- `description`
- `created_at`
- `updated_at`

Relasi:

- many-to-many ke `teacher_profiles` melalui `subject_teacher`
- many-to-one ke `majors` jika mata pelajaran spesifik jurusan/peminatan/program keahlian
- one-to-many ke `teaching_assignments`

Catatan:

- `school_type_scope` dapat berisi `SMA`, `SMK`, atau `ALL`
- `subject_group` dapat berisi `umum`, `peminatan`, `kejuruan`, `muatan_lokal`, atau kategori lain sesuai kebutuhan sekolah
- untuk SMA, `major_id` bisa dipakai bila mapel terkait jurusan atau peminatan tertentu
- untuk SMK, `major_id` bisa dipakai untuk mapel produktif/program keahlian tertentu

### `subject_teacher`

Fungsi:

- mapping kompetensi atau otorisasi guru terhadap mata pelajaran

Kolom inti:

- `id`
- `teacher_profile_id`
- `subject_id`
- `academic_year_id` nullable
- `competency_notes` nullable
- `notes`

Relasi:

- many-to-one ke `teacher_profiles`
- many-to-one ke `subjects`
- many-to-one ke `academic_years`

Catatan:

- tabel ini menunjukkan bahwa seorang guru dapat mengampu mapel tertentu
- tabel ini belum menunjukkan guru mengajar di kelas mana

### `teaching_assignments`

Fungsi:

- penugasan guru mengajar mata pelajaran tertentu pada kelas/rombel tertentu

Kolom inti:

- `id`
- `teacher_profile_id`
- `subject_id`
- `classroom_id`
- `academic_year_id`
- `semester_id` nullable
- `hours_per_week` nullable
- `assignment_status`
- `start_date` nullable
- `end_date` nullable
- `notes`
- `created_at`
- `updated_at`

Relasi:

- many-to-one ke `teacher_profiles`
- many-to-one ke `subjects`
- many-to-one ke `classrooms`
- many-to-one ke `academic_years`
- many-to-one ke `semesters`

Catatan:

- tabel ini adalah inti pengaturan guru mapel operasional
- mendukung SMA karena guru bisa diassign ke mapel dan rombel jurusan/peminatan tertentu
- mendukung SMK karena guru bisa diassign ke mapel produktif dan rombel program keahlian tertentu

### `positions`

Fungsi:

- master jabatan struktural/fungsional

Kolom inti:

- `id`
- `name`
- `code`
- `type`
- `description`
- `created_at`
- `updated_at`

Contoh data:

- kepala sekolah
- wakil kepala sekolah
- guru mapel
- staf TU

### `teacher_positions`

Fungsi:

- riwayat atau penempatan jabatan guru

Kolom inti:

- `id`
- `teacher_profile_id`
- `position_id`
- `start_date`
- `end_date` nullable
- `is_active`
- `decree_number` nullable
- `notes`

Relasi:

- many-to-one ke `teacher_profiles`
- many-to-one ke `positions`

### `additional_assignments`

Fungsi:

- tugas tambahan guru seperti wali kelas, pembina, koordinator

Kolom inti:

- `id`
- `teacher_profile_id`
- `assignment_type`
- `classroom_id` nullable
- `start_date`
- `end_date` nullable
- `is_active`
- `notes`

Relasi:

- many-to-one ke `teacher_profiles`
- many-to-one ke `classrooms` jika tugas tambahan terkait kelas

---

## 6.4 Modul Siswa

### `majors`

Fungsi:

- master struktur akademik yang dapat dipakai untuk jurusan SMA, peminatan, atau program keahlian SMK

Kolom inti:

- `id`
- `name`
- `code`
- `short_name` nullable
- `department_group` nullable
- `description` nullable
- `is_active`
- `created_at`
- `updated_at`

Contoh data:

- IPA
- IPS
- Bahasa
- Teknik Komputer dan Jaringan
- Rekayasa Perangkat Lunak
- Akuntansi
- Desain Komunikasi Visual

Relasi:

- one-to-many ke `classrooms`
- one-to-many ke `student_profiles`

Catatan:

- Nama tabel tetap `majors` agar implementasi teknis sederhana.
- Di level UI, label bisa dibuat dinamis menjadi `Jurusan`, `Peminatan`, atau `Program Keahlian` sesuai tipe sekolah.
- Perilaku label yang disarankan:
  - `SMA`: tampilkan sebagai `Jurusan` atau `Peminatan`
  - `SMK`: tampilkan sebagai `Program Keahlian` atau `Jurusan`

### `student_profiles`

Fungsi:

- data induk siswa dari PPDB sampai aktif/alumni

Kolom inti:

- `id`
- `nis`
- `nisn`
- `dapodik_id` nullable
- `registration_number` nullable
- `major_id` nullable
- `full_name`
- `birth_place`
- `birth_date`
- `gender`
- `religion`
- `phone`
- `email` nullable
- `address`
- `guardian_name`
- `guardian_phone`
- `entry_year`
- `student_status`
- `ppdb_status`
- `graduation_year` nullable
- `is_alumni`
- `notes`
- `created_at`
- `updated_at`
- `deleted_at`

Relasi:

- many-to-one ke `majors`
- one-to-many ke `student_class_histories`
- one-to-many ke `letters`
- polymorphic ke Media Library untuk foto, KK, akta, ijazah, dan lampiran

### `ppdb_registrations`

Fungsi:

- data asal pendaftaran peserta didik baru

Kolom inti:

- `id`
- `student_profile_id`
- `registration_number`
- `registration_date`
- `origin_school`
- `entry_path`
- `status`
- `documents_verified_at` nullable
- `notes`

Relasi:

- one-to-one atau many-to-one ke `student_profiles`

Catatan:

- jika proses PPDB sudah final, data ini menjadi sumber data induk siswa

### `classrooms`

Fungsi:

- master rombel per tingkat, tahun ajaran, dan struktur akademik sekolah

Kolom inti:

- `id`
- `academic_year_id`
- `major_id`
- `name`
- `grade_level`
- `capacity`
- `homeroom_teacher_id` nullable
- `is_active`
- `created_at`
- `updated_at`

Contoh:

- X-IPA-1
- XI-IPS-2
- X-TKJ-1
- X-RPL-1
- XI-AKL-1
- XII-DKV-2

Relasi:

- many-to-one ke `academic_years`
- many-to-one ke `majors`
- many-to-one ke `teacher_profiles` melalui `homeroom_teacher_id`
- one-to-many ke `student_class_histories`

### `student_class_histories`

Fungsi:

- riwayat penempatan siswa ke kelas

Kolom inti:

- `id`
- `student_profile_id`
- `classroom_id`
- `academic_year_id`
- `semester_id` nullable
- `start_date`
- `end_date` nullable
- `status`
- `notes`

Relasi:

- many-to-one ke `student_profiles`
- many-to-one ke `classrooms`
- many-to-one ke `academic_years`
- many-to-one ke `semesters`

### `alumni_profiles`

Fungsi:

- snapshot alumni bila ingin dipisah dari siswa aktif

Kolom inti:

- `id`
- `student_profile_id`
- `graduation_year`
- `certificate_number` nullable
- `destination_after_graduation` nullable
- `notes`
- `created_at`
- `updated_at`

Relasi:

- one-to-one ke `student_profiles`

Catatan:

- sebenarnya status alumni bisa cukup memakai `student_profiles.is_alumni`
- tabel ini dipakai bila sekolah ingin modul alumni lebih kaya

---

## 6.5 Modul Surat Dinas

### `letter_categories`

Fungsi:

- master kategori surat

Kolom inti:

- `id`
- `name`
- `code`
- `module_scope`
- `direction`
- `description`
- `is_active`

Contoh:

- Surat Tugas
- Surat Keterangan Guru
- Surat Keluar
- Surat Masuk
- Surat Dispensasi
- Surat Keterangan Siswa

Keterangan:

- `module_scope`: `guru`, `siswa`, `umum`
- `direction`: `incoming`, `outgoing`, `internal`

### `letter_templates`

Fungsi:

- template surat custom yang dapat dipilih saat pembuatan surat

Kolom inti:

- `id`
- `letter_category_id`
- `name`
- `code`
- `subject_format`
- `body_template`
- `footer_template` nullable
- `available_variables` json nullable
- `paper_size`
- `orientation`
- `is_active`
- `created_at`
- `updated_at`

Relasi:

- many-to-one ke `letter_categories`

Catatan:

- `body_template` diisi HTML dari TinyMCE
- placeholder contoh:
  - `{{school_name}}`
  - `{{letter_number}}`
  - `{{date_localized}}`
  - `{{teacher_name}}`
  - `{{student_name}}`
  - `{{class_name}}`
  - `{{principal_name}}`

### `letter_number_formats`

Fungsi:

- aturan penomoran otomatis per kategori surat

Kolom inti:

- `id`
- `letter_category_id`
- `name`
- `format_pattern`
- `reset_type`
- `current_sequence`
- `year_format`
- `month_format`
- `is_active`
- `created_at`
- `updated_at`

Contoh `format_pattern`:

- `{{sequence}}/ST/{{month_roman}}/{{year}}`
- `{{sequence}}/SKET/SIS/{{year}}`

Relasi:

- many-to-one ke `letter_categories`

### `letters`

Fungsi:

- tabel transaksi utama surat

Kolom inti:

- `id`
- `letter_category_id`
- `letter_template_id` nullable
- `academic_year_id` nullable
- `number_format_id` nullable
- `letter_number` nullable
- `agenda_number` nullable
- `subject`
- `regarding` nullable
- `direction`
- `letter_date`
- `status`
- `sender_name` nullable
- `recipient_name` nullable
- `recipient_address` nullable
- `reference_number` nullable
- `content_html`
- `content_text` nullable
- `signed_by_teacher_id` nullable
- `approved_by`
- `created_by`
- `approved_at` nullable
- `printed_at` nullable
- `sent_at` nullable
- `received_at` nullable
- `notes` nullable
- `created_at`
- `updated_at`
- `deleted_at`

Relasi:

- many-to-one ke `letter_categories`
- many-to-one ke `letter_templates`
- many-to-one ke `academic_years`
- many-to-one ke `letter_number_formats`
- many-to-one ke `teacher_profiles` melalui `signed_by_teacher_id`
- many-to-one ke `users` melalui `created_by`
- many-to-one ke `users` melalui `approved_by`
- one-to-many ke `letter_recipients`
- one-to-many ke `letter_signatories`
- one-to-many ke `letter_logs`
- polymorphic ke Media Library untuk file PDF hasil generate, lampiran masuk, scan surat, dan dokumen pendukung

### `letter_recipients`

Fungsi:

- daftar penerima surat, terutama jika satu surat ke banyak tujuan

Kolom inti:

- `id`
- `letter_id`
- `recipient_type`
- `teacher_profile_id` nullable
- `student_profile_id` nullable
- `external_name` nullable
- `external_address` nullable
- `notes`

Relasi:

- many-to-one ke `letters`
- many-to-one ke `teacher_profiles`
- many-to-one ke `student_profiles`

### `letter_signatories`

Fungsi:

- daftar penandatangan surat

Kolom inti:

- `id`
- `letter_id`
- `teacher_profile_id`
- `position_name`
- `signature_role`
- `sign_order`
- `is_primary`

Relasi:

- many-to-one ke `letters`
- many-to-one ke `teacher_profiles`

Catatan:

- file tanda tangan tidak disimpan di tabel ini, tetapi pada Media Library milik guru

### `letter_logs`

Fungsi:

- audit trail perubahan status surat

Kolom inti:

- `id`
- `letter_id`
- `status`
- `description`
- `acted_by`
- `acted_at`
- `meta` json nullable

Relasi:

- many-to-one ke `letters`
- many-to-one ke `users` melalui `acted_by`

### `incoming_letter_dispositions`

Fungsi:

- disposisi untuk surat masuk

Kolom inti:

- `id`
- `letter_id`
- `from_user_id`
- `to_user_id`
- `instruction`
- `due_date` nullable
- `status`
- `read_at` nullable
- `completed_at` nullable

Relasi:

- many-to-one ke `letters`
- many-to-one ke `users` melalui `from_user_id`
- many-to-one ke `users` melalui `to_user_id`

---

## 7. Relasi Inti Antar Tabel

Relasi yang paling penting dalam sistem:

1. `users` 1:1 `teacher_profiles`
2. `teacher_profiles` M:N `subjects` melalui `subject_teacher`
3. `teacher_profiles` 1:M `teaching_assignments`
4. `subjects` 1:M `teaching_assignments`
5. `teacher_profiles` M:N `positions` melalui `teacher_positions`
6. `teacher_profiles` 1:M `additional_assignments`
7. `teacher_profiles` 1:M `classrooms` sebagai wali kelas
8. `majors` 1:M `classrooms`
9. `majors` 1:M `student_profiles`
10. `academic_years` 1:M `classrooms`
11. `student_profiles` 1:M `student_class_histories`
12. `classrooms` 1:M `student_class_histories`
13. `student_profiles` 1:1 `alumni_profiles` opsional
14. `letter_categories` 1:M `letter_templates`
15. `letter_categories` 1:M `letter_number_formats`
16. `letter_categories` 1:M `letters`
17. `letter_templates` 1:M `letters`
18. `letters` 1:M `letter_recipients`
19. `letters` 1:M `letter_signatories`
20. `letters` 1:M `letter_logs`
21. Semua entitas penting dapat memiliki banyak file lewat Media Library

---

## 8. Alur Kerja Sistem

## 8.1 Alur Modul Guru

1. Admin atau operator guru menambahkan data guru.
2. Data guru dapat dihubungkan dengan akun user bila guru perlu akses sistem.
3. Guru dipetakan ke mata pelajaran yang dapat diampu melalui `subject_teacher`.
4. Guru kemudian ditugaskan mengajar per kelas/rombel melalui `teaching_assignments`.
5. Guru dipetakan ke jabatan.
6. Jika guru menjadi wali kelas, hubungkan ke `classrooms.homeroom_teacher_id`.
7. Dokumen pendukung guru diunggah lewat Media Library.

## 8.2 Alur Modul Siswa

1. Data PPDB masuk lebih dulu.
2. Setelah valid, data menjadi `student_profiles`.
3. Siswa dapat dipetakan ke struktur akademik sekolah melalui `major_id`.
4. Rombel dibuat per tahun ajaran dan mengikuti kebutuhan SMA atau SMK.
5. Siswa ditempatkan ke rombel melalui `student_class_histories`.
6. Riwayat kelas tidak dihapus, tetapi ditutup dengan `end_date`.
7. Saat lulus, status siswa berubah menjadi alumni dan opsional dibuat `alumni_profiles`.

## 8.3 Alur Modul Surat

1. Admin menentukan kategori surat.
2. Admin membuat template surat.
3. Admin menentukan format nomor surat otomatis.
4. Operator membuat surat baru berdasarkan kategori dan template.
5. Sistem mengisi placeholder dari data guru/siswa/sekolah.
6. Surat direview dan di-approve.
7. Sistem generate PDF final.
8. PDF dan lampiran disimpan di Media Library.
9. Riwayat perubahan status tersimpan di `letter_logs`.

---

## 8.4 Alur Konfigurasi Awal Sistem

1. Saat aplikasi pertama kali dibuka, sistem memeriksa `system_settings.app_initialized`.
2. Jika belum aktif, tampilkan wizard konfigurasi awal.
3. Admin mengisi profil sekolah dasar.
4. Admin memilih `school_type`: `SMA` atau `SMK`.
5. Sistem menyimpan `active_school_id`, `school_type`, `default_locale`, dan pengaturan label akademik.
6. Sistem menyesuaikan label menu, form, filter, dan validasi berdasarkan `school_type`.
7. Setelah konfigurasi selesai, `app_initialized` ditandai aktif.
8. Perubahan `school_type` setelah sistem berjalan sebaiknya dibatasi hanya untuk super admin dan harus melewati validasi dampak data.

---

## 9. Desain Penomoran Surat

Kebutuhan:

- nomor surat otomatis
- bisa berbeda per kategori
- bisa reset per tahun atau per bulan

Contoh desain:

- Surat Tugas: `001/ST/III/2026`
- Surat Keterangan Siswa: `014/SKS/2026`
- Surat Keluar: `122/SKEL/TU/2026`

Logika minimal:

- ambil `letter_number_formats`
- cek `reset_type`
- naikkan `current_sequence`
- render ke format final
- simpan hasil ke `letters.letter_number`

---

## 10. Strategi Template Surat

Rekomendasi:

- standar desain surat menggunakan **custom Blade print view**
- konten dinamis utama disimpan di `letter_templates.body_template`
- untuk layout resmi, gunakan wrapper Blade tunggal agar header/footer konsisten
- proses generate PDF dipanggil dari **Filament Action** agar alur preview, approval, dan export tetap terkontrol

Keputusan implementasi:

- desain surat tidak dibuat langsung di komponen tabel/export sederhana Filament
- layout final surat dirender melalui **custom Blade print view**
- hasil render kemudian dikirim ke generator PDF melalui **action Filament**
- pendekatan ini dipilih karena lebih tangguh untuk dokumen resmi yang memuat kop surat, tabel, logo, tanda tangan, dan struktur layout kompleks

Arsitektur template:

1. **Layout global surat**
   - kop surat
   - margin halaman
   - footer
2. **Body template per kategori**
   - isi surat dari TinyMCE
3. **Data binding**
   - placeholder diganti dari data surat, guru, siswa, sekolah

Contoh placeholder:

- `{{school_name}}`
- `{{school_address}}`
- `{{letter_number}}`
- `{{letter_date}}`
- `{{teacher_name}}`
- `{{student_name}}`
- `{{student_nis}}`
- `{{class_name}}`
- `{{signatory_name}}`
- `{{signatory_position}}`

Catatan bahasa dan format:

- seluruh label surat, nama field admin, dan isi template default menggunakan **Bahasa Indonesia**
- gunakan format tanggal lokal Indonesia pada placeholder seperti `{{date_localized}}`
- gunakan istilah administrasi sekolah yang umum dipakai di Indonesia pada dashboard dan menu

---

## 11. Strategi Media Library

Gunakan collection terpisah agar file rapi:

### Guru

- `teacher-photo`
- `teacher-documents`
- `teacher-signature`

### Siswa

- `student-photo`
- `student-documents`

### Sekolah

- `school-logo`

### Surat

- `letter-attachments`
- `letter-generated-pdf`
- `letter-scans`

Keuntungan:

- file lebih terstruktur
- mudah membatasi jenis file per collection
- mudah menampilkan file terkait di Filament

---

## 12. Struktur Resource Filament yang Disarankan

### Master Data

- `SchoolResource`
- `AcademicYearResource`
- `SemesterResource`
- `MajorResource`
- `SubjectResource`
- `PositionResource`
- `LetterCategoryResource`
- `LetterTemplateResource`
- `LetterNumberFormatResource`

Catatan:

- setiap resource master data sebaiknya menyediakan **ExportAction** untuk export Excel/CSV

### Modul Guru

- `TeacherProfileResource`
- `TeachingAssignmentResource`
- `TeacherPositionRelationManager`
- `TeacherSubjectRelationManager`

Catatan:

- `TeacherProfileResource` dan `TeachingAssignmentResource` sebaiknya mendukung export Excel

### Modul Siswa

- `StudentProfileResource`
- `PpdbRegistrationResource`
- `MajorResource`
- `ClassroomResource`
- `StudentClassHistoryRelationManager`
- `AlumniProfileResource`

Catatan:

- `StudentProfileResource`, `PpdbRegistrationResource`, `ClassroomResource`, dan `AlumniProfileResource` sebaiknya mendukung export Excel

### Modul Surat

- `LetterResource`
- `IncomingLetterDispositionResource`

Catatan:

- `LetterResource` dan `IncomingLetterDispositionResource` sebaiknya mendukung export Excel untuk kebutuhan arsip dan pelaporan

### Sistem

- `UserResource`
- `SystemSettingResource` atau halaman konfigurasi khusus
- Shield role/permission pages

---

## 13. Struktur Menu Filament

Menu disarankan:

- Dashboard
- Master Sekolah
- Modul Guru
- Modul Siswa
- Modul Surat Dinas
- Arsip Dokumen
- Pengaturan Sistem

Catatan menu dinamis:

- jika `school_type = SMA`, submenu `Struktur Akademik` dapat ditampilkan sebagai `Jurusan` atau `Peminatan`
- jika `school_type = SMK`, submenu `Struktur Akademik` dapat ditampilkan sebagai `Program Keahlian` atau `Jurusan`
- nama resource internal tetap bisa memakai `MajorResource` agar kode tidak bercabang terlalu jauh
- seluruh label navigasi, aksi tombol, filter, empty state, dan notifikasi dashboard ditampilkan dalam **Bahasa Indonesia**

Submenu:

- Modul Guru
  - Data Guru
  - Mata Pelajaran
  - Penugasan Mengajar
  - Jabatan
  - Tugas Tambahan
- Modul Siswa
  - Struktur Akademik
  - PPDB
  - Data Siswa
  - Kelas/Rombel
  - Alumni
- Modul Surat Dinas
  - Surat Guru
  - Surat Siswa
  - Surat Masuk
  - Surat Keluar
  - Template Surat
  - Penomoran Surat
- Pengaturan Sistem
  - Konfigurasi Awal
  - Pengaturan Sekolah
  - Pengaturan Bahasa

---

## 14. Tahap Implementasi yang Disarankan

### Fase 1

- autentikasi
- role permission
- profil sekolah
- konfigurasi `school_type`
- tahun ajaran
- data guru
- data mata pelajaran
- data siswa
- kelas dan wali kelas

### Fase 2

- penugasan guru mapel per kelas
- kategori surat
- template surat
- penomoran otomatis
- pembuatan surat guru
- pembuatan surat siswa
- export PDF
- export Excel per modul

### Fase 3

- surat masuk
- disposisi
- arsip digital
- sinkronisasi data eksternal
- dashboard statistik

---

## 14.1 Strategi Konfigurasi SMA dan SMK

Supaya satu codebase bisa melayani SMA dan SMK, tambahkan konfigurasi berbasis `school_type` dari tabel `schools`.

Implementasi yang disarankan:

- tampilkan wizard saat first run aplikasi
- simpan `school_type` di profil sekolah aktif
- buat helper atau service, misalnya `SchoolContext`, untuk membaca tipe sekolah aktif
- gunakan helper tersebut di Filament Resource, Navigation, Form Schema, dan Table column label
- nama tabel dan model internal tetap stabil, sedangkan label UI bisa berubah dinamis
- tetap gunakan **Bahasa Indonesia** sebagai bahasa antarmuka utama untuk kedua tipe sekolah
- seluruh query pilihan data master seperti mapel, struktur akademik, rombel, dan template harus difilter berdasarkan `school_type` atau scope yang sesuai
- validasi create/update pada modul guru, siswa, dan surat harus membaca `school_type` aktif

Contoh perilaku:

- jika `school_type = SMA`
  - label menu `Struktur Akademik` bisa tampil sebagai `Jurusan` atau `Peminatan`
  - contoh rombel: `X-IPA-1`, `XI-IPS-2`
- jika `school_type = SMK`
  - label menu `Struktur Akademik` bisa tampil sebagai `Program Keahlian`
  - contoh rombel: `X-TKJ-1`, `XI-RPL-2`

Keuntungan:

- skema database tetap satu
- resource Filament tetap sedikit
- perbedaan SMA dan SMK cukup ditangani di layer konfigurasi dan UI

Aturan kompatibilitas lintas sistem:

- **Modul Guru**: hanya menampilkan mapel dan penugasan yang sesuai `school_type`
- **Modul Siswa**: label dan validasi struktur akademik menyesuaikan `school_type`
- **Modul Surat**: placeholder akademik menyesuaikan istilah sekolah aktif
- **Dashboard**: statistik akademik dan label widget mengikuti tipe sekolah
- **Master Data**: data yang bertanda `school_type_scope` harus dibatasi sesuai konfigurasi aktif

---

## 15. Catatan Desain Teknis Penting

1. **Jangan simpan file langsung di kolom tabel** selain path internal yang memang diperlukan. Gunakan Media Library.
2. **Pisahkan template dan transaksi surat** agar perubahan template tidak merusak surat lama.
3. **Simpan HTML final surat ke tabel `letters.content_html`** supaya hasil surat historis tetap konsisten walau template berubah.
4. **Tanda tangan pejabat** sebaiknya mengikuti data guru dan disimpan sebagai media terpisah.
5. **Nomor surat harus di-lock setelah approval** agar tidak berubah sesudah PDF final dibuat.
6. **Surat masuk dan surat keluar** tetap memakai tabel `letters` yang sama, dibedakan oleh kategori dan `direction`.
7. **Data alumni** bisa dibuat sederhana dulu dengan flag, lalu dipisah tabel bila kebutuhan berkembang.
8. **Tabel `majors`** dipakai sebagai struktur akademik fleksibel agar blueprint tetap kompatibel untuk SMA maupun SMK.
9. **`school_type` pada tabel `schools`** sebaiknya dibaca sejak awal login panel agar label form, menu, dan validasi akademik bisa menyesuaikan tipe sekolah.
10. **Bahasa antarmuka Filament dan dashboard** sebaiknya dikunci ke **Bahasa Indonesia**, termasuk label resource, aksi tabel, validasi form, notifikasi, dan format tanggal tampilan.
11. **Pengaturan guru mapel** sebaiknya dipisah antara kemampuan mengampu mapel (`subject_teacher`) dan penugasan mengajar nyata per rombel (`teaching_assignments`).
12. **Wizard konfigurasi awal** sebaiknya wajib dijalankan sebelum panel admin dipakai penuh, agar `school_type`, sekolah aktif, bahasa, dan label akademik sudah terkunci dari awal.
13. **Perubahan `school_type` setelah go-live** harus dibatasi dan sebaiknya memicu pemeriksaan dampak data pada mapel, struktur akademik, rombel, dan template surat.
14. **Fitur export Excel** sebaiknya tersedia di setiap modul utama dan mengikuti filter aktif pada tabel/resource agar hasil export konsisten dengan tampilan admin.
15. **Format export data** diprioritaskan ke `XLSX`, sedangkan `CSV` disediakan sebagai opsi ringan untuk kebutuhan interoperabilitas.
16. **Kolom export default** sebaiknya mengikuti kolom yang sedang tampil di table Filament, agar hasil file selaras dengan konteks tampilan admin saat itu.
17. **Database default aplikasi** menggunakan **PostgreSQL**, sehingga desain migration, indexing, dan validasi query sebaiknya mengikuti praktik yang aman untuk PostgreSQL.

---

## 16. Rekomendasi Akhir

Struktur paling stabil untuk proyek ini:

- **Laravel 12** untuk fondasi aplikasi
- **Filament 4** untuk admin panel
- **Filament Shield** untuk kontrol akses
- **Spatie Media Library** untuk semua file
- **TinyMCE** untuk editor template dan isi surat
- **custom Blade print view** untuk layout surat
- **spatie/laravel-pdf** sebagai engine export utama untuk dokumen kompleks
- **Filament ExportAction + maatwebsite/excel** untuk export data Excel per modul

Untuk desain surat, standar final yang dipakai adalah **custom Blade print view** dan generator PDF dipanggil dari **action Filament**. Pendekatan ini lebih tangguh untuk kebutuhan surat resmi sekolah.

---

## 17. Spesifikasi Implementasi Teknis

## 17.1 Paket Composer yang Disarankan

Paket inti:

- `laravel/framework:^12.0`
- `filament/filament:^4.0`
- `ext-pdo_pgsql`
- `bezhansalleh/filament-shield`
- `spatie/laravel-medialibrary`
- `spatie/laravel-pdf`
- `maatwebsite/excel`

Paket pendukung yang disarankan:

- plugin TinyMCE yang kompatibel dengan Filament 4
- package translasi/locale tambahan bila diperlukan untuk Bahasa Indonesia

Catatan:

- plugin editor TinyMCE dipilih yang stabil dengan Filament 4 pada saat implementasi
- koneksi database standar aplikasi menggunakan **PostgreSQL**
- export PDF tetap memakai kombinasi Blade print view + `spatie/laravel-pdf`
- export Excel standar mengandalkan `ExportAction`, sedangkan export kompleks memakai `maatwebsite/excel`

## 17.2 Struktur Folder Aplikasi yang Disarankan

Struktur utama:

```text
app/
  Actions/
    Letters/
    Exports/
  Enums/
  Filament/
    Resources/
    Pages/
    Widgets/
  Models/
  Policies/
  Services/
    School/
    Letters/
    Exports/
    Academic/
  Support/
    Placeholders/
    Formatting/
database/
  migrations/
  seeders/
resources/
  views/
    pdf/
      letters/
        layouts/
        templates/
    filament/
lang/
  id/
```

Pembagian folder service:

- `Services/School`: konteks sekolah aktif, `school_type`, label akademik
- `Services/Letters`: render template, placeholder resolver, nomor surat, generate PDF
- `Services/Exports`: export Excel/CSV, builder kolom visible, penamaan file
- `Services/Academic`: helper rombel, jurusan, mapel, dan validasi SMA/SMK

## 17.3 Model Eloquent yang Disarankan

Model inti:

- `User`
- `School`
- `SystemSetting`
- `AcademicYear`
- `Semester`
- `TeacherProfile`
- `Subject`
- `SubjectTeacher`
- `TeachingAssignment`
- `Position`
- `TeacherPosition`
- `AdditionalAssignment`
- `Major`
- `StudentProfile`
- `PpdbRegistration`
- `Classroom`
- `StudentClassHistory`
- `AlumniProfile`
- `LetterCategory`
- `LetterTemplate`
- `LetterNumberFormat`
- `Letter`
- `LetterRecipient`
- `LetterSignatory`
- `LetterLog`
- `IncomingLetterDisposition`

Trait dan interface yang relevan:

- `InteractsWithMedia` pada model yang menyimpan file
- `HasRoles` pada `User`
- `SoftDeletes` pada model master/transaksi yang perlu arsip

## 17.4 Enum yang Disarankan

Enum aplikasi:

- `SchoolTypeEnum`
- `SubjectGroupEnum`
- `LetterDirectionEnum`
- `LetterStatusEnum`
- `AssignmentStatusEnum`
- `StudentStatusEnum`
- `PpdbStatusEnum`

Manfaat:

- mengurangi magic string di form, filter, dan validasi
- mempermudah sinkronisasi label Bahasa Indonesia di UI

## 17.5 Urutan Pembuatan Migration

Urutan migration yang disarankan:

1. `users`
2. tabel permission/roles
3. `schools`
4. `system_settings`
5. `academic_years`
6. `semesters`
7. `majors`
8. `positions`
9. `subjects`
10. `teacher_profiles`
11. `student_profiles`
12. `ppdb_registrations`
13. `classrooms`
14. `subject_teacher`
15. `teacher_positions`
16. `additional_assignments`
17. `teaching_assignments`
18. `student_class_histories`
19. `alumni_profiles`
20. `letter_categories`
21. `letter_templates`
22. `letter_number_formats`
23. `letters`
24. `letter_recipients`
25. `letter_signatories`
26. `letter_logs`
27. `incoming_letter_dispositions`
28. tabel Media Library

Catatan:

- tabel Media Library mengikuti migration bawaan package Spatie
- foreign key sebaiknya konsisten memakai `cascadeOnUpdate()` dan `nullOnDelete()` atau `restrictOnDelete()` sesuai kebutuhan data

## 17.6 Seeder Awal yang Disarankan

Seeder minimum:

- `RolePermissionSeeder`
- `SchoolTypeSeeder` bila memakai referensi tambahan
- `AcademicYearSeeder`
- `SemesterSeeder`
- `PositionSeeder`
- `LetterCategorySeeder`
- `SystemSettingSeeder`
- `AdminUserSeeder`

Data awal sistem:

- role Super Admin
- role Admin
- role Operator Guru
- role Operator Siswa
- kategori surat default
- contoh format nomor surat
- default locale `id`

## 17.7 Resource Filament Prioritas

Prioritas build tahap awal:

1. `SchoolResource` atau halaman setup sekolah
2. `SystemSettingPage`
3. `UserResource`
4. `TeacherProfileResource`
5. `SubjectResource`
6. `StudentProfileResource`
7. `MajorResource`
8. `ClassroomResource`
9. `TeachingAssignmentResource`
10. `LetterCategoryResource`
11. `LetterTemplateResource`
12. `LetterResource`

Catatan:

- konfigurasi awal bisa lebih tepat dibuat sebagai **custom Filament page** daripada CRUD resource biasa
- `SystemSettingResource` dapat diganti dengan halaman pengaturan terkontrol agar user umum tidak mengakses konfigurasi sensitif

## 17.8 Service dan Action yang Perlu Dibuat

Service utama:

- `SchoolContextService`
- `AcademicLabelService`
- `LetterNumberService`
- `LetterTemplateRenderService`
- `LetterPdfService`
- `LetterPlaceholderService`
- `ExportColumnResolverService`
- `ExportFileNameService`

Action utama:

- `GenerateLetterPdfAction`
- `PreviewLetterPdfAction`
- `ExportVisibleTableAction`
- `InitializeApplicationAction`

Tanggung jawab singkat:

- `SchoolContextService`: membaca sekolah aktif, locale, dan `school_type`
- `AcademicLabelService`: mengubah label `Jurusan`, `Peminatan`, atau `Program Keahlian`
- `LetterTemplateRenderService`: mengganti placeholder template dengan data final
- `LetterPdfService`: merender Blade print view ke PDF dan menyimpan ke Media Library
- `ExportColumnResolverService`: membaca kolom yang visible di table Filament
- `ExportFileNameService`: membentuk nama file export berdasarkan modul dan filter aktif

## 17.9 View dan Template Surat

Struktur view yang disarankan:

```text
resources/views/pdf/letters/layouts/base.blade.php
resources/views/pdf/letters/layouts/with-signature.blade.php
resources/views/pdf/letters/templates/guru/
resources/views/pdf/letters/templates/siswa/
resources/views/pdf/letters/components/
```

Komponen Blade yang disarankan:

- kop surat
- blok identitas surat
- tabel lampiran
- blok tanda tangan
- footer legal/formal

## 17.10 Strategi Localization

Konfigurasi bahasa:

- `config/app.php` menggunakan locale default `id`
- `Carbon::setLocale('id')`
- terjemahan resource, action, filter, validation, dan notification menggunakan Bahasa Indonesia

Area yang wajib diterjemahkan:

- label navigasi Filament
- action tabel
- filter dan placeholder
- pesan validasi
- nama status surat
- nama status siswa

## 17.11 Standar Implementasi Export

Standar export tabel:

- gunakan `ExportAction` pada `table()` resource Filament
- kolom default mengikuti kolom visible di tabel
- file name memakai `ExportFileNameService`
- filter aktif diteruskan ke export query

Standar export laporan custom:

- gunakan class export berbasis `maatwebsite/excel`
- dipakai untuk laporan lintas modul, multi-sheet, atau kebutuhan resmi sekolah

## 17.12 Standar Implementasi Media Library

Aturan media:

- semua upload file melalui collection yang sudah ditentukan
- file PDF final surat disimpan ke collection `letter-generated-pdf`
- signature pejabat/guru disimpan terpisah dari dokumen umum
- gunakan nama file yang konsisten dan aman

## 17.13 Checklist Implementasi Awal

Checklist coding minimum:

1. install paket inti
2. setup Filament panel
3. setup Shield
4. setup locale Indonesia
5. buat migration inti
6. buat seeder role dan admin awal
7. buat wizard konfigurasi awal
8. implementasi `SchoolContextService`
9. bangun resource master akademik
10. bangun resource guru dan siswa
11. bangun template surat + PDF flow
12. bangun export Excel per resource

---

## 18. Draft Migration List

Daftar berikut adalah draft nama file migration yang disarankan agar implementasi Laravel lebih rapi dan mudah diurutkan.

## 18.1 Migration Inti Sistem

```text
0001_01_01_000000_create_users_table.php
0001_01_01_000001_create_cache_table.php
0001_01_01_000002_create_jobs_table.php
2026_01_01_000100_create_permission_tables.php
2026_01_01_000200_create_schools_table.php
2026_01_01_000300_create_system_settings_table.php
2026_01_01_000400_create_academic_years_table.php
2026_01_01_000500_create_semesters_table.php
```

## 18.2 Migration Master Akademik

```text
2026_01_01_000600_create_majors_table.php
2026_01_01_000700_create_positions_table.php
2026_01_01_000800_create_subjects_table.php
```

## 18.3 Migration Modul Guru

```text
2026_01_01_000900_create_teacher_profiles_table.php
2026_01_01_001000_create_subject_teacher_table.php
2026_01_01_001100_create_teacher_positions_table.php
2026_01_01_001200_create_classrooms_table.php
2026_01_01_001300_create_additional_assignments_table.php
2026_01_01_001400_create_teaching_assignments_table.php
```

Catatan:

- `classrooms` diletakkan sebelum `additional_assignments` dan `teaching_assignments` karena dipakai sebagai foreign key

## 18.4 Migration Modul Siswa

```text
2026_01_01_001500_create_student_profiles_table.php
2026_01_01_001600_create_ppdb_registrations_table.php
2026_01_01_001700_create_student_class_histories_table.php
2026_01_01_001800_create_alumni_profiles_table.php
```

## 18.5 Migration Modul Surat

```text
2026_01_01_001900_create_letter_categories_table.php
2026_01_01_002000_create_letter_templates_table.php
2026_01_01_002100_create_letter_number_formats_table.php
2026_01_01_002200_create_letters_table.php
2026_01_01_002300_create_letter_recipients_table.php
2026_01_01_002400_create_letter_signatories_table.php
2026_01_01_002500_create_letter_logs_table.php
2026_01_01_002600_create_incoming_letter_dispositions_table.php
```

## 18.6 Migration Media Library

```text
2026_01_01_002700_create_media_table.php
```

Catatan:

- file ini mengikuti migration bawaan `spatie/laravel-medialibrary`

## 18.7 Catatan Draft Migration

- timestamp migration final dapat disesuaikan saat implementasi nyata
- nama file migration sebaiknya tetap konsisten dengan nama tabel
- untuk pivot seperti `subject_teacher`, tetap gunakan migration terpisah agar relasi mudah dirawat
- jika menggunakan multi-panel atau multi-tenant di masa depan, pertimbangkan penambahan `school_id` pada tabel operasional sejak awal

---

## 19. Model Relation Map

Bagian ini merangkum relasi Eloquent yang disarankan agar implementasi model konsisten dengan blueprint.

## 19.1 Relasi Model Inti

### `User`

- `hasOne(TeacherProfile::class)`
- `hasMany(Letter::class, 'created_by')`
- `hasMany(Letter::class, 'approved_by')`
- `hasMany(LetterLog::class, 'acted_by')`
- `hasMany(IncomingLetterDisposition::class, 'from_user_id')`
- `hasMany(IncomingLetterDisposition::class, 'to_user_id')`

### `School`

- `hasMany(AcademicYear::class)` jika nanti dibuat multi-sekolah
- media collection: `school-logo`

### `SystemSetting`

- tanpa relasi wajib, dipakai sebagai key-value global

### `AcademicYear`

- `hasMany(Semester::class)`
- `hasMany(Classroom::class)`
- `hasMany(StudentClassHistory::class)`
- `hasMany(Letter::class)`
- `hasMany(TeachingAssignment::class)`
- `hasMany(SubjectTeacher::class)`

### `Semester`

- `belongsTo(AcademicYear::class)`
- `hasMany(StudentClassHistory::class)`
- `hasMany(TeachingAssignment::class)`

## 19.2 Relasi Model Modul Guru

### `TeacherProfile`

- `belongsTo(User::class)`
- `belongsToMany(Subject::class, 'subject_teacher')`
- `belongsToMany(Position::class, 'teacher_positions')`
- `hasMany(SubjectTeacher::class)`
- `hasMany(TeacherPosition::class)`
- `hasMany(AdditionalAssignment::class)`
- `hasMany(TeachingAssignment::class)`
- `hasMany(Classroom::class, 'homeroom_teacher_id')`
- `hasMany(Letter::class, 'signed_by_teacher_id')`
- `hasMany(LetterRecipient::class)`
- `hasMany(LetterSignatory::class)`
- media collections:
  - `teacher-photo`
  - `teacher-documents`
  - `teacher-signature`

### `Subject`

- `belongsTo(Major::class)->nullable()`
- `belongsToMany(TeacherProfile::class, 'subject_teacher')`
- `hasMany(SubjectTeacher::class)`
- `hasMany(TeachingAssignment::class)`

### `SubjectTeacher`

- `belongsTo(TeacherProfile::class)`
- `belongsTo(Subject::class)`
- `belongsTo(AcademicYear::class)->nullable()`

### `TeachingAssignment`

- `belongsTo(TeacherProfile::class)`
- `belongsTo(Subject::class)`
- `belongsTo(Classroom::class)`
- `belongsTo(AcademicYear::class)`
- `belongsTo(Semester::class)->nullable()`

### `Position`

- `belongsToMany(TeacherProfile::class, 'teacher_positions')`
- `hasMany(TeacherPosition::class)`

### `TeacherPosition`

- `belongsTo(TeacherProfile::class)`
- `belongsTo(Position::class)`

### `AdditionalAssignment`

- `belongsTo(TeacherProfile::class)`
- `belongsTo(Classroom::class)->nullable()`

## 19.3 Relasi Model Modul Siswa

### `Major`

- `hasMany(StudentProfile::class)`
- `hasMany(Classroom::class)`
- `hasMany(Subject::class)`

### `StudentProfile`

- `belongsTo(Major::class)->nullable()`
- `hasOne(PpdbRegistration::class)`
- `hasOne(AlumniProfile::class)`
- `hasMany(StudentClassHistory::class)`
- `hasMany(LetterRecipient::class)`
- media collections:
  - `student-photo`
  - `student-documents`

### `PpdbRegistration`

- `belongsTo(StudentProfile::class)`

### `Classroom`

- `belongsTo(AcademicYear::class)`
- `belongsTo(Major::class)`
- `belongsTo(TeacherProfile::class, 'homeroom_teacher_id')->nullable()`
- `hasMany(StudentClassHistory::class)`
- `hasMany(TeachingAssignment::class)`
- `hasMany(AdditionalAssignment::class)`

### `StudentClassHistory`

- `belongsTo(StudentProfile::class)`
- `belongsTo(Classroom::class)`
- `belongsTo(AcademicYear::class)`
- `belongsTo(Semester::class)->nullable()`

### `AlumniProfile`

- `belongsTo(StudentProfile::class)`

## 19.4 Relasi Model Modul Surat

### `LetterCategory`

- `hasMany(LetterTemplate::class)`
- `hasMany(LetterNumberFormat::class)`
- `hasMany(Letter::class)`

### `LetterTemplate`

- `belongsTo(LetterCategory::class)`
- `hasMany(Letter::class)`

### `LetterNumberFormat`

- `belongsTo(LetterCategory::class)`
- `hasMany(Letter::class, 'number_format_id')`

### `Letter`

- `belongsTo(LetterCategory::class)`
- `belongsTo(LetterTemplate::class)->nullable()`
- `belongsTo(AcademicYear::class)->nullable()`
- `belongsTo(LetterNumberFormat::class, 'number_format_id')->nullable()`
- `belongsTo(TeacherProfile::class, 'signed_by_teacher_id')->nullable()`
- `belongsTo(User::class, 'created_by')`
- `belongsTo(User::class, 'approved_by')->nullable()`
- `hasMany(LetterRecipient::class)`
- `hasMany(LetterSignatory::class)`
- `hasMany(LetterLog::class)`
- `hasMany(IncomingLetterDisposition::class)`
- media collections:
  - `letter-attachments`
  - `letter-generated-pdf`
  - `letter-scans`

### `LetterRecipient`

- `belongsTo(Letter::class)`
- `belongsTo(TeacherProfile::class)->nullable()`
- `belongsTo(StudentProfile::class)->nullable()`

### `LetterSignatory`

- `belongsTo(Letter::class)`
- `belongsTo(TeacherProfile::class)`

### `LetterLog`

- `belongsTo(Letter::class)`
- `belongsTo(User::class, 'acted_by')`

### `IncomingLetterDisposition`

- `belongsTo(Letter::class)`
- `belongsTo(User::class, 'from_user_id')`
- `belongsTo(User::class, 'to_user_id')`

## 19.5 Catatan Relasi Implementasi

- relasi nullable sebaiknya eksplisit di migration dan model
- gunakan eager loading pada resource Filament yang menampilkan relasi banyak
- untuk export dan tabel admin, siapkan scope query agar tidak terjadi N+1 query
- relasi media tidak perlu dibuat manual selain implementasi Media Library pada model terkait

---

## 20. Task Breakdown Coding

Bagian ini memecah implementasi menjadi task coding yang lebih operasional agar dapat dipakai sebagai backlog development.

## 20.1 Fase 0 - Inisialisasi Proyek

Tujuan:

- menyiapkan fondasi Laravel, Filament, auth, role permission, dan locale

Task:

1. buat project Laravel 12
2. konfigurasi koneksi **PostgreSQL**, queue, mail, dan filesystem
3. install Filament 4
4. install Filament Shield
5. install Spatie Media Library
6. install `spatie/laravel-pdf`
7. install `maatwebsite/excel`
8. install editor TinyMCE yang kompatibel dengan Filament 4
9. publish asset, config, dan migration package yang diperlukan
10. set locale aplikasi ke `id`
11. setup panel admin Filament
12. setup user admin awal

Output:

- aplikasi Laravel berjalan
- panel Filament bisa login
- package inti sudah terpasang

## 20.2 Fase 1 - Konfigurasi Sistem dan Sekolah

Tujuan:

- menyiapkan konfigurasi awal sistem agar tipe sekolah dapat dipilih saat first run

Task database:

1. buat migration `schools`
2. buat migration `system_settings`
3. jalankan migration
4. buat seeder default `system_settings`

Task backend:

1. buat model `School`
2. buat model `SystemSetting`
3. buat enum `SchoolTypeEnum`
4. buat `SchoolContextService`
5. buat `AcademicLabelService`
6. buat helper untuk membaca sekolah aktif

Task Filament:

1. buat halaman `InitializeApplicationPage`
2. buat form konfigurasi awal sekolah
3. tambahkan pilihan `school_type` saat first run
4. simpan `active_school_id`, `default_locale`, dan `app_initialized`
5. cegah akses penuh ke panel bila setup awal belum selesai

Output:

- wizard konfigurasi awal berfungsi
- `school_type` aktif bisa dibaca seluruh sistem

## 20.3 Fase 2 - Autentikasi, Role, dan Permission

Tujuan:

- menyiapkan kontrol akses untuk admin, operator guru, operator siswa, dan role lainnya

Task:

1. jalankan migration permission bawaan
2. buat seeder role dan permission
3. definisikan role:
   - Super Admin
   - Admin
   - Operator Guru
   - Operator Siswa
   - Kepala Sekolah
   - Tata Usaha
4. generate permission resource dengan Shield
5. atur akses menu berdasarkan role
6. uji login per role

Output:

- struktur role/permission aktif
- menu dan resource terbatas sesuai role

## 20.4 Fase 3 - Master Akademik

Tujuan:

- membangun master data yang dipakai lintas modul

Task database:

1. buat migration `academic_years`
2. buat migration `semesters`
3. buat migration `majors`
4. buat migration `positions`
5. buat migration `subjects`

Task backend:

1. buat model `AcademicYear`
2. buat model `Semester`
3. buat model `Major`
4. buat model `Position`
5. buat model `Subject`
6. buat enum `SubjectGroupEnum`
7. buat scope/filter `school_type_scope`

Task Filament:

1. buat `AcademicYearResource`
2. buat `SemesterResource`
3. buat `MajorResource`
4. buat `PositionResource`
5. buat `SubjectResource`
6. aktifkan `ExportAction` pada resource master

Output:

- master akademik siap dipakai modul guru dan siswa

## 20.5 Fase 4 - Modul Guru

Tujuan:

- membangun data guru, mapel, jabatan, dan penugasan mengajar

Task database:

1. buat migration `teacher_profiles`
2. buat migration `subject_teacher`
3. buat migration `teacher_positions`
4. buat migration `additional_assignments`
5. buat migration `teaching_assignments`

Task backend:

1. buat model `TeacherProfile`
2. buat model `SubjectTeacher`
3. buat model `TeacherPosition`
4. buat model `AdditionalAssignment`
5. buat model `TeachingAssignment`
6. daftarkan media collection guru:
   - `teacher-photo`
   - `teacher-documents`
   - `teacher-signature`

Task Filament:

1. buat `TeacherProfileResource`
2. buat relation manager mapel guru
3. buat relation manager jabatan guru
4. buat `TeachingAssignmentResource`
5. tambahkan filter berdasarkan tahun ajaran, mapel, dan rombel
6. tambahkan export Excel

Task business logic:

1. pisahkan kompetensi mapel guru dan penugasan mengajar aktual
2. filter pilihan mapel berdasarkan `school_type`
3. validasi agar penugasan mengajar tidak duplikat pada semester yang sama

Output:

- modul guru aktif
- penugasan guru mapel bisa dipakai untuk SMA dan SMK

## 20.6 Fase 5 - Modul Siswa

Tujuan:

- membangun data siswa, PPDB, rombel, riwayat kelas, dan alumni

Task database:

1. buat migration `student_profiles`
2. buat migration `ppdb_registrations`
3. buat migration `classrooms`
4. buat migration `student_class_histories`
5. buat migration `alumni_profiles`

Task backend:

1. buat model `StudentProfile`
2. buat model `PpdbRegistration`
3. buat model `Classroom`
4. buat model `StudentClassHistory`
5. buat model `AlumniProfile`
6. daftarkan media collection siswa:
   - `student-photo`
   - `student-documents`

Task Filament:

1. buat `StudentProfileResource`
2. buat `PpdbRegistrationResource`
3. buat `ClassroomResource`
4. buat relation manager riwayat kelas
5. buat `AlumniProfileResource`
6. tambahkan export Excel

Task business logic:

1. sesuaikan label struktur akademik berdasar `school_type`
2. validasi `major_id` sesuai kebutuhan SMA atau SMK
3. hubungkan wali kelas ke `TeacherProfile`
4. buat flow perubahan status siswa menjadi alumni

Output:

- modul siswa aktif
- rombel dan struktur akademik berjalan untuk SMA/SMK

## 20.7 Fase 6 - Modul Surat Dinas

Tujuan:

- membangun kategori surat, template surat, penomoran otomatis, transaksi surat, dan disposisi

Task database:

1. buat migration `letter_categories`
2. buat migration `letter_templates`
3. buat migration `letter_number_formats`
4. buat migration `letters`
5. buat migration `letter_recipients`
6. buat migration `letter_signatories`
7. buat migration `letter_logs`
8. buat migration `incoming_letter_dispositions`

Task backend:

1. buat model `LetterCategory`
2. buat model `LetterTemplate`
3. buat model `LetterNumberFormat`
4. buat model `Letter`
5. buat model `LetterRecipient`
6. buat model `LetterSignatory`
7. buat model `LetterLog`
8. buat model `IncomingLetterDisposition`

Task service:

1. buat `LetterNumberService`
2. buat `LetterPlaceholderService`
3. buat `LetterTemplateRenderService`
4. buat `LetterPdfService`

Task Filament:

1. buat `LetterCategoryResource`
2. buat `LetterTemplateResource`
3. buat `LetterNumberFormatResource`
4. buat `LetterResource`
5. buat `IncomingLetterDispositionResource`
6. tambahkan export Excel

Task business logic:

1. buat status flow surat
2. lock nomor surat setelah approval
3. simpan `content_html` final setelah render
4. sesuaikan placeholder akademik berdasarkan `school_type`

Output:

- modul surat aktif
- surat masuk, keluar, dan surat internal dapat dikelola

## 20.8 Fase 7 - PDF Surat

Tujuan:

- membangun alur preview dan generate PDF berbasis Blade

Task view:

1. buat layout `resources/views/pdf/letters/layouts/base.blade.php`
2. buat komponen kop surat
3. buat komponen tanda tangan
4. buat template surat guru
5. buat template surat siswa

Task action:

1. buat `PreviewLetterPdfAction`
2. buat `GenerateLetterPdfAction`
3. simpan PDF final ke Media Library
4. tampilkan file PDF dari Filament

Task business logic:

1. gunakan custom Blade print view sebagai standar
2. kirim hasil render ke `spatie/laravel-pdf`
3. pastikan logo, tabel, dan tanda tangan tampil benar

Output:

- preview dan export PDF surat berjalan stabil

## 20.9 Fase 8 - Export Excel

Tujuan:

- menyediakan export data per modul sesuai tampilan tabel Filament

Task backend:

1. buat `ExportColumnResolverService`
2. buat `ExportFileNameService`
3. buat class export custom bila dibutuhkan untuk laporan khusus

Task Filament:

1. pasang `ExportAction` pada resource utama
2. pastikan export mengikuti filter aktif
3. pastikan export mengikuti kolom visible di tabel
4. siapkan fallback kolom wajib untuk laporan tertentu

Task business logic:

1. gunakan format nama file sesuai standar blueprint
2. prioritaskan format `XLSX`
3. sediakan opsi `CSV` bila diperlukan

Output:

- semua modul utama dapat export Excel
- hasil export konsisten dengan tampilan admin

## 20.10 Fase 9 - Media Library dan Arsip

Tujuan:

- merapikan seluruh alur file upload dan arsip dokumen

Task:

1. publish migration Media Library
2. jalankan migration media
3. daftarkan collection media pada model terkait
4. atur validasi tipe file dan ukuran upload
5. tampilkan file terkait di resource Filament
6. siapkan naming convention file

Output:

- file guru, siswa, dan surat tersimpan rapi

## 20.11 Fase 10 - Dashboard dan Pelaporan

Tujuan:

- menyediakan widget ringkas untuk operasional admin

Task:

1. buat widget statistik guru
2. buat widget statistik siswa
3. buat widget surat masuk/keluar
4. buat widget status surat
5. sesuaikan label dashboard dengan `school_type`
6. pastikan seluruh widget berbahasa Indonesia

Output:

- dashboard operasional siap dipakai

## 20.12 Fase 11 - Quality Control dan Hardening

Tujuan:

- memastikan sistem stabil sebelum dipakai operasional

Task:

1. uji alur setup awal
2. uji alur SMA
3. uji alur SMK
4. uji role dan permission
5. uji generate PDF
6. uji export Excel
7. uji upload file
8. uji validasi form utama
9. uji performa query resource yang relasional
10. review N+1 query pada resource Filament

Output:

- sistem siap masuk tahap implementasi nyata

## 20.13 Prioritas Eksekusi Praktis

Urutan paling pragmatis untuk coding:

1. setup proyek dan package
2. wizard konfigurasi awal
3. role dan permission
4. master akademik
5. modul guru
6. modul siswa
7. modul surat
8. PDF surat
9. export Excel
10. dashboard
11. hardening dan testing

---

## 21. Referensi

- Laravel 12: https://laravel.com
- Filament 4 docs: https://filamentphp.com/docs/4.x
- Spatie Media Library: https://spatie.be/docs/laravel-medialibrary
- Spatie Laravel PDF: https://spatie.be/docs/laravel-pdf
- Filament Shield repository: https://github.com/bezhanSalleh/filament-shield
- TinyMCE docs: https://www.tiny.cloud/docs/

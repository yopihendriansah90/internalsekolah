# Audit Implementasi vs BLUEPRINT_SIS_SEKOLAH

Tanggal audit: 25 Maret 2026

## Ringkasan

- Status umum: **parsial**
- Modul Guru: **mayoritas sudah tersedia**
- Modul Siswa: **mayoritas sudah tersedia**
- Modul Surat Dinas: **sudah tersedia (fase dasar)**
- Penyesuaian pada audit ini: **standarisasi export resource prioritas + inisialisasi modul surat fase dasar**

## Cakupan yang Sudah Sesuai

- Stack inti sesuai blueprint:
  - Laravel 12
  - Filament 4
  - Filament Shield
  - Spatie Media Library
  - TinyEditor package terpasang
  - `spatie/laravel-pdf` terpasang
  - `maatwebsite/excel` terpasang
- Role utama tersedia di seeder:
  - Super Admin, Admin, Operator Guru, Operator Siswa, Kepala Sekolah, Tata Usaha
- Master dan modul inti (guru/siswa) sudah ada:
  - migrations, models, dan Filament resources untuk school, academic year, semester, major, subject, teacher, student, classroom, ppdb, alumni, assignment.

## Cakupan Parsial

- Fitur export:
  - Sekarang sudah ada `ExportAction` untuk resource prioritas.
  - Kolom default export untuk modul prioritas telah disesuaikan mendekati daftar blueprint.
  - Nama file export sudah distandarkan `prefix-YYYY-MM-DD`.
  - Catatan: belum ada `ExportColumnResolverService` khusus; saat ini memakai `enableVisibleTableColumnsByDefault()` bawaan Filament.
- Localization:
  - Label UI resource dominan Bahasa Indonesia.
  - Belum ada paket/localization flow menyeluruh untuk semua string sistem.
- Media Library:
  - Model `School`, `TeacherProfile`, `StudentProfile` sudah implement `InteractsWithMedia`.
  - Koleksi media baru terdefinisi eksplisit di `School`; teacher/student masih default collection.

## Cakupan Belum Tersedia (Gap Utama)

- Modul Surat Dinas lanjutan belum lengkap:
  - service penomoran otomatis surat dan generator nomor berjalan
  - render template placeholder dinamis ke isi final
  - generate PDF surat formal + preview
  - workflow approval/tandatangan dan log aktivitas otomatis
- Resource sistem yang direkomendasikan blueprint belum ada:
  - `UserResource`
  - `SystemSettingResource`/`SystemSettingPage` terkontrol
- Service/action blueprint yang belum ada:
  - `LetterNumberService`
  - `LetterTemplateRenderService`
  - `LetterPdfService`
  - `LetterPlaceholderService`
  - `ExportColumnResolverService` (custom)
  - `ExportFileNameService` (custom service formal)
  - `GenerateLetterPdfAction`
  - `PreviewLetterPdfAction`
  - `ExportVisibleTableAction` (custom action formal)
  - `InitializeApplicationAction`

## Checklist Migrasi Blueprint

- Terimplementasi: `28/28` item urutan migrasi blueprint (termasuk `users`, permission tables, media table, dan seluruh tabel modul surat).
- Belum terimplementasi pada level migration: `0/28`.

## Penyesuaian Kode yang Dilakukan pada Audit Ini

- Menambahkan `ExportActionFactory` untuk konsistensi export action:
  - label export
  - default mengikuti kolom tabel yang visible
  - penamaan file export standar tanggal
- Menambahkan `ExportAction` pada tabel resource:
  - `TeacherProfilesTable`
  - `SubjectsTable`
  - `TeachingAssignmentsTable`
  - `StudentProfilesTable`
  - `PpdbRegistrationsTable`
  - `ClassroomsTable`
  - `AlumniProfilesTable`
  - `MajorsTable`
  - `PositionsTable`
  - `SchoolsTable`
  - `AcademicYearsTable`
  - `SemestersTable`
- Menambahkan exporter Filament dan menyetel default kolom untuk modul prioritas:
  - `TeacherProfileExporter`
  - `SubjectExporter`
  - `TeachingAssignmentExporter`
  - `StudentProfileExporter`
  - `PpdbRegistrationExporter`
  - `ClassroomExporter`
  - `AlumniProfileExporter`
  - `MajorExporter`
- Menambahkan fase dasar Modul Surat Dinas:
  - migration 8 tabel surat
  - model + relasi surat (`Letter*`, `IncomingLetterDisposition`)
  - resource Filament: `LetterCategory`, `LetterTemplate`, `LetterNumberFormat`, `Letter`, `IncomingLetterDisposition`
  - exporter + export action untuk resource surat dasar
  - policy modul surat agar konsisten dengan Shield permission pattern

## Prioritas Lanjutan (Sesuai Blueprint)

1. Implement service surat (`LetterNumberService`, `LetterTemplateRenderService`, `LetterPdfService`).
2. Tambahkan workflow approval + tanda tangan + log aksi otomatis saat state berubah.
3. Tambahkan `UserResource` dan halaman konfigurasi sistem terkontrol.
4. Finalisasi layer export custom (`ExportColumnResolverService`, `ExportFileNameService`) bila perlu kontrol lebih detail dari bawaan Filament.

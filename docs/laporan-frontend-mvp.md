# Laporan Pembuatan Frontend MVP — Andara Motor

Dokumen ini merangkum pekerjaan **frontend** yang telah diselesaikan pada tahap MVP aplikasi showroom motor bekas **Andara Motor**.

## 1. Teknologi & Sistem Desain
- **Stack**: Laravel Blade, Tailwind CSS v4 (`@tailwindcss/vite`), Vite 8, dan Vanilla JavaScript.
- **Tema & Styling** (`resources/css/app.css`):
  - Font utama **Plus Jakarta Sans** dengan utilitas `tabular-nums` untuk harga, tahun, dan kilometer.
  - Palet warna terpusat: Brand Merah (`#C81E1E`), Ink Gelap (`#111318`), Surface (`#F6F7F9`), dan WhatsApp Hijau (`#15803D`).
  - Kelas tombol konsisten (`.btn-primary`, `.btn-secondary`, `.btn-dark`, `.btn-wa`) dengan target klik minimal `44px` dan animasi ringan yang menghormati `prefers-reduced-motion`.

## 2. Layout & Komponen Reusable
- **Layout Utama**:
  - `layouts/public.blade.php`: Header sticky berisi strip informasi showroom, search bar kategori, navigasi utama, menu drawer mobile, serta footer kontak & WhatsApp.
  - `layouts/owner.blade.php`: Layout panel admin dengan sidebar desktop, topbar aksi cepat, dan drawer navigasi mobile.
- **Komponen Blade** (`resources/views/components/`):
  - `brand-mark`: Identitas logo/teks showroom (varian terang & gelap).
  - `motorcycle-card`: Kartu unit motor (foto rasio 4:3, badge status, harga, spek singkat, tombol Detail & Tanya WA).
  - `status-badge`: Label visual status stok (*Tersedia*, *Dipesan*, *Terjual*).
  - `alert`: Banner notifikasi status sukses dan error.

## 3. Halaman Publik (Sisi Pembeli)
- **Beranda** (`public/home.blade.php`): Hero banner dengan foto showroom & CTA, strip standar pengecekan unit, navigasi cepat per kategori, grid unit pilihan, banner inspeksi unit, serta daftar merek aktif.
- **Katalog Motor** (`public/catalog/index.blade.php`): Form pencarian & filter (kata kunci, merek, kategori, transmisi, urutan, rentang harga, rentang tahun), daftar unit responsif, *empty state*, dan paginasi.
- **Detail Unit** (`public/catalog/show.blade.php`): Breadcrumb, galeri foto interaktif dengan thumbnail, banner pemberitahuan jika unit terjual, rincian spesifikasi lengkap (surat BPKB/STNK/Faktur, pajak, odometer, kondisi setting & mesin, garansi), tombol WhatsApp otomatis (termasuk sticky bar khusus mobile), dan rekomendasi unit lain.

## 4. Halaman Autentikasi & Panel Owner
- **Login Owner** (`auth/login.blade.php`): Tampilan split 2 kolom dengan validasi inline, toggle tampilkan/sembunyikan password, dan opsi *remember me*.
- **Dashboard** (`owner/dashboard.blade.php`): 4 kartu metrik ringkasan stok (*Tersedia*, *Dipesan*, *Terjual*, *Merek Terdaftar*) dan tabel unit motor terbaru.
- **Inventori Unit Motor** (`owner/motorcycles/`):
  - `index.blade.php`: Filter inventori, tabel daftar unit, aksi cepat ubah status (*Tersedia* ↔ *Dipesan*), serta tombol detail/edit/hapus.
  - `create.blade.php`, `edit.blade.php`, `_form.blade.php`: Form terstruktur dalam 4 bagian (Identitas & Spek, Kondisi & Surat, Harga & Data Internal, Unggah Foto) lengkap dengan pratinjau foto langsung.
  - `show.blade.php`: Ringkasan spesifikasi unit beserta kartu modal, biaya rekondisi, dan estimasi keuntungan khusus internal Owner.
- **Master Merek** (`owner/brands/`): Daftar merek dengan jumlah unit, form tambah & edit merek, serta aksi hapus dengan konfirmasi.

## 5. Interaktivitas & Responsivitas
- **Interaksi JavaScript** (`resources/js/app.js`):
  - Toggle menu mobile (`aria-expanded` & dukungan tombol `Escape`).
  - Toggle visibilitas password di halaman login.
  - Proteksi *double-submit* saat mengirim form dan konfirmasi hapus (`data-confirm`).
  - *Gallery thumbnail switcher* di halaman detail motor dan *live image preview* saat memilih file foto di form Owner.
- **Responsif & Aksesibilitas**: Skip-link navigasi, struktur HTML semantik (`<search>`, `<nav>`, `<main>`), indikator fokus keyboard, serta tabel data responsif menggunakan **CSS Container Queries** (`.data-table--stack`) yang otomatis berubah menjadi tampilan kartu di layar kecil.

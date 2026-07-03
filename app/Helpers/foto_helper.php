<?php

/**
 * Helper: foto_url()
 *
 * Mengembalikan URL yang benar untuk menampilkan foto, baik dari:
 * - Supabase Storage  → langsung kembalikan URL-nya
 * - Storage lokal     → tambahkan base_url() sebagai prefix
 * - Kosong            → kembalikan URL foto default
 *
 * Cara pakai di view:
 *   <img src="<?= foto_url($kreator['foto_profil']) ?>">
 *
 *   // Dengan folder kustom:
 *   <img src="<?= foto_url($laporan['foto_views_konten'], 'laporan') ?>">
 *
 *   // Dengan fallback kustom:
 *   <img src="<?= foto_url($kreator['foto_profil'], 'profil', base_url('assets/img/default-avatar.png')) ?>">
 *   */
if (!function_exists('foto_url')) {
    function foto_url(?string $namaFile, string $folder = 'profil', ?string $default = null): string
    {
        // Jika kosong, kembalikan default
        if (empty($namaFile)) {
            return $default ?? base_url('assets/img/profile/blood-strike.jpg');
        }

        // Jika sudah berupa URL lengkap (dari Supabase Storage), langsung kembalikan
        if (str_starts_with($namaFile, 'http://') || str_starts_with($namaFile, 'https://')) {
            return $namaFile;
        }

        // Jika nama file lokal, tambahkan base_url
        return base_url("uploads/{$folder}/{$namaFile}");
    }
}

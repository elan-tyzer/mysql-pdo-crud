<?php
// konfigurasi database
$host = "localhost";
$dbname = "db_daftar_buku";
$username = "root";
$password = "";

// membuat koneksi ke database menggunakan PDO
try {
    // membuat objek PDO untuk koneksi ke database
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // mengatur mode error PDO menjadi exception agar lebih mudah menangani kesalahan
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // memulai sesi untuk menyimpan token keamanan (CSRF token)
} catch (PDOException $e) {
    // jika terjadi kesalahan saat koneksi ke database, tampilkan pesan kesalahan dan hentikan eksekusi dan ditolak
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
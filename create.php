<?php
// require adalah bagian dimana langsung menghubungkan db (data base).
require "config.php";
//
// Jika request ditolak oleh post, maka akan diarahkan ke index.php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");// ini untuk membuka langsung ke halaman index.php
    exit;
}

// mengambil data dari form index.php 
$judul = $_POST["judul"];
$penulis = $_POST["penulis"];
$tahun = $_POST["tahun"];
$status = $_POST["status"];

//membuat quer untuk memasukan data ke dalam database
$sql = "INSERT INTO buku (judul, penulis, tahun_terbit, status_baca)
        VALUES (:judul, :penulis, :tahun_terbit, :status_baca)";

//menyiapkan statement untuk di eksekusi/digunakan
$stmt = $pdo->prepare($sql);

//mengeksekusi statemnet dengan data yang berada di index.php
$stmt->execute([
    "judul" => $judul,
    "penulis" => $penulis,
    "tahun_terbit" => $tahun,
    "status_baca" => $status
]);

// setelah data berhasil disimpan ke dalam database, maka akan diarahkan ke index.php
header("Location: index.php");
exit;
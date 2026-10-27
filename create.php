<?php

require "config.php";
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}
$judul = $_POST["judul"];
$penulis = $_POST["penulis"];
$tahun = $_POST["tahun"];
$status = $_POST["status"];

$sql = "INSERT INTO buku (judul, penulis, tahun_terbit, status_baca)
        VALUES (:judul, :penulis, :tahun_terbit, :status_baca)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "judul" => $judul,
    "penulis" => $penulis,
    "tahun_terbit" => $tahun,
    "status_baca" => $status
]);

header("Location: index.php");
exit;
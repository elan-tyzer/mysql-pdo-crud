<?php

require "config.php";
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}
$nama = $_POST["nama"];
$penulis = $_POST["penulis"];
$tahun = $_POST["tahun"];
$status = $_POST["status"];

$sql = "INSERT INTO buku (nama, penulis, tahun, status)
        VALUES (:nama, :penulis, :tahun, :status)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "nama" => $nama,
    "penulis" => $penulis,
    "tahun" => $tahun,
    "status" => $status
]);

header("Location: index.php");
exit;
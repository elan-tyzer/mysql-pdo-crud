
<?php
require_once "config.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID buku tidak valid.");
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(["id" => $id]);
$buku = $stmt->fetch();

if (!$buku) {
    http_response_code(404);
    exit("Buku tidak ditemukan.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["csrf_token"] ?? "";

    if (!is_string($token) ||
        !hash_equals($_SESSION["csrf_token"], $token)) {
        die("Token keamanan tidak valid.");
    }

    $judul = trim($_POST["judul"] ?? "");
    $penulis = trim($_POST["penulis"] ?? "");
    $tahun = $_POST["tahun_terbit"] ?? "";
    $status = $_POST["status_baca"] ?? "";

    $tahunSekarang = (int) date("Y");

    if ($judul === "" || $penulis === "") {
        $error = "Judul dan penulis wajib diisi.";
    } elseif (!ctype_digit((string) $tahun) ||
              (int) $tahun < 1901 ||
              (int) $tahun > $tahunSekarang) {
        $error = "Tahun terbit tidak valid.";
    } elseif (!in_array(
        $status,
        ["Sudah Dibaca", "Belum Dibaca"],
        true
    )) {
        $error = "Status baca tidak valid.";
    } else {
        $sql = "UPDATE buku
                SET judul = :judul,
                    penulis = :penulis,
                    tahun_terbit = :tahun,
                    status_baca = :status
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "judul" => $judul,
            "penulis" => $penulis,
            "tahun" => (int) $tahun,
            "status" => $status,
            "id" => $id
        ]);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 30px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input, select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 8px 0 16px;
        }

        button {
            background: #2563eb;
            color: white;
            border: 0;
            padding: 12px 18px;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Buku</h1>

    <?php if ($error !== ""): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>">

        <label>Judul Buku</label>
        <input type="text" name="judul" maxlength="150"
               value="<?= htmlspecialchars($_POST["judul"] ?? $buku["judul"]) ?>"
               required>

        <label>Penulis</label>
        <input type="text" name="penulis" maxlength="100"
               value="<?= htmlspecialchars($_POST["penulis"] ?? $buku["penulis"]) ?>"
               required>

        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit"
               min="1901" max="<?= date("Y") ?>"
               value="<?= htmlspecialchars($_POST["tahun_terbit"] ?? (string) $buku["tahun_terbit"]) ?>"
               required>

        <label>Status Baca</label>
        <?php $statusForm = $_POST["status_baca"] ?? $buku["status_baca"]; ?>
        <select name="status_baca" required>
            <option value="Belum Dibaca"
                <?= $statusForm === "Belum Dibaca" ? "selected" : "" ?>>
                Belum Dibaca
            </option>
            <option value="Sudah Dibaca"
                <?= $statusForm === "Sudah Dibaca" ? "selected" : "" ?>>
                Sudah Dibaca
            </option>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <p><a href="index.php">Kembali ke Daftar Buku</a></p>
</div>
</body>
</html>

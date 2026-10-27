<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>daftar Buku</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>daftar Buku</h1>

    <form action="create.php" method="POST">
        <p>
            judul:<br>
            <input type="text" name="nama" required>
        </p>

        <p>
            nama penulis:<br>
            <input type="text" name="penulis" required>
        </p>

        <p>
            Tahun Terbit:<br>
            <input type="number" name="tahun" required>
        </p>

        <p>
            Status baca<br>
            <select name="status" required>
                <option value="Sudah Dibaca">Sudah Dibaca</option>
                <option value="Belum Dibaca">Belum Dibaca</option>
            </select>
        </p>

        <button type="submit">Submit</button>

    </form>
</body>
</html>
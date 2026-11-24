<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard utama</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="form-card">
        <header>
            <h2>Perpustakaan Yusuf</h2>
            <p>Dashboard Admin</p>
        </header>
        <form action="tampil.php" method="POST">
            <button type="submit" class="btn-submit">Tampilkan Data</button>
        </form>
        <form action="form_anggota.php" method="POST">
            <button type="submit" class="btn-submit">Form Input Data</button>
        </form>
    </main> 
</body>
</html>
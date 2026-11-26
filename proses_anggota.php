<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: form_anggota.php");
    exit;
}

require_once "validasi_anggota.php";

$data          = ambil_input_anggota($_POST);
$no_anggota    = $data["no_anggota"];
$nama_lengkap  = $data["nama_lengkap"];
$email         = $data["email"];
$no_hp         = $data["no_hp"];
$jenis_anggota = $data["jenis_anggota"];
$alamat        = $data["alamat"];

$errors = validasi_data_anggota($data);

$berhasil = false;
$pesan_db = "";

if (empty($errors)) {
    require_once "koneksi.php";

    $sql = "INSERT INTO anggota (no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat) "
         . "VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt, "ssssss", $no_anggota, $nama_lengkap, $email, $no_hp, $jenis_anggota, $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            $berhasil = true;
        } else {
            $pesan_db = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $pesan_db = mysqli_error($koneksi);
    }
    mysqli_close($koneksi);

    if ($berhasil) {
        header("Location: form_anggota.php?status=sukses");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Penyimpanan Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-card">
        <?php if (!empty($errors)) { ?>

            <h2>Data Tidak Valid</h2>
            <p class="gagal">Data belum dapat disimpan. Perbaiki kesalahan:</p>
            <ul class="error-list">
                <?php foreach ($errors as $pesan) { ?>
                    <li><?php echo htmlspecialchars($pesan); ?></li>
                <?php } ?>
            </ul>

        <?php } else { ?>

            <h2>Data Gagal Disimpan</h2>
            <p class="gagal">Terjadi kesalahan saat menyimpan data ke database.</p>
            <p class="pesan-db">Pesan dari MySQL: <?php echo htmlspecialchars($pesan_db); ?></p>

        <?php } ?>

        <a href="javascript:history.back()" class="btn-kembali">Kembali dan perbaiki data</a>
    </div>
</body>
</html>

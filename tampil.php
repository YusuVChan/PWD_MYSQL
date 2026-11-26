<?php
require_once "koneksi.php";

$sql = "SELECT id, no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat FROM anggota ORDER BY id DESC";

$hasil = mysqli_query($koneksi, $sql);
$jumlah = $hasil ? mysqli_num_rows($hasil) : 0;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampil data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="form-card">
        <header>
            <h2>Daftar Anggota Perpustakaan</h2>
            <p>Diurutkan berdasarkan anggota terbaru</p>
        </header>
        <?php if (isset($_GET["status"]) && $_GET["status"] === "edit_sukses") { ?>
            <section class="alert-wrapper" aria-label="Notifikasi status">
                <input type="checkbox" id="tutup-alert" class="alert-checkbox">
                <div class="alert-sukses">
                    <div class="alert-konten">
                        <span class="alert-ikon">&#10004;</span>
                        <div>
                            <strong>Berhasil!</strong>
                            <span>Data anggota telah berhasil diperbarui.</span>
                        </div>
                    </div>
                    <label for="tutup-alert" class="alert-tutup" title="Tutup notifikasi">&times;</label>
                </div>
            </section>
        <?php } ?>
        <nav>
            <form action="dashboard.php">
                <button type="submit" class="btn-submit">Kembali ke dashboard</button>
            </form>
        </nav>
        <div class="bungkus-tabel">
            <table>
                <tr>
                    <th>
                        No_Anggota
                    </th>
                    <th>
                        Nama_Lengkap
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        No_hp
                    </th>
                    <th>
                        Jenis_anggota
                    </th>
                    <th class="kolom-alamat">
                        Alamat
                    </th>
                    <th class="kolom-aksi">
                        Aksi
                    </th>
                </tr>
                <?php if ($jumlah > 0) { ?>
                    <?php while ($baris = mysqli_fetch_assoc($hasil)) { ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($baris["no_anggota"]); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($baris["nama_lengkap"]); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($baris["email"]); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($baris["no_hp"]); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($baris["jenis_anggota"]); ?>
                        </td>
                        <td class="kolom-alamat">
                            <?php echo htmlspecialchars($baris["alamat"]); ?>
                        </td>
                        <td class="kolom-aksi">
                            <a href="edit_anggota.php?id=<?php echo (int) $baris["id"]; ?>" class="btn-edit">Edit</a>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="tabel-kosong">Belum ada data anggota.</td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main> 
</body>
</html>
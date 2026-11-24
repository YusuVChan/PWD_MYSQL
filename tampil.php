<?php
require_once "koneksi.php";

$sql = "SELECT no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat FROM anggota GROUP BY id 
        ORDER BY id DESC";

$hasil = mysqli_query($koneksi, $sql);

$jumlah = mysqli_num_rows($hasil);

?>

<!DOCTYPE html>
<html lang="en">
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
            <p>Diurutukan berdasarkan anggota terbaru</p>
        </header>
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
                    <th>
                        Alamat
                    </th>
                </tr>
                <?php $no = 1; while ($baris = mysqli_fetch_assoc($hasil)) {?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($baris["no_anggota"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($baris["nama_lengkap"]); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($baris["email"])?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($baris["no_hp"])?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($baris["jenis_anggota"])?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($baris["alamat"])?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main> 
</body>
</html>
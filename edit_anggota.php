<?php
require_once "koneksi.php";
require_once "validasi_anggota.php";

$errors = [];
$pesan_db = "";
$data = null;
$id = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $raw_id = isset($_POST["id"]) ? trim((string) $_POST["id"]) : "";
    if (!ctype_digit($raw_id) || (int) $raw_id <= 0) {
        header("Location: tampil.php");
        exit;
    }

    $id = (int) $raw_id;
    $data = ambil_input_anggota($_POST);
    $errors = validasi_data_anggota($data);

    if (empty($errors)) {
        $sql = "UPDATE anggota SET no_anggota = ?, nama_lengkap = ?, email = ?, no_hp = ?, jenis_anggota = ?, alamat = ? WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssi",
                $data["no_anggota"],
                $data["nama_lengkap"],
                $data["email"],
                $data["no_hp"],
                $data["jenis_anggota"],
                $data["alamat"],
                $id
            );

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($koneksi);
                header("Location: tampil.php?status=edit_sukses");
                exit;
            }

            $pesan_db = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $pesan_db = mysqli_error($koneksi);
        }
    }
} else {
    $raw_id = isset($_GET["id"]) ? trim((string) $_GET["id"]) : "";
    if (!ctype_digit($raw_id) || (int) $raw_id <= 0) {
        mysqli_close($koneksi);
        header("Location: tampil.php");
        exit;
    }

    $id = (int) $raw_id;
    $sql = "SELECT no_anggota, nama_lengkap, email, no_hp, jenis_anggota, alamat FROM anggota WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $hasil = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($hasil) ?: null;
        } else {
            $pesan_db = mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $pesan_db = mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Data Anggota</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <main class="form-card">
    <?php if ($data === null) { ?>
      <header>
        <h2>Data Tidak Ditemukan</h2>
        <p class="gagal">
          <?php echo $pesan_db !== "" ? "Terjadi kesalahan: " . htmlspecialchars($pesan_db) : "Data anggota yang dipilih tidak ditemukan."; ?>
        </p>
      </header>
      <a href="tampil.php" class="btn-kembali">Kembali ke Daftar Anggota</a>
    <?php } else { ?>
      <header>
        <h2>Edit Data Anggota</h2>
        <p>Perbarui data anggota perpustakaan di bawah ini dengan benar.</p>
      </header>

      <?php if (!empty($errors)) { ?>
        <div class="gagal">Perbaiki kesalahan berikut sebelum menyimpan:</div>
        <ul class="error-list">
          <?php foreach ($errors as $pesan) { ?>
            <li><?php echo htmlspecialchars($pesan); ?></li>
          <?php } ?>
        </ul>
      <?php } elseif ($pesan_db !== "") { ?>
        <div class="gagal">Gagal memperbarui data ke database.</div>
        <p class="pesan-db">Pesan dari MySQL: <?php echo htmlspecialchars($pesan_db); ?></p>
      <?php } ?>

      <form action="edit_anggota.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="form-group">
          <label for="no_anggota">Nomor Anggota</label>
          <input
            type="text"
            id="no_anggota"
            name="no_anggota"
            class="form-control"
            placeholder="No Anggota"
            maxlength="15"
            value="<?php echo htmlspecialchars($data["no_anggota"]); ?>"
            required>
        </div>

        <div class="form-group">
          <label for="nama_lengkap">Nama Lengkap</label>
          <input
            type="text"
            id="nama_lengkap"
            name="nama_lengkap"
            class="form-control"
            placeholder="Masukkan nama lengkap"
            maxlength="100"
            value="<?php echo htmlspecialchars($data["nama_lengkap"]); ?>"
            required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            placeholder="Masukan Email @"
            maxlength="100"
            value="<?php echo htmlspecialchars($data["email"]); ?>"
            required>
        </div>

        <div class="form-group">
          <label for="no_hp">Nomor HP</label>
          <input
            type="text"
            id="no_hp"
            name="no_hp"
            class="form-control"
            placeholder="No Hp"
            minlength="10"
            maxlength="13"
            value="<?php echo htmlspecialchars($data["no_hp"]); ?>"
            required>
        </div>

        <div class="form-group">
          <label for="jenis_anggota">Jenis Anggota</label>
          <select id="jenis_anggota" name="jenis_anggota" class="form-control" required>
            <?php foreach (daftar_jenis_anggota() as $jenis) { ?>
              <option value="<?php echo htmlspecialchars($jenis); ?>" <?php echo $data["jenis_anggota"] === $jenis ? "selected" : ""; ?>>
                <?php echo htmlspecialchars($jenis); ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea
            id="alamat"
            name="alamat"
            class="form-control"
            placeholder="Masukkan alamat lengkap tempat tinggal"
            required><?php echo htmlspecialchars($data["alamat"]); ?></textarea>
        </div>

        <button type="submit" class="btn-submit">Simpan Perubahan</button>
      </form>

      <a href="tampil.php" class="btn-kembali btn-batal">Batal &amp; Kembali ke Daftar</a>
    <?php } ?>
  </main>

</body>
</html>

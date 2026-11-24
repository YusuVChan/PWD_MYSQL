<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pendaftaran Anggota</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <main class="form-card">
    <header>
      <h2>Data Anggota</h2>
      <p>Silakan lengkapi seluruh informasi di bawah ini dengan benar.</p>
    </header>

    <?php if (isset($_GET["status"]) && $_GET["status"] === "sukses") { ?>
      <section class="alert-wrapper" aria-label="Notifikasi status">
        <input type="checkbox" id="tutup-alert" class="alert-checkbox">
        <div class="alert-sukses">
          <div class="alert-konten">
            <span class="alert-ikon">&#10004;</span>
            <div>
              <strong>Berhasil!</strong>
              <span>Data anggota telah berhasil disimpan ke database.</span>
            </div>
          </div>
          <label for="tutup-alert" class="alert-tutup" title="Tutup notifikasi">&times;</label>
        </div>
      </section>
    <?php } ?>

    <form action="proses_anggota.php" method="POST">
      <div class="form-group">
        <label for="no_anggota">Nomor Anggota</label>
        <input 
          type="text" 
          id="no_anggota" 
          name="no_anggota" 
          class="form-control" 
          placeholder="No Anggota"
          maxlength="15" 
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
          >
      </div>

      <div class="form-group">
        <label for="jenis_anggota">Jenis Anggota</label>
        <select id="jenis_anggota" name="jenis_anggota" class="form-control" required>
          <option value="Mahasiswa" selected>Mahasiswa</option>
          <option value="Dosen">Dosen</option>
          <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
        </select>
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea 
          id="alamat" 
          name="alamat" 
          class="form-control" 
          placeholder="Masukkan alamat lengkap tempat tinggal"
          required></textarea>
      </div>

      <button type="submit" class="btn-submit">Simpan Data</button>
    </form>
    <form action="dashboard.php" method="POST">
      <button type="submit" class="btn-submit">Kembali ke Dashboard</button>
    </form>
  </main>

</body>
</html>
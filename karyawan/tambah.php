<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
require '../config/db.php';

// Ambil daftar perusahaan
$perusahaan = $conn->query("SELECT id, nama FROM perusahaan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Karyawan</h2>
    <form method="post" action="proses_simpan.php">
        <div class="mb-3">
            <label for="kode_karyawan" class="form-label">Kode Karyawan</label>
            <input type="text" class="form-control" id="kode_karyawan" name="kode_karyawan" required />
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required />
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required />
        </div>

        <div class="mb-3">
            <label for="no_tlp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_tlp" name="no_tlp" required />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required />
        </div>

        <div class="mb-3">
            <label for="no_rekening" class="form-label">No. Rekening</label>
            <input type="text" class="form-control" id="no_rekening" name="no_rekening" required />
        </div>

        <div class="mb-3">
            <label for="rek_bank" class="form-label">Bank</label>
            <input type="text" class="form-control" id="rek_bank" name="rek_bank" required />
        </div>

        <div class="mb-3">
            <label for="id_perusahaan" class="form-label">Perusahaan</label>
            <select class="form-select" id="id_perusahaan" name="id_perusahaan" required>
                <option value="">-- Pilih Perusahaan --</option>
                <?php while ($row = $perusahaan->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">← Kembali</a>
    </form>
</div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
require '../config/db.php';

$kode_karyawan = $_GET['kode_karyawan'] ?? null;
if (!$kode_karyawan) {
    header("Location: index.php");
    exit;
}

// Ambil data perusahaan untuk dropdown
$perusahaanResult = $conn->query("SELECT id, nama FROM perusahaan");

// Ambil data karyawan yang mau diubah
$stmt = $conn->prepare("SELECT * FROM karyawan WHERE kode_karyawan = ?");
$stmt->bind_param("s", $kode_karyawan);
$stmt->execute();
$result = $stmt->get_result();
$karyawan = $result->fetch_assoc();

if (!$karyawan) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $no_tlp = $_POST['no_tlp'];
    $email = $_POST['email'];
    $no_rekening = $_POST['no_rekening'];
    $rek_bank = $_POST['rek_bank'];
    $id_perusahaan = $_POST['id_perusahaan'];

    $stmt_update = $conn->prepare("UPDATE karyawan SET nama=?, alamat=?, jabatan=?, no_tlp=?, email=?, no_rekening=?, rek_bank=?, id_perusahaan=? WHERE kode_karyawan=?");
    $stmt_update->bind_param("sssssssis", $nama, $alamat, $jabatan, $no_tlp, $email, $no_rekening, $rek_bank, $id_perusahaan, $kode_karyawan);
    $stmt_update->execute();

    if ($stmt_update->affected_rows >= 0) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal memperbarui data karyawan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Ubah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Ubah Karyawan</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Kode Karyawan</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($karyawan['kode_karyawan']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control" required value="<?= htmlspecialchars($karyawan['nama']) ?>">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control" required><?= htmlspecialchars($karyawan['alamat']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" id="jabatan" name="jabatan" class="form-control" required value="<?= htmlspecialchars($karyawan['jabatan']) ?>">
        </div>
        <div class="mb-3">
            <label for="no_tlp" class="form-label">No. Telepon</label>
            <input type="text" id="no_tlp" name="no_tlp" class="form-control" required value="<?= htmlspecialchars($karyawan['no_tlp']) ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required value="<?= htmlspecialchars($karyawan['email']) ?>">
        </div>
        <div class="mb-3">
            <label for="no_rekening" class="form-label">No. Rekening</label>
            <input type="text" id="no_rekening" name="no_rekening" class="form-control" required value="<?= htmlspecialchars($karyawan['no_rekening']) ?>">
        </div>
        <div class="mb-3">
            <label for="rek_bank" class="form-label">Bank</label>
            <input type="text" id="rek_bank" name="rek_bank" class="form-control" required value="<?= htmlspecialchars($karyawan['rek_bank']) ?>">
        </div>
        <div class="mb-3">
            <label for="id_perusahaan" class="form-label">Perusahaan</label>
            <select id="id_perusahaan" name="id_perusahaan" class="form-select" required>
                <option value="">-- Pilih Perusahaan --</option>
                <?php while ($perusahaan = $perusahaanResult->fetch_assoc()): ?>
                    <option value="<?= $perusahaan['id'] ?>" <?= $perusahaan['id'] == $karyawan['id_perusahaan'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($perusahaan['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">← Kembali</a>
    </form>
</div>
</body>
</html>

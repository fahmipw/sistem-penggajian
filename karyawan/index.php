<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
require '../config/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Data Karyawan</h2><br>
    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Karyawan</a>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Kode Karyawan</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>No. Rekening</th>
                <th>Bank</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM karyawan";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['kode_karyawan']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['jabatan']) ?></td>
                <td><?= htmlspecialchars($row['no_tlp']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['no_rekening']) ?></td>
                <td><?= htmlspecialchars($row['rek_bank']) ?></td>
               <td>
    <a href="ubah.php?kode_karyawan=<?= $row['kode_karyawan'] ?>" class="btn btn-sm btn-warning">Ubah</a>
    <a href="hapus.php?kode_karyawan=<?= $row['kode_karyawan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus karyawan ini?')">Hapus</a>
</td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../dashboard.php" class="btn btn-secondary">← Kembali ke Beranda</a>
</div>
</body>
</html>

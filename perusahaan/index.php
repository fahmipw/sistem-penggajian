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
    <title>Data Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Data Perusahaan</h2><br>
    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Perusahaan</a>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM perusahaan");
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td>
                    <a href="ubah.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Ubah</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus perusahaan ini?')">Hapus</a>
                </td>
            </tr>
            <?php
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="5" class="text-center">Data perusahaan belum tersedia.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../dashboard.php" class="btn btn-secondary">← Kembali ke Beranda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

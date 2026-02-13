<?php
require '../config/db.php';

$sql = "SELECT s.no_ref, s.tgl, k.nama
        FROM slip_gaji s
        JOIN karyawan k ON s.kode_karyawan = k.kode_karyawan
        ORDER BY s.tgl DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Slip Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Slip Gaji</h2>
<a href="cetak_semua.php" target="_blank" class="btn btn-outline-primary mb-3">
    🖨️ Cetak Semua Slip Gaji
</a>

    <div class="table-responsive">
        
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No Ref</th>
                    <th>Tanggal</th>
                    <th>Karyawan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['no_ref']) ?></td>
                        <td><?= htmlspecialchars($row['tgl']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td>
                            <a href="tambah_detail.php?no_ref=<?= urlencode($row['no_ref']) ?>" class="btn btn-sm btn-success me-2">
                                Tambah Nominal Gaji
                            </a>
                            <a href="cetak.php?no_ref=<?= urlencode($row['no_ref']) ?>" target="_blank" class="btn btn-sm btn-primary">
                                Cetak
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data slip gaji.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="../dashboard.php" class="btn btn-secondary mt-3">← Kembali ke Beranda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


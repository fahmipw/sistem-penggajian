<?php
require '../config/db.php';

$no_ref = $_GET['no_ref'] ?? '';
if (!$no_ref) {
    die("No Ref slip gaji tidak ditemukan.");
}

// Ambil daftar keterangan gaji (tunjangan, potongan)
$sql = "SELECT * FROM keterangan_gaji ORDER BY keterangan ASC";
$resultKeterangan = $conn->query($sql);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_keterangan = $_POST['no_keterangan'] ?? '';
    $nominal = $_POST['nominal'] ?? '';

    if ($no_keterangan && is_numeric($nominal)) {
        $stmt = $conn->prepare("INSERT INTO detail_gaji (no, no_ref, nominal) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $no_keterangan, $no_ref, $nominal);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = '<div class="alert alert-success">Data nominal gaji berhasil ditambahkan.</div>';
        } else {
            $message = '<div class="alert alert-danger">Gagal menambahkan data.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Mohon isi data dengan benar.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Nominal Gaji - Slip No: <?= htmlspecialchars($no_ref) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Nominal Gaji untuk Slip No: <?= htmlspecialchars($no_ref) ?></h2>

    <?= $message ?>

    <form method="post" action="" class="mt-3">
        <div class="mb-3">
            <label for="no_keterangan" class="form-label">Jenis Gaji</label>
            <select name="no_keterangan" id="no_keterangan" class="form-select" required>
                <option value="">-- Pilih Jenis Gaji --</option>
                <?php while ($row = $resultKeterangan->fetch_assoc()): ?>
                    <option value="<?= $row['no'] ?>">
                        <?= htmlspecialchars($row['keterangan']) ?> (<?= htmlspecialchars($row['jenis']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal (Rp)</label>
            <input type="number" name="nominal" id="nominal" min="0" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary ms-2">← Kembali ke daftar slip gaji</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

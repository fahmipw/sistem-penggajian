<?php
require '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$data = $conn->query("SELECT * FROM perusahaan WHERE id = " . intval($id))->fetch_assoc();
if (!$data) {
    echo "<script>alert('Data perusahaan tidak ditemukan'); window.location='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $telp = $conn->real_escape_string($_POST['no_telepon']);
    $email = $conn->real_escape_string($_POST['email']);

    $conn->query("UPDATE perusahaan SET nama='$nama', alamat='$alamat', no_telepon='$telp', email='$email' WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ubah Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Ubah Perusahaan</h2>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="no_telepon" class="form-label">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="<?= htmlspecialchars($data['no_telepon']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary ms-2">← Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

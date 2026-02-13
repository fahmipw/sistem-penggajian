<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_karyawan = $_POST['kode_karyawan'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jabatan = $_POST['jabatan'];
    $no_tlp = $_POST['no_tlp'];
    $email = $_POST['email'];
    $no_rekening = $_POST['no_rekening'];
    $rek_bank = $_POST['rek_bank'];

    // Insert data ke tabel karyawan
    $sql_karyawan = "INSERT INTO karyawan 
        (kode_karyawan, nama, alamat, jabatan, no_tlp, email, no_rekening, rek_bank) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_karyawan);
    $stmt->bind_param("ssssssss", $kode_karyawan, $nama, $alamat, $jabatan, $no_tlp, $email, $no_rekening, $rek_bank);

    if ($stmt->execute()) {
        // Jika sukses, buat slip gaji otomatis
        $no_ref = 'RF' . rand(1000000, 9999999);
        $tgl = date('Y-m-d');
        $total_gaji = 0;

        $sql_slip = "INSERT INTO slip_gaji (no_ref, tgl, total_gaji, kode_karyawan) VALUES (?, ?, ?, ?)";
        $stmt_slip = $conn->prepare($sql_slip);
        $stmt_slip->bind_param("ssds", $no_ref, $tgl, $total_gaji, $kode_karyawan);
        $stmt_slip->execute();

        // Redirect ke halaman data karyawan atau penggajian
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Karyawan</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="kode_karyawan" class="form-label">Kode Karyawan</label>
            <input type="text" class="form-control" id="kode_karyawan" name="kode_karyawan" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan">
        </div>
        <div class="mb-3">
            <label for="no_tlp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_tlp" name="no_tlp">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="no_rekening" class="form-label">No. Rekening</label>
            <input type="text" class="form-control" id="no_rekening" name="no_rekening">
        </div>
        <div class="mb-3">
            <label for="rek_bank" class="form-label">Bank</label>
            <input type="text" class="form-control" id="rek_bank" name="rek_bank">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>

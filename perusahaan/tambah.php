<?php
require '../config/db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['no_telepon'];
    $email = $_POST['email'];
    $conn->query("INSERT INTO perusahaan (nama, alamat, no_telepon, email)
                  VALUES ('$nama', '$alamat', '$telp', '$email')");
    header("Location: index.php");
}
?>

<h2>Tambah Perusahaan</h2>
<form method="post">
    <input name="nama" placeholder="Nama" required><br>
    <textarea name="alamat" placeholder="Alamat" required></textarea><br>
    <input name="no_telepon" placeholder="No Telepon" required><br>
    <input name="email" placeholder="Email" required><br>
    <button type="submit">Simpan</button>
</form>

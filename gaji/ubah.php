<?php
require '../config/db.php';
require '../config/functions.php';

$no_ref = $_GET['no_ref'];
$slip = $conn->query("SELECT * FROM slip_gaji WHERE no_ref='$no_ref'")->fetch_assoc();
$karyawan = $conn->query("SELECT * FROM karyawan");
$ket = $conn->query("SELECT * FROM keterangan_gaji");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tgl = $_POST['tgl'];
    $kode = $_POST['kode_karyawan'];
    $items = $_POST['nominal'];
    $ket_ids = $_POST['no'];

    $conn->query("DELETE FROM detail_gaji WHERE no_ref='$no_ref'");

    for ($i = 0; $i < count($ket_ids); $i++) {
        $no = $ket_ids[$i];
        $nominal = $items[$i];
        $conn->query("INSERT INTO detail_gaji (no, no_ref, nominal) VALUES ('$no', '$no_ref', '$nominal')");
    }

    $total = hitungGajiBersih($no_ref, $conn);
    $conn->query("UPDATE slip_gaji SET tgl='$tgl', total_gaji='$total', kode_karyawan='$kode' WHERE no_ref='$no_ref'");

    header("Location: index.php");
}
?>

<h2>Ubah Slip Gaji</h2>
<form method="post">
    <input name="no_ref" value="<?= $slip['no_ref'] ?>" readonly><br>
    <input type="date" name="tgl" value="<?= $slip['tgl'] ?>" required><br>
    <select name="kode_karyawan" required>
        <?php while ($k = $karyawan->fetch_assoc()): ?>
            <option value="<?= $k['kode_karyawan'] ?>" <?= $k['kode_karyawan'] == $slip['kode_karyawan'] ? 'selected' : '' ?>>
                <?= $k['nama'] ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <h4>Rincian Gaji</h4>
    <?php
    $detail = $conn->query("SELECT * FROM detail_gaji WHERE no_ref='$no_ref'");
    $detail_map = [];
    while ($d = $detail->fetch_assoc()) {
        $detail_map[$d['no']] = $d['nominal'];
    }

    mysqli_data_seek($ket, 0);
    while ($k = $ket->fetch_assoc()): ?>
        <input type="hidden" name="no[]" value="<?= $k['no'] ?>">
        <?= $k['keterangan'] ?> (<?= $k['jenis'] ?>):
        <input type="number" name="nominal[]" value="<?= $detail_map[$k['no']] ?? 0 ?>"><br>
    <?php endwhile; ?>

    <button type="submit">Update</button>
</form>

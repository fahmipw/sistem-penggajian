<?php
require '../config/db.php';

if (!isset($_GET['kode_karyawan'])) {
    header("Location: index.php");
    exit;
}

$kode = $_GET['kode_karyawan'];

// Hapus data detail_gaji terkait slip_gaji karyawan
$stmt1 = $conn->prepare("
    DELETE d FROM detail_gaji d
    INNER JOIN slip_gaji s ON d.no_ref = s.no_ref
    WHERE s.kode_karyawan = ?
");
$stmt1->bind_param("s", $kode);
$stmt1->execute();

// Hapus data slip_gaji karyawan
$stmt2 = $conn->prepare("DELETE FROM slip_gaji WHERE kode_karyawan = ?");
$stmt2->bind_param("s", $kode);
$stmt2->execute();

// Hapus data karyawan
$stmt3 = $conn->prepare("DELETE FROM karyawan WHERE kode_karyawan = ?");
$stmt3->bind_param("s", $kode);
$stmt3->execute();

header("Location: index.php");
exit;

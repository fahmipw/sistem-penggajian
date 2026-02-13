<?php
require '../config/db.php';
require '../config/functions.php';

$no_ref = $_GET['no_ref'] ?? '';

if (!$no_ref) {
    die("No Ref gaji tidak ditemukan.");
}

// Ambil data slip gaji + data karyawan
$sql = "SELECT s.*, k.nama, k.jabatan, k.no_rekening, k.rek_bank
        FROM slip_gaji s
        JOIN karyawan k ON s.kode_karyawan = k.kode_karyawan
        WHERE s.no_ref = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $no_ref);
$stmt->execute();
$slip = $stmt->get_result()->fetch_assoc();

if (!$slip) {
    die("Data slip gaji tidak ditemukan.");
}

// Hitung gaji bersih
$gaji_bersih = hitungGajiBersih($no_ref, $conn);

// Ambil detail gaji (komponen)
$sqlDetail = "SELECT keterangan.keterangan, d.nominal, keterangan.jenis
              FROM detail_gaji d
              JOIN keterangan_gaji keterangan ON d.no = keterangan.no
              WHERE d.no_ref = ?";
$stmtDetail = $conn->prepare($sqlDetail);
$stmtDetail->bind_param("s", $no_ref);
$stmtDetail->execute();
$resultDetail = $stmtDetail->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?= htmlspecialchars($slip['nama']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .total { font-weight: bold; }
        .print-button { margin-top: 30px; text-align: center; }
        button { padding: 10px 20px; font-size: 16px; cursor: pointer; }
        @media print {
            .print-button { display: none; }
        }
    </style>
</head>
<body>

    <h2>Slip Gaji</h2>

    <p><strong>Nama Karyawan:</strong> <?= htmlspecialchars($slip['nama']) ?></p>
    <p><strong>Jabatan:</strong> <?= htmlspecialchars($slip['jabatan']) ?></p>
    <p><strong>Tanggal:</strong> <?= htmlspecialchars($slip['tgl']) ?></p>
    <p><strong>No. Rekening:</strong> <?= htmlspecialchars($slip['no_rekening']) ?> (<?= htmlspecialchars($slip['rek_bank']) ?>)</p>

    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $resultDetail->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td>
                        <?= ($row['jenis'] === 'debit' ? '+ ' : '- ') ?>
                        <?= number_format($row['nominal'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr class="total">
                <td>Total Gaji Bersih</td>
                <td>Rp <?= number_format($gaji_bersih, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div class="print-button">
        <button onclick="window.print()">Cetak Slip Gaji</button>
    </div>

</body>
</html>

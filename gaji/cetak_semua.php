<?php
require '../config/db.php';
require '../config/functions.php';

// Ambil semua slip gaji
$sql = "SELECT s.*, k.nama, k.jabatan, k.no_rekening, k.rek_bank
        FROM slip_gaji s
        JOIN karyawan k ON s.kode_karyawan = k.kode_karyawan
        ORDER BY s.tgl DESC, k.nama ASC";
$result = $conn->query($sql);

// Ambil semua detail gaji
$allDetails = [];
$sqlDetail = "SELECT d.no_ref, keterangan.keterangan, d.nominal, keterangan.jenis
              FROM detail_gaji d
              JOIN keterangan_gaji keterangan ON d.no = keterangan.no";
$detailResult = $conn->query($sqlDetail);
while ($row = $detailResult->fetch_assoc()) {
    $allDetails[$row['no_ref']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Semua Slip Gaji</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 30px;}
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
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

    <h2>Daftar Slip Gaji Semua Karyawan</h2>

    <?php while($slip = $result->fetch_assoc()): 
        $no_ref = $slip['no_ref'];
        $gaji_bersih = hitungGajiBersih($no_ref, $conn);
        $details = $allDetails[$no_ref] ?? [];
    ?>
    <div style="page-break-after: always;">
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
                <?php foreach($details as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                        <td><?= ($row['jenis'] === 'debit' ? '+ ' : '- ') . number_format($row['nominal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total">
                    <td>Total Gaji Bersih</td>
                    <td>Rp <?= number_format($gaji_bersih, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endwhile; ?>

    <div class="print-button">
        <button onclick="window.print()">Cetak Semua</button>
    </div>

</body>
</html>

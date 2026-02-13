<?php
function hitungGajiBersih($no_ref, $conn) {
    $total = 0;
    $sql = "SELECT k.jenis, d.nominal
            FROM detail_gaji d
            JOIN keterangan_gaji k ON d.no = k.no
            WHERE d.no_ref = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error prepare statement: " . $conn->error);
    }

    $stmt->bind_param("s", $no_ref);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($row['jenis'] === 'debit') {
            $total += $row['nominal'];
        } else {
            $total -= $row['nominal'];
        }
    }

    return $total;
}



?>

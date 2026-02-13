    <?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    }
    require 'config/db.php';

    // Ambil data perusahaan
    $perusahaan = $conn->query("SELECT * FROM perusahaan");

    // Ambil data karyawan + nama perusahaan
   $karyawan = $conn->query("
    SELECT k.*, p.nama AS nama_perusahaan
    FROM karyawan k
    LEFT JOIN perusahaan p ON k.id_perusahaan = p.id
");

    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Sistem Penggajian</title>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
        <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f8;
        padding: 20px;
    }
    h2 {
        text-align: center;
        margin-top: 30px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
        box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }
    th {
        background: #007BFF;
        color: #fff;
    }

    /* Gaya Navigasi */
    nav {
        text-align: center;
        margin-bottom: 30px;
    }
    nav a {
        display: inline-block;
        margin: 0 8px;
        text-decoration: none;
        padding: 10px 18px;
        background-color: #007BFF;
        color: white;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        font-weight: 500;
    }
    nav a:hover {
        background-color: #0056b3;
    }
</style>

    </head>
    <body>

    <h2>Selamat Datang di Sistem Penggajian</h2>

    <nav>
    <a href="dashboard.php">Beranda</a>
    <a href="perusahaan/index.php">Kelola Perusahaan</a>
    <a href="karyawan/index.php">Kelola Karyawan</a>
    <a href="gaji/index.php">Kelola Penggajian</a>
    <a href="logout.php">Logout</a>
</nav>



    <!-- Tabel Perusahaan -->
    <h2>Data Perusahaan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $perusahaan->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tabel Karyawan -->
    <h2>Data Karyawan</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>No Telepon</th>
                <th>Email</th>
                <th>No Rekening</th>
                <th>Bank</th>
                <th>Perusahaan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $karyawan->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['kode_karyawan']) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['jabatan']) ?></td>
                <td><?= htmlspecialchars($row['no_tlp']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['no_rekening']) ?></td>
                <td><?= htmlspecialchars($row['rek_bank']) ?></td>
                <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    </body>
    </html>

<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

$tanggal_hari_ini = date('Y-m-d');
$tanggal_bulan_ini = date('Y-m');
$tanggal_tahun_ini = date('Y');

$sql_harian = "SELECT SUM(jumlah) AS total FROM pembayaran WHERE DATE(tanggal_pembayaran) = '$tanggal_hari_ini'";
$sql_bulanan = "SELECT SUM(jumlah) AS total FROM pembayaran WHERE DATE_FORMAT(tanggal_pembayaran, '%Y-%m') = '$tanggal_bulan_ini'";
$sql_tahunan = "SELECT SUM(jumlah) AS total FROM pembayaran WHERE YEAR(tanggal_pembayaran) = '$tanggal_tahun_ini'";

$total_harian = $conn->query($sql_harian)->fetch_assoc()['total'] ?? 0;
$total_bulanan = $conn->query($sql_bulanan)->fetch_assoc()['total'] ?? 0;
$total_tahunan = $conn->query($sql_tahunan)->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php include 'navbar.php'; ?>
        <div class="content">
            <h1 class="text-center mb-4">Data Laporan Pembayaran</h1>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Periode</th>
                        <th>Total Penghasilan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Hari Ini (<?= date('d-m-Y') ?>)</td>
                        <td>Rp<?= number_format($total_harian, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Bulan Ini (<?= date('F Y') ?>)</td>
                        <td>Rp<?= number_format($total_bulanan, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tahun Ini (<?= date('Y') ?>)</td>
                        <td>Rp<?= number_format($total_tahunan, 2, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>

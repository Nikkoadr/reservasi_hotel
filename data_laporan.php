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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            align-items: center;
        }
        .navbar .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar-links {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        .navbar-links li {
            display: inline;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            padding: 5px 10px;
            transition: background 0.3s ease;
        }

        .navbar-links a:hover,
        .navbar-links .logout-btn {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            font-size: 1em;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'navbar.php'; ?>
        <div class="content">
            <h1>Data Laporan Pembayaran</h1>
            <table class="table">
                <thead>
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
</body>
</html>

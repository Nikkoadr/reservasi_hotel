<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil informasi pengguna dari session
$user_id = $_SESSION['id_user'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role']; // Role pengguna: admin, resepsionis, atau tamu
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/style_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="container">
                <a href="dashboard.php" class="logo">Dashboard Admin</a>
                <ul class="nav-links">
                    <li><a href="kamar.php">Kamar</a></li>
                    <li><a href="reservasi.php">Reservasi</a></li>
                    <li><a href="pembayaran.php">Pembayaran</a></li>
                    <li><a href="laporan.php">Laporan</a></li>
                    <li><a href="log.php">Log</a></li>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- Konten -->
        <div class="container">
            <h1>Selamat Datang, <?= htmlspecialchars($user_name) ?></h1>
            <p>Anda login sebagai: <strong><?= htmlspecialchars($user_role) ?></strong></p>
            <p>Pilih menu di atas untuk mengelola data.</p>
        </div>
    </div>
</body>
</html>

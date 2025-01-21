<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil informasi pengguna dari session
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$role = $_SESSION['role']; // Role pengguna: admin, resepsionis, atau tamu

// Jika role adalah tamu, periksa status pembayaran
if ($role === 'tamu') {
    $query_pembayaran = mysqli_query($conn, "
        SELECT p.*, r.tanggal_check_in, r.tanggal_check_out 
        FROM pembayaran p 
        INNER JOIN reservasi r ON p.id_reservasi = r.id 
        WHERE r.id_user = $id_user AND p.status = 'belum dibayar'
        LIMIT 1
    ");
    $pembayaran = mysqli_fetch_assoc($query_pembayaran);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Tambahkan CSS Anda di sini (sama seperti kode sebelumnya) */
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

        .btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            background-color: #ffc107;
            color: black;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php include 'navbar.php'; ?>
    
        <h1>Selamat Datang, <?= htmlspecialchars($nama) ?></h1>
        <p>Anda login sebagai: <strong><?= htmlspecialchars($role) ?></strong></p>

        <?php if ($role === 'tamu' && $pembayaran): ?>
            <div class="alert">
                Anda memiliki pembayaran yang belum diselesaikan.
            </div>
            <p><strong>Detail Pembayaran:</strong></p>
            <ul>
                <li>Check-in: <?= $pembayaran['tanggal_check_in'] ?></li>
                <li>Check-out: <?= $pembayaran['tanggal_check_out'] ?></li>
                <li>Jumlah yang harus dibayar: Rp<?= number_format($pembayaran['jumlah'], 0, ',', '.') ?></li>
            </ul>
            <a href="bayar.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn">Lakukan Pembayaran</a>
        <?php elseif ($role === 'tamu'): ?>
            <p>Tidak ada pembayaran yang harus diselesaikan.</p>
            <a href="invoice.php" class="btn">Print Invoice</a>
        <?php endif; ?>
    </div>
</body>
</html>

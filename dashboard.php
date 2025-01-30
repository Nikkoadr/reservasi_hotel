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

if ($role === 'tamu') {
    $query_pembayaran = mysqli_query($conn, "
        SELECT pembayaran.id, pembayaran.id_reservasi, pembayaran.jumlah, pembayaran.status AS status_pembayaran, 
               reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.status AS status_reservasi
        FROM pembayaran
        INNER JOIN reservasi ON pembayaran.id_reservasi = reservasi.id 
        WHERE reservasi.id_user = $id_user 
        AND pembayaran.status IN ('belum dibayar', 'pending', 'sukses')
        LIMIT 1
    ");
    $pembayaran = mysqli_fetch_assoc($query_pembayaran);
    
    if (!$pembayaran || $pembayaran['status_reservasi'] === 'dibatalkan') {
        $query_kamar = mysqli_query($conn, "
            SELECT * FROM kamar
            WHERE status = 'tersedia'
        ");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
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

        .room-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .room-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .room-card h3 {
            margin-bottom: 15px;
        }

        .room-card .btn {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'navbar.php'; ?>
        
        <h1>Selamat Datang, <?= htmlspecialchars($nama) ?></h1>

        <?php if ($role === 'tamu' && $pembayaran): ?>
            <?php if ($pembayaran['status_pembayaran'] === 'belum dibayar'): ?>
                <div class="alert">
                    Anda memiliki pembayaran yang belum diselesaikan.
                </div>
                <p><strong>Detail Pembayaran:</strong></p>
                <ul>
                    <li>Check-in: <?= $pembayaran['tanggal_check_in'] ?></li>
                    <li>Check-out: <?= $pembayaran['tanggal_check_out'] ?></li>
                    <li>Jumlah yang harus dibayar: Rp<?= number_format($pembayaran['jumlah'], 0, ',', '.') ?></li>
                    <li>Status Reservasi: <?= htmlspecialchars($pembayaran['status_reservasi']) ?></li>
                </ul>
                <a href="bayar.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn">Lakukan Pembayaran</a>
                <a href="batal_reservasi.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn btn-danger">Batalkan Reservasi</a>

            <?php elseif (in_array($pembayaran['status_pembayaran'], ['pending', 'sukses'])): ?>
                <p>Pembayaran Anda sedang dalam proses atau telah selesai.</p>
                <p><strong>Status Reservasi:</strong> <?= htmlspecialchars($pembayaran['status_reservasi']) ?></p>
                <a href="invoice.php?id_reservasi=<?= $pembayaran['id_reservasi'] ?>" class="btn">Print Invoice</a>
                <a href="batal_reservasi.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn btn-danger">Batalkan Reservasi</a>
            <?php endif; ?>

        <?php elseif ($role === 'tamu' && !$pembayaran): ?>
            <p>Tidak ada pembayaran yang perlu dilakukan.</p>
        <?php endif; ?>

        <?php if ($role === 'tamu' && (!$pembayaran || $pembayaran['status_reservasi'] === 'dibatalkan')): ?>
            <h2>Kamar yang Tersedia</h2>
            <div class="room-list">
                <?php if ($query_kamar && mysqli_num_rows($query_kamar) > 0): ?>
                    <?php while ($room = mysqli_fetch_assoc($query_kamar)): ?>
                        <div class="room-card">
                            <h3>Kamar : <?= htmlspecialchars($room['nomor_kamar']) ?></h3>
                            <h3>Tipe : <?= htmlspecialchars($room['tipe']) ?></h3>
                            <h6>Deskipsi : <?= htmlspecialchars($room['deskripsi']) ?></h6>
                            <p>Status : <?= htmlspecialchars($room['status']) ?></p>
                            <p>Harga : Rp<?= number_format($room['harga'], 0, ',', '.') ?></p>
                            <a href="form_reservasi.php?id=<?= $room['id'] ?>" class="btn">Pesan Kamar</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada kamar yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

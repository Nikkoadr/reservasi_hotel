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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <?php include 'navbar.php'; ?>
        
        <h1 class="text-center text-primary mb-4">Selamat Datang, <?= htmlspecialchars($nama) ?></h1>

        <?php if ($role === 'tamu' && $pembayaran): ?>
            <?php if ($pembayaran['status_pembayaran'] === 'belum dibayar'): ?>
                <div class="alert alert-warning">
                    Anda memiliki pembayaran yang belum diselesaikan.
                </div>
                <p><strong>Detail Pembayaran:</strong></p>
                <ul>
                    <li>Check-in: <?= $pembayaran['tanggal_check_in'] ?></li>
                    <li>Check-out: <?= $pembayaran['tanggal_check_out'] ?></li>
                    <li>Jumlah yang harus dibayar: Rp<?= number_format($pembayaran['jumlah'], 0, ',', '.') ?></li>
                    <li>Status Reservasi: <?= htmlspecialchars($pembayaran['status_reservasi']) ?></li>
                </ul>
                <a href="bayar.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn btn-primary">Lakukan Pembayaran</a>
                <a href="batal_reservasi.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">Batalkan Reservasi</a>

            <?php elseif (in_array($pembayaran['status_pembayaran'], ['pending', 'sukses'])): ?>
                <p>Pembayaran Anda sedang dalam proses atau telah selesai.</p>
                <p><strong>Status Reservasi:</strong> <?= htmlspecialchars($pembayaran['status_reservasi']) ?></p>
                <a href="invoice.php?id_reservasi=<?= $pembayaran['id_reservasi'] ?>" class="btn btn-success">Print Invoice</a>
                <a href="batal_reservasi.php?id_pembayaran=<?= $pembayaran['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">Batalkan Reservasi</a>
            <?php endif; ?>

        <?php elseif ($role === 'tamu' && !$pembayaran): ?>
            <p>Tidak ada pembayaran yang perlu dilakukan.</p>
        <?php endif; ?>

        <?php if ($role === 'tamu' && (!$pembayaran || $pembayaran['status_reservasi'] === 'dibatalkan')): ?>
            <h2 class="text-center text-primary mt-5">Kamar yang Tersedia</h2>
            <div class="row mt-3">
                <?php if ($query_kamar && mysqli_num_rows($query_kamar) > 0): ?>
                    <?php while ($room = mysqli_fetch_assoc($query_kamar)): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Kamar : <?= htmlspecialchars($room['nomor_kamar']) ?></h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Tipe : <?= htmlspecialchars($room['tipe']) ?></h6>
                                    <p class="card-text">Deskripsi : <?= htmlspecialchars($room['deskripsi']) ?></p>
                                    <p>Status : <?= htmlspecialchars($room['status']) ?></p>
                                    <p>Harga : Rp<?= number_format($room['harga'], 0, ',', '.') ?></p>
                                    <a href="form_reservasi.php?id=<?= $room['id'] ?>" class="btn btn-primary">Pesan Kamar</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Tidak ada kamar yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

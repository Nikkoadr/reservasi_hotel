<?php
include 'koneksi.php';

$sql = "SELECT * FROM kamar WHERE status = 'tersedia'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar Tersedia</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a href="index.php" class="navbar-brand">Cluckin' Bell Hotel</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>
            </ul>
        </nav>

        <h1 class="text-center text-primary mb-4">Daftar Kamar Tersedia</h1>
        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Kamar Nomor: <?= htmlspecialchars($row['nomor_kamar']) ?></h5>
                                <p><strong>Tipe:</strong> <?= htmlspecialchars($row['tipe']) ?></p>
                                <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                                <p><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                                <a href="registrasi.php" class="btn btn-success">Pesan Sekarang</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Tidak ada kamar tersedia saat ini.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>

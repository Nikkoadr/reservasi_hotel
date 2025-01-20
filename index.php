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
    <link rel="stylesheet" href="css/style_index.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Cluckin' Bell Hotel</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php" class="btn-login">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Daftar Kamar Tersedia</h1>
        <?php if ($result->num_rows > 0): ?>
            <div class="kamar-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="kamar">
                        <h2>Kamar Nomor: <?= htmlspecialchars($row['nomor_kamar']) ?></h2>
                        <p><strong>Tipe:</strong> <?= htmlspecialchars($row['tipe']) ?></p>
                        <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 2, ',', '.') ?></p>
                        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                        <a href="reservasi.php?id=<?= $row['id'] ?>" class="btn">Pesan Sekarang</a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Tidak ada kamar tersedia saat ini.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>

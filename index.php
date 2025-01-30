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

            .navbar .logo {
                font-size: 1.5em;
                font-weight: bold;
                color: white;
                text-decoration: none;
            }

            .nav-links {
                list-style: none;
                display: flex;
                gap: 15px;
                margin: 0;
                padding: 0;
            }

            .nav-links a {
                color: white;
                text-decoration: none;
                font-size: 1em;
                padding: 5px 10px;
                transition: background 0.3s ease;
            }

            .nav-links a:hover {
                background-color: #0056b3;
                border-radius: 5px;
            }

            .container {
                margin: 20px auto;
                max-width: 900px;
                padding: 20px;
                text-align: center;
            }

            h1 {
                color: #007bff;
                margin-bottom: 20px;
            }

            .kamar-list {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
            }

            .kamar {
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 15px;
                text-align: left;
            }

            .kamar h2 {
                font-size: 1.2em;
                margin-bottom: 10px;
            }

            .kamar p {
                margin: 5px 0;
            }

            .btn {
                display: inline-block;
                background-color: #28a745;
                color: white;
                text-decoration: none;
                padding: 10px 15px;
                border-radius: 5px;
                font-size: 0.9em;
                transition: background 0.3s ease;
            }

            .btn:hover {
                background-color: #218838;
            }

            .no-data {
                font-size: 1.1em;
                color: #888;
            }
        </style>
    </head>
    <body>
            <div class="container">
        <nav class="navbar">
            <a href="index.php" class="logo">Cluckin' Bell Hotel</a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php" class="btn-login">Login</a></li>
            </ul>
        </nav>

            <h1>Daftar Kamar Tersedia</h1>
            <?php if ($result->num_rows > 0): ?>
                <div class="kamar-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="kamar">
                            <h2>Kamar Nomor: <?= htmlspecialchars($row['nomor_kamar']) ?></h2>
                            <p><strong>Tipe:</strong> <?= htmlspecialchars($row['tipe']) ?></p>
                            <p><strong>Harga:</strong> Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                            <a href="registrasi.php" class="btn">Pesan Sekarang</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="no-data">Tidak ada kamar tersedia saat ini.</p>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php $conn->close(); ?>

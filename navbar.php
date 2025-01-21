    <div class="navbar">
        <div class="navbar-brand">Hotel Management</div>
        <ul class="navbar-links">
            <?php if ($role === 'admin'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="kelola_kamar.php">Kelola Kamar</a></li>
                <li><a href="laporan.php">Laporan</a></li>
            <?php elseif ($role === 'resepsionis'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="reservasi.php">Reservasi</a></li>
                <li><a href="pembayaran.php">Pembayaran</a></li>
            <?php elseif ($role === 'tamu'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>
    <div class="navbar">
        <div class="navbar-brand">Hotel Management</div>
        <ul class="navbar-links">
            <?php if ($role === 'Admin'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data_kamar.php">kamar</a></li>
                <li><a href="data_reservasi.php">Reservasi</a></li>
                <li><a href="data_pembayaran.php">Pembayaran</a></li>
                <li><a href="data_laporan.php">Laporan</a></li>
            <?php elseif ($role === 'Resepsionis'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data_reservasi.php">Reservasi</a></li>
                <li><a href="data_pembayaran.php">Pembayaran</a></li>
            <?php elseif ($role === 'Tamu'): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>
<div class="navbar">
    <div class="navbar-brand">
        <a href="dashboard.php" style="color: white; text-decoration: none;">Hotel Management</a>
    </div>
    <ul class="navbar-links">
        <?php if ($role === 'Admin'): ?>
            <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="data_kamar.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_kamar.php' ? 'active' : '' ?>">Kamar</a></li>
            <li><a href="data_reservasi.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_reservasi.php' ? 'active' : '' ?>">Reservasi</a></li>
            <li><a href="data_pembayaran.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_pembayaran.php' ? 'active' : '' ?>">Pembayaran</a></li>
            <li><a href="data_laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_laporan.php' ? 'active' : '' ?>">Laporan</a></li>
        <?php elseif ($role === 'Resepsionis'): ?>
            <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
            <li><a href="data_reservasi.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_reservasi.php' ? 'active' : '' ?>">Reservasi</a></li>
            <li><a href="data_pembayaran.php" class="<?= basename($_SERVER['PHP_SELF']) == 'data_pembayaran.php' ? 'active' : '' ?>">Pembayaran</a></li>
        <?php elseif ($role === 'Tamu'): ?>
            <li><a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a></li>
        <?php endif; ?>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
    </ul>
</div>

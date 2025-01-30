<div class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Hotel Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_kamar.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_kamar.php' ? 'active' : '' ?>">Kamar</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_reservasi.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_reservasi.php' ? 'active' : '' ?>">Reservasi</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_pembayaran.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_pembayaran.php' ? 'active' : '' ?>">Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_laporan.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_laporan.php' ? 'active' : '' ?>">Laporan</a>
                    </li>
                <?php elseif ($role === 'resepsionis'): ?>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_kamar.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_kamar.php' ? 'active' : '' ?>">Kamar</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_reservasi.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_reservasi.php' ? 'active' : '' ?>">Reservasi</a>
                    </li>
                    <li class="nav-item">
                        <a href="data_pembayaran.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'data_pembayaran.php' ? 'active' : '' ?>">Pembayaran</a>
                    </li>
                <?php elseif ($role === 'tamu'): ?>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link logout-btn">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
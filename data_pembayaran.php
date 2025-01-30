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

$is_admin = ($role == 'admin' || $role == 'resepsionis');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php include 'navbar.php'; ?>

        <div class="content">
            <h1 class="mb-4">Data Pembayaran</h1>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nomor Reservasi</th>
                        <th>Nama Pengguna</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <?php if ($is_admin): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php';

                    $sql_pembayaran = "SELECT pembayaran.id, pembayaran.tanggal_pembayaran, pembayaran.jumlah, pembayaran.status,
                                        pembayaran.bukti_pembayaran, reservasi.id AS id_reservasi, reservasi.status AS status_reservasi, 
                                        reservasi.id_kamar, users.nama
                                        FROM pembayaran
                                        JOIN reservasi ON pembayaran.id_reservasi = reservasi.id
                                        JOIN users ON reservasi.id_user = users.id";
                    $result_pembayaran = $conn->query($sql_pembayaran);

                    if ($result_pembayaran->num_rows > 0):
                        $no = 1;
                        while ($row = $result_pembayaran->fetch_assoc()):
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['id_reservasi']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pembayaran']) ?></td>
                                <td>Rp<?= number_format($row['jumlah'], 2, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['status'] == 'belum dibayar'): ?>
                                        <span class="badge bg-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'sukses'): ?>
                                        <span class="badge bg-success"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'pending'): ?>
                                        <span class="badge bg-warning"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'batal'): ?>
                                        <span class="badge bg-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'dibatalkan'): ?>
                                        <span class="badge bg-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['bukti_pembayaran']): ?>
                                        <img src="assets/bukti_pembayaran/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" class="img-fluid" style="max-width: 100px;" alt="Bukti Pembayaran">
                                    <?php else: ?>
                                        <span>Belum ada bukti</span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($is_admin): ?>
                                    <td>
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <form action="update_status_pembayaran.php" method="POST">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="id_reservasi" value="<?= $row['id_reservasi'] ?>">
                                                <button type="submit" class="btn btn-success btn-sm">Tandai Sukses</button>
                                            </form>
                                        <?php elseif ($row['status'] == 'batal'): ?>
                                            <form action="konfirmasi_batal.php" method="POST">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="id_reservasi" value="<?= $row['id_reservasi'] ?>">
                                                <input type="hidden" name="id_kamar" value="<?= $row['id_kamar'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Tandai Dibatalkan</button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="hapus_pembayaran.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">
                                            <input type="hidden" name="id_pembayaran" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pembayaran tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php
        include 'navbar.php';
        ?>

        <div class="content">
            <h1>Data Reservasi</h1>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nomor Kamar</th>
                        <th>Nama Pengguna</th>
                        <th>Tanggal Check-in</th>
                        <th>Tanggal Check-out</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_reservasi = "SELECT reservasi.id, reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.total_pembayaran, reservasi.status, 
                                            kamar.nomor_kamar, users.nama
                                    FROM reservasi
                                    JOIN kamar ON reservasi.id_kamar = kamar.id
                                    JOIN users ON reservasi.id_user = users.id";
                    $result_reservasi = $conn->query($sql_reservasi);
                    if ($result_reservasi->num_rows > 0):
                        $no = 1;
                        while ($row = $result_reservasi->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_check_in']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_check_out']) ?></td>
                                <td>Rp<?= number_format($row['total_pembayaran'], 2, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['status'] == 'booked'): ?>
                                        <span class="badge bg-success"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="edit_reservasi.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_reservasi" value="<?= $row['id'] ?>">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="batal" <?= $row['status'] == 'batal' ? 'selected' : '' ?>>Batal</option>
                                            <option value="booked" <?= $row['status'] == 'booked' ? 'selected' : '' ?>>Booked</option>
                                            <option value="check-in" <?= $row['status'] == 'check-in' ? 'selected' : '' ?>>Check-in</option>
                                            <option value="check-out" <?= $row['status'] == 'check-out' ? 'selected' : '' ?>>Check-out</option>
                                        </select>
                                        <button type="submit" class="btn btn-success btn-sm mt-2">Update</button>
                                    </form>

                                    <form action="hapus_reservasi.php" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
                                        <input type="hidden" name="id_reservasi" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data reservasi tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

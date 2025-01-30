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

        .navbar .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar-links {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        .navbar-links li {
            display: inline;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            padding: 5px 10px;
            transition: background 0.3s ease;
        }

        .navbar-links a:hover,
        .navbar-links .logout-btn {
            background-color: #0056b3;
            border-radius: 5px;
        }

        .container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            font-size: 1em;
            color: #888;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 0.9em;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'navbar.php';
        ?>

        <div class="content">
            <h1>Data Reservasi</h1>
            <table class="table">
                <thead>
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
                    include 'koneksi.php';

                    $sql_reservasi = "SELECT reservasi.id, reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.total_pembayaran, reservasi.status, 
                                            kamar.nomor_kamar, users.nama
                                    FROM reservasi
                                    JOIN kamar ON reservasi.id_kamar = kamar.id
                                    JOIN users ON reservasi.id_user = users.id";
                    $result_reservasi = $conn->query($sql_reservasi);
                    if ($result_reservasi->num_rows > 0):
                        $no = 1;
                        while ($row = $result_reservasi->fetch_assoc()):
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_check_in']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_check_out']) ?></td>
                                <td>Rp<?= number_format($row['total_pembayaran'], 2, ',', '.') ?></td>
                                <td>
                                    <?php if ($row['status'] == 'booked'): ?>
                                        <span class="badge badge-success"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="edit_reservasi.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_reservasi" value="<?= $row['id'] ?>">
                                        <select name="status">
                                            <option value="batal" <?= $row['status'] == 'batal' ? 'selected' : '' ?>>batal</option>
                                            <option value="booked" <?= $row['status'] == 'booked' ? 'selected' : '' ?>>Booked</option>
                                            <option value="check-in" <?= $row['status'] == 'check-in' ? 'selected' : '' ?>>Check-in</option>
                                            <option value="check-out" <?= $row['status'] == 'check-out' ? 'selected' : '' ?>>Check-out</option>
                                        </select>
                                        <button type="submit" class="btn-success">Update</button>
                                    </form>

                                    <form action="hapus_reservasi.php" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?');">
                                        <input type="hidden" name="id_reservasi" value="<?= $row['id'] ?>">
                                        <button type="submit" class="btn-danger">Hapus</button>
                                    </form>
                            </td>
                            </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="7" class="no-data">Tidak ada data reservasi tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

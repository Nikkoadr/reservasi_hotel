<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil informasi pengguna dari session
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// Cek jika user adalah admin
$is_admin = ($role == 'admin' || $role == 'resepsionis');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran</title>
    <style>
        /* Reset */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar */
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

        /* Container */
        .container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }

        /* Table */
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

        /* Badge */
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

        .badge-warning {
            background-color: rgb(218, 204, 22);
        }

        /* Image styling */
        .bukti-img {
            max-width: 100px;
            height: auto;
        }

        /* Button styling */
        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'navbar.php';
        ?>

        <div class="content">
            <h1>Data Pembayaran</h1>
            <table class="table">
                <thead>
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
                                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'sukses'): ?>
                                        <span class="badge badge-success"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'pending'): ?>
                                        <span class="badge badge-warning"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'batal'): ?>
                                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'dibatalkan'): ?>
                                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['bukti_pembayaran']): ?>
                                        <img src="assets/bukti_pembayaran/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" class="bukti-img" alt="Bukti Pembayaran">
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
                                                <button type="submit" class="btn-success">Tandai Sukses</button>
                                            </form>
                                        <?php elseif ($row['status'] == 'batal'): ?>
                                            <form action="konfirmasi_batal.php" method="POST">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row['id'] ?>">
                                                <input type="hidden" name="id_reservasi" value="<?= $row['id_reservasi'] ?>">
                                                <input type="hidden" name="id_kamar" value="<?= $row['id_kamar'] ?>">
                                                <button type="submit" class="btn-danger">Tandai Dibatalkan</button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="hapus_pembayaran.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?');">
                                            <input type="hidden" name="id_pembayaran" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="8" class="no-data">Tidak ada data pembayaran tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

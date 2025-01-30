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
    <title>Data Kamar</title>
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
    align-items: center;
    padding: 10px 20px;
}

.navbar-brand a {
    font-size: 1.5em;
    font-weight: bold;
    color: white;
    text-decoration: none;
}

.navbar-links {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.navbar-links a {
    color: white;
    text-decoration: none;
    font-size: 1em;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar-links a.active {
    background-color: #0056b3;
}

.navbar-links a:hover {
    background-color: #0056b3;
}

.logout-btn {
    background-color: #dc3545;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9em;
}

.logout-btn:hover {
    background-color: #a71d2a;
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

.badge-warning {
  background-color: #ffc107;
  color: black;
}

.badge-danger {
  background-color: #dc3545;
}

.btn {
  padding: 5px 10px;
  border: none;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 0.9em;
  transition: background 0.3s ease;
}

.btn-edit {
  background-color: #007bff;
}

.btn-edit:hover {
  background-color: #0056b3;
}

.btn-delete {
  background-color: #dc3545;
}

.btn-delete:hover {
  background-color: #a71d2a;
}
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'navbar.php';
        ?>
        <div class="content">
            <h1>Data Kamar</h1>
            <a href="tambah_kamar.php" class="btn btn-edit">Tambah Kamar</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Kamar</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php';
                    $sql_kamar = "SELECT * FROM kamar";
                    $result_kamar = $conn->query($sql_kamar);
                    if ($result_kamar->num_rows > 0):
                        $no = 1;
                        while ($row = $result_kamar->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nomor_kamar']) ?></td>
                                <td><?= htmlspecialchars($row['tipe']) ?></td>
                                <td>Rp<?= number_format($row['harga'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'tersedia'): ?>
                                        <span class="badge badge-success"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php elseif ($row['status'] == 'terisi'): ?>
                                        <span class="badge badge-warning"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><?= htmlspecialchars($row['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_kamar.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                                    <a href="hapus_kamar.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="6" class="no-data">Tidak ada data kamar tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

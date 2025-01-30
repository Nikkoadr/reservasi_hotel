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
        form {
          display: flex;
          flex-direction: column;
          gap: 15px;
          max-width: 600px;
          margin: 20px auto;
          padding: 20px;
          background-color: #f9f9f9;
          border-radius: 8px;
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form label {
          font-size: 1em;
          font-weight: bold;
          margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select {
          width: 100%;
          padding: 10px;
          font-size: 1em;
          border: 1px solid #ccc;
          border-radius: 5px;
          box-sizing: border-box;
        }

        form textarea {
          resize: vertical;
        }

        form button {
          background-color: #007bff;
          color: white;
          border: none;
          padding: 10px 15px;
          font-size: 1em;
          border-radius: 5px;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }

        form button:hover {
          background-color: #0056b3;
        }

        form .btn-back {
          background-color: #6c757d;
          text-decoration: none;
          display: inline-block;
          padding: 10px 15px;
          color: white;
          font-size: 1em;
          border-radius: 5px;
          margin-bottom: 15px;
          transition: background-color 0.3s ease;
        }

        form .btn-back:hover {
          background-color: #5a6268;
        }

        form .error {
          color: #dc3545;
          font-size: 0.9em;
          margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include 'navbar.php';
        ?>
            <div class="container">
                
                <?php if (isset($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <form action="create_kamar.php" method="POST">
                    <h1>Tambah Kamar</h1>
                    <label for="nomor_kamar">Nomor Kamar</label>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" required>

                    <label for="tipe">Tipe</label>
                    <input type="text" id="tipe" name="tipe" required>

                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" required step="0.01" min="0">

                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>

                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="dibersihkan">Dibersihkan</option>
                        <option value="terpesan">Terpesan</option>
                    </select>

                    <button type="submit">Simpan</button>
                </form>
            </div>
    </div>
</body>
</html>

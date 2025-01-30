<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: data_kamar.php");
    exit;
}

$id_kamar = intval($_GET['id']);

$sql_kamar = "SELECT * FROM kamar WHERE id = ?";
$stmt = $conn->prepare($sql_kamar);
$stmt->bind_param("i", $id_kamar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: data_kamar.php");
    exit;
}

$kamar = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container a {
            text-decoration: none;
            color: #007bff;
            font-size: 0.9em;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Edit Kamar</h1>
        <form action="update_kamar.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($kamar['id']) ?>">

            <label for="nomor_kamar">Nomor Kamar</label>
            <input type="text" id="nomor_kamar" name="nomor_kamar" value="<?= htmlspecialchars($kamar['nomor_kamar']) ?>" required>

            <label for="tipe">Tipe</label>
            <input type="text" id="tipe" name="tipe" value="<?= htmlspecialchars($kamar['tipe']) ?>" required>

            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" value="<?= htmlspecialchars($kamar['harga']) ?>" required step="0.01" min="0">

            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($kamar['deskripsi']) ?></textarea>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="tersedia" <?= $kamar['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="dibersihkan" <?= $kamar['status'] === 'dibersihkan' ? 'selected' : '' ?>>Dibersihkan</option>
                <option value="terpesan" <?= $kamar['status'] === 'terpesan' ? 'selected' : '' ?>>Terpesan</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="data_kamar.php">Kembali ke Data Kamar</a>
    </div>
</body>
</html>

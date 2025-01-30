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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4">
        <?php include 'navbar.php'; ?>
            <div class="form-container bg-light p-4 rounded shadow-sm">
                <h1>Edit Kamar</h1>
                <form action="update_kamar.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($kamar['id']) ?>">

                    <div class="mb-3">
                        <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                        <input type="text" id="nomor_kamar" name="nomor_kamar" class="form-control" value="<?= htmlspecialchars($kamar['nomor_kamar']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <input type="text" id="tipe" name="tipe" class="form-control" value="<?= htmlspecialchars($kamar['tipe']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" id="harga" name="harga" class="form-control" value="<?= htmlspecialchars($kamar['harga']) ?>" required step="0.01" min="0">
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($kamar['deskripsi']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="tersedia" <?= $kamar['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                            <option value="dibersihkan" <?= $kamar['status'] === 'dibersihkan' ? 'selected' : '' ?>>Dibersihkan</option>
                            <option value="terpesan" <?= $kamar['status'] === 'terpesan' ? 'selected' : '' ?>>Terpesan</option>
                        </select>
                    </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="data_kamar.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

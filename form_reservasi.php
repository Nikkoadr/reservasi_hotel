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

$id_kamar = $_GET['id'] ?? null;
if (!$id_kamar) {
    echo "ID kamar tidak ditemukan!";
    exit;
}

$sql_kamar = "SELECT * FROM kamar WHERE id = ?";
$stmt = $conn->prepare($sql_kamar);
$stmt->bind_param("i", $id_kamar);
$stmt->execute();
$result = $stmt->get_result();
$kamar = $result->fetch_assoc();

if (!$kamar) {
    echo "Kamar tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-4">
        <?php include 'navbar.php'; ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="text-center text-primary mb-4">Form Reservasi</h1>

                <form action="proses_reservasi.php" method="POST">
                    <input type="hidden" name="id_kamar" value="<?= htmlspecialchars($kamar['id']) ?>">

                    <div class="mb-3">
                        <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                        <input type="text" id="nomor_kamar" class="form-control" value="<?= htmlspecialchars($kamar['nomor_kamar']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Kamar</label>
                        <input type="text" id="tipe" class="form-control" value="<?= htmlspecialchars($kamar['tipe']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga per Malam</label>
                        <input type="text" id="harga" class="form-control" value="Rp<?= number_format($kamar['harga'], 0, ',', '.') ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_check_in" class="form-label">Tanggal Check-in</label>
                        <input type="date" name="tanggal_check_in" id="tanggal_check_in" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_check_out" class="form-label">Tanggal Check-out</label>
                        <input type="date" name="tanggal_check_out" id="tanggal_check_out" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Lanjutkan Reservasi</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

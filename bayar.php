<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id_pembayaran'])) {
    $id_pembayaran = $_GET['id_pembayaran'];

    $query = mysqli_query($conn, "SELECT pembayaran.*, reservasi.tanggal_check_in, reservasi.tanggal_check_out, reservasi.id_kamar
                                  FROM pembayaran 
                                  INNER JOIN reservasi ON pembayaran.id_reservasi = reservasi.id 
                                  WHERE pembayaran.id = $id_pembayaran 
                                  AND pembayaran.status = 'belum dibayar'");

    $pembayaran = mysqli_fetch_assoc($query);

    if (!$pembayaran) {
        echo "Pembayaran tidak valid atau sudah dibayar.";
        exit;
    }
} else {
    echo "ID pembayaran tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bukti_pembayaran = $_FILES['bukti_pembayaran'];

    if ($bukti_pembayaran['error'] == 0) {
        $upload_dir = 'assets/bukti_pembayaran/';
        $file_name = time() . '_' . basename($bukti_pembayaran['name']);
        $upload_path = $upload_dir . $file_name;

        if (move_uploaded_file($bukti_pembayaran['tmp_name'], $upload_path)) {
            $update_query = "UPDATE pembayaran 
                            SET status = 'pending',
                                bukti_pembayaran = '$file_name' 
                            WHERE id = $id_pembayaran";
            mysqli_query($conn, $update_query);

            $id_kamar = $pembayaran['id_kamar'];
            $update_kamar_query = "UPDATE kamar 
                                SET status = 'terpesan' 
                                WHERE id = $id_kamar";
            mysqli_query($conn, $update_kamar_query);

            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = "Gagal mengunggah bukti transfer!";
        }
    } else {
        $error_message = "Silakan unggah bukti transfer!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Reservasi</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="text-center text-primary mb-4">Pembayaran Reservasi</h1>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>

            <p><strong>Detail Pembayaran:</strong></p>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Check-in:</strong> <?= $pembayaran['tanggal_check_in'] ?></li>
                <li class="list-group-item"><strong>Check-out:</strong> <?= $pembayaran['tanggal_check_out'] ?></li>
                <li class="list-group-item"><strong>Total Pembayaran:</strong> Rp<?= number_format($pembayaran['jumlah'], 0, ',', '.') ?></li>
            </ul>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="bank_tujuan" class="form-label">Transfer Ke BRI: 123-456-789-098-321 A/N Cluckin' Bell Hotel</label>
                </div>

                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran:</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim bukti Transfer</button>
            </form>

            <a href="dashboard.php" class="btn btn-secondary w-100 mt-3">Kembali</a>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

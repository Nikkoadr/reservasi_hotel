<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID Pembayaran dari URL
if (isset($_GET['id_pembayaran'])) {
    $id_pembayaran = $_GET['id_pembayaran'];

    // Ambil informasi pembayaran dari database
    $query = mysqli_query($conn, "SELECT p.*, r.tanggal_check_in, r.tanggal_check_out 
                                  FROM pembayaran p 
                                  INNER JOIN reservasi r ON p.id_reservasi = r.id 
                                  WHERE p.id = $id_pembayaran AND p.status = 'belum dibayar'");

    $pembayaran = mysqli_fetch_assoc($query);

    if (!$pembayaran) {
        // Pembayaran tidak ditemukan atau sudah dibayar
        echo "Pembayaran tidak valid atau sudah dibayar.";
        exit;
    }
} else {
    echo "ID pembayaran tidak ditemukan.";
    exit;
}

// Jika tombol bayar ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank_tujuan = $_POST['bank_tujuan'];
    $bukti_transfer = $_FILES['bukti_transfer'];

    // Cek apakah file upload sudah ada
    if ($bukti_transfer['error'] == 0) {
        // Tentukan lokasi upload file
        $upload_dir = 'uploads/bukti_transfer/';
        $file_name = time() . '_' . basename($bukti_transfer['name']);
        $upload_path = $upload_dir . $file_name;

        // Pindahkan file yang di-upload ke direktori tujuan
        if (move_uploaded_file($bukti_transfer['tmp_name'], $upload_path)) {
            // Simpan informasi bukti transfer di database
            $update_query = "UPDATE pembayaran 
                            SET status = 'pending',
                                bukti_transfer = '$file_name' 
                            WHERE id = $id_pembayaran";
            mysqli_query($conn, $update_query);

            // Redirect ke halaman sukses pembayaran
            header("Location: sukses_pembayaran.php");
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
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .alert {
            padding: 15px;
            background-color: #ffc107;
            color: black;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Pembayaran Reservasi</h1>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <p><strong>Detail Pembayaran:</strong></p>
    <ul>
        <li>Check-in: <?= $pembayaran['tanggal_check_in'] ?></li>
        <li>Check-out: <?= $pembayaran['tanggal_check_out'] ?></li>
        <li>Total Pembayaran: Rp<?= number_format($pembayaran['jumlah'], 0, ',', '.') ?></li>
    </ul>

    <form method="POST" enctype="multipart/form-data">
        <label for="bank_tujuan">Transfer Ke BRI: 123-456-789-098-321 A/N Cluckin' Bell Hotel</label>
        <br><br>

        <label for="bukti_transfer">Unggah Bukti Transfer: </label>
        <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required>
        <br><br>

        <button type="submit" class="btn">Kirim bukti Transfer</button>
        <a href="dashboard.php" class="btn">Kembali</a>
    </form>
</div>

</body>
</html>

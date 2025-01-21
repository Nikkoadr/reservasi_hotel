<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID reservasi dari URL
if (isset($_GET['id_reservasi'])) {
    $id_reservasi = $_GET['id_reservasi'];

    // Ambil data reservasi beserta kamar dan pembayaran terkait
    $query = mysqli_query($conn, "SELECT 
                                    r.id AS reservasi_id, 
                                    u.nama AS nama_pemesan, 
                                    u.email, 
                                    k.nomor_kamar, 
                                    k.tipe, 
                                    k.harga, 
                                    r.tanggal_check_in, 
                                    r.tanggal_check_out, 
                                    r.total_pembayaran, 
                                    p.status AS status_pembayaran 
                                  FROM reservasi r
                                  INNER JOIN users u ON r.id_user = u.id
                                  INNER JOIN kamar k ON r.id_kamar = k.id
                                  INNER JOIN pembayaran p ON p.id_reservasi = r.id
                                  WHERE r.id = $id_reservasi");

    $reservasi = mysqli_fetch_assoc($query);

    if (!$reservasi) {
        echo "Data reservasi tidak ditemukan.";
        exit;
    }
} else {
    echo "ID reservasi tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Reservasi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .invoice-box { border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto; }
        h2 { text-align: center; }
        .info-table td { padding: 5px 10px; }
        .total { font-weight: bold; font-size: 1.2em; }
        .status { color: <?= ($reservasi['status_pembayaran'] == 'sukses') ? 'green' : 'red'; ?>; }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2>INVOICE RESERVASI</h2>
    <table class="info-table">
        <tr>
            <td><strong>No. Reservasi:</strong></td>
            <td><?= $reservasi['reservasi_id']; ?></td>
        </tr>
        <tr>
            <td><strong>Nama Pemesan:</strong></td>
            <td><?= $reservasi['nama_pemesan']; ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?= $reservasi['email']; ?></td>
        </tr>
        <tr>
            <td><strong>Nomor Kamar:</strong></td>
            <td><?= $reservasi['nomor_kamar']; ?></td>
        </tr>
        <tr>
            <td><strong>Tipe Kamar:</strong></td>
            <td><?= $reservasi['tipe']; ?></td>
        </tr>
        <tr>
            <td><strong>Harga per Malam:</strong></td>
            <td>Rp<?= number_format($reservasi['harga'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><strong>Check-in:</strong></td>
            <td><?= $reservasi['tanggal_check_in']; ?></td>
        </tr>
        <tr>
            <td><strong>Check-out:</strong></td>
            <td><?= $reservasi['tanggal_check_out']; ?></td>
        </tr>
        <tr>
            <td class="total"><strong>Total Pembayaran:</strong></td>
            <td class="total">Rp<?= number_format($reservasi['total_pembayaran'], 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><strong>Status Pembayaran:</strong></td>
            <td class="status"><?= strtoupper($reservasi['status_pembayaran']); ?></td>
        </tr>
    </table>
    <br>
    <p style="text-align: center;">Terima kasih atas reservasi Anda!</p>
</div>

</body>
</html>

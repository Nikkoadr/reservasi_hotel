<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_reservasi = $_POST['id_reservasi'];
    $id_kamar = $_POST['id_kamar'];

    $update_pembayaran = mysqli_query($conn, "
        UPDATE pembayaran SET status = 'dibatalkan' WHERE id = $id_pembayaran
    ");

    $update_reservasi = mysqli_query($conn, "
        UPDATE reservasi SET status = 'batal' WHERE id = $id_reservasi
    ");

    $update_kamar = mysqli_query($conn, "
        UPDATE kamar SET status = 'tersedia' WHERE id = $id_kamar
    ");

    if ($update_pembayaran && $update_reservasi && $update_kamar) {
        echo "<script>
            alert('Pembayaran berhasil dibatalkan.');
            window.location.href = 'data_pembayaran.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal membatalkan pembayaran. Silakan coba lagi.');
            window.location.href = 'data_pembayaran.php';
        </script>";
    }
}
?>

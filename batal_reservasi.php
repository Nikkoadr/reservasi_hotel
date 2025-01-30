<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_pembayaran'])) {
    echo "ID Pembayaran tidak ditemukan.";
    exit;
}

$id_pembayaran = $_GET['id_pembayaran'];
$id_user = $_SESSION['id_user'];

$query_validasi = mysqli_query($conn, "
    SELECT pembayaran.id
    FROM pembayaran
    INNER JOIN reservasi ON pembayaran.id_reservasi = reservasi.id
    WHERE pembayaran.id = $id_pembayaran AND reservasi.id_user = $id_user
");

if (mysqli_num_rows($query_validasi) === 0) {
    echo "Pembayaran tidak ditemukan atau tidak milik Anda.";
    exit;
}

$update_pembayaran = mysqli_query($conn, "
    UPDATE pembayaran SET status = 'batal' WHERE id = $id_pembayaran
");

if ($update_pembayaran) {
    echo "<script>
        alert('Pembayaran berhasil dibatalkan.');
        window.location.href = 'dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal membatalkan pembayaran. Silakan coba lagi.');
        window.location.href = 'dashboard.php';
    </script>";
}
?>

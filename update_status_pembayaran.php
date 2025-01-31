<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id_pembayaran']) && isset($_POST['id_reservasi'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_reservasi = $_POST['id_reservasi'];

    $sql_update_pembayaran = "UPDATE pembayaran SET status = 'sukses' WHERE id = $id_pembayaran";
    $conn->query($sql_update_pembayaran);

    $sql_update_reservasi = "UPDATE reservasi SET status = 'booked' WHERE id = $id_reservasi";
    $conn->query($sql_update_reservasi);

    header("Location: data_pembayaran.php");
    exit;
}
?>


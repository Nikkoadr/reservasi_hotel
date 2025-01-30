<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'resepsionis')) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pembayaran'])) {
    $id_pembayaran = $_POST['id_pembayaran'];

    $sql_delete = "DELETE FROM pembayaran WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_pembayaran);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Pembayaran berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus pembayaran.";
    }

    $stmt->close();
    $conn->close();
    
    header("Location: data_pembayaran.php");
    exit;
} else {
    header("Location: data_pembayaran.php");
    exit;
}
?>

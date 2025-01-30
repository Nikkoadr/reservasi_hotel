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

$sql_delete = "DELETE FROM kamar WHERE id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("i", $id_kamar);

if ($stmt->execute()) {
    $_SESSION['message'] = "Kamar berhasil dihapus.";
    header("Location: data_kamar.php");
    exit;
} else {
    $_SESSION['error'] = "Gagal menghapus kamar.";
    header("Location: data_kamar.php");
    exit;
}

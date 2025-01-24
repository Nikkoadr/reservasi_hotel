<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah parameter id tersedia
if (!isset($_GET['id'])) {
    header("Location: data_kamar.php");
    exit;
}

$id_kamar = intval($_GET['id']); // Validasi ID untuk mencegah serangan SQL Injection

// Query untuk menghapus kamar
$sql_delete = "DELETE FROM kamar WHERE id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("i", $id_kamar);

if ($stmt->execute()) {
    // Redirect kembali ke halaman data kamar dengan pesan sukses
    $_SESSION['message'] = "Kamar berhasil dihapus.";
    header("Location: data_kamar.php");
    exit;
} else {
    // Redirect kembali ke halaman data kamar dengan pesan error
    $_SESSION['error'] = "Gagal menghapus kamar.";
    header("Location: data_kamar.php");
    exit;
}

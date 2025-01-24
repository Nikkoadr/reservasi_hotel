<?php
include 'koneksi.php';
// Proses tambah kamar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_kamar = $_POST['nomor_kamar'];
    $tipe = $_POST['tipe'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $sql = "INSERT INTO kamar (nomor_kamar, tipe, harga, deskripsi, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $nomor_kamar, $tipe, $harga, $deskripsi, $status);

    if ($stmt->execute()) {
        header("Location: data_kamar.php");
        exit;
    } else {
        $error = "Terjadi kesalahan saat menambahkan kamar.";
    }

    $stmt->close();
}
?>
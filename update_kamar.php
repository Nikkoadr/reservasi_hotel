<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kamar = intval($_POST['id']);
    $nomor_kamar = $_POST['nomor_kamar'];
    $tipe = $_POST['tipe'];
    $harga = floatval($_POST['harga']);
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $sql_update = "UPDATE kamar SET nomor_kamar = '$nomor_kamar', tipe = '$tipe', harga = $harga, deskripsi = '$deskripsi', status = '$status' WHERE id = $id_kamar";

    if ($conn->query($sql_update) === TRUE) {
        $_SESSION['message'] = "Data kamar berhasil diperbarui.";
        header("Location: data_kamar.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memperbarui data kamar.";
        header("Location: edit_kamar.php?id=$id_kamar");
        exit;
    }
} else {
    header("Location: data_kamar.php");
    exit;
}
?>

<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reservasi = $_POST['id_reservasi'];
    $status = $_POST['status'];

    $sql_update = "UPDATE reservasi SET status = '$status' WHERE id = $id_reservasi";
    $conn->query($sql_update);

    if ($status == 'check-out') {
        $sql_get_kamar = "SELECT id_kamar FROM reservasi WHERE id = $id_reservasi";
        $result = $conn->query($sql_get_kamar);
        if ($row = $result->fetch_assoc()) {
            $id_kamar = $row['id_kamar'];
            $sql_update_kamar = "UPDATE kamar SET status = 'dibersihkan' WHERE id = $id_kamar";
            $conn->query($sql_update_kamar);
        }
    }

    header("Location: data_reservasi.php");
}
?>

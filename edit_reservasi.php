<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reservasi = $_POST['id_reservasi'];
    $status = $_POST['status'];

    // Update status reservasi
    $sql_update = "UPDATE reservasi SET status = '$status' WHERE id = $id_reservasi";
    $conn->query($sql_update);

    // Jika check-out, ubah status kamar menjadi 'dibersihkan'
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

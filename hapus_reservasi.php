<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reservasi = $_POST['id_reservasi'];

    $sql_delete = "DELETE FROM reservasi WHERE id = $id_reservasi";
    $conn->query($sql_delete);

    header("Location: data_reservasi.php");
}
?>

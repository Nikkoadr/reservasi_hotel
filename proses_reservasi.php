<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kamar = $_POST['id_kamar'];
    $tanggal_check_in = $_POST['tanggal_check_in'];
    $tanggal_check_out = $_POST['tanggal_check_out'];
    $id_user = $_SESSION['id_user'];

    $result_harga = mysqli_query($conn, "SELECT harga FROM kamar WHERE id = $id_kamar");
    $row_harga = mysqli_fetch_assoc($result_harga);
    $harga_per_malam = $row_harga['harga'];

    $datetime1 = new DateTime($tanggal_check_in);
    $datetime2 = new DateTime($tanggal_check_out);
    $interval = $datetime1->diff($datetime2);
    $jumlah_hari = $interval->days;
    $total_harga = $jumlah_hari * $harga_per_malam;


    mysqli_query($conn, "INSERT INTO reservasi (id_user, id_kamar, tanggal_check_in, tanggal_check_out, total_pembayaran, status) 
                        VALUES ($id_user, $id_kamar, '$tanggal_check_in', '$tanggal_check_out', $total_harga, 'pending')");
    $id_reservasi = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO pembayaran (id_reservasi, tanggal_pembayaran, jumlah, status) 
                        VALUES ($id_reservasi, NOW(), $total_harga, 'belum dibayar')");

    header("Location: dashboard.php");
    exit;
} else {
    echo "Metode request tidak valid!";
}
?>

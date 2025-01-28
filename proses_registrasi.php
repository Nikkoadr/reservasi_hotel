<?php
session_start(); // Memulai session
include 'koneksi.php';

// Memeriksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menyimpan data ke dalam database tanpa mengenkripsi password
    $sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', 'tamu')";
    
    if ($conn->query($sql) === TRUE) {
        // Mengambil id_user terakhir yang dimasukkan
        $id_user = $conn->insert_id;

        // Menyimpan informasi user ke dalam session
        $_SESSION['id_user'] = $id_user;
        $_SESSION['nama'] = $nama;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'tamu'; // Sesuaikan dengan role yang diinginkan

        // Redirect ke halaman dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

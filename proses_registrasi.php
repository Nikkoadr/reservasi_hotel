<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email sudah terdaftar
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email sudah terdaftar, kirim notifikasi
        echo "<script>alert('Email sudah terdaftar! Silakan login'); window.location.href='registrasi.php';</script>";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user baru
        $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'tamu')");
        $stmt->bind_param("sss", $nama, $email, $hashed_password);

        if ($stmt->execute()) {
            // Ambil ID pengguna yang baru dibuat
            $id_user = $stmt->insert_id;

            // Simpan data di sesi
            $_SESSION['id_user'] = $id_user;
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'tamu';

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

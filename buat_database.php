<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reservasi_hotel";

try {

    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->exec("USE $dbname");


    $conn->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'resepsionis', 'tamu') NOT NULL
        )"
    );

    $conn->exec(
        "CREATE TABLE IF NOT EXISTS kamar (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nomor_kamar VARCHAR(10) NOT NULL UNIQUE,
            tipe VARCHAR(50) NOT NULL,
            harga DECIMAL(10,2) NOT NULL,
            deskripsi TEXT,
            status ENUM('tersedia', 'terpesan', 'dibersihkan') NOT NULL
        )"
    );

    $conn->exec(
        "CREATE TABLE IF NOT EXISTS reservasi (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_kamar INT NOT NULL,
            id_user INT NOT NULL,
            tanggal_check_in DATE NOT NULL,
            tanggal_check_out DATE NOT NULL,
            total_pembayaran DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'booked', 'batal','check-in', 'check-out') NOT NULL,
            FOREIGN KEY (id_kamar) REFERENCES kamar(id) ON DELETE CASCADE,
            FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
        )"
    );


    $conn->exec(
        "CREATE TABLE IF NOT EXISTS pembayaran (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_reservasi INT NOT NULL,
            tanggal_pembayaran DATE NOT NULL,
            jumlah DECIMAL(10,2) NOT NULL,
            status ENUM('belum dibayar', 'pending', 'sukses', 'batal', 'dibatalkan') NOT NULL,
            bukti_pembayaran VARCHAR(255) NULL,
            FOREIGN KEY (id_reservasi) REFERENCES reservasi(id) ON DELETE CASCADE
        )"
    );


    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    $resepsionis_password = password_hash('resepsionis123', PASSWORD_DEFAULT);


    $conn->exec(
        "INSERT IGNORE INTO users (nama, email, password, role) VALUES
        ('Admin', 'admin@gmail.com', '$admin_password', 'admin'),
        ('Resepsionis', 'resepsionis@gmail.com', '$resepsionis_password', 'resepsionis')"
    );


    $conn->exec(
        "INSERT IGNORE INTO kamar (nomor_kamar, tipe, harga, deskripsi, status) VALUES
        ('101', 'Standard', 500000, 'Kamar standar dengan fasilitas dasar', 'tersedia'),
        ('102', 'Standard', 500000, 'Kamar standar dengan fasilitas dasar', 'tersedia'),
        ('103', 'Deluxe', 750000, 'Kamar deluxe dengan pemandangan kota', 'tersedia'),
        ('104', 'Deluxe', 750000, 'Kamar deluxe dengan pemandangan kota', 'tersedia'),
        ('105', 'Suite', 1200000, 'Kamar suite mewah dengan ruang tamu', 'tersedia'),
        ('106', 'Suite', 1200000, 'Kamar suite mewah dengan ruang tamu', 'tersedia'),
        ('107', 'Family', 900000, 'Kamar keluarga dengan 2 ranjang queen', 'tersedia'),
        ('108', 'Family', 900000, 'Kamar keluarga dengan 2 ranjang queen', 'tersedia'),
        ('109', 'Presidential', 3000000, 'Kamar mewah dengan fasilitas premium', 'tersedia'),
        ('110', 'Presidential', 3000000, 'Kamar mewah dengan fasilitas premium', 'tersedia')"
    );

    echo "Database dan tabel berhasil dibuat dan diisi dengan data awal.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

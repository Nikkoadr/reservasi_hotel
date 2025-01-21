-- Database: reservasi_hotel
CREATE DATABASE IF NOT EXISTS reservasi_hotel;
USE reservasi_hotel;

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Resepsionis', 'Tamu') NOT NULL
);

-- Tabel kamar
CREATE TABLE kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_kamar VARCHAR(10) NOT NULL UNIQUE,
    tipe VARCHAR(50) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    status ENUM('tersedia', 'dibersihkan', 'terpesan') NOT NULL
);

-- Tabel reservasi
CREATE TABLE reservasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kamar INT NOT NULL,
    id_user INT NOT NULL,
    tanggal_check_in DATE NOT NULL,
    tanggal_check_out DATE NOT NULL,
    total_pembayaran DECIMAL(10,2) NOT NULL,
    status ENUM('aktif', 'dibatalkan') NOT NULL,
    FOREIGN KEY (id_kamar) REFERENCES kamar(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

-- Tabel pembayaran
CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_reservasi INT NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    status ENUM('belum dibayar', 'pending', 'sukses', 'gagal') NOT NULL,
    FOREIGN KEY (id_reservasi) REFERENCES reservasi(id)
);

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
    status ENUM('tersedia', 'terpesan') NOT NULL
);

-- Tabel reservasi
CREATE TABLE reservasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kamar INT NOT NULL,
    id_user INT NOT NULL,
    tanggal_check_in DATE NOT NULL,
    tanggal_check_out DATE NOT NULL,
    total_pembayaran DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'booked') NOT NULL,
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
    bukti_pembayaran VARCHAR(255) NULL, 
    FOREIGN KEY (id_reservasi) REFERENCES reservasi(id)
);

INSERT INTO users('nama', 'email', 'password','role') VALUES('Admin', 'admin@gmail.com', 'admin123', 'Admin'), 
('Resepsionis', 'resepsionis@gmail.com', 'resepsionis123', 'Resepsionis');

INSERT INTO kamar (nomor_kamar, tipe, harga, deskripsi, status) VALUES
(101, 'Standard', 500000, 'Kamar standar dengan fasilitas dasar', 'Tersedia'),
(102, 'Standard', 500000, 'Kamar standar dengan fasilitas dasar', 'Tersedia'),
(103, 'Deluxe', 750000, 'Kamar deluxe dengan pemandangan kota', 'Tersedia'),
(104, 'Deluxe', 750000, 'Kamar deluxe dengan pemandangan kota', 'Tersedia'),
(105, 'Suite', 1200000, 'Kamar suite mewah dengan ruang tamu', 'Tersedia'),
(106, 'Suite', 1200000, 'Kamar suite mewah dengan ruang tamu', 'Tersedia'),
(107, 'Family', 900000, 'Kamar keluarga dengan 2 ranjang queen', 'Tersedia'),
(108, 'Family', 900000, 'Kamar keluarga dengan 2 ranjang queen', 'Tersedia'),
(109, 'Presidential', 3000000, 'Kamar mewah dengan fasilitas premium', 'Tersedia'),
(110, 'Presidential', 3000000, 'Kamar mewah dengan fasilitas premium', 'Tersedia');

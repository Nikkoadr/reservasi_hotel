<?php
include 'koneksi.php';

$id_kamar = $_GET['id'] ?? null;
if (!$id_kamar) {
    echo "ID kamar tidak ditemukan!";
    exit;
}

$sql_kamar = "SELECT * FROM kamar WHERE id = ?";
$stmt = $conn->prepare($sql_kamar);
$stmt->bind_param("i", $id_kamar);
$stmt->execute();
$result = $stmt->get_result();
$kamar = $result->fetch_assoc();

if (!$kamar) {
    echo "Kamar tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Reservasi</h1>
        <form action="proses_reservasi.php" method="POST">
            <input type="hidden" name="id_kamar" value="<?= htmlspecialchars($kamar['id']) ?>">
            <label for="nomor_kamar">Nomor Kamar</label>
            <input type="text" id="nomor_kamar" value="<?= htmlspecialchars($kamar['nomor_kamar']) ?>" disabled>

            <label for="tipe">Tipe Kamar</label>
            <input type="text" id="tipe" value="<?= htmlspecialchars($kamar['tipe']) ?>" disabled>

            <label for="harga">Harga per Malam</label>
            <input type="text" id="harga" value="Rp<?= number_format($kamar['harga'], 0, ',', '.') ?>" disabled>

            <label for="tanggal_check_in">Tanggal Check-in</label>
            <input type="date" name="tanggal_check_in" id="tanggal_check_in" required>

            <label for="tanggal_check_out">Tanggal Check-out</label>
            <input type="date" name="tanggal_check_out" id="tanggal_check_out" required>


            <button type="submit" class="btn">Lanjutkan Reservasi</button>
        </form>
    </div>
</body>
</html>

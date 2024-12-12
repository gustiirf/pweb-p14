<?php
include 'config.php';

$sql = "SELECT COUNT(*) as total_pendaftar FROM calon_siswa";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_pendaftar = $row['total_pendaftar'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMAN 1 SUMENEP</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <header>
        <h1>Pendaftaran Siswa Baru</h1>
        <h2>SMAN 1 SUMENEP</h2>
    </header>
    
    <main>
        <div class="container">
            <img src="logo.jpg" alt="Logo Sekolah">
        </div>
        <nav class="menu">
            <h3>Menu</h3>
            <!-- Ganti "onclick" menjadi "window.location.href" agar tombol benar-benar mengarahkan ke link -->
            <button onclick="window.location.href='http://localhost/TUGASPWEB/p12/Form/form.php'">Daftar</button>
            <button onclick="viewRegistrants(list.php)">Pendaftar</button>
        </nav>
    </main>

    <script src="./asset/script.js"></script>
</body>
</html>
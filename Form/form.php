<?php

include '../config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $penjaga_id = $_POST['penjaga_id'];

    // Tangani unggahan foto
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];

    if ($foto) {
        $foto_path = "uploads/" . basename($foto); // Direktori penyimpanan
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        $foto_path = NULL; // Jika tidak ada foto diunggah
    }

    // Query untuk menambah siswa
    $sql = "INSERT INTO calon_siswa (nama, jenis_kelamin, alamat, email, sekolah_asal, penjaga_id, foto)
            VALUES ('$nama', '$jenis_kelamin', '$alamat', '$email', '$sekolah_asal', $penjaga_id, '$foto_path')";

    if ($conn->query($sql) === TRUE) {
        header("Location: list.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: left;
            background-color:  #C2B280; 
            margin: 0;
            padding: 0;
            color: black;
        }
        
        h1 {
            font-size: 2.5em;
            margin-top: 30px;
            font-weight: bold;
            letter-spacing: 2px;
            color: Black;
            text-align: center;
            background-color: #f5d986;
        }
        
        form {
            background-color: #f4f7f6;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            width: 50%;
        }
        
        label {
            font-size: 1.1em;
            color: black; /* Text color set to black */
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        
        input, select, textarea {
            font-size: 1em;
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: black; /* Ensuring text color in the form fields is black */
        }
        
        input[type="submit"] {
            background-color:  #C2B280; /* Blue submit button */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
            padding: 15px 20px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }
        
        input[type="submit"]:hover {
            background-color:  #C2B280; /* Darker blue on hover */
        }
        
        select, textarea {
            font-size: 1em;
            color: black;
        }
        
        textarea {
            resize: vertical;
            height: 100px;
        }
    </style>
</head>
<body>

    <h1>Tambah Siswa Baru</h1>
    <form method="POST" enctype="multipart/form-data">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required>

    <label for="jenis_kelamin">Jenis Kelamin:</label>
    <select id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select>

    <label for="alamat">Alamat:</label>
    <textarea id="alamat" name="alamat" required></textarea>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="sekolah_asal">Asal Sekolah:</label>
    <input type="text" id="sekolah_asal" name="sekolah_asal" required>

    <label for="penjaga_id">Pegawai yang Menangani:</label>
    <select id="penjaga_id" name="penjaga_id" required>
        <?php
        // Ambil data pegawai dari database untuk dropdown
        $sql_penjaga = "SELECT id, nama FROM penjaga";
        $result_penjaga = $conn->query($sql_penjaga);
        while ($penjaga = $result_penjaga->fetch_assoc()) {
            echo "<option value='" . $penjaga['id'] . "'>" . $penjaga['nama'] . "</option>";
        }
        ?>
    </select>

    <label for="foto">Foto:</label>
    <input type="file" id="foto" name="foto" accept="image/*" required>

    <input type="submit" value="Tambah Siswa">
</form>
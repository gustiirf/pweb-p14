<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM calon_siswa WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data siswa tidak ditemukan.";
        exit();
    }
} else {
    echo "ID tidak ditemukan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $penjaga_id = $_POST['penjaga_id'];

    // Cek jika ada foto baru yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $foto_name = uniqid() . "_" . basename($foto['name']);
        $foto_path = "../uploads/" . $foto_name;

        if (move_uploaded_file($foto['tmp_name'], $foto_path)) {
            // Hapus foto lama
            if (!empty($row['foto'])) {
                unlink("../uploads/" . $row['foto']);
            }
            $update_sql = "UPDATE calon_siswa SET 
                            nama='$nama', 
                            jenis_kelamin='$jenis_kelamin', 
                            alamat='$alamat', 
                            email='$email', 
                            sekolah_asal='$sekolah_asal', 
                            penjaga_id='$penjaga_id', 
                            foto='$foto_name'
                          WHERE id=$id";
        }
    } else {
        $update_sql = "UPDATE calon_siswa SET 
                        nama='$nama', 
                        jenis_kelamin='$jenis_kelamin', 
                        alamat='$alamat', 
                        email='$email', 
                        sekolah_asal='$sekolah_asal', 
                        penjaga_id='$penjaga_id'
                      WHERE id=$id";
    }

    if ($conn->query($update_sql) === TRUE) {
        header("Location: list.php");
        exit();
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
    <title>Edit Data Siswa</title>
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
    <h1>Edit Data Siswa</h1>
    <form method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?= $row['nama']; ?>" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option value="Laki-laki" <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
            <option value="Perempuan" <?= $row['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
        </select>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required><?= $row['alamat']; ?></textarea>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $row['email']; ?>" required>

        <label for="sekolah_asal">Asal Sekolah:</label>
        <input type="text" id="sekolah_asal" name="sekolah_asal" value="<?= $row['sekolah_asal']; ?>" required>

        <label for="penjaga_id">Pegawai yang Menangani:</label>
        <select id="penjaga_id" name="penjaga_id" required>
            <?php
            $sql_penjaga = "SELECT id, nama FROM penjaga";
            $result_penjaga = $conn->query($sql_penjaga);
            while ($penjaga = $result_penjaga->fetch_assoc()) {
                $selected = $penjaga['id'] == $row['penjaga_id'] ? 'selected' : '';
                echo "<option value='" . $penjaga['id'] . "' $selected>" . $penjaga['nama'] . "</option>";
            }
            ?>
        </select>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*">
        <small>Biarkan kosong jika tidak ingin mengganti foto.</small>

        <input type="submit" value="Simpan Perubahan">
    </form>
</body>
</html>
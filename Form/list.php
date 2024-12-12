<?php
include '../config.php';

$sql_calon_siswa = "
    SELECT calon_siswa.*, penjaga.nama AS nama_penjaga 
    FROM calon_siswa 
    LEFT JOIN penjaga ON calon_siswa.penjaga_id = penjaga.id
";

$result_calon_siswa = $conn->query($sql_calon_siswa);

$sql_penjaga = "SELECT * FROM penjaga";
$result_penjaga = $conn->query($sql_penjaga);

if (isset($_GET['delete_siswa_id'])) {
    $delete_id = intval($_GET['delete_siswa_id']);
    $delete_sql = "DELETE FROM calon_siswa WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
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
    <title>Daftar Siswa dan Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C2B280;
            margin: 0;
            padding: 0;
            color: black;
        }
        h1 {
            text-align: center;
            background-color: #f5d986;
            color: black;
            padding: 10px;
        }
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            color: #000;
        }
        th {
            background-color: #f5d986;
            color: black;
        }
        tr:nth-child(even) {
            background-color: #e6dbb8;
        }
        tr:hover {
            background-color: #fff;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            margin: 0 2px;
        }
        .btn-edit {
            background-color: #fff202;
        }
        .btn-delete {
            background-color: #f44336;
        }
        img {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
        }
        .btn-download {
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 10px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>List Siswa</h1>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Asal Sekolah</th>
            <th>Pegawai Pendaftar</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = $result_calon_siswa->fetch_assoc()) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['jenis_kelamin']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['sekolah_asal']; ?></td>
            <td><?= $row['nama_penjaga'] ?? 'Belum Ditetapkan'; ?></td>
            <td>
                <?php if (!empty($row['foto'])) { ?>
                    <img src="uploads/<?= $row['foto']; ?>" alt="Foto Siswa">
                <?php } else { ?>
                    Tidak Ada Foto
                <?php } ?>
            </td>
            <td>
                <a href="edit_form.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="?delete_siswa_id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <a href="generate_pdf.php" class="btn-download">Download PDF</a>

    <h1>List Pegawai</h1>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Jabatan</th>
        </tr>
        <?php $no = 1; while ($row = $result_penjaga->fetch_assoc()) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['jabatan']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

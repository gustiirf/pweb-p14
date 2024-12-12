<?php
require_once 'fpdf.php';
include 'config.php'; 

// Query data siswa
$sql_calon_siswa = "
    SELECT calon_siswa.*, penjaga.nama AS nama_penjaga 
    FROM calon_siswa 
    LEFT JOIN penjaga ON calon_siswa.penjaga_id = penjaga.id
";
$result_calon_siswa = $conn->query($sql_calon_siswa);

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(277, 7, 'PENDAFTARAN SISWA', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(277, 7, 'DAFTAR SISWA', 0, 1, 'C');

// Space
$pdf->Cell(10, 7, '', 0, 1);

// Row Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 100);
$pdf->Cell(30, 6, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 6, 'Nama', 1, 0, 'C', true);
$pdf->Cell(30, 6, 'Jenis Kelamin', 1, 0, 'C', true);
$pdf->Cell(50, 6, 'Alamat', 1, 0, 'C', true);
$pdf->Cell(50, 6, 'Email', 1, 0, 'C', true);
$pdf->Cell(50, 6, 'Pegawai Pendaftar', 1, 0, 'C', true);

// Data
$pdf->SetFont('Arial', '', 10);
$pdf->SetFillColor(255, 255, 255);
while($siswa = mysqli_fetch_array($result_calon_siswa)) {
    $pdf->Cell(30, 6, $siswa['id'], 1, 0, 'C');
    $pdf->Cell(50, 6, $siswa['nama'], 1, 0, 'C');
    $pdf->Cell(30, 6, ($siswa['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'), 1, 0, 'C');
    $pdf->Cell(50, 6, $siswa['alamat'], 1, 0, 'C');
    $pdf->Cell(50, 6, $siswa['email'], 1, 0, 'C');
    $pdf->Cell(50, 6, $siswa['nama_pegawai'], 1, 0, 'C');
}

$pdf->Output('daftar_siswa.pdf', 'I');
?>
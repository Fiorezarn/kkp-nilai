<?php
require '../vendor/autoload.php'; // Sesuaikan path dengan lokasi file autoload dari PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xml;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$tipe = $_GET['tipe'];
$kd = $_GET['kd'];

// Ambil data nilai siswa dari database
$sql = "
    SELECT n.id_nilai, n.id_siswa, s.nama_siswa, s.nis, n.kd, n.tipe,
           n.tugas_1, n.tugas_2, n.tugas_3, n.tugas_4, n.tugas_5, n.tugas_6,
           n.uh_1, n.uh_2
    FROM nilai n
    JOIN siswa s ON n.id_siswa = s.id_siswa
    WHERE s.id_kelas = ? AND n.id_mapel = ? AND n.tipe = ? AND n.kd = ?
";
$query = $conn->prepare($sql);
$query->bind_param("iisi", $id_kelas, $id_mapel, $tipe, $kd);
$query->execute();
$result = $query->get_result();
$nilaiData = $result->fetch_all(MYSQLI_ASSOC);

// Ambil nama kelas
$sql_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas = ?";
$query_kelas = $conn->prepare($sql_kelas);
$query_kelas->bind_param("i", $id_kelas);
$query_kelas->execute();
$result_kelas = $query_kelas->get_result();
$kelas = $result_kelas->fetch_assoc();

// Ambil nama mapel
$sql_mapel = "SELECT nama_mapel FROM mapel WHERE id_mapel = ?";
$query_mapel = $conn->prepare($sql_mapel);
$query_mapel->bind_param("i", $id_mapel);
$query_mapel->execute();
$result_mapel = $query_mapel->get_result();
$mapel = $result_mapel->fetch_assoc();

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul kolom
$sheet->setCellValue('B1', 'DAFTAR NILAI ASESMEN AKHIR SEMESTER GENAP TP 2023/2024');
$sheet->setCellValue('B2', 'MATA PELAJARAN');
$sheet->setCellValue('C2', $mapel['nama_mapel']);
$sheet->setCellValue('B3', 'KELAS');
$sheet->setCellValue('C3', $kelas['nama_kelas']);
$sheet->setCellValue('B4', 'GURU MATA PELAJARAN');
$sheet->setCellValue('C4', 'Arif Hidayat Pratomo');

$sheet->setCellValue('A6', 'NO');
$sheet->setCellValue('B6', 'NAMA SISWA');

// Set header KD
$kds = ['KD1', 'KD2', 'KD3', 'KD4', 'KD5', 'KD6']; // Sesuaikan dengan jumlah KD yang ada
$columns = range('C', 'Z'); // Tentukan rentang kolom yang diperlukan
$index = 0;

// Hitung kolom yang dibutuhkan untuk KD dan nilai
$requiredColumns = count($kds) * 12; // 12 kolom per KD

// Tambahkan lebih banyak kolom jika diperlukan
if (count($columns) < $requiredColumns) {
    $additionalColumns = $requiredColumns - count($columns);
    for ($i = 0; $i < $additionalColumns; $i++) {
        $columns[] = chr(ord(end($columns)) + 1);
    }
}

// Debug output
echo "Jumlah kolom yang tersedia: " . count($columns) . "<br>";
echo "Jumlah kolom yang dibutuhkan: " . $requiredColumns . "<br>";

foreach ($kds as $kd) {
    $col_start = $columns[$index];
    $col_end = $columns[$index + 11];
    $range = $col_start . '6:' . $col_end . '6';

    // Debug output
    echo "Rentang sel untuk KD '$kd': $range<br>";

    // Pastikan rentang sel valid
    if ($index + 11 < count($columns)) {
        $sheet->mergeCells($range);
        $sheet->setCellValue($col_start . '6', $kd);
        for ($i = 0; $i < 6; $i++) {
            $sheet->setCellValue($columns[$index + $i * 2] . '7', 'TUGAS ' . ($i + 1));
            $sheet->setCellValue($columns[$index + $i * 2 + 1] . '7', 'UH ' . ($i + 1));
        }
        $index += 12;
    } else {
        throw new Exception('Rentang sel tidak valid untuk merge.');
    }
}

// Menambahkan data siswa dan nilai
$row = 8;
$no = 1;
foreach ($nilaiData as $nilai) {
    $sheet->setCellValue('A' . $row, $no++);
    $sheet->setCellValue('B' . $row, $nilai['nama_siswa']);

    $index = 0;
    foreach ($kds as $kd) {
        $sheet->setCellValue($columns[$index] . $row, $nilai['tugas_1']);
        $sheet->setCellValue($columns[$index + 1] . $row, $nilai['uh_1']);
        $sheet->setCellValue($columns[$index + 2] . $row, $nilai['tugas_2']);
        $sheet->setCellValue($columns[$index + 3] . $row, $nilai['uh_2']);
        $sheet->setCellValue($columns[$index + 4] . $row, $nilai['tugas_3']);
        $sheet->setCellValue($columns[$index + 5] . $row, null); // Ujian harian tidak ada di kolom ke 3
        $sheet->setCellValue($columns[$index + 6] . $row, $nilai['tugas_4']);
        $sheet->setCellValue($columns[$index + 7] . $row, null); // Ujian harian tidak ada di kolom ke 4
        $sheet->setCellValue($columns[$index + 8] . $row, $nilai['tugas_5']);
        $sheet->setCellValue($columns[$index + 9] . $row, null); // Ujian harian tidak ada di kolom ke 5
        $sheet->setCellValue($columns[$index + 10] . $row, $nilai['tugas_6']);
        $sheet->setCellValue($columns[$index + 11] . $row, null); // Ujian harian tidak ada di kolom ke 6
        $index += 12;
    }
    $row++;
}

// Buat format sel untuk header
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'rgb' => 'FFFF00',
        ],
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
];

$sheet->getStyle('A6:Z7')->applyFromArray($headerStyle);
$sheet->getStyle('A6:A' . ($row - 1))->applyFromArray($headerStyle);
$sheet->getStyle('B6:B' . ($row - 1))->applyFromArray($headerStyle);
$sheet->getStyle('C6:' . $columns[$index - 1] . '7')->applyFromArray($headerStyle);

// Tulis file Excel dalam format XML
$filename = 'Daftar_Nilai_Akhir.xml';
$writer = new Xml($spreadsheet);

header('Content-Type: application/vnd.ms-excel.sheet.mxml');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>

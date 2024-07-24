<?php
require '../vendor/autoload.php'; // Sesuaikan path jika PHPSpreadsheet berada di folder berbeda
include('../koneksi.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$kd = $_GET['kd'];

// Ambil data nilai siswa dari database berdasarkan kelas, mapel, dan kd
$sql = "
    SELECT n.id_nilai, n.id_siswa, s.nama_siswa, s.nis, n.kd, n.tipe,
           COALESCE(n.tugas_1, 'Belum Ada') as tugas_1,
           COALESCE(n.tugas_2, 'Belum Ada') as tugas_2,
           COALESCE(n.tugas_3, 'Belum Ada') as tugas_3,
           COALESCE(n.tugas_4, 'Belum Ada') as tugas_4,
           COALESCE(n.tugas_5, 'Belum Ada') as tugas_5,
           COALESCE(n.tugas_6, 'Belum Ada') as tugas_6,
           COALESCE(n.uh_1, 'Belum Ada') as uh_1,
           COALESCE(n.uh_2, 'Belum Ada') as uh_2
    FROM nilai n
    JOIN siswa s ON n.id_siswa = s.id_siswa
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND n.kd = $kd
";
$result = $conn->query($sql);
if (!$result) {
    die("Query error (nilai siswa): " . $conn->error . " - Query: " . $sql);
}

// Ambil nama kelas
$sql_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas = $id_kelas";
$result_kelas = $conn->query($sql_kelas);
if (!$result_kelas) {
    die("Query error (kelas): " . $conn->error . " - Query: " . $sql_kelas);
}
$kelas = $result_kelas->fetch_assoc();
if (!$kelas) {
    die("No data found for id_kelas = $id_kelas");
}

// Ambil nama mapel
$sql_mapel = "SELECT nama_mapel FROM mapel WHERE id_mapel = $id_mapel";
$result_mapel = $conn->query($sql_mapel);
if (!$result_mapel) {
    die("Query error (mapel): " . $conn->error . " - Query: " . $sql_mapel);
}
$mapel = $result_mapel->fetch_assoc();
if (!$mapel) {
    die("No data found for id_mapel = $id_mapel");
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set judul dan header
$sheet->setCellValue('A1', 'Data Nilai Siswa');
$sheet->setCellValue('A2', 'Kelas: ' . $kelas['nama_kelas']);
$sheet->setCellValue('A3', 'Mata Pelajaran: ' . $mapel['nama_mapel']);
$sheet->setCellValue('A4', 'KD: ' . $kd);

// Merge cell untuk KD dan pengaturan header
$sheet->mergeCells('A6:A7')->setCellValue('A6', 'Nama Siswa');
$sheet->mergeCells('B6:B7')->setCellValue('B6', 'NIS');
$sheet->mergeCells('C6:J6')->setCellValue('C6', 'KD ' . $kd . ' - Pengetahuan');
$sheet->mergeCells('K6:R6')->setCellValue('K6', 'KD ' . $kd . ' - Keterampilan');

$sheet->setCellValue('C7', 'Tugas 1')
    ->setCellValue('D7', 'Tugas 2')
    ->setCellValue('E7', 'Tugas 3')
    ->setCellValue('F7', 'Tugas 4')
    ->setCellValue('G7', 'Tugas 5')
    ->setCellValue('H7', 'Tugas 6')
    ->setCellValue('I7', 'UH 1')
    ->setCellValue('J7', 'UH 2')
    ->setCellValue('K7', 'Tugas 1')
    ->setCellValue('L7', 'Tugas 2')
    ->setCellValue('M7', 'Tugas 3')
    ->setCellValue('N7', 'Tugas 4')
    ->setCellValue('O7', 'Tugas 5')
    ->setCellValue('P7', 'Tugas 6')
    ->setCellValue('Q7', 'UH 1')
    ->setCellValue('R7', 'UH 2');

// Penerapan gaya untuk header
$styleArrayHeader = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FF4CAF50'],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

// Terapkan gaya ke header
$sheet->getStyle('A6:R7')->applyFromArray($styleArrayHeader);

// Mengumpulkan data dari database
$data_siswa = [];
while ($row = $result->fetch_assoc()) {
    $id_siswa = $row['id_siswa'];
    if (!isset($data_siswa[$id_siswa])) {
        $data_siswa[$id_siswa] = [
            'nama_siswa' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'pengetahuan' => [],
            'keterampilan' => [],
        ];
    }

    if ($row['tipe'] == 'pengetahuan') {
        $data_siswa[$id_siswa]['pengetahuan'] = [
            $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
            $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
            $row['uh_1'], $row['uh_2']
        ];
    } else if ($row['tipe'] == 'keterampilan') {
        $data_siswa[$id_siswa]['keterampilan'] = [
            $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
            $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
            $row['uh_1'], $row['uh_2']
        ];
    }
}

// Isi data ke spreadsheet
$rowNumber = 8; // Dimulai dari baris ke-8
foreach ($data_siswa as $siswa) {
    $sheet->setCellValue('A' . $rowNumber, $siswa['nama_siswa']);
    $sheet->setCellValue('B' . $rowNumber, $siswa['nis']);

    // Pengetahuan
    if (!empty($siswa['pengetahuan'])) {
        $sheet->setCellValue('C' . $rowNumber, $siswa['pengetahuan'][0]);
        $sheet->setCellValue('D' . $rowNumber, $siswa['pengetahuan'][1]);
        $sheet->setCellValue('E' . $rowNumber, $siswa['pengetahuan'][2]);
        $sheet->setCellValue('F' . $rowNumber, $siswa['pengetahuan'][3]);
        $sheet->setCellValue('G' . $rowNumber, $siswa['pengetahuan'][4]);
        $sheet->setCellValue('H' . $rowNumber, $siswa['pengetahuan'][5]);
        $sheet->setCellValue('I' . $rowNumber, $siswa['pengetahuan'][6]);
        $sheet->setCellValue('J' . $rowNumber, $siswa['pengetahuan'][7]);
    }

    // Keterampilan
    if (!empty($siswa['keterampilan'])) {
        $sheet->setCellValue('K' . $rowNumber, $siswa['keterampilan'][0]);
        $sheet->setCellValue('L' . $rowNumber, $siswa['keterampilan'][1]);
        $sheet->setCellValue('M' . $rowNumber, $siswa['keterampilan'][2]);
        $sheet->setCellValue('N' . $rowNumber, $siswa['keterampilan'][3]);
        $sheet->setCellValue('O' . $rowNumber, $siswa['keterampilan'][4]);
        $sheet->setCellValue('P' . $rowNumber, $siswa['keterampilan'][5]);
        $sheet->setCellValue('Q' . $rowNumber, $siswa['keterampilan'][6]);
        $sheet->setCellValue('R' . $rowNumber, $siswa['keterampilan'][7]);
    }

    $rowNumber++;
}

// Atur lebar kolom agar otomatis menyesuaikan isi
foreach (range('A', 'R') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Atur nama file dan download
$filename = 'nilai_siswa_' . $kelas['nama_kelas'] . '_' . $mapel['nama_mapel'] . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

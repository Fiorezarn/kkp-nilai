<?php
require '../vendor/autoload.php'; // Sesuaikan path jika PHPSpreadsheet berada di folder berbeda
include('../koneksi.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];

// Ambil data nilai siswa dari database berdasarkan kelas dan mapel
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
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND (n.kd = 1 OR n.kd = 2)
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

// Merge cell untuk KD dan pengaturan header
$sheet->mergeCells('A5:A6')->setCellValue('A5', 'Nama Siswa');
$sheet->mergeCells('B5:B6')->setCellValue('B5', 'NIS');
$sheet->mergeCells('C5:J5')->setCellValue('C5', 'KD 1 - Pengetahuan');
$sheet->mergeCells('K5:R5')->setCellValue('K5', 'KD 1 - Keterampilan');
$sheet->mergeCells('S5:Z5')->setCellValue('S5', 'KD 2 - Pengetahuan');
$sheet->mergeCells('AA5:AH5')->setCellValue('AA5', 'KD 2 - Keterampilan');

$sheet->setCellValue('C6', 'Tugas 1')
    ->setCellValue('D6', 'Tugas 2')
    ->setCellValue('E6', 'Tugas 3')
    ->setCellValue('F6', 'Tugas 4')
    ->setCellValue('G6', 'Tugas 5')
    ->setCellValue('H6', 'Tugas 6')
    ->setCellValue('I6', 'UH 1')
    ->setCellValue('J6', 'UH 2')
    ->setCellValue('K6', 'Tugas 1')
    ->setCellValue('L6', 'Tugas 2')
    ->setCellValue('M6', 'Tugas 3')
    ->setCellValue('N6', 'Tugas 4')
    ->setCellValue('O6', 'Tugas 5')
    ->setCellValue('P6', 'Tugas 6')
    ->setCellValue('Q6', 'UH 1')
    ->setCellValue('R6', 'UH 2')
    ->setCellValue('S6', 'Tugas 1')
    ->setCellValue('T6', 'Tugas 2')
    ->setCellValue('U6', 'Tugas 3')
    ->setCellValue('V6', 'Tugas 4')
    ->setCellValue('W6', 'Tugas 5')
    ->setCellValue('X6', 'Tugas 6')
    ->setCellValue('Y6', 'UH 1')
    ->setCellValue('Z6', 'UH 2')
    ->setCellValue('AA6', 'Tugas 1')
    ->setCellValue('AB6', 'Tugas 2')
    ->setCellValue('AC6', 'Tugas 3')
    ->setCellValue('AD6', 'Tugas 4')
    ->setCellValue('AE6', 'Tugas 5')
    ->setCellValue('AF6', 'Tugas 6')
    ->setCellValue('AG6', 'UH 1')
    ->setCellValue('AH6', 'UH 2');

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
$sheet->getStyle('A5:AH6')->applyFromArray($styleArrayHeader);

// Mengumpulkan data dari database
$data_siswa = [];
while ($row = $result->fetch_assoc()) {
    $id_siswa = $row['id_siswa'];
    if (!isset($data_siswa[$id_siswa])) {
        $data_siswa[$id_siswa] = [
            'nama_siswa' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'kd1_pengetahuan' => [],
            'kd1_keterampilan' => [],
            'kd2_pengetahuan' => [],
            'kd2_keterampilan' => [],
        ];
    }

    if ($row['kd'] == 1) {
        if ($row['tipe'] == 'pengetahuan') {
            $data_siswa[$id_siswa]['kd1_pengetahuan'] = [
                $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
                $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
                $row['uh_1'], $row['uh_2']
            ];
        } else if ($row['tipe'] == 'keterampilan') {
            $data_siswa[$id_siswa]['kd1_keterampilan'] = [
                $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
                $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
                $row['uh_1'], $row['uh_2']
            ];
        }
    } else if ($row['kd'] == 2) {
        if ($row['tipe'] == 'pengetahuan') {
            $data_siswa[$id_siswa]['kd2_pengetahuan'] = [
                $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
                $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
                $row['uh_1'], $row['uh_2']
            ];
        } else if ($row['tipe'] == 'keterampilan') {
            $data_siswa[$id_siswa]['kd2_keterampilan'] = [
                $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
                $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
                $row['uh_1'], $row['uh_2']
            ];
        }
    }
}

// Isi data ke spreadsheet
$rowNumber = 7; // Dimulai dari baris ke-7
foreach ($data_siswa as $siswa) {
    $sheet->setCellValue('A' . $rowNumber, $siswa['nama_siswa']);
    $sheet->setCellValue('B' . $rowNumber, $siswa['nis']);

    // KD1 - Pengetahuan
    if (!empty($siswa['kd1_pengetahuan'])) {
        $sheet->setCellValue('C' . $rowNumber, $siswa['kd1_pengetahuan'][0]);
        $sheet->setCellValue('D' . $rowNumber, $siswa['kd1_pengetahuan'][1]);
        $sheet->setCellValue('E' . $rowNumber, $siswa['kd1_pengetahuan'][2]);
        $sheet->setCellValue('F' . $rowNumber, $siswa['kd1_pengetahuan'][3]);
        $sheet->setCellValue('G' . $rowNumber, $siswa['kd1_pengetahuan'][4]);
        $sheet->setCellValue('H' . $rowNumber, $siswa['kd1_pengetahuan'][5]);
        $sheet->setCellValue('I' . $rowNumber, $siswa['kd1_pengetahuan'][6]);
        $sheet->setCellValue('J' . $rowNumber, $siswa['kd1_pengetahuan'][7]);
    }

    // KD1 - Keterampilan
    if (!empty($siswa['kd1_keterampilan'])) {
        $sheet->setCellValue('K' . $rowNumber, $siswa['kd1_keterampilan'][0]);
        $sheet->setCellValue('L' . $rowNumber, $siswa['kd1_keterampilan'][1]);
        $sheet->setCellValue('M' . $rowNumber, $siswa['kd1_keterampilan'][2]);
        $sheet->setCellValue('N' . $rowNumber, $siswa['kd1_keterampilan'][3]);
        $sheet->setCellValue('O' . $rowNumber, $siswa['kd1_keterampilan'][4]);
        $sheet->setCellValue('P' . $rowNumber, $siswa['kd1_keterampilan'][5]);
        $sheet->setCellValue('Q' . $rowNumber, $siswa['kd1_keterampilan'][6]);
        $sheet->setCellValue('R' . $rowNumber, $siswa['kd1_keterampilan'][7]);
    }

    // KD2 - Pengetahuan
    if (!empty($siswa['kd2_pengetahuan'])) {
        $sheet->setCellValue('S' . $rowNumber, $siswa['kd2_pengetahuan'][0]);
        $sheet->setCellValue('T' . $rowNumber, $siswa['kd2_pengetahuan'][1]);
        $sheet->setCellValue('U' . $rowNumber, $siswa['kd2_pengetahuan'][2]);
        $sheet->setCellValue('V' . $rowNumber, $siswa['kd2_pengetahuan'][3]);
        $sheet->setCellValue('W' . $rowNumber, $siswa['kd2_pengetahuan'][4]);
        $sheet->setCellValue('X' . $rowNumber, $siswa['kd2_pengetahuan'][5]);
        $sheet->setCellValue('Y' . $rowNumber, $siswa['kd2_pengetahuan'][6]);
        $sheet->setCellValue('Z' . $rowNumber, $siswa['kd2_pengetahuan'][7]);
    }

    // KD2 - Keterampilan
    if (!empty($siswa['kd2_keterampilan'])) {
        $sheet->setCellValue('AA' . $rowNumber, $siswa['kd2_keterampilan'][0]);
        $sheet->setCellValue('AB' . $rowNumber, $siswa['kd2_keterampilan'][1]);
        $sheet->setCellValue('AC' . $rowNumber, $siswa['kd2_keterampilan'][2]);
        $sheet->setCellValue('AD' . $rowNumber, $siswa['kd2_keterampilan'][3]);
        $sheet->setCellValue('AE' . $rowNumber, $siswa['kd2_keterampilan'][4]);
        $sheet->setCellValue('AF' . $rowNumber, $siswa['kd2_keterampilan'][5]);
        $sheet->setCellValue('AG' . $rowNumber, $siswa['kd2_keterampilan'][6]);
        $sheet->setCellValue('AH' . $rowNumber, $siswa['kd2_keterampilan'][7]);
    }

    $rowNumber++;
}

// Atur lebar kolom agar otomatis menyesuaikan isi
foreach (range('A', 'AH') as $columnID) {
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

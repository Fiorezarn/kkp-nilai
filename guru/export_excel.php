<?php
require '../vendor/autoload.php'; // Sesuaikan path jika PHPSpreadsheet berada di folder berbeda
include('../koneksi.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];

// Ambil data nilai siswa dari database berdasarkan kelas dan mapel
$sql = "
    SELECT n.id_nilai, n.id_siswa, s.nama_siswa, s.nis, n.kd, n.tipe,
           COALESCE(n.tugas_1, 0) as tugas_1,
           COALESCE(n.tugas_2, 0) as tugas_2,
           COALESCE(n.tugas_3, 0) as tugas_3,
           COALESCE(n.tugas_4, 0) as tugas_4,
           COALESCE(n.tugas_5, 0) as tugas_5,
           COALESCE(n.tugas_6, 0) as tugas_6,
           COALESCE(n.uh_1, 0) as uh_1,
           COALESCE(n.uh_2, 0) as uh_2
    FROM nilai n
    JOIN siswa s ON n.id_siswa = s.id_siswa
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel
";
$result = $conn->query($sql);
if (!$result) {
    die("Query error (nilai siswa): " . $conn->error . " - Query: " . $sql);
}

// Mengumpulkan data dari database
$data_siswa = [];
while ($row = $result->fetch_assoc()) {
    $id_siswa = $row['id_siswa'];
    if (!isset($data_siswa[$id_siswa])) {
        $data_siswa[$id_siswa] = [
            'nama_siswa' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'kd' => [
                'pengetahuan' => [[], [], [], [], [], []], // KD 1-6 pengetahuan
                'keterampilan' => [[], [], [], [], [], []], // KD 1-6 keterampilan
            ],
            'pts' => 0,
            'psaj' => 0
        ];
    }

    $kd_index = $row['kd'] - 1;
    if ($row['tipe'] == 'pengetahuan') {
        $data_siswa[$id_siswa]['kd']['pengetahuan'][$kd_index] = [
            $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
            $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
            $row['uh_1'], $row['uh_2']
        ];
    } else if ($row['tipe'] == 'keterampilan') {
        $data_siswa[$id_siswa]['kd']['keterampilan'][$kd_index] = [
            $row['tugas_1'], $row['tugas_2'], $row['tugas_3'],
            $row['tugas_4'], $row['tugas_5'], $row['tugas_6'],
            $row['uh_1'], $row['uh_2']
        ];
    }
}

// Ambil nilai PTS dan PSAJ dari tabel nilai_akhir
$types = ['pts', 'psaj'];
foreach ($types as $tipe) {
    $sql_akhir = "
        SELECT na.id_nilai_akhir as id_nilai, na.id_siswa, s.nama_siswa, s.nis, na.tipe, na.nilai as nilai_akhir
        FROM nilai_akhir na
        JOIN siswa s ON na.id_siswa = s.id_siswa
        WHERE s.id_kelas = $id_kelas AND na.id_mapel = $id_mapel AND na.tipe = '$tipe'
    ";
    $result_akhir = $conn->query($sql_akhir);
    if (!$result_akhir) {
        die("Query error (nilai_akhir): " . $conn->error . " - Query: " . $sql_akhir);
    }

    while ($row_akhir = $result_akhir->fetch_assoc()) {
        $id_siswa = $row_akhir['id_siswa'];
        if (isset($data_siswa[$id_siswa])) {
            $data_siswa[$id_siswa][$tipe] = $row_akhir['nilai_akhir'];
        }
    }
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
$sheet->mergeCells('AI5:AP5')->setCellValue('AI5', 'KD 3 - Pengetahuan');
$sheet->mergeCells('AQ5:AX5')->setCellValue('AQ5', 'KD 3 - Keterampilan');
$sheet->mergeCells('AY5:BF5')->setCellValue('AY5', 'KD 4 - Pengetahuan');
$sheet->mergeCells('BG5:BN5')->setCellValue('BG5', 'KD 4 - Keterampilan');
$sheet->mergeCells('BO5:BV5')->setCellValue('BO5', 'KD 5 - Pengetahuan');
$sheet->mergeCells('BW5:CD5')->setCellValue('BW5', 'KD 5 - Keterampilan');
$sheet->mergeCells('CE5:CL5')->setCellValue('CE5', 'KD 6 - Pengetahuan');
$sheet->mergeCells('CM5:CT5')->setCellValue('CM5', 'KD 6 - Keterampilan');
$sheet->mergeCells('CU5:CU6')->setCellValue('CU5', 'PTS');
$sheet->mergeCells('CV5:CV6')->setCellValue('CV5', 'PSAJ');

// Buat header baris 6
$header = ['Tugas 1', 'Tugas 2', 'Tugas 3', 'Tugas 4', 'Tugas 5', 'Tugas 6', 'UH 1', 'UH 2'];

// Buat header baris 6
$columnIndex = 'C'; // Mulai dari kolom 'C'
foreach (range(1, 6) as $kd) {
    foreach (['pengetahuan', 'keterampilan'] as $type) {
        foreach ($header as $h) {
            $sheet->setCellValue($columnIndex . '6', $h);
            $columnIndex++;
        }
    }
}

// Set warna background untuk header
$sheet->getStyle('A5:CV6')->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'argb' => Color::COLOR_YELLOW,
        ],
    ],
]);

// Set border untuk header
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ],
];
$sheet->getStyle('A5:CV6')->applyFromArray($styleArray);

// Isi data siswa
$row_number = 7;
foreach ($data_siswa as $data) {
    $sheet->setCellValue('A' . $row_number, $data['nama_siswa']);
    $sheet->setCellValue('B' . $row_number, $data['nis']);

    $col = 'C';
    foreach ($data['kd']['pengetahuan'] as $kd) {
        foreach ($kd as $nilai) {
            $sheet->setCellValue($col . $row_number, $nilai);
            $col++;
        }
    }

    foreach ($data['kd']['keterampilan'] as $kd) {
        foreach ($kd as $nilai) {
            $sheet->setCellValue($col . $row_number, $nilai);
            $col++;
        }
    }

    $sheet->setCellValue('CU' . $row_number, $data['pts']);
    $sheet->setCellValue('CV' . $row_number, $data['psaj']);

    // Set border untuk setiap baris data
    $sheet->getStyle('A' . $row_number . ':CV' . $row_number)->applyFromArray($styleArray);

    // Set auto size untuk tinggi baris agar sesuai dengan panjang data
    $sheet->getRowDimension($row_number)->setRowHeight(-1);

    $row_number++;
}

// Set auto size untuk kolom
foreach (range('A', 'CV') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Menyimpan file Excel
$writer = new Xlsx($spreadsheet);
$filename = 'data_nilai_siswa.xlsx';
$writer->save($filename);

// Menyajikan file untuk diunduh
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();

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
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND (n.kd BETWEEN 1 AND 6)
";
$result = $conn->query($sql);
if (!$result) {
    die("Query error (nilai siswa): " . $conn->error . " - Query: " . $sql);
}

// Tambahkan validasi untuk nilai KD yang belum terisi
$kd_unfilled = false;

// Mengumpulkan data dari database
$data_siswa = [];
while ($row = $result->fetch_assoc()) {
    if ($row['tugas_6'] == 0) {
        $kd_unfilled = true;
    }
    
    $id_siswa = $row['id_siswa'];
    if (!isset($data_siswa[$id_siswa])) {
        $data_siswa[$id_siswa] = [
            'nama_siswa' => $row['nama_siswa'],
            'nis' => $row['nis'],
            'kd' => [
                'pengetahuan' => [[], [], [], [], [], []], // KD 1-6 pengetahuan
                'keterampilan' => [[], [], [], [], [], []], // KD 1-6 keterampilan
            ]
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

if ($kd_unfilled) {
    echo "<div id='modal' class='modal'>
            <div class='modal-content'>
                <span class='close'>&times;</span>
                <p>Nilai KD belum terisi lengkap. Silakan lengkapi nilai KD terlebih dahulu.</p>
            </div>
          </div>
          <style>
            .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); }
            .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; }
            .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
            .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
          </style>
          <script>
            var modal = document.getElementById('modal');
            var span = document.getElementsByClassName('close')[0];
            modal.style.display = 'block';
            span.onclick = function() {
                modal.style.display = 'none';
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
          </script>";
    exit;
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

$headerColumns = [
    'C6' => 'Tugas 1', 'D6' => 'Tugas 2', 'E6' => 'Tugas 3', 'F6' => 'Tugas 4', 'G6' => 'Tugas 5', 'H6' => 'Tugas 6', 'I6' => 'UH 1', 'J6' => 'UH 2',
    'K6' => 'Tugas 1', 'L6' => 'Tugas 2', 'M6' => 'Tugas 3', 'N6' => 'Tugas 4', 'O6' => 'Tugas 5', 'P6' => 'Tugas 6', 'Q6' => 'UH 1', 'R6' => 'UH 2',
    'S6' => 'Tugas 1', 'T6' => 'Tugas 2', 'U6' => 'Tugas 3', 'V6' => 'Tugas 4', 'W6' => 'Tugas 5', 'X6' => 'Tugas 6', 'Y6' => 'UH 1', 'Z6' => 'UH 2',
    'AA6' => 'Tugas 1', 'AB6' => 'Tugas 2', 'AC6' => 'Tugas 3', 'AD6' => 'Tugas 4', 'AE6' => 'Tugas 5', 'AF6' => 'Tugas 6', 'AG6' => 'UH 1', 'AH6' => 'UH 2',
    'AI6' => 'Tugas 1', 'AJ6' => 'Tugas 2', 'AK6' => 'Tugas 3', 'AL6' => 'Tugas 4', 'AM6' => 'Tugas 5', 'AN6' => 'Tugas 6', 'AO6' => 'UH 1', 'AP6' => 'UH 2',
    'AQ6' => 'Tugas 1', 'AR6' => 'Tugas 2', 'AS6' => 'Tugas 3', 'AT6' => 'Tugas 4', 'AU6' => 'Tugas 5', 'AV6' => 'Tugas 6', 'AW6' => 'UH 1', 'AX6' => 'UH 2',
    'AY6' => 'Tugas 1', 'AZ6' => 'Tugas 2', 'BA6' => 'Tugas 3', 'BB6' => 'Tugas 4', 'BC6' => 'Tugas 5', 'BD6' => 'Tugas 6', 'BE6' => 'UH 1', 'BF6' => 'UH 2',
    'BG6' => 'Tugas 1', 'BH6' => 'Tugas 2', 'BI6' => 'Tugas 3', 'BJ6' => 'Tugas 4', 'BK6' => 'Tugas 5', 'BL6' => 'Tugas 6', 'BM6' => 'UH 1', 'BN6' => 'UH 2',
    'BO6' => 'Tugas 1', 'BP6' => 'Tugas 2', 'BQ6' => 'Tugas 3', 'BR6' => 'Tugas 4', 'BS6' => 'Tugas 5', 'BT6' => 'Tugas 6', 'BU6' => 'UH 1', 'BV6' => 'UH 2',
    'BW6' => 'Tugas 1', 'BX6' => 'Tugas 2', 'BY6' => 'Tugas 3', 'BZ6' => 'Tugas 4', 'CA6' => 'Tugas 5', 'CB6' => 'Tugas 6', 'CC6' => 'UH 1', 'CD6' => 'UH 2',
    'CE6' => 'Tugas 1', 'CF6' => 'Tugas 2', 'CG6' => 'Tugas 3', 'CH6' => 'Tugas 4', 'CI6' => 'Tugas 5', 'CJ6' => 'Tugas 6', 'CK6' => 'UH 1', 'CL6' => 'UH 2',
    'CM6' => 'Tugas 1', 'CN6' => 'Tugas 2', 'CO6' => 'Tugas 3', 'CP6' => 'Tugas 4', 'CQ6' => 'Tugas 5', 'CR6' => 'Tugas 6', 'CS6' => 'UH 1', 'CT6' => 'UH 2'
];

foreach ($headerColumns as $cell => $value) {
    $sheet->setCellValue($cell, $value);
}

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
$sheet->getStyle('A5:CT6')->applyFromArray($styleArrayHeader);

// Isi data ke spreadsheet
$rowNumber = 7; // Dimulai dari baris ke-7
foreach ($data_siswa as $siswa) {
    $sheet->setCellValue('A' . $rowNumber, $siswa['nama_siswa']);
    $sheet->setCellValue('B' . $rowNumber, $siswa['nis']);

    $columns = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU',
        'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP',
        'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK',
        'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT'];

    $columnIndex = 0;
    for ($kd = 0; $kd < 6; $kd++) {
        // Pengetahuan
        foreach ($siswa['kd']['pengetahuan'][$kd] as $nilai) {
            $sheet->setCellValue($columns[$columnIndex++] . $rowNumber, $nilai);
        }

        // Keterampilan
        foreach ($siswa['kd']['keterampilan'][$kd] as $nilai) {
            $sheet->setCellValue($columns[$columnIndex++] . $rowNumber, $nilai);
        }
    }

    $rowNumber++;
}

// Atur lebar kolom agar otomatis menyesuaikan isi
foreach (range('A', 'CT') as $columnID) {
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
?>

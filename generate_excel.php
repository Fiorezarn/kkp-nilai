<?php
require './PHPExcel/Classes/PHPExcel.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kkp_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data dari database
// $sql = "SELECT * FROM Nilai";
// $result = $conn->query($sql);

// Membuat objek PHPExcel
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

// Menulis header
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ID Siswa');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'KD');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Type KD');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Tugas 1');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Tugas 2');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Tugas 3');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Tugas 4');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Tugas 5');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Tugas 6');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'UH 1');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'UH 2');

// Menulis data
$row = 2;
if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row, $data['id_siswa']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row, $data['kd']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row, $data['type_kd']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row, $data['tugas_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row, $data['tugas_2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row, $data['tugas_3']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row, $data['tugas_4']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row, $data['tugas_5']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $row, $data['tugas_6']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $row, $data['uh_1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $row, $data['uh_2']);
        $row++;
    }
}

// Menyimpan file Excel

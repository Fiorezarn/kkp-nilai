<?php
include 'koneksi.php';
// Menangkap data dari form
$id_siswa = $_POST['id_siswa'];
$kd = $_POST['kd'];
$type_kd = $_POST['type_kd'];
$tugas_1 = $_POST['tugas_1'];
$tugas_2 = $_POST['tugas_2'];
$tugas_3 = $_POST['tugas_3'];
$tugas_4 = $_POST['tugas_4'];
$tugas_5 = $_POST['tugas_5'];
$tugas_6 = $_POST['tugas_6'];
$uh_1 = $_POST['uh_1'];
$uh_2 = $_POST['uh_2'];

// SQL untuk menyimpan data
$sql = "INSERT INTO Nilai (id_siswa, kd, type_kd, tugas_1, tugas_2, tugas_3, tugas_4, tugas_5, tugas_6, uh_1, uh_2)
VALUES ('$id_siswa', '$kd', '$type_kd', '$tugas_1', '$tugas_2', '$tugas_3', '$tugas_4', '$tugas_5', '$tugas_6', '$uh_1', '$uh_2')";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

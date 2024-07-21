<?php
include('../koneksi.php');
session_start();

$id_siswa = $_POST['id_siswa'];
$id_kelas = $_POST['id_kelas'];
$id_mapel = $_POST['id_mapel'];
$tugas_1 = $_POST['tugas_1'];
$tugas_2 = $_POST['tugas_2'];
$tugas_3 = $_POST['tugas_3'];
$tugas_4 = $_POST['tugas_4'];
$tugas_5 = $_POST['tugas_5'];
$tugas_6 = $_POST['tugas_6'];
$uh_1 = $_POST['uh_1'];
$uh_2 = $_POST['uh_2'];

// Periksa apakah nilai sudah ada untuk siswa ini
$sql_check = "SELECT * FROM nilai WHERE id_siswa = $id_siswa AND kd = 'kd_value' AND type_kd = 'type_value'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Jika nilai sudah ada, lakukan update
    $sql_update = "UPDATE nilai SET tugas_1 = $tugas_1, tugas_2 = $tugas_2, tugas_3 = $tugas_3, tugas_4 = $tugas_4, tugas_5 = $tugas_5, tugas_6 = $tugas_6, uh_1 = $uh_1, uh_2 = $uh_2 WHERE id_siswa = $id_siswa AND kd = 'kd_value' AND type_kd = 'type_value'";
    $conn->query($sql_update);
} else {
    // Jika nilai belum ada, lakukan insert
    $sql_insert = "INSERT INTO nilai (id_siswa, kd, type_kd, tugas_1, tugas_2, tugas_3, tugas_4, tugas_5, tugas_6, uh_1, uh_2) VALUES ($id_siswa, 'kd_value', 'type_value', $tugas_1, $tugas_2, $tugas_3, $tugas_4, $tugas_5, $tugas_6, $uh_1, $uh_2)";
    $conn->query($sql_insert);
}

header("Location: nilai.php?id_kelas=$id_kelas&id_mapel=$id_mapel");
exit();
?>

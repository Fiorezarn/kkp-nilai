<?php
include('../koneksi.php');

$id_kelas = $_POST['id_kelas'];
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$kd = $_POST['kd'];
$tipe = $_POST['tipe'];

$sql = "INSERT INTO nilai (id_siswa, id_mapel, kd, tipe) VALUES ($id_siswa, $id_mapel, $kd, '$tipe')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(array('status' => 'success', 'message' => 'Nilai berhasil ditambahkan'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $conn->error));
}

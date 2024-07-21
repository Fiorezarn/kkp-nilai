<?php
include('../koneksi.php');
session_start();

$id_kelas = $_POST['id_kelas'];
$id_mapel = $_POST['id_mapel'];
$id_siswa = $_POST['id_siswa'];
$kd = $_POST['kd'];
$tipe = $_POST['tipe'];

$sql = "INSERT INTO nilai (id_siswa, id_mapel, kd, tipe) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $id_siswa, $id_mapel, $kd, $tipe);

if ($stmt->execute()) {
    header("Location: nilai.php?id_kelas=$id_kelas&id_mapel=$id_mapel");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>

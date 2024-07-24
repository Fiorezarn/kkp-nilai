<?php
include('../koneksi.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == "insertNilai") {
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
}

if ($action == "insertNilaiAkhir") {
    $id_kelas = $_POST['id_kelas'];
    $id_mapel = $_POST['id_mapel'];
    $id_siswa = $_POST['id_siswa'];
    $tipe = $_POST['tipe'];
    $nilai = $_POST['nilai'];

    $sql = "INSERT INTO `nilai_akhir` (`id_nilai_akhir`, `id_siswa`, `id_kelas`, `id_mapel`, `tipe`, `nilai`) VALUES (NULL, '$id_siswa', '$id_kelas', '$id_mapel', '$tipe', '$nilai');";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'Nilai berhasil ditambahkan'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $conn->error));
    }
}

<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$tipe = $_GET['tipe'];
$kd = $_GET['kd'];

// Ambil data nilai siswa dari database berdasarkan kelas, mapel, tipe, dan kd
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
    WHERE s.id_kelas = ? AND n.id_mapel = ? AND n.tipe = ? AND n.kd = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('iisi', $id_kelas, $id_mapel, $tipe, $kd);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$response = [
    "data" => $data
];

header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();

<?php
include('../koneksi.php');

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$tipe = $_GET['tipe'];
$kd = $_GET['kd'];

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
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND n.tipe = '$tipe' AND n.kd = $kd
";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(array('data' => $data));

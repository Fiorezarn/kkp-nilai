<?php
include('../koneksi.php');
session_start();

$id_nilai = $_POST['id_nilai'];
$tugas_1 = isset($_POST['tugas_1']) ? $_POST['tugas_1'] : 'NULL';
$tugas_2 = isset($_POST['tugas_2']) ? $_POST['tugas_2'] : 'NULL';
$tugas_3 = isset($_POST['tugas_3']) ? $_POST['tugas_3'] : 'NULL';
$tugas_4 = isset($_POST['tugas_4']) ? $_POST['tugas_4'] : 'NULL';
$tugas_5 = isset($_POST['tugas_5']) ? $_POST['tugas_5'] : 'NULL';
$tugas_6 = isset($_POST['tugas_6']) ? $_POST['tugas_6'] : 'NULL';
$uh_1 = isset($_POST['uh_1']) ? $_POST['uh_1'] : 'NULL';
$uh_2 = isset($_POST['uh_2']) ? $_POST['uh_2'] : 'NULL';

$sql_update = "UPDATE nilai SET tugas_1 = ?, tugas_2 = ?, tugas_3 = ?, tugas_4 = ?, tugas_5 = ?, tugas_6 = ?, uh_1 = ?, uh_2 = ? WHERE id_nilai = ?";

$stmt = $conn->prepare($sql_update);
$stmt->bind_param("iiiiiiiii", $tugas_1, $tugas_2, $tugas_3, $tugas_4, $tugas_5, $tugas_6, $uh_1, $uh_2, $id_nilai);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();

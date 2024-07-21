<?php
include 'koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === "addGuru") {
    $nama_guru = $_POST['nama_guru'];
    $nip = $_POST['nip'];
    $no_telp = $_POST['no_telp'];

    $sql = "INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `no_telp`) VALUES (NULL, '$nama_guru', '$nip', '$no_telp');";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}


if ($action === "showGuru") {
    $sql = "SELECT * FROM guru";
    $result = $conn->query($sql);
    $guruData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $siswaData[] = $row;
        }
    } else {
        $siswaData = "Tidak ada data";
    }
    echo json_encode($siswaData);
}

if ($action == "deleteGuru") {
    $id = trim($_GET["id_guru"]);
    $sql = "DELETE FROM guru WHERE id_guru = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $response = [
            'status' => 'success',
            'message' => 'Siswa Deleted Successfully',
        ];
        echo json_encode($response);
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error Delete Siswa',
        ];
        http_response_code(500);
        echo json_encode($response);
    }
}


if ($action == "updateGuru") {
    $id = trim($_GET["id_guru"]);
    $nama_guru = trim($_POST['nama_guru']);
    echo $id;
    $nip = trim($_POST['nip']);
    $no_telp = trim($_POST['no_telp']);
    $sql = "UPDATE guru SET nama_guru = '$nama_guru', nip = '$nip', no_telp = '$no_telp' WHERE id_guru = $id";
    // echo $sql;
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Guru updated successfully.";
        return true;
    } else {
        echo "Error updating Guru.";
        return http_response_code(503);
    }
}

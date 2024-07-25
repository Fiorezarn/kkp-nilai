<?php
include 'koneksi.php';

// $action = $_REQUEST["action"];
$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($action == "insertSiswa") {
    $nama_siswa = trim($_POST['nama_siswa']);
    $nis = trim($_POST['nis']);
    $id_kelas = trim($_POST['id_kelas']);
    $id_jurusan = trim($_POST['id_jurusan']);
    $sql = "INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `nis`, `id_kelas`, `id_jurusan`) VALUES (NULL, '$nama_siswa', '$nis', '$id_kelas', '$id_jurusan');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Customer added successfully.";
        return true;
    } else {
        echo "Error adding customer.";
        return http_response_code(503);
    }
}

if ($action == "showCustomer") {
    $sql = "SELECT s.id_siswa,s.nama_siswa, s.nis, k.nama_kelas, j.nama_jurusan FROM siswa s
            LEFT JOIN kelas k ON k.id_kelas = s.id_kelas
            LEFT JOIN jurusan j ON j.id_jurusan = s.id_jurusan";
    $result = $conn->query($sql);
    $siswaData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $siswaData[] = $row;
        }
    } else {
        $siswaData = "Tidak ada data";
    }
    echo json_encode($siswaData);
}

if ($action == "listJurusan") {
    $sql = "SELECT * FROM jurusan";
    $result = $conn->query($sql);
    $jurusanData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $jurusanData[] = $row;
        }
    } else {
        $jurusanData = [];
    }
    header('Content-Type: application/json');
    echo json_encode($jurusanData);
}

if ($action == "updateSiswa") {
    $id_siswa = trim($_POST['id_siswa']);
    $nama_siswa = trim($_POST['nama_siswa']);
    $nis = trim($_POST['nis']);
    $id_kelas = trim($_POST['id_kelas']);
    $id_jurusan = trim($_POST['id_jurusan']);
    $sql = "UPDATE siswa SET nama_siswa = '$nama_siswa', nis = '$nis', id_kelas = '$id_kelas', id_jurusan = '$id_jurusan' WHERE id_siswa = $id_siswa";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Siswa updated successfully.";
        return true;
    } else {
        echo "Error updating siswa.";
        return http_response_code(503);
    }
}


if ($action == "deleteSiswa") {
    $id = trim($_GET["id_siswa"]);
    $sql = "DELETE FROM siswa WHERE id_siswa = $id";
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

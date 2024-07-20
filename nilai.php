<?php
include 'koneksi.php';

if (isset($_POST['add_nilai'])) {
    $id_siswa = $_POST['id_siswa'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $nilai = $_POST['nilai'];

    $sql = "INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `mata_pelajaran`, `nilai`) VALUES (NULL, '$id_siswa', '$mata_pelajaran', '$nilai');";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT nilai.*, siswa.nama_siswa FROM nilai JOIN siswa ON siswa.id_siswa = nilai.id_siswa";
$result = $conn->query($sql);
$nilaiData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nilaiData[] = $row;
    }
} else {
    $message = "Tidak ada data";
}

$sql_siswa = "SELECT * FROM siswa";
$result_siswa = $conn->query($sql_siswa);
$siswaData = [];
if ($result_siswa->num_rows > 0) {
    while ($row = $result_siswa->fetch_assoc()) {
        $siswaData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai</title>
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .header-table {
            text-align: center;
            margin-top: 20px;
            font-size: 2em;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .actions i {
            margin: 0 5px;
            cursor: pointer;
        }

        .actions i.edit {
            color: #ffc107;
        }

        .actions i.delete {
            color: #dc3545;
        }

        .actions i.add {
            color: #28a745;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo">KKP</label>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="guru.php">Guru</a></li>
            <li><a href="siswa.php">Siswa</a></li>
            <li><a class="active" href="nilai.php">Nilai</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="header-table">Data Nilai</h2>
        <button id="openModalBtn">Add Nilai</button>
        <div id="addNilaiModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="nilai.php" method="post">
                    <label for="id_siswa">Nama Siswa:</label>
                    <select id="id_siswa" name="id_siswa" required>
                        <?php foreach ($siswaData as $siswa) : ?>
                            <option value="<?= $siswa['id_siswa'] ?>"><?= $siswa['nama_siswa'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="mata_pelajaran">Mata Pelajaran:</label>
                    <input type="text" id="mata_pelajaran" name="mata_pelajaran" required>
                    <label for="nilai">Nilai:</label>
                    <input type="text" id="nilai" name="nilai" required>
                    <button type="submit" name="add_nilai">Add</button>
                </form>
            </div>
        </div>

        <table id="tableNilai" class="display">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Nilai</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($nilaiData)) : foreach ($nilaiData as $row) : ?>
                        <tr>
                            <td><?= $row['nama_siswa'] ?></td>
                            <td><?= $row['mata_pelajaran'] ?></td>
                            <td><?= $row['nilai'] ?></td>
                            <td class="actions">
                                <i class="fas fa-edit edit"></i>
                                <i class="fas fa-trash delete"></i>
                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="4">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableNilai').DataTable();

            const modal = document.getElementById('addNilaiModal');
            const btn = document.getElementById('openModalBtn');
            const span = document.getElementsByClassName('close')[0];

            btn.onclick = function() {
                modal.style.display = 'block';
            }

            span.onclick = function() {
                modal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>
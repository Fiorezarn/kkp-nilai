<?php
include 'koneksi.php';

if (isset($_POST['add_siswa'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $kelas = $_POST['kelas'];

    $sql = "INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `kelas`) VALUES (NULL, '$nama_siswa', '$kelas');";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT s.nama_siswa, k.nama_kelas, j.nama_jurusan FROM siswa s
        JOIN kelas k ON k.id_kelas = s.id_kelas
        JOIN jurusan j ON j.id_jurusan = s.id_jurusan";
$result = $conn->query($sql);
$siswaData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $siswaData[] = $row;
    }
} else {
    $message = "Tidak ada data";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
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

        .button1 {
            padding: 10px 20px;
            color: white;
            background-color: #2d7eff;
            border: 3px solid transparent;
            transition: .2s ease;
            border-radius: 10px;
            cursor: pointer;
        }

        .button1:hover {
            color: #2d7eff;
            background-color: white;
            transform: scale(1.1);
            border: 3px solid #2d7eff;
        }

        .frameTable {
            margin-top: 20px !important;
        }

        .dt-button {
            margin-left: 10px !important;
            color: #ffffff !important;
            background-color: #28a745 !important;
            padding: 5px 10px 0px 10px !important;
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo">KKP</label>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="guru.php">Guru</a></li>
            <li><a class="active" href="siswa.php">Siswa</a></li>
            <li><a href="nilai.php">Nilai</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="header-table">Data Siswa</h2>
        <div id="addSiswaModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="siswa.php" method="post">
                    <label for="nama_siswa">Nama Siswa:</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" required>
                    <label for="kelas">Kelas:</label>
                    <input type="text" id="kelas" name="kelas" required>
                    <button type="submit" name="add_siswa">Add</button>
                </form>
            </div>
        </div>

        <a id="openModalBtn" class="button1">Tambahkan Murid</a>
        <div class="frameTable">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($siswaData)) : foreach ($siswaData as $row) : ?>
                            <tr>
                                <td><?= $row['nama_siswa'] ?></td>
                                <td><?= $row['nama_kelas'] ?></td>
                                <td><?= $row['nama_jurusan'] ?></td>
                                <td class="actions">
                                    <i class="fas fa-edit edit"></i>
                                    <i class="fas fa-trash delete"></i>
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr>
                            <td colspan="3">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tableSiswa').DataTable({
                dom: 'lBftip',
                buttons: [{
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Data Siswa',
                    footer: true
                }],
                initComplete: function() {
                    $(".dt-buttons").css("float", "right").insertBefore("#tableSiswa_filter label");
                }
            });

            const modal = document.getElementById('addSiswaModal');
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
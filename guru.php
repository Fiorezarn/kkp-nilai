<?php
include 'koneksi.php';

if (isset($_POST['add_guru'])) {
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

$sql = "SELECT * FROM guru";
$result = $conn->query($sql);
$guruData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $guruData[] = $row;
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
    <title>Data Guru</title>
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
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a class="active" href="guru.php">Guru</a></li>
            <li><a href="siswa.php">Siswa</a></li>
            <li><a href="nilai.php">Nilai</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="header-table">Data Guru</h2>
        <button id="openModalBtn">Add Guru</button>
        <div id="addGuruModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form action="guru.php" method="post">
                    <label for="nama_guru">Nama Guru:</label>
                    <input type="text" id="nama_guru" name="nama_guru" required>
                    <label for="nip">NIP:</label>
                    <input type="text" id="nip" name="nip" required>
                    <label for="no_telp">No Telepon:</label>
                    <input type="text" id="no_telp" name="no_telp" required>
                    <button type="submit" name="add_guru">Add</button>
                </form>
            </div>
        </div>

        <table id="tableGuru" class="display">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>No Telepon</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($guruData)) : foreach ($guruData as $index => $row) : ?>
                        <tr>
                            <td><?php echo $row['nama_guru']; ?></td>
                            <td><?php echo $row['nip']; ?></td>
                            <td><?php echo $row['no_telp']; ?></td>
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
            $('#tableGuru').DataTable();

            const modal = document.getElementById('addGuruModal');
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
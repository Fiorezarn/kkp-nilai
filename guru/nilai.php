<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];

// Ambil data nilai siswa dari database berdasarkan kelas dan mapel
$sql = "
    SELECT s.id_siswa, s.nama_siswa, s.nis, 
           COALESCE(n.tugas_1, 'Belum Ada') as tugas_1,
           COALESCE(n.tugas_2, 'Belum Ada') as tugas_2,
           COALESCE(n.tugas_3, 'Belum Ada') as tugas_3,
           COALESCE(n.tugas_4, 'Belum Ada') as tugas_4,
           COALESCE(n.tugas_5, 'Belum Ada') as tugas_5,
           COALESCE(n.tugas_6, 'Belum Ada') as tugas_6,
           COALESCE(n.uh_1, 'Belum Ada') as uh_1,
           COALESCE(n.uh_2, 'Belum Ada') as uh_2
    FROM siswa s
    LEFT JOIN nilai n ON s.id_siswa = n.id_siswa
    WHERE s.id_kelas = $id_kelas
";
$result = $conn->query($sql);
if (!$result) {
    die("Query error (nilai siswa): " . $conn->error . " - Query: " . $sql);
}

// Ambil nama kelas
$sql_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas = $id_kelas";
$result_kelas = $conn->query($sql_kelas);
if (!$result_kelas) {
    die("Query error (kelas): " . $conn->error . " - Query: " . $sql_kelas);
}
$kelas = $result_kelas->fetch_assoc();
if (!$kelas) {
    die("No data found for id_kelas = $id_kelas");
}

// Ambil nama mapel
$sql_mapel = "SELECT nama_mapel FROM mapel WHERE id_mapel = $id_mapel";
$result_mapel = $conn->query($sql_mapel);
if (!$result_mapel) {
    die("Query error (mapel): " . $conn->error . " - Query: " . $sql_mapel);
}
$mapel = $result_mapel->fetch_assoc();
if (!$mapel) {
    die("No data found for id_mapel = $id_mapel");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa - <?php echo htmlspecialchars($kelas['nama_kelas']); ?> - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        /* CSS untuk kartu informasi */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 20px 0;
        }

        .card {
            flex: 1 1 calc(20% - 10px);
            background-color: #f8f9fa;
            padding: 20px;
            margin: 5px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            margin: 10px 0;
            font-size: 1.5em;
        }

        .card p {
            margin: 0;
            font-size: 1.2em;
        }

        .card i {
            font-size: 2em;
            color: #007bff;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .card {
                flex: 1 1 calc(50% - 10px);
            }
        }

        @media (max-width: 480px) {
            .card {
                flex: 1 1 100%;
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .logout {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#nilaiTable').DataTable();
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Nilai Siswa - <?php echo htmlspecialchars($kelas['nama_kelas']); ?> - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h2>
            <a href="logout_guru.php" class="logout">Logout</a>
        </div>
        <table id="nilaiTable" class="display">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Tugas 1</th>
                    <th>Tugas 2</th>
                    <th>Tugas 3</th>
                    <th>Tugas 4</th>
                    <th>Tugas 5</th>
                    <th>Tugas 6</th>
                    <th>UH 1</th>
                    <th>UH 2</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['nis']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_1']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_2']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_3']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_4']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_5']); ?></td>
                        <td><?php echo htmlspecialchars($row['tugas_6']); ?></td>
                        <td><?php echo htmlspecialchars($row['uh_1']); ?></td>
                        <td><?php echo htmlspecialchars($row['uh_2']); ?></td>
                        <td>
                            <button class="editBtn" data-id="<?php echo htmlspecialchars($row['id_siswa']); ?>" data-nilai="<?php echo htmlspecialchars(json_encode($row)); ?>">Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="editModal" style="display:none;">
        <div style="background-color: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
            <div style="background-color: white; padding: 20px; margin: 50px auto; width: 300px;">
                <h2>Edit Nilai</h2>
                <form id="editForm" method="POST" action="update_nilai.php">
                    <input type="hidden" name="id_siswa" id="editIdSiswa">
                    <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                    <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                    <label for="tugas_1">Tugas 1:</label>
                    <input type="number" name="tugas_1" id="editTugas1">
                    <label for="tugas_2">Tugas 2:</label>
                    <input type="number" name="tugas_2" id="editTugas2">
                    <label for="tugas_3">Tugas 3:</label>
                    <input type="number" name="tugas_3" id="editTugas3">
                    <label for="tugas_4">Tugas 4:</label>
                    <input type="number" name="tugas_4" id="editTugas4">
                    <label for="tugas_5">Tugas 5:</label>
                    <input type="number" name="tugas_5" id="editTugas5">
                    <label for="tugas_6">Tugas 6:</label>
                    <input type="number" name="tugas_6" id="editTugas6">
                    <label for="uh_1">UH 1:</label>
                    <input type="number" name="uh_1" id="editUh1">
                    <label for="uh_2">UH 2:</label>
                    <input type="number" name="uh_2" id="editUh2">
                    <button type="submit">Save</button>
                    <button type="button" id="closeModal">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.editBtn').on('click', function() {
                var idSiswa = $(this).data('id');
                var nilai = JSON.parse($(this).data('nilai'));
                $('#editIdSiswa').val(idSiswa);
                $('#editTugas1').val(nilai.tugas_1);
                $('#editTugas2').val(nilai.tugas_2);
                $('#editTugas3').val(nilai.tugas_3);
                $('#editTugas4').val(nilai.tugas_4);
                $('#editTugas5').val(nilai.tugas_5);
                $('#editTugas6').val(nilai.tugas_6);
                $('#editUh1').val(nilai.uh_1);
                $('#editUh2').val(nilai.uh_2);
                $('#editModal').show();
            });

            $('#closeModal').on('click', function() {
                $('#editModal').hide();
            });
        });
    </script>
</body>

</html>
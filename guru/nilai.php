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
    WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND n.tipe = '$tipe' AND n.kd = $kd
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

        .logout,
        .add-student {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout {
            background-color: #dc3545;
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

        #editModal,
        #addStudentModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        #modalContent,
        #modalAddContent {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #modalContent h2,
        #modalAddContent h2 {
            margin-top: 0;
        }

        #modalContent label,
        #modalAddContent label {
            display: block;
            margin: 10px 0 5px;
        }

        #modalContent input,
        #modalContent select,
        #modalAddContent input,
        #modalAddContent select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #modalContent button,
        #modalAddContent button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        #modalContent button[type="submit"],
        #modalAddContent button[type="submit"] {
            background-color: #28a745;
            color: #fff;
        }

        #modalContent button[type="button"],
        #modalAddContent button[type="button"] {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo">KKP</label>
        <ul>
            <li><a class="active" href="welcome.php">Dashboard</a></li>
            <li><a href="logout_guru.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <h2>Nilai Siswa - <?php echo htmlspecialchars($kelas['nama_kelas']); ?> - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h2>
            <div>
                <button class="add-student">Tambah Siswa</button>
            </div>
        </div>
        <table id="nilaiTable" class="display">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>KD</th>
                    <th>Tipe</th>
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
            </tbody>
        </table>
    </div>

    <!-- Modal Edit -->
    <div id="editModal">
        <div id="modalContent">
            <h2>Edit Nilai</h2>
            <form id="editForm" method="POST" action="update.php">
                <input type="hidden" name="id_nilai" id="editIdNilai">
                <input type="hidden" name="id_siswa" id="editIdSiswa">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                <label for="kd">KD:</label>
                <input type="number" name="kd" id="editKd" required>
                <label for="tipe">Tipe:</label>
                <select name="tipe" id="editTipe" required>
                    <option value="pengetahuan">Pengetahuan</option>
                    <option value="keterampilan">Keterampilan</option>
                </select>
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

    <!-- Modal Tambah Siswa ke Tabel Nilai -->
    <div id="addStudentModal">
        <div id="modalAddContent">
            <h2>Tambah Siswa ke Tabel Nilai</h2>
            <form id="addStudentForm" method="POST" action="tambah_nilai.php">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                <label for="id_siswa">Nama Siswa:</label>
                <select name="id_siswa" id="id_siswa" required>
                    <?php
                    // Ambil daftar siswa berdasarkan id_kelas
                    $sql_siswa = "SELECT id_siswa, nama_siswa FROM siswa WHERE id_kelas = $id_kelas";
                    $result_siswa = $conn->query($sql_siswa);
                    while ($siswa = $result_siswa->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($siswa['id_siswa']) . '">' . htmlspecialchars($siswa['nama_siswa']) . '</option>';
                    }
                    ?>
                </select>
                <label for="kd">KD:</label>
                <input type="number" name="kd" id="kd" required>
                <label for="tipe">Tipe:</label>
                <select name="tipe" id="tipe" required>
                    <option value="pengetahuan">Pengetahuan</option>
                    <option value="keterampilan">Keterampilan</option>
                </select>
                <button type="submit">Tambah</button>
                <button type="button" id="closeAddModal">Cancel</button>
            </form>
        </div>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        var table = $('#nilaiTable').DataTable({
            "ajax": "data_nilai.php?id_kelas=<?php echo $id_kelas; ?>&id_mapel=<?php echo $id_mapel; ?>&tipe=<?php echo $tipe; ?>&kd=<?php echo $kd; ?>",
            "columns": [{
                    "data": "nama_siswa"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "kd"
                },
                {
                    "data": "tipe"
                },
                {
                    "data": "tugas_1"
                },
                {
                    "data": "tugas_2"
                },
                {
                    "data": "tugas_3"
                },
                {
                    "data": "tugas_4"
                },
                {
                    "data": "tugas_5"
                },
                {
                    "data": "tugas_6"
                },
                {
                    "data": "uh_1"
                },
                {
                    "data": "uh_2"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `<button class="editBtn" style="color: #fbbf24; cursor: pointer" data-id="${data.id_nilai}" data-nilai='${JSON.stringify(data)}'><i class="fas fa-edit edit"></i></button>`;
                    }
                }
            ],
            "drawCallback": function(settings) {
                // Pengikatan event pada tombol edit dilakukan di sini
                $('.editBtn').on('click', function() {
                    var idNilai = $(this).data('id');
                    var nilai = JSON.parse($(this).attr('data-nilai'));
                    $('#editIdNilai').val(idNilai);
                    $('#editKd').val(nilai.kd);
                    $('#editTipe').val(nilai.tipe);
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
            }
        });

        $('#closeModal').on('click', function() {
            $('#editModal').hide();
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'update.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });

        $('.add-student').on('click', function() {
            $('#addStudentModal').show();
        });

        $('#addStudentForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'tambah_nilai.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Siswa berhasil ditambahkan');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }
            });
        });

        $('#closeAddModal').on('click', function() {
            $('#addStudentModal').hide();
        });
    });
</script>

</html>
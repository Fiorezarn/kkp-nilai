<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$tipe = $_GET['tipe'];
$kd = isset($_GET['kd']) ? $_GET['kd'] : null;

// Buat query SQL berdasarkan tipe
if ($tipe == 'pengetahuan' || $tipe == 'keterampilan') {
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
        WHERE s.id_kelas = $id_kelas AND n.id_mapel = $id_mapel AND n.tipe = '$tipe'
    ";
} else {
    $sql = "
        SELECT na.id_nilai_akhir as id_nilai, na.id_siswa, s.nama_siswa, s.nis, na.tipe, na.nilai as nilai_akhir
        FROM nilai_akhir na
        JOIN siswa s ON na.id_siswa = s.id_siswa
        WHERE s.id_kelas = $id_kelas AND na.id_mapel = $id_mapel AND na.tipe = '$tipe'
    ";
}

if ($kd !== null && ($tipe == 'pengetahuan' || $tipe == 'keterampilan')) {
    $sql .= " AND n.kd = $kd";
}

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
        #addStudentModal,
        #addStudentModalSpecial {
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
        #modalAddContent,
        #modalAddContentSpecial {
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
        #modalAddContent h2,
        #modalAddContentSpecial h2 {
            margin-top: 0;
        }

        #modalContent label,
        #modalAddContent label,
        #modalAddContentSpecial label {
            display: block;
            margin: 10px 0 5px;
        }

        #modalContent input,
        #modalContent select,
        #modalAddContent input,
        #modalAddContent select,
        #modalAddContentSpecial input,
        #modalAddContentSpecial select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        #modalContent button,
        #modalAddContent button,
        #modalAddContentSpecial button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        #modalContent button[type="submit"],
        #modalAddContent button[type="submit"],
        #modalAddContentSpecial button[type="submit"] {
            background-color: #28a745;
            color: #fff;
        }

        #modalContent button[type="button"],
        #modalAddContent button[type="button"],
        #modalAddContentSpecial button[type="button"] {
            background-color: #dc3545;
            color: #fff;
        }

        .export-excel {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Nilai Siswa - <?php echo htmlspecialchars($kelas['nama_kelas']); ?> - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h2>
            <div>
                <a href="export_excel.php?id_kelas=<?php echo $id_kelas; ?>&id_mapel=<?php echo $id_mapel; ?>&tipe=<?php echo $tipe; ?>&kd=<?php echo $kd; ?>" class="export-excel">Export to Excel</a>
                <a class="add-student">Tambah Siswa</a>
                <a class="logout" href="../logout.php">Logout</a>
            </div>
        </div>
        <table id="nilaiTable" class="display">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <?php if ($tipe == 'pengetahuan' || $tipe == 'keterampilan') { ?>
                        <th>Tipe</th>
                        <th>Tugas 1</th>
                        <th>Tugas 2</th>
                        <th>Tugas 3</th>
                        <th>Tugas 4</th>
                        <th>Tugas 5</th>
                        <th>Tugas 6</th>
                        <th>UH 1</th>
                        <th>UH 2</th>
                    <?php } else { ?>
                        <th>Tipe</th>
                        <th>Nilai Akhir</th>
                    <?php } ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['nis']); ?></td>
                        <?php if ($tipe == 'pengetahuan' || $tipe == 'keterampilan') { ?>
                            <td><?php echo htmlspecialchars($row['tipe']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_1']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_2']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_3']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_4']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_5']); ?></td>
                            <td><?php echo htmlspecialchars($row['tugas_6']); ?></td>
                            <td><?php echo htmlspecialchars($row['uh_1']); ?></td>
                            <td><?php echo htmlspecialchars($row['uh_2']); ?></td>
                        <?php } else { ?>
                            <td><?php echo htmlspecialchars($row['tipe']); ?></td>
                            <td><?php echo htmlspecialchars($row['nilai_akhir']); ?></td>
                        <?php } ?>
                        <td>
                            <button class="edit-btn" data-id="<?php echo $row['id_nilai']; ?>" data-tipe="<?php echo $row['tipe']; ?>" data-id_siswa="<?php echo $row['id_siswa']; ?>" data-nama_siswa="<?php echo $row['nama_siswa']; ?>" <?php if ($tipe == 'pengetahuan' || $tipe == 'keterampilan') { ?> data-tugas_1="<?php echo $row['tugas_1']; ?>" data-tugas_2="<?php echo $row['tugas_2']; ?>" data-tugas_3="<?php echo $row['tugas_3']; ?>" data-tugas_4="<?php echo $row['tugas_4']; ?>" data-tugas_5="<?php echo $row['tugas_5']; ?>" data-tugas_6="<?php echo $row['tugas_6']; ?>" data-uh_1="<?php echo $row['uh_1']; ?>" data-uh_2="<?php echo $row['uh_2']; ?>" <?php } else { ?> data-nilai_akhir="<?php echo $row['nilai_akhir']; ?>" <?php } ?>>Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit Nilai -->
    <div id="editModal">
        <div id="modalContent">
            <h2>Edit Nilai</h2>
            <form id="editForm" method="POST" action="update.php">
                <input type="hidden" name="id_nilai" id="edit_id_nilai">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                <input type="hidden" name="tipe" id="edit_tipe">
                <input type="hidden" name="kd" value="<?php echo htmlspecialchars($kd); ?>">
                <label for="edit_id_siswa">Nama Siswa:</label>
                <select name="id_siswa" id="edit_id_siswa" required>
                    <?php
                    $sql_siswa = "SELECT id_siswa, nama_siswa FROM siswa WHERE id_kelas = $id_kelas";
                    $result_siswa = $conn->query($sql_siswa);
                    while ($siswa = $result_siswa->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($siswa['id_siswa']) . '">' . htmlspecialchars($siswa['nama_siswa']) . '</option>';
                    }
                    ?>
                </select>
                <div id="editNilaiFields">
                    <!-- Fields for Pengetahuan and Keterampilan -->
                    <div class="nilai-pengetahuan-keterampilan">
                        <label for="edit_tugas_1">Tugas 1:</label>
                        <input type="number" name="tugas_1" id="edit_tugas_1">
                        <label for="edit_tugas_2">Tugas 2:</label>
                        <input type="number" name="tugas_2" id="edit_tugas_2">
                        <label for="edit_tugas_3">Tugas 3:</label>
                        <input type="number" name="tugas_3" id="edit_tugas_3">
                        <label for="edit_tugas_4">Tugas 4:</label>
                        <input type="number" name="tugas_4" id="edit_tugas_4">
                        <label for="edit_tugas_5">Tugas 5:</label>
                        <input type="number" name="tugas_5" id="edit_tugas_5">
                        <label for="edit_tugas_6">Tugas 6:</label>
                        <input type="number" name="tugas_6" id="edit_tugas_6">
                        <label for="edit_uh_1">UH 1:</label>
                        <input type="number" name="uh_1" id="edit_uh_1">
                        <label for="edit_uh_2">UH 2:</label>
                        <input type="number" name="uh_2" id="edit_uh_2">
                    </div>
                    <!-- Fields for PTS and PSAJ -->
                    <div class="nilai-pts-psaj">
                        <label for="edit_nilai_akhir">Nilai Akhir:</label>
                        <input type="number" name="nilai" id="edit_nilai_akhir">
                    </div>
                </div>
                <button type="submit">Simpan</button>
                <button type="button" id="closeModal">Cancel</button>
            </form>
        </div>
    </div>


    <!-- Modal Tambah Siswa untuk tipe pengetahuan dan keterampilan -->
    <div id="addStudentModal">
        <div id="modalAddContent">
            <h2>Tambah Siswa ke Tabel Nilai (Pengetahuan / Keterampilan)</h2>
            <form id="addStudentForm" method="POST">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                <input type="hidden" name="kd" value="<?php echo htmlspecialchars($kd); ?>">
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
                <label for="tipe">Tipe:</label>
                <select name="tipe" id="tipe" required>
                    <option value="pengetahuan">Pengetahuan</option>
                    <option value="keterampilan">Keterampilan</option>
                </select>
                <div id="nilaiFields">
                    <label for="tugas_1">Tugas 1:</label>
                    <input type="number" name="tugas_1" id="tugas_1">
                    <label for="tugas_2">Tugas 2:</label>
                    <input type="number" name="tugas_2" id="tugas_2">
                    <label for="tugas_3">Tugas 3:</label>
                    <input type="number" name="tugas_3" id="tugas_3">
                    <label for="tugas_4">Tugas 4:</label>
                    <input type="number" name="tugas_4" id="tugas_4">
                    <label for="tugas_5">Tugas 5:</label>
                    <input type="number" name="tugas_5" id="tugas_5">
                    <label for="tugas_6">Tugas 6:</label>
                    <input type="number" name="tugas_6" id="tugas_6">
                    <label for="uh_1">UH 1:</label>
                    <input type="number" name="uh_1" id="uh_1">
                    <label for="uh_2">UH 2:</label>
                    <input type="number" name="uh_2" id="uh_2">
                </div>
                <button type="submit">Tambah</button>
                <button type="button" id="closeAddModal">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Siswa untuk tipe PTS dan PSAJ -->
    <div id="addStudentModalSpecial">
        <div id="modalAddContentSpecial">
            <h2>Tambah Siswa ke Tabel Nilai (PTS / PSAJ)</h2>
            <form id="addStudentFormSpecial" method="POST">
                <input type="hidden" name="id_kelas" value="<?php echo htmlspecialchars($id_kelas); ?>">
                <input type="hidden" name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                <input type="hidden" name="kd" value="<?php echo htmlspecialchars($kd); ?>">
                <label for="id_siswa_special">Nama Siswa:</label>
                <select name="id_siswa" id="id_siswa_special" required>
                    <?php
                    // Ambil daftar siswa berdasarkan id_kelas
                    $sql_siswa = "SELECT id_siswa, nama_siswa FROM siswa WHERE id_kelas = $id_kelas";
                    $result_siswa = $conn->query($sql_siswa);
                    while ($siswa = $result_siswa->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($siswa['id_siswa']) . '">' . htmlspecialchars($siswa['nama_siswa']) . '</option>';
                    }
                    ?>
                </select>
                <label for="tipe_special">Tipe:</label>
                <select name="tipe" id="tipe_special" required>
                    <option value="pts">PTS</option>
                    <option value="psaj">PSAJ</option>
                </select>
                <div id="nilaiFieldsSpecial">
                    <label for="nilai">Nilai Akhir:</label>
                    <input type="number" name="nilai" id="nilai">
                </div>
                <button type="submit">Tambah</button>
                <button type="button" id="closeAddModalSpecial">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#nilaiTable').DataTable();

            // Fungsi untuk membuka modal edit
            $('.edit-btn').click(function() {
                var id_nilai_akhir = $(this).data('id_nilai_akhir');
                var id_siswa = $(this).data('id_siswa');
                var nama_siswa = $(this).data('nama_siswa');
                var tipe = $(this).data('tipe');

                console.log(id_nilai_akhir, id_siswa, nama_siswa, tipe);
                $('#edit_id_nilai').val(id_nilai_akhir);
                $('#edit_id_siswa').val(id_siswa);
                $('#edit_tipe').val(tipe);

                // Penyesuaian field untuk Pengetahuan/Keterampilan dan PTS/PSAJ
                if (tipe === 'pengetahuan' || tipe === 'keterampilan') {
                    $('#editNilaiFields .nilai-pengetahuan-keterampilan').show();
                    $('#editNilaiFields .nilai-pts-psaj').hide();
                    $('#edit_tugas_1').val($(this).data('tugas_1'));
                    $('#edit_tugas_2').val($(this).data('tugas_2'));
                    $('#edit_tugas_3').val($(this).data('tugas_3'));
                    $('#edit_tugas_4').val($(this).data('tugas_4'));
                    $('#edit_tugas_5').val($(this).data('tugas_5'));
                    $('#edit_tugas_6').val($(this).data('tugas_6'));
                    $('#edit_uh_1').val($(this).data('uh_1'));
                    $('#edit_uh_2').val($(this).data('uh_2'));
                } else {
                    $('#editNilaiFields .nilai-pengetahuan-keterampilan').hide();
                    $('#editNilaiFields .nilai-pts-psaj').show();
                    $('#edit_nilai_akhir').val($(this).data('nilai_akhir'));
                }

                $('#editModal').show();
            });


            // Fungsi untuk membuka modal tambah siswa
            $('.add-student').click(function() {
                if ('<?php echo $tipe; ?>' === 'pengetahuan' || '<?php echo $tipe; ?>' === 'keterampilan') {
                    $('#addStudentModal').show();
                } else {
                    $('#addStudentModalSpecial').show();
                }
            });

            // Fungsi untuk menutup modal edit
            $('#closeModal').click(function() {
                $('#editModal').hide();
            });

            // Fungsi untuk menutup modal tambah siswa
            $('#closeAddModal').click(function() {
                $('#addStudentModal').hide();
            });

            $('#closeAddModalSpecial').click(function() {
                $('#addStudentModalSpecial').hide();
            });

            // AJAX untuk edit nilai
            $('#editForm').submit(function(event) {
                event.preventDefault();
                var actionUrl = $('#edit_tipe').val() === 'pengetahuan' || $('#edit_tipe').val() === 'keterampilan' ? 'update.php?action=updateNilai' : 'update.php?action=updateNilaiAkhir';
                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        $('#editModal').hide();
                        // $('#nilaiTable').DataTable().ajax.reload();
                        // alert('Nilai berhasil diperbarui');
                        // location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                        console.log(xhr.responseText);
                    }
                });
            });

            // AJAX untuk tambah nilai pengetahuan/keterampilan
            $('#addStudentForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'tambah_nilai.php?action=insertNilai',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Nilai berhasil ditambahkan!');
                        location.reload(); // Untuk me-reload halaman setelah menambah data
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            // AJAX untuk tambah nilai PTS/PSAJ
            $('#addStudentFormSpecial').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'tambah_nilai.php?action=insertNilaiAkhir',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Nilai berhasil ditambahkan!');
                        location.reload(); // Untuk me-reload halaman setelah menambah data
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>
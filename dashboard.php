<?php
include 'koneksi.php';

// Mengambil data dari database
$sql = "SELECT k.id_kelas, k.nama_kelas, j.id_jurusan, j.nama_jurusan, m.id_mapel, m.nama_mapel
        FROM kelas_jurusan_mapel kjm
        JOIN kelas k ON kjm.id_kelas = k.id_kelas
        JOIN jurusan j ON kjm.id_jurusan = j.id_jurusan
        JOIN mapel m ON kjm.id_mapel = m.id_mapel";
$result = $conn->query($sql);

$records = [
    'Kelas X' => [],
    'Kelas XI' => [],
    'Kelas XII' => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['id_kelas'] == 1) {
            $records['Kelas X'][] = $row;
        } elseif ($row['id_kelas'] == 2) {
            $records['Kelas XI'][] = $row;
        } elseif ($row['id_kelas'] == 3) {
            $records['Kelas XII'][] = $row;
        }
    }
} else {
    echo "Tidak ada data";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Kelas, Jurusan, dan Mapel</title>
    <link rel="stylesheet" href="assets/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />

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
            margin: auto;
            padding: 0 20px;
        }

        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tab button.active {
            background-color: #ccc;
        }

        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
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
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <nav>
        <input type="checkbox" id="check" />
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">DesignX</label>
        <ul>
            <li><a class="active" href="#">Home</a></li>
            <li><a href="guru.php">Guru</a></li>
            <li><a href="siswa.php">Siswa</a></li>
            <li><a href="nilai.php">Nilai</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="cards-container">
            <div class="card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>15</h3>
                <p>Guru</p>
            </div>
            <div class="card">
                <i class="fas fa-chalkboard"></i>
                <h3>10</h3>
                <p>Jurusan</p>
            </div>
            <div class="card">
                <i class="fas fa-school"></i>
                <h3>20</h3>
                <p>Kelas</p>
            </div>
            <div class="card">
                <i class="fas fa-book"></i>
                <h3>30</h3>
                <p>Mapel</p>
            </div>
            <div class="card">
                <i class="fas fa-user-graduate"></i>
                <h3>400</h3>
                <p>Siswa</p>
            </div>
        </div>

        <h1 class="header-table">Data Kelas, Jurusan, dan Mapel</h1>
        <div class="tab">
            <button class="tablinks" onclick="openTab(event, 'KelasX')">Kelas X</button>
            <button class="tablinks" onclick="openTab(event, 'KelasXI')">Kelas XI</button>
            <button class="tablinks" onclick="openTab(event, 'KelasXII')">Kelas XII</button>
        </div>

        <div id="KelasX" class="tabcontent">
            <h3>Kelas X</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Kelas</th>
                        <th>Nama Kelas</th>
                        <th>ID Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>ID Mapel</th>
                        <th>Nama Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records['Kelas X'] as $record) : ?>
                        <tr>
                            <td><?php echo $record['id_kelas']; ?></td>
                            <td><?php echo $record['nama_kelas']; ?></td>
                            <td><?php echo $record['id_jurusan']; ?></td>
                            <td><?php echo $record['nama_jurusan']; ?></td>
                            <td><?php echo $record['id_mapel']; ?></td>
                            <td><?php echo $record['nama_mapel']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="KelasXI" class="tabcontent">
            <h3>Kelas XI</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Kelas</th>
                        <th>Nama Kelas</th>
                        <th>ID Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>ID Mapel</th>
                        <th>Nama Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records['Kelas XI'] as $record) : ?>
                        <tr>
                            <td><?php echo $record['id_kelas']; ?></td>
                            <td><?php echo $record['nama_kelas']; ?></td>
                            <td><?php echo $record['id_jurusan']; ?></td>
                            <td><?php echo $record['nama_jurusan']; ?></td>
                            <td><?php echo $record['id_mapel']; ?></td>
                            <td><?php echo $record['nama_mapel']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="KelasXII" class="tabcontent">
            <h3>Kelas XII</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID Kelas</th>
                        <th>Nama Kelas</th>
                        <th>ID Jurusan</th>
                        <th>Nama Jurusan</th>
                        <th>ID Mapel</th>
                        <th>Nama Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records['Kelas XII'] as $record) : ?>
                        <tr>
                            <td><?php echo $record['id_kelas']; ?></td>
                            <td><?php echo $record['nama_kelas']; ?></td>
                            <td><?php echo $record['id_jurusan']; ?></td>
                            <td><?php echo $record['nama_jurusan']; ?></td>
                            <td><?php echo $record['id_mapel']; ?></td>
                            <td><?php echo $record['nama_mapel']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Open default tab
        document.getElementsByClassName("tablinks")[0].click();
    </script>
</body>

</html>

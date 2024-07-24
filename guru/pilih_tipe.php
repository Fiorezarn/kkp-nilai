<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];

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
    <title>Pilih Tipe - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .card a {
            text-decoration: none;
            color: #000;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Pilih Tipe - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h2>
        <div class="card">
            <a href="pilih_kd.php?id_mapel=<?php echo $id_mapel; ?>&id_kelas=<?php echo $id_kelas; ?>&tipe=pengetahuan">Pengetahuan</a>
        </div>
        <div class="card">
            <a href="pilih_kd.php?id_mapel=<?php echo $id_mapel; ?>&id_kelas=<?php echo $id_kelas; ?>&tipe=keterampilan">Keterampilan</a>
        </div>
        <div class="card">
            <a href="nilai.php?id_mapel=<?php echo $id_mapel; ?>&id_kelas=<?php echo $id_kelas; ?>&tipe=PTS">PTS</a>
        </div>
        <div class="card">
            <a href="nilai.php?id_mapel=<?php echo $id_mapel; ?>&id_kelas=<?php echo $id_kelas; ?>&tipe=PSAJ">PSAJ</a>
        </div>
    </div>
</body>

</html>
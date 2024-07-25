<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];
$id_mapel = $_GET['id_mapel'];
$tipe = $_GET['tipe'];

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
    <title>Daftar Jurusan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Pilih KD - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></title>
    <style>
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
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo">KKP</label>
        <ul>
            <li><a class="active" href="welcome.php">Dashboard</a></li>
            <li><a href="logout_guru.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Pilih KD - <?php echo htmlspecialchars($mapel['nama_mapel']); ?></h2>
        <?php for ($kd = 1; $kd <= 6; $kd++) : ?>
            <div class="card">
                <a href="nilai.php?id_kelas=<?php echo $id_kelas; ?>&id_mapel=<?php echo $id_mapel; ?>&tipe=<?php echo $tipe; ?>&kd=<?php echo $kd; ?>">KD <?php echo $kd; ?></a>
            </div>
        <?php endfor; ?>
    </div>
</body>

</html>
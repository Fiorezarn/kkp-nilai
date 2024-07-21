<?php
include('../koneksi.php');
session_start();

$id_kelas = $_GET['id_kelas'];

// Ambil data mapel dari database berdasarkan kelas
$sql = "
    SELECT m.nama_mapel, m.id_mapel FROM mapel m
    JOIN kelas_mapel km ON m.id_mapel = km.id_mapel
    WHERE km.id_kelas = $id_kelas
";
$result = $conn->query($sql);
if (!$result) {
    die("Query error (mapel): " . $conn->error . " - Query: " . $sql);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mapel - <?php echo htmlspecialchars($kelas['nama_kelas']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
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
        .class-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
            text-decoration: none;
            color: black;
            width: calc(33.333% - 20px); /* 3 cards per row with a 20px gap */
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 0;
        }
        .card i {
            color: #007bff;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Daftar Mapel - <?php echo htmlspecialchars($kelas['nama_kelas']); ?></h2>
        </div>
        <div class="class-list">
            <?php while($row = $result->fetch_assoc()) : ?>
                <a href="nilai.php?id_kelas=<?php echo $id_kelas; ?>&id_mapel=<?php echo $row['id_mapel']; ?>" class="card">
                    <h3><i class="fas fa-book"></i> <?php echo htmlspecialchars($row['nama_mapel']); ?></h3>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

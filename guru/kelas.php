<?php
include('../koneksi.php');
session_start();

$id_jurusan = $_GET['id_jurusan'];

// Ambil data jurusan dari database
$sql = "SELECT * FROM kelas WHERE id_jurusan = $id_jurusan";
$result = $conn->query($sql);

// Ambil nama jurusan
$sql_jurusan = "SELECT nama_jurusan FROM jurusan WHERE id_jurusan = $id_jurusan";
$result_jurusan = $conn->query($sql_jurusan);
$jurusan = $result_jurusan->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas - <?php echo $jurusan['nama_jurusan']; ?></title>
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
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            margin: 0;
        }
        .card p {
            color: #666;
        }
        .card i {
            color: #007bff;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Daftar Kelas - <?php echo $jurusan['nama_jurusan']; ?></h2>
            <a href="logout_guru.php" class="logout">Logout</a>
        </div>
        <div class="class-list">
            <?php while($row = $result->fetch_assoc()) : ?>
                <div class="card">
                    <h3><i class="fas fa-chalkboard"></i> Kelas <?php echo $row['tingkatan']; ?> - <?php echo $row['nama_kelas']; ?></h3>
                    <p><a href="mapel.php?id_kelas=<?php echo $row['id_kelas']; ?>">Lihat Mapel</a></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

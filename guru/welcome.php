<?php
include('../koneksi.php');
session_start();

if (!isset($_SESSION['login_guru'])) {
    header("location: login_guru.php");
    die();
}

$sql = "SELECT * FROM jurusan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jurusan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
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
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0 0 10px 0;
        }

        .card p {
            color: #666;
            margin: 0;
        }

        .card i {
            color: #007bff;
        }

        .class-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            flex: 1 1 calc(25% - 20px);
            box-sizing: border-box;
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
        <div class="container">
            <div class="header">
                <h2>Welcome, <?php echo $_SESSION['login_guru']; ?></h2>
            </div>
            <div class="class-list">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="card">
                        <h3><i class="fas fa-book"></i> <?php echo $row['nama_jurusan']; ?></h3>
                        <p><a href="kelas.php?id_jurusan=<?php echo $row['id_jurusan']; ?>">Lihat Kelas</a></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
</body>

</html>
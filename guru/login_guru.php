<?php
include('../koneksi.php');
session_start();

// Jika sesi sudah ada, arahkan ke halaman welcome
if (isset($_SESSION['login_guru'])) {
    header("location: welcome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_guru = $_POST['nama_guru'];
    $nip = $_POST['nip'];

    $sql = "SELECT id_guru, nama_guru, nip FROM guru WHERE nama_guru = '$nama_guru'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($nip == $row['nip']) {  // Membandingkan password biasa
            $_SESSION['login_guru'] = $row['nama_guru'];
            header("location: welcome.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            width: 300px;
        }

        .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
        }

        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <img src="../assets/img/profile.jpg" alt="Profile Image"> <!-- Add your profile image path here -->
            <h2>Login Guru</h2>
            <form method="post" action="">
                <input type="text" name="nama_guru" placeholder="Nama Guru" required><br>
                <input type="password" name="nip" placeholder="NIP" required><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

</html>
<?php
include('../koneksi.php');
session_start();

// Jika sesi sudah ada, arahkan ke halaman welcome
if(isset($_SESSION['login_guru'])){
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
<body>
    <h2>Login Guru</h2>
    <form method="post" action="">
        Nama Guru: <input type="text" name="nama_guru" required><br>
        NIP: <input type="password" name="nip" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

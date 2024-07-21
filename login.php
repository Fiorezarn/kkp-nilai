<?php
include('koneksi.php');
session_start();

// Jika sesi sudah ada, arahkan ke halaman welcome
if(isset($_SESSION['login_user'])){
    header("location: welcome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, nama FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {  // Hanya membandingkan password biasa
            $_SESSION['login_user'] = $row['username'];
            $_SESSION['nama_user'] = $row['nama'];
            header("location: dashboard.php");
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
    <h2>Login</h2>
    <form method="post" action="">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

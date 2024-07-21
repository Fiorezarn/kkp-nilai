<?php
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];  // Simpan password biasa

    $sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. <a href='login.php'>Login</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        Nama: <input type="text" name="nama" required><br>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

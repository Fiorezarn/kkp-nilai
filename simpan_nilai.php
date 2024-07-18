<div>
    <h1>Input Nilai Siswa</h1>
    <form action="simpan_nilai.php" method="POST">
        <label for="id_siswa">ID Siswa:</label>
        <input type="text" id="id_siswa" name="id_siswa" /><br />

        <label for="kd">KD:</label>
        <input type="text" id="kd" name="kd" /><br />

        <label for="type_kd">Type KD:</label>
        <input type="text" id="type_kd" name="type_kd" /><br />

        <label for="tugas_1">Tugas 1:</label>
        <input type="number" id="tugas_1" name="tugas_1" /><br />

        <label for="tugas_2">Tugas 2:</label>
        <input type="number" id="tugas_2" name="tugas_2" /><br />

        <label for="tugas_3">Tugas 3:</label>
        <input type="number" id="tugas_3" name="tugas_3" /><br />

        <label for="tugas_4">Tugas 4:</label>
        <input type="number" id="tugas_4" name="tugas_4" /><br />

        <label for="tugas_5">Tugas 5:</label>
        <input type="number" id="tugas_5" name="tugas_5" /><br />

        <label for="tugas_6">Tugas 6:</label>
        <input type="number" id="tugas_6" name="tugas_6" /><br />

        <label for="uh_1">UH 1:</label>
        <input type="number" id="uh_1" name="uh_1" /><br />

        <label for="uh_2">UH 2:</label>
        <input type="number" id="uh_2" name="uh_2" /><br />

        <input type="submit" value="Simpan" name='submit_button' />
    </form>
</div>

<?php
include 'koneksi.php';

if (isset($_POST['submit_button'])) {
    // Menangkap data dari form
    $id_siswa = $_POST['id_siswa'];
    $kd = $_POST['kd'];
    $type_kd = $_POST['type_kd'];
    $tugas_1 = $_POST['tugas_1'];
    $tugas_2 = $_POST['tugas_2'];
    $tugas_3 = $_POST['tugas_3'];
    $tugas_4 = $_POST['tugas_4'];
    $tugas_5 = $_POST['tugas_5'];
    $tugas_6 = $_POST['tugas_6'];
    $uh_1 = $_POST['uh_1'];
    $uh_2 = $_POST['uh_2'];

    // SQL untuk menyimpan data
    $sql = "INSERT INTO Nilai (id_siswa, kd, type_kd, tugas_1, tugas_2, tugas_3, tugas_4, tugas_5, tugas_6, uh_1, uh_2)
            VALUES ('$id_siswa', '$kd', '$type_kd', '$tugas_1', '$tugas_2', '$tugas_3', '$tugas_4', '$tugas_5', '$tugas_6', '$uh_1', '$uh_2')";

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
} else {
    $message = "";
}
?>

<div>
    <?php echo $message; ?>
</div>
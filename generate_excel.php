<?php
include 'koneksi.php';

// Mengambil data dari database
$sql = "SELECT * FROM nilai JOIN siswa ON siswa.id_siswa = nilai.id_siswa";
$result = $conn->query($sql);

$kds = [];
$students = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
        if (!in_array($row['kd'], $kds)) {
            $kds[] = $row['kd'];
        }
    }
} else {
    echo "Tidak ada data";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nilai Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .highlight {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <h2>Daftar Nilai Siswa</h2>
    <table>
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA SISWA</th>
                <?php foreach ($kds as $kd) : ?>
                    <th colspan="8"><?= $kd ?> PENGETAHUAN</th>
                    <th colspan="2"><?= $kd ?> KETERAMPILAN</th>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($kds as $kd) : ?>
                    <?php for ($i = 1; $i <= 6; $i++) : ?>
                        <th>TUG AS <?= $i ?></th>
                    <?php endfor; ?>
                    <?php for ($i = 1; $i <= 2; $i++) : ?>
                        <th>UH<?= $i ?></th>
                    <?php endfor; ?>
                    <?php for ($i = 1; $i <= 2; $i++) : ?>
                        <th>TUG AS <?= $i ?></th>
                    <?php endfor; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($students as $student) :
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $student['nama_siswa'] ?></td>
                    <?php foreach ($kds as $kd) : ?>
                        <?php for ($i = 1; $i <= 6; $i++) : ?>
                            <td class='highlight'><?= $student['kd' . $kd . '_tugas_' . $i] ?? '##' ?></td>
                        <?php endfor; ?>
                        <?php for ($i = 1; $i <= 2; $i++) : ?>
                            <td class='highlight'><?= $student['kd' . $kd . '_uh_' . $i] ?? '##' ?></td>
                        <?php endfor; ?>
                        <?php for ($i = 1; $i <= 2; $i++) : ?>
                            <td class='highlight'><?= $student['kd' . $kd . '_tugas_as_' . $i] ?? '##' ?></td>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
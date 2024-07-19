<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Add Siswa</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include 'koneksi.php';
    $sql = "SELECT * FROM siswa";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $siswaData = [];
        while ($row = $result->fetch_assoc()) {
            $siswaData[] = $row;
        }
    } ?>
    <button id="openModalBtn">Add Siswa</button>
    <div id="addSiswaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="siswa.php" method="post">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required>
                <button type="submit" name="add_siswa">Add</button>
            </form>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA SISWA</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($siswaData)) : foreach ($siswaData as $index => $row) : ?><tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $row['nama_siswa']; ?></td>
                        </tr><?php endforeach;
                        else : ?><tr>
                        <td colspan="2">No data available</td>
                    </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const modal = document.getElementById('addSiswaModal');
            const btn = document.getElementById('openModalBtn');
            const span = document.getElementsByClassName('close')[0];
            btn.onclick = function() {
                modal.style.display = 'block';
            }
            span.onclick = function() {
                modal.style.display = 'none';
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>

<?php

if (isset($_POST['add_siswa'])) {
    // Menangkap data dari form
    $nama_siswa = $_POST['nama_siswa'];
    // SQL untuk menyimpan data
    $sql = "INSERT INTO `siswa` (`id_siswa`, `nama_siswa`) VALUES (NULL, '$nama_siswa');";

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Add Guru</title>
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
    $sql = "SELECT * FROM guru";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $guruData = [];
        while ($row = $result->fetch_assoc()) {
            $guruData[] = $row;
        }
    } ?>
    <button id="openModalBtn">Add Guru</button>
    <div id="addSiswaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="guru.php" method="post">
                <label for="nama_guru">Nama Guru:</label>
                <input type="text" id="nama_guru" name="nama_guru" required>
                <label for="nip">NIP:</label>
                <input type="text" id="nip" name="nip" required>
                <label for="no_telp">No Telepon:</label>
                <input type="text" id="no_telp" name="no_telp" required>
                <button type="submit" name="add_guru">Add</button>
            </form>
        </div>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Guru</th>
                    <th>NIP</th>
                    <th>No Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($guruData)) : foreach ($guruData as $index => $row) : ?><tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $row['nama_guru']; ?></td>
                            <td><?php echo $row['nip']; ?></td>
                            <td><?php echo $row['no_telp']; ?></td>
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

if (isset($_POST['add_guru'])) {
    $nama_guru = $_POST['nama_guru'];
    $nip = $_POST['nip'];
    $no_telp = $_POST['no_telp'];

    $sql = "INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`, `no_telp`) VALUES (NULL, '$nama_guru', '$nip', '$no_telp');";

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
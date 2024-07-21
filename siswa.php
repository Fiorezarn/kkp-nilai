<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_siswa'])) {
    header("Location: siswa.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .header-table {
            text-align: center;
            margin-top: 20px;
            font-size: 2em;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .actions i {
            margin: 0 5px;
            cursor: pointer;
        }

        .actions i.edit {
            color: #ffc107;
        }

        .actions i.delete {
            color: #dc3545;
        }

        .actions i.add {
            color: #28a745;
        }

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

        .button1 {
            padding: 10px 20px;
            color: white;
            background-color: #2d7eff;
            border: 3px solid transparent;
            transition: .2s ease;
            border-radius: 10px;
            cursor: pointer;
        }

        .button1:hover {
            color: #2d7eff;
            background-color: white;
            transform: scale(1.1);
            border: 3px solid #2d7eff;
        }

        .frameTable {
            margin-top: 20px !important;
        }

        .dt-button {
            margin-left: 10px !important;
            color: #ffffff !important;
            background-color: #28a745 !important;
            padding: 5px 10px 5px 10px !important;
            border: #ddd;
            border-radius: 2px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav>
        <label class="logo">KKP</label>
        <ul>
            <li><a href="guru.php">Guru</a></li>
            <li><a class="active" href="siswa.php">Siswa</a></li>
            <li><a class="logout">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="header-table">Data Siswa</h2>


        <a id="openModalBtn" class="button1">Tambahkan Murid</a>
        <div class="frameTable">
            <table id="tableSiswa" class="display">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content">
            <span class="close close-delete">&times;</span>
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete <span id="delete-item-name"></span>? This action cannot be undone.</p>
            <button id="confirmDeleteBtn" class="button1">Delete</button>
            <button id="cancelDeleteBtn" class="button1" style="background-color: #6c757d;">Cancel</button>
        </div>
    </div>

    <div id="addSiswaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="siswa.php" method="post">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required>
                <label for="kelas">Kelas:</label>
                <select id="kelas" name="kelas" required>
                    <option value="1">Kelas 10</option>
                    <option value="2">Kelas 11</option>
                    <option value="3">Kelas 12</option>
                </select>
                <label for="jurusan">Jurusan:</label>
                <select id="jurusan" name="jurusan" required>
                </select>
                <button type="submit" name="add_siswa" id="addSiswa">Add</button>
            </form>
        </div>
    </div>

    <!-- Edit Siswa Modal -->
    <div id="editSiswaModal" class="modal">
        <div class="modal-content">
            <span class="close close-edit">&times;</span>
            <form id="editSiswaForm" method="post">
                <input type="hidden" id="edit_id_siswa" name="id_siswa">
                <label for="edit_nama_siswa">Nama Siswa:</label>
                <input type="text" id="edit_nama_siswa" name="nama_siswa" required>
                <label for="edit_kelas">Kelas:</label>
                <select id="edit_kelas" name="kelas" required>
                    <option value="1">Kelas 10</option>
                    <option value="2">Kelas 11</option>
                    <option value="3">Kelas 12</option>
                </select>
                <label for="edit_jurusan">Jurusan:</label>
                <select id="edit_jurusan" name="jurusan" required>
                </select>
                <button type="submit" name="edit_siswa" id="editSiswa">Update</button>
            </form>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#tableSiswa').DataTable({
                ajax: {
                    url: 'siswa-script.php',
                    data: {
                        action: 'showCustomer'
                    },
                    dataSrc: ''
                },
                columns: [{
                        data: 'nama_siswa'
                    },
                    {
                        data: 'nama_kelas'
                    },
                    {
                        data: 'nama_jurusan'
                    },
                    {
                        data: null,
                        className: 'actions',
                        render: function(data, type, row) {
                            return `
                <button class="edit-btn">
                    <i class="fas fa-edit edit"></i>
                </button>
                <button class="delete-btn" data-id="${row.id_siswa}">
                    <i class="fas fa-trash delete"></i>
                </button>
            `;
                        },
                        orderable: false
                    }
                ],
                dom: 'lBftip',
                buttons: [{
                    text: '<i class="fas fa-file-excel"></i>',
                    extend: 'excel',
                    title: 'Data Siswa',
                    footer: true
                }],
                initComplete: function() {
                    $(".dt-buttons").css("float", "right").insertBefore("#tableSiswa_filter label");
                }
            });

            const addModal = document.getElementById('addSiswaModal');
            const editModal = document.getElementById('editSiswaModal');
            const deleteModal = document.getElementById('deleteConfirmModal');
            const addBtn = document.getElementById('openModalBtn');
            const addCloseBtn = document.querySelector('#addSiswaModal .close');
            const editCloseBtn = document.querySelector('#editSiswaModal .close-edit');
            const deleteCloseBtn = document.querySelector('#deleteConfirmModal .close-delete');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

            addBtn.onclick = function() {
                addModal.style.display = 'block';
                populateJurusanOptions();
            }

            addCloseBtn.onclick = function() {
                addModal.style.display = 'none';
            }

            editCloseBtn.onclick = function() {
                editModal.style.display = 'none';
            }

            deleteCloseBtn.onclick = function() {
                deleteModal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == addModal) {
                    addModal.style.display = 'none';
                }
                if (event.target == editModal) {
                    editModal.style.display = 'none';
                }
                if (event.target == deleteModal) {
                    deleteModal.style.display = 'none';
                }
            }

            $('#tableSiswa tbody').on('click', '.edit-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                var id = data.id_siswa;
                $('#edit_id_siswa').val(id);
                $('#edit_nama_siswa').val(data.nama_siswa);
                $('#edit_kelas').val(data.nama_kelas);
                $('#edit_jurusan').val(data.nama_jurusan);
                editModal.style.display = 'block';
                populateEditJurusanOptions();
            });

            $('#tableSiswa tbody').on('click', '.delete-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                var id = data.id_siswa;
                var name = data.nama_siswa;
                $('#delete-item-name').text(name);
                deleteModal.style.display = 'block';

                confirmDeleteBtn.onclick = function() {
                    confirmDelete(id);
                    deleteModal.style.display = 'none';
                }

                cancelDeleteBtn.onclick = function() {
                    deleteModal.style.display = 'none';
                }
            });

            function populateJurusanOptions() {
                $.ajax({
                    url: 'siswa-script.php?action=listJurusan',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (Array.isArray(response)) {
                            var jurusanSelect = $('#jurusan');
                            var editJurusanSelect = $('#edit_jurusan');
                            jurusanSelect.empty();
                            editJurusanSelect.empty();
                            $.each(response, function(index, item) {
                                jurusanSelect.append(new Option(item.nama_jurusan, item.id_jurusan));
                                editJurusanSelect.append(new Option(item.nama_jurusan, item.id_jurusan));
                            });
                        } else {
                            console.error("Expected an array but got:", response);
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching jurusan data:", error);
                    }
                });
            }

            function populateEditJurusanOptions() {
                $.ajax({
                    url: 'siswa-script.php?action=listJurusan',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (Array.isArray(response)) {
                            var editJurusanSelect = $('#edit_jurusan');
                            editJurusanSelect.empty();
                            $.each(response, function(index, item) {
                                editJurusanSelect.append(new Option(item.nama_jurusan, item.id_jurusan));
                            });
                        } else {
                            console.error("Expected an array but got:", response);
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching jurusan data:", error);
                    }
                });
            }

            $("#addSiswa").on("click", function() {
                event.preventDefault();
                var formData = new FormData();
                formData.append('nama_siswa', $("#nama_siswa").val());
                formData.append('id_kelas', $("#kelas").val());
                formData.append('id_jurusan', $("#jurusan").val());
                $.ajax({
                    url: 'siswa-script.php?action=insertSiswa',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#tableSiswa").DataTable().ajax.reload();
                        addModal.style.display = 'none';
                    },
                    error: function(error) {
                        console.error("Error adding Siswa:", error);
                    }
                });
            });

            $("#editSiswaForm").on("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('nama_siswa', $("#edit_nama_siswa").val());
                formData.append('id_kelas', $("#edit_kelas").val());
                formData.append('id_jurusan', $("#edit_jurusan").val());
                $.ajax({
                    url: 'siswa-script.php?action=updateSiswa',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#tableSiswa").DataTable().ajax.reload();
                        editModal.style.display = 'none';
                    },
                    error: function(error) {
                        console.error("Error updating Siswa:", error);
                    }
                });
            });

            function confirmDelete(id) {
                $.ajax({
                    url: `siswa-script.php?action=deleteSiswa&id_siswa=${id}`,
                    method: "POST",
                    success: function(response) {
                        $("#tableSiswa").DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.error("Error deleting Siswa:", error);
                    }
                });
            }
        });
    </script>
</body>

</html>
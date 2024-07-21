<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_guru'])) {
    header("Location: guru.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru</title>
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

        .frameTable {
            margin-top: 20px !important;
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
            <li><a href="index.html">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a class="active" href="guru.php">Guru</a></li>
            <li><a href="siswa.php">Siswa</a></li>
            <li><a href="nilai.php">Nilai</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="header-table">Data Guru</h2>
        <button class="button1" id="openModalBtn">Tambahkan Guru</button>

        <div class="frameTable">
            <table id="tableGuru" class="display">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>No Telepon</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Guru Modal -->
    <div id="addGuruModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="addGuruForm" method="post">
                <label for="nama_guru">Nama Guru:</label>
                <input type="text" id="nama_guru" name="nama_guru" required>
                <label for="nip">NIP:</label>
                <input type="text" id="nip" name="nip" required>
                <label for="no_telp">No Telepon:</label>
                <input type="text" id="no_telp" name="no_telp" required>
                <button type="submit" name="add_guru" id="addGuru">Add</button>
            </form>
        </div>
    </div>

    <!-- Edit Guru Modal -->
    <div id="editGuruModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editGuruForm" method="post">
                <input type="hidden" id="edit_id_guru" name="edit_id_guru">
                <label for="edit_nama_guru">Nama Guru:</label>
                <input type="text" id="edit_nama_guru" name="edit_nama_guru" required>
                <label for="edit_nip">NIP:</label>
                <input type="text" id="edit_nip" name="edit_nip" required>
                <label for="edit_no_telp">No Telepon:</label>
                <input type="text" id="edit_no_telp" name="edit_no_telp" required>
                <button type="submit" name="edit_guru">Save</button>
            </form>
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
            var table = $('#tableGuru').DataTable({
                ajax: {
                    url: 'guru-script.php',
                    data: {
                        action: 'showGuru'
                    },
                    dataSrc: ''
                },
                columns: [{
                        data: 'nama_guru'
                    },
                    {
                        data: 'nip'
                    },
                    {
                        data: 'no_telp'
                    },
                    {
                        data: null,
                        className: 'actions',
                        render: function(data, type, row) {
                            return `
                <button class="edit-btn">
                    <i class="fas fa-edit edit"></i>
                </button>
                <button class="delete-btn" data-id="${row.id_guru}">
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
                    title: 'Data Guru',
                    footer: true
                }],
                initComplete: function() {
                    $(".dt-buttons").css("float", "right").insertBefore("#tableGuru_filter label");
                }
            });

            const addBtn = document.getElementById('openModalBtn');
            const addModal = document.getElementById('addGuruModal');
            const addCloseBtn = document.querySelector('#addGuruModal .close');
            const modal = document.getElementById('addGuruModal');
            const btn = document.getElementById('openModalBtn');
            const deleteModal = document.getElementById('deleteConfirmModal');
            const span = document.getElementsByClassName('close')[0];
            const deleteCloseBtn = document.querySelector('#deleteConfirmModal .close-delete');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const editModal = document.getElementById('editGuruModal');
            const editCloseBtn = document.querySelector('#editGuruModal .close-edit');

            addBtn.onclick = function() {
                addModal.style.display = 'block';
            }

            addCloseBtn.onclick = function() {
                addModal.style.display = 'none';
            }

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

            $("#addGuruForm").on("submit", function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'guru-script.php?action=addGuru',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $("#tableGuru").DataTable().ajax.reload();
                        addModal.style.display = 'none';
                    },
                    error: function(error) {
                        console.error("Error adding Guru:", error);
                    }
                });
            });

            $('#tableGuru tbody').on('click', '.delete-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                var id = data.id_guru;
                var name = data.nama_guru;
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

            $('#tableGuru tbody').on('click', '.edit-btn', function() {
                var data = table.row($(this).parents('tr')).data();
                var id = data.id_guru;
                $('#edit_id_guru').val(id);
                $('#edit_nama_guru').val(data.nama_guru);
                $('#edit_nip').val(data.nip);
                $('#edit_no_telp').val(data.no_telp);
                editModal.style.display = 'block';
            });

            $("#editGuruForm").on("submit", function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                formData.append('edit_id_guru', $("#edit_id_guru").val());
                formData.append('nama_guru', $("#edit_nama_guru").val());
                formData.append('nip', $("#edit_nip").val());
                formData.append('no_telp', $("#edit_no_telp").val());
                $.ajax({
                    url: `guru-script.php?action=updateGuru&id_guru=${$("#edit_id_guru").val()}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#tableGuru").DataTable().ajax.reload();
                        editModal.style.display = 'none';
                    },
                    error: function(error) {
                        console.error("Error updating Guru:", error);
                    }
                });
            });

            function confirmDelete(id) {
                $.ajax({
                    url: `guru-script.php?action=deleteGuru&id_guru=${id}`,
                    method: "POST",
                    success: function(response) {
                        $("#tableGuru").DataTable().ajax.reload();
                    },
                    error: function(error) {
                        console.error("Error deleting Guru:", error);
                    }
                });
            }
        });
    </script>
</body>

</html>
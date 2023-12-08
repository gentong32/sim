<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DataTables Editor - Paste from Excel</title>
    <!-- Tambahkan referensi ke CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Tambahkan referensi ke JavaScript DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Tambahkan referensi ke DataTables Editor -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/editor/2.22.5/js/dataTables.editor.min.js"></script>
</head>

<body>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Field 1</th>
                <th>Field 2</th>
                <!-- Atur kolom yang sesuai dengan Editor -->
            </tr>
        </thead>
        <tbody>
            <!-- Isi tabel dengan data Editor yang diinginkan -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            var editor = new $.fn.dataTable.Editor({
                // Konfigurasi Editor
                ajax: "contoh_pengolahan_data.php",
                table: "#example",
                fields: [{
                        label: "Field 1",
                        name: "field1"
                    },
                    {
                        label: "Field 2",
                        name: "field2"
                    }
                    // Sesuaikan dengan struktur kolom yang sesuai
                ]
            });

            // Inisialisasi DataTables dengan Editor
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                ajax: "contoh_pengolahan_data.php",
                columns: [{
                        data: "field1"
                    },
                    {
                        data: "field2"
                    }
                    // Sesuaikan dengan struktur kolom yang sesuai
                ],
                select: true,
                buttons: [{
                        extend: "create",
                        editor: editor
                    },
                    {
                        extend: "edit",
                        editor: editor
                    },
                    {
                        extend: "remove",
                        editor: editor
                    },
                    'copy', 'excel'
                ]
            });

            // Menangani event paste
            $('#example').on('paste', function(e) {
                var pasteData = (e.clipboardData || window.clipboardData).getData('text');
                var rows = pasteData.split('\n');

                rows.forEach(function(row, rowIndex) {
                    var columns = row.split('\t'); // Sesuaikan dengan pemisah yang sesuai (tab, koma, dll.)
                    var rowData = {};
                    columns.forEach(function(column, columnIndex) {
                        rowData['field' + columnIndex] = column.trim();
                    });

                    editor.create(rowData)
                        .set('row_id', 'new')
                        .submit();
                });
            });
        });
    </script>

</body>

</html>
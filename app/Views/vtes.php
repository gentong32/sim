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

    <label for="start_time">Waktu</label>
    <input type="text" id="start_time" name="start_time" maxlength="5" pattern="[0-9]{2}\:[0-9]{2}" title="Format harus HH:MM" placeholder="HH:MM">
    <input type="text" id="end_time" name="end_time" maxlength="5" pattern="[0-9]{2}\:[0-9]{2}" title="Format harus HH:MM" placeholder="HH:MM">

    <script>
        var startTimeInput = document.getElementById("start_time");
        var endTimeInput = document.getElementById("end_time");

        startTimeInput.addEventListener("input", function() {
            var sanitizedValue = this.value.replace(/\D/g, "");
            if (sanitizedValue.length === 4) {
                var hour = sanitizedValue.substring(0, 2);
                var minute = sanitizedValue.substring(2);

                this.value = hour + ":" + minute;
            }
        });

        endTimeInput.addEventListener("input", function() {
            var sanitizedValue = this.value.replace(/\D/g, "");
            if (sanitizedValue.length === 4) {
                var hour = sanitizedValue.substring(0, 2);
                var minute = sanitizedValue.substring(2);

                this.value = hour + ":" + minute;
            }
        });
    </script>


</body>

</html>
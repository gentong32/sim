<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .jenis {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 10px;
        padding: 15px;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .ekskul {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .ekskul td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .ekskul th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .ekskul th:nth-child(2) {
        width: 100px;
    }

    .tbtambah {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #26BEAE;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit,
    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .delete,
    .batal {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit[disabled],
    .delete[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .tbpilihan {
        display: inline-block;
        padding: 6px 6px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #288AA4;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 35px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .aksi {
        margin-right: 5px;
    }

    button {
        height: 25px;
        margin-bottom: 2px;
    }

    .infosub {
        color: red;
        font-style: italic;
        font-size: 14px;
    }

    .uppercase-input {
        text-transform: uppercase;
    }

    .info {
        color: green;
        font-style: italic;
        font-size: 12px;
        max-width: 600px;
    }

    .opsi2 {
        width: 200px;
    }

    table {
        font-size: 14px;
    }

    table th {
        text-align: center;
    }

    /* table td:nth-child(1),
    table td:nth-child(2) {
        text-align: center;
    } */

    .select2-dropdown .select2-results__option {
        font-size: 14px;
    }

    @media screen and (max-width: 768px) {

        .edit,
        .ok,
        .delete,
        .batal {
            font-size: 12px;
        }

        .content {
            padding: 5px;
        }

        table {
            font-size: 12px;
        }

        .opsi2 {
            width: 100px;
        }

        .select2-dropdown .select2-results__option {
            font-size: 12px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Daftar Ekskul</h2>

    <div class="jenis">
        <table class="ekskul" id="iekskul">
            <tr>
                <th style="width: 20px;">Jenis</th>
                <th style="width: 100px;">Nama Ekskul</th>
                <th style="width: 60px;">Pengampu</th>
                <th style="width: 90px;">Aksi</th>
            </tr>
            <?php
            $baris = 0;
            $adapilihan = 0;
            $daftar_pilihan = [];
            foreach ($daftar_ekskul as $datarow) {
                $baris++;
                echo "<tr><td>" . $datarow->jenis . "</td>";
                echo "<td class='editable' contentEditable=false>" . $datarow->nama_ekskul . "</td>";
                echo "<td><div id='pilguru_a" . $baris . "' style='display:none'><select class='js-example-basic-single opsi2' id='isiguru" . $baris . "'><option value='A'>A</option><option value='B'>B</option></select></div><div id='pilguru_b" . $baris . "' style='display:inline' data-guru='" . $datarow->id . "'>" . $datarow->nama . "</div></td>";
                echo "<td><button class='edit' onclick='editEkskul(this,`" . $baris . "`,`" . $datarow->jenis . "`)'>Edit</button> <button class='delete' onclick = 'hapusekskul(this,`" . $baris . "`,`" . $datarow->id . "`)'>Hapus</button> <button style = 'display:none' class = 'ok' onclick = 'okekskul(this,`" . $baris . "`,`" . $datarow->jenis . "`)'>OK</button> <button style = 'display:none' class = 'batal' onclick = 'batalekskul(this, `" . $baris . "`)'>Batal</button></td></tr>";

                $daftar_pilihan[] = strtoupper($datarow->nama_ekskul);
            }
            ?>
        </table>

        <div class="info"></div>

        <label for="dimensi"><b>Jenis</b></label>
        <select name="jenis" id="jenis">
            <option value='Pilihan'>Pilihan</option>";
            <option value='Wajib'>Wajib</option>";
        </select>

        <button class="tbtambah" onclick="tambahEkskul()">Tambah ekskul</button>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    var daftarekskul = [];
    var jenis;
    var addedit;
    var ekskullama;

    function tambahEkskul() {
        var table = document.getElementById('iekskul');
        jenis = document.getElementById('jenis').value;
        addedit = "add";
        ekskullama = "";

        baris = table.rows.length;
        var newRow = table.insertRow(baris);
        var cell = newRow.insertCell(0);
        cell.textContent = jenis;

        cell = newRow.insertCell(1);

        cell.classList.add('editable');
        cell.setAttribute('contenteditable', 'true');
        cell.textContent = '...';
        cell.style.backgroundColor = 'white';

        cell.focus();
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);

        cell = newRow.insertCell(2);

        list_sub2 = '<option value="0">- pilih -</option>';

        var daftarGuru = <?= $daftar_guru; ?>;

        daftarGuru.forEach(function(guru) {
            list_sub2 = list_sub2 + "<option value='" + guru.id + "'>" + guru.nama + "</option>";
        });
        cell.innerHTML = "<div id='pilguru_a" + baris + "'><select class='js-example-basic-single opsi2' id = 'isiguru" + baris +
            "'>" + list_sub2 + "</select></div>";

        cell = newRow.insertCell(3);
        cell.innerHTML = "<button style='display: none' class='edit' onclick='editEkskul(this,`" + baris + "`)'>Edit</button> <button style='display: none' class='delete' onclick = 'hapusekskul(this, `" + baris + "`)'>Hapus</button> <button class = 'ok' onclick = 'okekskul(this, `" + baris + "`, `" + jenis + "`)'>OK</button> <button class = 'batal' onclick = 'batalekskul(this, `" + baris + "`)'>Batal</button>";

        $('.js-example-basic-single').select2();
        disableEditDeleteButtons();

    }

    function editEkskul(button, baris, jenis) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var okButton = row.querySelector('.ok');
        var deleteButton = row.querySelector('.delete');
        var batalButton = row.querySelector('.batal');

        addedit = "edit";

        deleteButton.style.display = 'none';
        editButton.style.display = 'none';
        okButton.style.display = 'inline';
        batalButton.style.display = 'inline';

        var pilguru_a = document.getElementById('pilguru_a' + baris);
        pilguru_a.style.display = 'inline';
        var pilguru_b = document.getElementById('pilguru_b' + baris);
        pilguru_b.style.display = 'none';

        var isi_guru = document.getElementById('isiguru' + baris);

        selectedwali = pilguru_b.getAttribute('data-guru');

        isi_guru.innerHTML = '<option value="0">- pilih -</option>';

        var daftarGuru = <?= $daftar_guru; ?>;

        daftarGuru.forEach(function(guru) {
            var optionElement = document.createElement('option');
            optionElement.value = guru.id;
            optionElement.textContent = guru.nama;
            if (guru.id === selectedwali) {
                optionElement.selected = true;
            }
            isi_guru.appendChild(optionElement);
        });

        cell.contentEditable = true;
        cell.style.backgroundColor = 'white';

        ekskullama = cell.textContent;

        disableEditDeleteButtons();

        cell.focus();
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            var activeElement = document.activeElement;

            if (activeElement.classList.contains('editable')) {
                var okButton = activeElement.parentElement.querySelector('.ok');
                if (okButton) {
                    okButton.focus();
                }
            }
        }
    });

    function okekskul(button, baris, jenis) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var deleteButton = row.querySelector('.delete');
        var okButton = row.querySelector('.ok');
        var batalButton = row.querySelector('.delete');
        var cellContent = cell.textContent;

        var isi_guru = document.getElementById('isiguru' + baris).value;

        if (daftarekskul.includes(cellContent) && cellContent != ekskullama) {
            alert('Nama ekskul sudah ada!');
            return;
        }

        deleteButton.style.display = 'inline';
        editButton.style.display = 'inline';
        okButton.style.display = 'none';
        batalButton.style.display = 'none';

        cell.contentEditable = false;
        cell.style.backgroundColor = '';
        cell.style.backgroundColor = '';
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();

        if (addedit == "add") {
            var url = '<?= base_url() . "admin/simpan_ekskul" ?>';
            var data = {
                jenis: jenis,
                id_guru: isi_guru,
                ekskul: cellContent
            };
        } else {
            var url = '<?= base_url() . "admin/update_ekskul" ?>';
            var data = {
                jenis: jenis,
                id_guru: isi_guru,
                ekskul: cellContent,
                ekskullama: ekskullama
            };
        }

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));

    }

    function hapusekskul(button, baris, id) {
        if (confirm("Yakin mau menghapus ekskul ini?")) {
            var row = button.parentElement.parentElement;
            var cell = row.querySelector('.editable');
            var cellContent = cell.textContent;
            var url = '<?= base_url() . "admin/hapus_ekskul" ?>';
            var data = {
                id: id,
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    row.remove();
                })
                .then()
                .catch(error => console.error('Error:', error));

        }
    }

    function batalekskul(button, baris) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        if (addedit == "add")
            row.remove();
        else {
            var pilguru_a = document.getElementById('pilguru_a' + baris);
            pilguru_a.style.display = 'none';
            var pilguru_b = document.getElementById('pilguru_b' + baris);
            pilguru_b.style.display = 'inline';
            var editButton = row.querySelector('.edit');
            var okButton = row.querySelector('.ok');
            var deleteButton = row.querySelector('.delete');
            var batalButton = row.querySelector('.batal');
            deleteButton.style.display = 'inline';
            editButton.style.display = 'inline';
            okButton.style.display = 'none';
            batalButton.style.display = 'none';
            cell.textContent = ekskullama;
            cell.contentEditable = false;
            cell.style.backgroundColor = '';
            var selection = window.getSelection();
            selection.removeAllRanges();
        }
        enableEditDeleteButtons();
    }

    function enableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var deleteButtons = document.querySelectorAll('.delete');

        editButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });

        deleteButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });
    }

    function disableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var deleteButtons = document.querySelectorAll('.delete');

        editButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });

        deleteButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });
    }
</script>
<?= $this->endSection() ?>
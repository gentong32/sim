<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .kelas {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 10px;
        padding: 15px;
        margin: auto;
        text-align: center;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .tj_pem {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin: auto;
        margin-bottom: 20px;
    }

    .tj_pem td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .tj_pem th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .tj_pem th:nth-child(2) {
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

    table td:nth-child(1) {
        text-align: right;
    }

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
    <h2><?= $nama_mapel ?></h2>
    <h3>Kelas
        <select class="pilkelas" name="daftarrombel" id="daftarrombel">
            <?php
            $kelas_sudah = [];
            $indeks = 0;
            foreach ($daftarkelasajar as $row) :
                $indeks++;
                $selected = "";
                if ($pilidx == $indeks) {
                    $selected = "selected";
                }
                if (!in_array($row['kelas'], $kelas_sudah)) {
                    $kelas_sudah[] = $row['kelas'];
                    echo "<option " . $selected . " value=" . $indeks . ">" . $row['kelas'] . "</option>";
                }
            ?>

            <?php endforeach ?>
        </select>
    </h3>

    <div class="kelas">
        <table class="tj_pem" id="itj_pem">
            <tr>
                <th style="width: 20px;">No</th>
                <th style="width: 160px;">Tujuan Pembelajaran</th>
                <th style="width: 90px;">Aksi</th>
            </tr>
            <?php
            $baris = 0;
            $adapilihan = 0;
            foreach ($daftartp as $datarow) {
                $baris++;
                echo "<tr><td>" . $baris . "</td>";
                echo "<td class='editable' contentEditable=false>" . $datarow->tujuan_pembelajaran . "</td>";
                echo "<td><button class='edit' onclick='editTujPem(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>Edit</button> <button class='delete' onclick = 'hapustj_pem(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>Hapus</button> <button style = 'display:none' class = 'ok' onclick = 'oktj_pem(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>OK</button> <button style = 'display:none' class = 'batal' onclick = 'bataltj_pem(this, `" . $baris . "`)'>Batal</button></td></tr>";
            }
            ?>
        </table>

        <button class="tbtambah" onclick="tambahtj_pem()">Tambah TP</button>
    </div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        let kelasPilihan;

        $('.js-example-basic-single').select2();

    });

    var daftartj_pem = [];
    var kelas;
    var addedit;
    var tj_pemlama;

    <?php
    foreach ($daftartp as $row) {
        echo "daftartj_pem.push('$row->tujuan_pembelajaran');\n";
    }
    ?>

    function tambahtj_pem() {
        var table = document.getElementById('itj_pem');
        addedit = "add";
        tj_pemlama = "";

        baris = table.rows.length;
        var newRow = table.insertRow(baris);
        var cell = newRow.insertCell(0);
        cell.textContent = baris;

        cell = newRow.insertCell(1);

        cell.classList.add('editable');
        cell.setAttribute('contenteditable', 'true');
        cell.textContent = '...';
        cell.style.backgroundColor = 'white';
        cell.style.textAlign = 'left';

        cell.focus();
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);

        cell = newRow.insertCell(2);
        cell.innerHTML = "<button style='display: none' class='edit' onclick='editTujPem(this,`" + baris + "`)'>Edit</button> <button style='display: none' class='delete' onclick = 'hapustj_pem(this, `" + baris + "`)'>Hapus</button> <button class = 'ok' onclick = 'oktj_pem(this, `" + baris + "`)'>OK</button> <button class = 'batal' onclick = 'bataltj_pem(this, `" + baris + "`)'>Batal</button>";

        $('.js-example-basic-single').select2();
        disableEditDeleteButtons();

    }

    function editTujPem(button, baris) {
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

        cell.contentEditable = true;
        cell.style.backgroundColor = 'white';

        tj_pemlama = cell.textContent;

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

    function oktj_pem(button, baris) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var deleteButton = row.querySelector('.delete');
        var okButton = row.querySelector('.ok');
        var batalButton = row.querySelector('.batal');
        var cellContent = cell.textContent;

        if (daftartj_pem.includes(cellContent) && cellContent != tj_pemlama) {
            alert('Tujuan pembelajaran sudah ada!');
            return;
        }

        deleteButton.style.display = 'inline';
        editButton.style.display = 'inline';
        okButton.style.display = 'none';
        batalButton.style.display = 'none';

        cell.contentEditable = false;
        cell.style.backgroundColor = '';
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();

        if (addedit == "add") {
            var url = '<?= base_url() . "tujuan_pembelajaran/simpan_tj_pem" ?>';
            var data = {
                valkelas: '<?= $valkelas ?>',
                tj_pem: cellContent
            };
        } else {
            var url = '<?= base_url() . "tujuan_pembelajaran/update_tj_pem" ?>';
            var data = {
                valkelas: '<?= $valkelas ?>',
                tj_pem: cellContent,
                tj_pemlama: tj_pemlama
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
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));

    }

    function hapustj_pem(button, baris, kelas) {
        if (confirm("Yakin mau menghapus tj_pem ini?")) {
            var row = button.parentElement.parentElement;
            var cell = row.querySelector('.editable');
            var cellContent = cell.textContent;
            var url = '<?= base_url() . "tujuan_pembelajaran/hapus_tj_pem" ?>';
            var data = {
                valkelas: '<?= $valkelas ?>',
                tj_pem: cellContent,
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
                    console.log(data);
                    row.remove();
                })
                .then()
                .catch(error => console.error('Error:', error));

        }
    }

    function bataltj_pem(button, baris) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        if (addedit == "add")
            row.remove();
        else {
            var editButton = row.querySelector('.edit');
            var okButton = row.querySelector('.ok');
            var deleteButton = row.querySelector('.delete');
            var batalButton = row.querySelector('.batal');
            deleteButton.style.display = 'inline';
            editButton.style.display = 'inline';
            okButton.style.display = 'none';
            batalButton.style.display = 'none';
            cell.textContent = tj_pemlama;
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

    document.getElementById('daftarrombel').addEventListener('change', function() {
        window.open("<?= base_url() . 'tujuan_pembelajaran?kelas=g' ?>" + this.value, "_self");
    });
</script>
<?= $this->endSection() ?>
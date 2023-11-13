<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script>
    window.addEventListener('resize', function() {
        var lebarLayar = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var piltbl = document.getElementById('piltbl');

        if (lebarLayar < 700) {
            piltbl.innerText = 'Pil';
        } else {
            piltbl.innerText = 'Pilihan';
        }
    });
</script>
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
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .rombel {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .rombel td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .rombel th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .rombel th:nth-child(2) {
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

    table td:nth-child(1),
    table td:nth-child(2) {
        text-align: center;
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
    <h2>Rombel dan Wali Kelas</h2>

    <div class="kelas">
        <table class="rombel" id="irombel">
            <tr>
                <th style="width: 20px;">Kelas</th>
                <th id='piltbl' style="width: 20px;">Pilihan</th>
                <th style="width: 60px;">Nama Rombel</th>
                <th>Wali Kelas</th>
                <th style="width: 90px;">Aksi</th>
            </tr>
            <?php
            $baris = 0;
            $adapilihan = 0;
            $daftar_pilihan = [];
            foreach ($daftar_rombel as $datarow) {
                $baris++;
                echo "<tr><td>" . $datarow->kelas . "</td>";
                echo "<td><div id='pilsub_a" . $baris . "' style='display:none'><select id='isipil" . $baris . "'><option value='A'>A</option><option value='B'>B</option></select></div><div id='pilsub_b" . $baris . "' style='display:inline'>" . $datarow->sub_kelas . "</div></td>";
                echo "<td class='editable' contentEditable=false>" . $datarow->nama_rombel . "</td>";
                echo "<td><div id='pilwali_a" . $baris . "' style='display:none'><select class='js-example-basic-single opsi2' id='isiwali" . $baris . "'><option value='A'>A</option><option value='B'>B</option></select></div><div id='pilwali_b" . $baris . "' style='display:inline' data-wali='" . $datarow->nuptk_wali_kelas . "'>" . $datarow->nama . "</div></td>";
                echo "<td><button class='edit' onclick='editMataPelajaran(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>Edit</button> <button class='delete' onclick = 'hapusRombel(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>Hapus</button> <button style = 'display:none' class = 'ok' onclick = 'okRombel(this,`" . $baris . "`,`" . $datarow->kelas . "`)'>OK</button> <button style = 'display:none' class = 'batal' onclick = 'batalRombel(this, `" . $baris . "`)'>Batal</button></td></tr>";

                $daftar_pilihan[] = strtoupper($datarow->nama_rombel);
            }
            ?>
        </table>

        <div class="info">Untuk kolom 'Pilihan', secara default akan kosong (-). Masukkan kelas yang tersedia terlebih dahulu, setelah itu jika Mata Pelajaran Pilihan sudah ditentukan nama subkelas-nya melalui menu <b>Data Referensi Lokal > Mata Pelajaran</b>, pilihan subkelas akan muncul di kolom 'Pilihan'. </div>

        <label for="dimensi"><b>KELAS:</b></label>
        <select name="kelas" id="kelas">
            <?php
            foreach ($daftar_kelas as $row) {
                echo "<option value='" . $row . "'>" . $row . "</option>";
            }
            ?>
        </select>

        <button class="tbtambah" onclick="tambahRombel()">Tambah Rombel</button>
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

        <?php if (sizeof($daftar_rombel) == 0) { ?>
            kelasPilihan = <?= $daftar_rombel[0]->kelas ?>;
        <?php } else { ?>
            kelasPilihan = sessionStorage.getItem('kelaspilihan');
        <?php } ?>
        if (kelasPilihan) {
            document.getElementById('kelas').value = kelasPilihan;
        }

    });

    var daftarrombel = [];
    var kelas;
    var addedit;
    var rombellama;

    var dataKelasSubkelas = [
        <?php foreach ($daftar_sub_kelas as $subkelas) {
            echo $subkelas . ", ";
        } ?>
    ];

    <?php
    foreach ($daftar_pilihan as $row) {
        echo "daftarrombel.push('$row');\n";
    }
    ?>

    function tambahRombel() {
        var table = document.getElementById('irombel');
        kelas = document.getElementById('kelas').value;
        addedit = "add";
        rombellama = "";

        baris = table.rows.length;
        var newRow = table.insertRow(baris);
        var cell = newRow.insertCell(0);
        cell.textContent = kelas;

        cell = newRow.insertCell(1);

        var kelasSubkelas = dataKelasSubkelas.filter(function(item) {
            return item[0] == kelas;
        });
        var subkelasUnik = [...new Set(kelasSubkelas.map(item => item[1]))];
        list_sub = "";
        subkelasUnik.forEach(function(subkelas) {
            list_sub = list_sub + "<option value='" + subkelas + "'>" + subkelas + "</option>";
        });

        cell.innerHTML = "<div id='pilsub_a" + baris + "'><select id='isipil" + baris +
            "'>" + list_sub + "</select></div>";

        cell = newRow.insertCell(2);
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

        cell = newRow.insertCell(3);

        list_sub2 = '<option value="0">- pilih -</option>';

        var daftarGuru = <?= $daftar_guru; ?>;

        daftarGuru.forEach(function(guru) {
            list_sub2 = list_sub2 + "<option value='" + guru.nuptk + "'>" + guru.nama + "</option>";
        });
        cell.innerHTML = "<div id='pilwali_a" + baris + "'><select class='js-example-basic-single opsi2' id = 'isiwali" + baris +
            "'>" + list_sub2 + "</select></div>";

        cell = newRow.insertCell(4);
        cell.innerHTML = "<button style='display: none' class='edit' onclick='editMataPelajaran(this,`" + baris + "`)'>Edit</button> <button style='display: none' class='delete' onclick = 'hapusRombel(this, `" + baris + "`)'>Hapus</button> <button class = 'ok' onclick = 'okRombel(this, `" + baris + "`, `" + kelas + "`)'>OK</button> <button class = 'batal' onclick = 'batalRombel(this, `" + baris + "`)'>Batal</button>";

        $('.js-example-basic-single').select2();
        disableEditDeleteButtons();

    }

    function editMataPelajaran(button, baris, kelas) {
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

        var pilsub_a = document.getElementById('pilsub_a' + baris);
        pilsub_a.style.display = 'inline';
        var pilsub_b = document.getElementById('pilsub_b' + baris);
        pilsub_b.style.display = 'none';

        var isi_pil = document.getElementById('isipil' + baris);

        selectedpil = pilsub_b.textContent;
        isi_pil.innerHTML = '';

        var kelasSubkelas = dataKelasSubkelas.filter(function(item) {
            return item[0] == kelas;
        });

        var subkelasUnik = [...new Set(kelasSubkelas.map(item => item[1]))];

        subkelasUnik.forEach(function(subkelas) {
            var optionElement = document.createElement('option');
            optionElement.value = subkelas;
            optionElement.textContent = subkelas;
            if (subkelas === selectedpil) {
                optionElement.selected = true;
            }
            isi_pil.appendChild(optionElement);
        });

        var pilwali_a = document.getElementById('pilwali_a' + baris);
        pilwali_a.style.display = 'inline';
        var pilwali_b = document.getElementById('pilwali_b' + baris);
        pilwali_b.style.display = 'none';

        var isi_wali = document.getElementById('isiwali' + baris);

        selectedwali = pilwali_b.getAttribute('data-wali');

        isi_wali.innerHTML = '<option value="0">- pilih -</option>';

        var daftarGuru = <?= $daftar_guru; ?>;

        daftarGuru.forEach(function(guru) {
            var optionElement = document.createElement('option');
            optionElement.value = guru.nuptk;
            optionElement.textContent = guru.nama;
            if (guru.nuptk === selectedwali) {
                optionElement.selected = true;
            }
            isi_wali.appendChild(optionElement);
        });

        cell.contentEditable = true;
        cell.style.backgroundColor = 'white';

        rombellama = cell.textContent;

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

    function okRombel(button, baris, kelas) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var deleteButton = row.querySelector('.delete');
        var okButton = row.querySelector('.ok');
        var batalButton = row.querySelector('.batal');
        var cellContent = cell.textContent.toUpperCase();

        var isi_pil = document.getElementById('isipil' + baris).value;
        var isi_wali = document.getElementById('isiwali' + baris).value;

        if (daftarrombel.includes(cellContent) && cellContent != rombellama) {
            alert('Nama rombel sudah ada!');
            return;
        }

        sessionStorage.setItem('kelaspilihan', kelas);

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
            var url = '<?= base_url() . "admin/simpan_rombel" ?>';
            var data = {
                kelas: kelas,
                sub_kelas: isi_pil,
                nuptk_wali_kelas: isi_wali,
                rombel: cellContent
            };
        } else {
            var url = '<?= base_url() . "admin/update_rombel" ?>';
            var data = {
                kelas: kelas,
                sub_kelas: isi_pil,
                nuptk_wali_kelas: isi_wali,
                rombel: cellContent,
                rombellama: rombellama
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

    function hapusRombel(button, baris, kelas) {
        if (confirm("Yakin mau menghapus rombel ini?")) {
            var row = button.parentElement.parentElement;
            var cell = row.querySelector('.editable');
            var cellContent = cell.textContent.toUpperCase();
            var url = '<?= base_url() . "admin/hapus_rombel" ?>';
            var data = {
                kelas: kelas,
                rombel: cellContent,
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

    function batalRombel(button, baris) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        if (addedit == "add")
            row.remove();
        else {
            var pilsub_a = document.getElementById('pilsub_a' + baris);
            pilsub_a.style.display = 'none';
            var pilsub_b = document.getElementById('pilsub_b' + baris);
            pilsub_b.style.display = 'inline';
            var pilwali_a = document.getElementById('pilwali_a' + baris);
            pilwali_a.style.display = 'none';
            var pilwali_b = document.getElementById('pilwali_b' + baris);
            pilwali_b.style.display = 'inline';
            var editButton = row.querySelector('.edit');
            var okButton = row.querySelector('.ok');
            var deleteButton = row.querySelector('.delete');
            var batalButton = row.querySelector('.batal');
            deleteButton.style.display = 'inline';
            editButton.style.display = 'inline';
            okButton.style.display = 'none';
            batalButton.style.display = 'none';
            cell.textContent = rombellama;
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
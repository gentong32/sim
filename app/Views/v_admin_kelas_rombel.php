<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        font-size: 24px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        max-width: 600px;
        margin: auto;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    select,
    input[type="text"] {
        width: 50px;
        text-align: center;
        font-size: 16px;
    }

    .action-buttons button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 6px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
    }

    .center {
        text-align: center;
        margin: auto;
    }

    .center span {
        text-align: center;
        margin-top: 20px;
        color: blue;
        display: block;
    }

    .wide-button {
        width: 100px;
        font-size: 16px;
        margin: 10px;
    }

    .disabled-button {
        background-color: #ccc;
        cursor: not-allowed;
    }

    #simpanButton {
        display: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h1>Daftar Kelas Rombel</h1>

<table id="kelasTable">
    <tr>
        <th>Kelas</th>
        <th>Nama Rombel</th>
    </tr>
</table>

<div class="center">
    <button id="tambahButton" class="wide-button" onclick="tambahBaris()">Tambah Baris</button>
    <button id="hapusButton" class="wide-button" onclick="hapusBaris()">Hapus Baris</button>
</div>

<div class="center">
    <center>
        <button id="simpanButton" class="wide-button" onclick="simpanData()">Simpan</button>
        <span id="info"></span>
    </center>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    let kelasData = [];
    let lastSelectedValue = 'TK';

    function tambahBaris(kelas = 'TK', rombel = '') {
        let tabel = document.getElementById('kelasTable');
        let row = tabel.insertRow(-1);
        let kelasCell = row.insertCell(0);
        let rombelCell = row.insertCell(1);

        let kelasSelect = document.createElement('select');

        let options = ["TK", "KB"];
        for (let i = 1; i <= 12; i++) {
            options.push(i.toString());
        }

        options.forEach(optionValue => {
            let option = document.createElement('option');
            option.value = optionValue;
            option.text = optionValue;

            if (optionValue == lastSelectedValue) {
                option.selected = true;
            }

            kelasSelect.add(option);
        });

        let rombelInput = document.createElement('input');
        rombelInput.type = 'text';
        rombelInput.value = rombel;

        rombelInput.addEventListener('input', function() {
            document.getElementById('tambahButton').style.display = '';
            document.getElementById('hapusButton').style.display = '';
            if (kelasData.length >= 3) {
                document.getElementById('simpanButton').style.display = 'block';
            }
        });

        document.getElementById('tambahButton').style.display = 'none';
        document.getElementById('hapusButton').style.display = 'none';

        kelasCell.appendChild(kelasSelect);
        rombelCell.appendChild(rombelInput);

        kelasData.push({
            kelasSelect,
            rombelInput
        });

        kelasSelect.addEventListener('change', function() {
            lastSelectedValue = this.value;
        });

        rombelInput.focus();
    }

    function hapusBaris() {
        if (kelasData.length > 0) {
            let tabel = document.getElementById('kelasTable');
            tabel.deleteRow(-1);
            kelasData.pop();
            document.getElementById('simpanButton').style.display = 'block';
        }

        if (kelasData.length < 3) {
            document.getElementById('simpanButton').style.display = 'none';
        }
    }

    function simpanData() {
        document.getElementById('simpanButton').style.display = 'none';
        let dataToSave = kelasData.map(data => {
            return {
                kelas: data.kelasSelect.value,
                rombel: data.rombelInput.value
            };
        });

        if (dataToSave.length > 0) {
            // alert(JSON.stringify(dataToSave));
            fetch('<?= base_url() . "admin/simpan_rombel_sekolah" ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataToSave),
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('info').innerText = "Data Berhasil Disimpan";
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    window.onload = function() {
        muatDataDariJSON();
    }

    function muatDataDariJSON() {
        fetch('<?= base_url() . "admin/get_rombel_sekolah/" . $tahun_ajaran ?>')
            .then(response => response.json())
            .then(data => {
                try {
                    data.forEach(item => {
                        let kelas = item.kelas;
                        let rombel = item.nama_rombel;
                        lastSelectedValue = kelas;
                        tambahBaris(kelas, rombel);
                    });
                    document.getElementById('simpanButton').style.display = 'none';
                    document.getElementById('tambahButton').style.display = '';
                    document.getElementById('hapusButton').style.display = '';
                } catch (error) {
                    console.error('Error:', error);
                }
            })
            .catch(error => console.error('Error:', error));

    }
</script>

<?= $this->endSection() ?>
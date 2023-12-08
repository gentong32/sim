<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .kelas {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 20px;
        padding: 15px;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .projek-sekolah {
        width: 100%;
        min-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .projek-sekolah td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        vertical-align: top;
        /* border-bottom: 1px solid #ccc; */
    }

    .projek-sekolah th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .projek-sekolah th:nth-child(2) {
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
        padding: 0px 0px;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 50px;
    }

    .delete,
    .hapus {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 50px;
    }

    .tbdimensi {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 14px;
        color: #fff;
        background-color: #D6a240;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 90px;
    }

    .tbdimensi[disabled],
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

    .table-responsive {
        overflow-x: auto;
    }

    .table-container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .copsi {
        width: 200px;
        font-size: 16px;
    }

    .cprojek {
        width: 95%;
        height: 100px;
    }

    .cdeskripsi {
        width: 96%;
        height: 100px;
    }

    #overlayprojek {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: none;
    }

    #formContainer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 600px;
        width: 95%;
        z-index: 9999;
        display: none;
    }

    label {
        display: block;
        margin-bottom: 0px;
        margin-top: 5px;
        font-size: 14px;
    }



    @media (max-width: 767px) {
        .tbtambah {
            margin-bottom: 10px;
            /* Menambahkan margin bawah pada tombol "Tambah" */
        }

        .table-container {
            margin-top: 20px;
            /* Menambahkan jarak antara tombol dan tabel pada perangkat seluler */
        }

        .copsi {
            width: 180px;
            font-size: 12px;
        }

        .copsie {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Daftar Projek P5 Sekolah</h2>
    <div id="overlayprojek"></div>

    <div id="formContainer">
        <div class="formContent">
            <h5>Menambahkan Projek Baru</h5>
            <label for="opsi">Tema</label>
            <select class="copsie" id="itema">
                <?php foreach ($daftar_tema as $row) : ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nama_tema'] ?></option>
                <?php endforeach ?>
            </select><br>
            <label for="nama">Nama projek:</label>
            <textarea class="cprojek" id="iprojek"></textarea>
            <label for="desc">Deskripsi projek:</label>
            <textarea class="cdeskripsi" id="ideskripsi"></textarea><br>
            <button class="hapus" onclick="batalInput()">Batal</button>
            <button class="ok" onclick="okInput()">OK</button>
        </div>
    </div>

    <?php
    $daftar_subkelas = [];
    foreach ($daftar_kelas as $kelas) : ?>

        <div class="kelas">
            <h2>Projek Kelas <?= $kelas ?></h2>

            <div class="">
                <button class="btn btn-primary tbtambah" onclick="tambahProjekSekolah('<?= $kelas ?>')">Tambah Projek</button>
            </div>

            <div class="table-container"> <!-- Menambahkan margin top 4 -->
                <div class="table-responsive">
                    <table class="table projek-sekolah" id="ProjekSekolah<?= $kelas ?>">
                        <tr>
                            <th style="width: 150px;">Tema</th>
                            <th style="width: 30%">Nama Proyek</th>
                            <th style="width: 50%">Deskripsi Proyek</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $adapilihan = 0;
                        $daftar_pilihan = [];
                        foreach ($projek_sekolah as $datarow) {
                            if ($datarow['kelas'] == $kelas) {
                                echo "<tr>";
                                echo "<td data-id='" . $datarow['id'] . "'>" . $datarow['nama_tema'] . "<br></td>";
                                echo "<td>" . $datarow['nama_projek'] . "</td>";
                                echo "<td>" . $datarow['deskripsi_projek'] . "</td>";
                                echo "<td><button data-status='0' class='edit' onclick='editProjekSekolah(this, `" . $kelas . "`,`" . $datarow['id_projek'] . "`)'>Edit</button> <button class='delete' onclick = 'hapusProjekSekolah(this,`" . $datarow['id_projek'] . "`)'>Hapus</button></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach ?>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    var daftarSubKelas = [];
    var kelasprojek;
    var idprojek;
    var randomString;
    var editadd;

    function tambahProjekSekolah(kelas) {
        editadd = "add";
        kelasprojek = kelas;
        kodeacak = "";
        document.getElementById("itema").value = 1;
        document.getElementById("iprojek").value = "";
        document.getElementById("ideskripsi").value = "";
        disableEditDeleteButtons();
        document.getElementById('overlayprojek').style.display = 'block';
        document.getElementById('formContainer').style.display = 'block';
    }

    function generateRandomString(length) {
        var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var randomString = '';

        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            randomString += characters[randomIndex];
        }

        return randomString;
    }

    function okInput() {

        var tableId = "ProjekSekolah" + kelasprojek;
        var table = document.getElementById(tableId);
        var randomString = generateRandomString(10);

        if (document.getElementById("iprojek").value.length <= 10 || document.getElementById("ideskripsi").value.length <= 10) {
            alert("Minimal diisi 10 karakter");
        } else {

            if (editadd == "add") {
                var newRow = table.insertRow(table.rows.length);
                var cell = newRow.insertCell(0);
                var selectElement = document.getElementById("itema");
                cell.style.verticalAlign = "top"
                cell.setAttribute('data-id', selectElement.value);
                cell.innerHTML = selectElement.options[selectElement.selectedIndex].text;

                cell = newRow.insertCell(1);
                cell.style.verticalAlign = "top"
                cell.innerHTML = document.getElementById("iprojek").value;

                cell = newRow.insertCell(2);
                cell.style.verticalAlign = "top"
                cell.innerHTML = document.getElementById("ideskripsi").value;

                cell = newRow.insertCell(3);
                cell.style.verticalAlign = "top"
                cell.innerHTML = '<button class="edit" onclick="editProjekSekolah(this, `' + kelasprojek + '`)">Edit</button> <button class="delete" onclick = "hapusProjekSekolah(this, `' + randomString + '`)">Hapus</button>';

                var url = '<?= base_url() . "admin/simpan_projek" ?>';
                var data = {
                    kelas: kelasprojek,
                    id_tema: selectElement.value,
                    nama_projek: document.getElementById("iprojek").value,
                    deskripsi_projek: document.getElementById("ideskripsi").value,
                    id_projek: randomString,
                };

            } else {
                var rows = table.getElementsByTagName('tr');
                for (var i = 1; i < rows.length; i++) {
                    var row = rows[i];
                    var editButton = row.querySelector('.edit');

                    var dataStatus = row.querySelector('.edit').getAttribute('data-status');

                    if (dataStatus === '1') {

                        var kolomPertama = row.getElementsByTagName('td')[0];
                        var kolomKedua = row.getElementsByTagName('td')[1];
                        var kolomKetiga = row.getElementsByTagName('td')[2];
                        var selectElement = document.getElementById("itema");
                        kolomPertama.setAttribute('data-id', selectElement.value);
                        kolomPertama.innerHTML = selectElement.options[selectElement.selectedIndex].text;
                        kolomKedua.innerHTML = document.getElementById("iprojek").value;
                        kolomKetiga.innerHTML = document.getElementById("ideskripsi").value;

                        row.querySelector('.edit').setAttribute('data-status', '0');
                    }
                }

                var url = '<?= base_url() . "admin/update_projek" ?>';
                var data = {
                    kelas: kelasprojek,
                    id_tema: selectElement.value,
                    nama_projek: document.getElementById("iprojek").value,
                    deskripsi_projek: document.getElementById("ideskripsi").value,
                    id_projek: idprojek,
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
                    document.getElementById('overlayprojek').style.display = 'none';
                    document.getElementById('formContainer').style.display = 'none';
                    enableEditDeleteButtons();
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function batalInput() {
        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
        enableEditDeleteButtons();
    }

    function editProjekSekolah(button, kelas, id_projek) {
        kelasprojek = kelas;
        idprojek = id_projek;
        editadd = "edit";
        var row = button.parentElement.parentElement;

        var dataId = row.cells[0].getAttribute('data-id');
        var cell2 = row.cells[1].textContent;
        var cell3 = row.cells[2].textContent;
        var editButton = row.querySelector('.edit');
        var deleteButton = row.querySelector('.delete');

        editButton.setAttribute('data-status', '1');

        var temaSelect = document.getElementById('itema');
        temaSelect.value = dataId;
        var projekTextarea = document.getElementById('iprojek');
        var deskripsiTextarea = document.getElementById('ideskripsi');
        projekTextarea.value = cell2;
        deskripsiTextarea.value = cell3;

        disableEditDeleteButtons();
        document.getElementById('overlayprojek').style.display = 'block';
        document.getElementById('formContainer').style.display = 'block';

    }

    function hapusProjekSekolah(button, id_projek) {
        if (confirm("Yakin mau menghapus mapel ini")) {
            var row = button.parentElement.parentElement;
            var url = '<?= base_url() . "admin/hapus_projek" ?>';
            var data = {
                id_projek: id_projek,
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

    function dimensiProjekSekolah(id_projek) {
        alert(id_projek);
    }

    function enableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var tbtambah = document.querySelectorAll('.tbtambah');
        var deleteButtons = document.querySelectorAll('.delete');
        var dimensiButtons = document.querySelectorAll('.tbdimensi');

        tbtambah.forEach(function(button) {
            button.removeAttribute('disabled');
        });

        editButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });

        deleteButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });

        dimensiButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });
    }

    function disableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var tbtambah = document.querySelectorAll('.tbtambah');
        var deleteButtons = document.querySelectorAll('.delete');
        var dimensiButtons = document.querySelectorAll('.tbdimensi');

        editButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });

        tbtambah.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });

        deleteButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });

        dimensiButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });
    }

    function tambahProjekSekolahPilihan(kelas) {
        var divPilihan = document.getElementById('pilihan' + kelas);
        divPilihan.style.display = 'block';
    }

    function tambahSubKelas(kelas) {
        var subKelas = document.getElementById('subKelas' + kelas).value;
        var divDaftarSubKelas = document.getElementById('daftarSubKelas' + kelas);

        if (daftarSubKelas.includes(kelas + subKelas.toUpperCase())) {
            alert('Subkelas sudah ada!');
            return;
        }

        if (subKelas == "") {
            document.getElementById('infosub' + kelas).style.display = "block";
            setTimeout(function() {
                document.getElementById('infosub' + kelas).style.display = "none";
            }, 2000);
        } else {
            daftarSubKelas.push(kelas + subKelas.toUpperCase());
            var divSubKelas = document.createElement('div');
            divSubKelas.innerHTML = `<div class="sub-judul">Mapel Pilihan ${subKelas.toUpperCase()} <button onclick="hapusmapelpilihan('${kelas}',this)" class="delete" data-subkelas="${subKelas.toUpperCase()}">Hapus</button></div>
            <button class="tbtambah" onclick="tambahProjekSekolah('pilihan${subKelas.toUpperCase()}', '${kelas}')">Tambah Tema</button>
            <table class="projek-sekolah" id="ProjekSekolahPilihan${subKelas.toUpperCase()}${kelas}">
            <tr>
            <th>Tema</th>
            <th>Aksi</th>
            </tr>
            </table>`;
            divDaftarSubKelas.appendChild(divSubKelas);
            document.getElementById('subKelas' + kelas).value = '';
            document.getElementById('pilihan' + kelas).style.display = "none";
        }
    }

    function hapusmapelpilihan(kelas, e) {
        if (confirm("Yakin mau menghapus mapel pilihan ini")) {

            var url = '<?= base_url() . "admin/hapus_mapel_pilihan" ?>';
            var namaSubKelas = e.getAttribute('data-subkelas');
            var data = {
                kelas: kelas,
                sub_kelas: namaSubKelas,
            };

            e.parentElement.parentElement.remove();
            var index = daftarSubKelas.indexOf(kelas + namaSubKelas);
            if (index !== -1) {
                daftarSubKelas.splice(index, 1);
            }
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {})
                .then()
                .catch(error => console.error('Error:', error));


        }
    }
</script>
<?= $this->endSection() ?>
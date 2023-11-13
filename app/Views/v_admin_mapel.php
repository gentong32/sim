<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
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

    .mata-pelajaran {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .mata-pelajaran td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .mata-pelajaran th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .mata-pelajaran th:nth-child(2) {
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

    .tbimpor {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        margin-right: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #41B55C;
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
        margin-top: 10px;
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
        margin-top: 10px;
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
    }

    #overlayprojek {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        /* display: none; */
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
        /* display: none; */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Daftar Mata Pelajaran</h2>
    <?php
    $daftar_subkelas = [];
    foreach ($daftar_kelas as $kelas) : ?>

        <div class="kelas">
            <h2>Kelas <?= $kelas ?></h2>

            <!-- Mata Pelajaran Umum -->
            <div class="sub-judul">Mata Pelajaran Umum:</div>
            <button class="tbtambah" onclick="tambahMataPelajaran('umum', '<?= $kelas ?>')">Tambah Mapel Lokal</button>
            <table class="mata-pelajaran" id="mataPelajaranUmum<?= $kelas ?>">
                <tr>
                    <th>Nama Mata Pelajaran</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $baris = 0;
                $adapilihan = 0;
                $daftar_pilihan = [];
                foreach ($daftar_mapel as $datarow) {
                    if ($datarow['kelas'] == $kelas && ($datarow['jenis'] == 0 || $datarow['jenis'] == 1)) {
                        $baris++;
                        echo "<tr><td class='editable' contentEditable=false>" . $datarow['nama_mapel'] . "</td>";
                        echo "<td><button class='edit' onclick='editMataPelajaran(this,`" . $datarow['id'] . "`)'>Edit</button> <button style = 'display:none' class = 'ok' onclick = 'okMataPelajaran(this,`umum`,`" . $kelas . "`,`" . $datarow['id'] . "`)'>OK</button><button style = 'display:none' class = 'batal' onclick = 'batalMataPelajaran(this, `" . $baris . "`)'>Batal</button><button class='delete' onclick = 'hapusMataPelajaran(this,`umum`,`" . $kelas . "`,`" . $baris . "`)'>Hapus</button></td></tr>";
                    } else
                    if ($datarow['kelas'] == $kelas && $datarow['jenis'] == 2) {
                        if (!in_array($datarow['sub_kelas'], $daftar_pilihan)) {
                            $daftar_pilihan[] = $datarow['sub_kelas'];
                            $daftar_subkelas[] = $kelas . $datarow['sub_kelas'];
                            $nama_mapel[$datarow['sub_kelas']] = [];
                            $id[$datarow['sub_kelas']] = [];
                            $adapilihan++;
                        }
                        $nama_mapel[$datarow['sub_kelas']][] = $datarow['nama_mapel'];
                        $id[$datarow['sub_kelas']][] = $datarow['id'];
                    }
                }
                ?>
            </table>

            <div id="daftarSubKelas<?= $kelas ?>">
                <?php if ($adapilihan > 0) :
                    foreach ($daftar_pilihan as $sub_kelas) :
                ?> <div>
                            <div class="sub-judul">Mapel Pilihan <?= $sub_kelas ?> <button onclick="hapusmapelpilihan('<?= $kelas ?>',this)" class="delete" data-subkelas="<?= $sub_kelas ?>">Hapus</button></div>
                            <button class="tbimpor" onclick="tampilkanstandarpil('<?= $kelas ?>','<?= $sub_kelas ?>')">Lihat Standar Mapel Pilihan</button>
                            <button class="tbtambah" onclick="tambahMataPelajaran('pilihan<?= $sub_kelas ?>', '<?= $kelas ?>')">Tambah Mapel Lokal</button>
                            <table class="mata-pelajaran" id="mataPelajaranPilihan<?= $sub_kelas ?><?= $kelas ?>">
                                <tr>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php
                                for ($a = 0; $a < sizeof($nama_mapel[$sub_kelas]); $a++) :
                                    echo "<tr><td class='editable' contentEditable=false>" . $nama_mapel[$sub_kelas][$a] . "</td>";
                                    echo "<td><button class='edit' onclick='editMataPelajaran(this, `" . $id[$sub_kelas][$a] . "`)'>Edit</button> <button style = 'display:none' class = 'ok' onclick = 'okMataPelajaran(this,`pilihan" . $sub_kelas . "`,`" . $kelas . "`,`" . $id[$sub_kelas][$a] . "`)'>OK</button><button class='delete' onclick = 'hapusMataPelajaran(this,`pilihan" . $sub_kelas . "`,`" . $kelas . "`,`" . $id[$sub_kelas][$a] . "`)'>Hapus</button></td></tr>\n";
                                endfor;
                                ?>
                            </table>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <?php if ($kelas == 11 || $kelas == 12) : ?>
                <button class="tbpilihan" onclick="tambahMataPelajaranPilihan('<?= $kelas ?>')">Membuat Mata Pelajaran Pilihan Baru</button>
                <br>
                <div id="pilihan<?= $kelas ?>" style="display:none;">
                    <input class="uppercase-input" type="text" id="subKelas<?= $kelas ?>" placeholder="SubKelas" style="width:75px">
                    <button class="ok" onclick="tambahSubKelas('<?= $kelas ?>')">Tambahkan</button>
                    <div style="display:none;" class="infosub" id="infosub<?= $kelas ?>">Isi nama subkelas, misal 'A'</div>
                </div>
            <?php endif ?>
        </div>

    <?php endforeach ?>

    <div class="info">* Kelas yang muncul sesuai dengan kelas yang ada di daftar Rombel</div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var daftarSubKelas = [];
    var addedit;
    var mapellama;
    var idedit = '';

    <?php
    foreach ($daftar_subkelas as $row) {
        echo "daftarSubKelas.push('$row');\n";
    }
    ?>

    function tambahMataPelajaran(jenis, kelas) {
        var tableId = "mataPelajaran" + jenis.charAt(0).toUpperCase() + jenis.slice(1) + kelas.toUpperCase();
        var table = document.getElementById(tableId);
        addedit = "add";

        var newRow = table.insertRow(table.rows.length);
        var cell = newRow.insertCell(0);
        cell.classList.add('editable');
        cell.setAttribute('contenteditable', 'true');
        cell.textContent = 'Nama mapel ...';

        cell.focus();
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);

        cell = newRow.insertCell(1);
        cell.innerHTML = '<button style = "display:none" class="edit" onclick="editMataPelajaran(this, ``)">Edit</button> <button class = "ok" onclick = "okMataPelajaran(this,`' + jenis + '`,`' + kelas + '`,`' + (table.rows.length - 1) + '`)"> OK</button><button class = "batal" onclick = "batalMataPelajaran(this, `' + (table.rows.length - 1) + '`)">Batal</button><button style = "display:none" class="delete"  onclick = "hapusMataPelajaran(this,`' + jenis + '`,`' + kelas + '`,`' + (table.rows.length - 1) + '`)">Hapus</button>';
        disableEditDeleteButtons();

    }

    function editMataPelajaran(button, idmapel) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var okButton = row.querySelector('.ok');
        var deleteButton = row.querySelector('.delete');
        var batalButton = row.querySelector('.batal');
        addedit = "edit";
        mapellama = cell.textContent;
        idedit = idmapel;

        deleteButton.style.display = 'none';
        editButton.style.display = 'none';
        okButton.style.display = 'inline';
        batalButton.style.display = 'inline';

        cell.contentEditable = true;

        disableEditDeleteButtons();

        // Memberikan fokus ke sel yang dapat diedit
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

            // Pastikan elemen yang sedang aktif adalah elemen dengan kelas .editable
            if (activeElement.classList.contains('editable')) {
                // Jalankan fungsi okMataPelajaran dengan tombol "OK" yang sesuai
                var okButton = activeElement.parentElement.querySelector('.ok');
                if (okButton) {
                    okButton.focus();
                }
            }
        }
    });

    function okMataPelajaran(button, jenis, kelas, baris) {
        var row = button.parentElement.parentElement;
        var cell = row.querySelector('.editable');
        var editButton = row.querySelector('.edit');
        var okButton = row.querySelector('.ok');
        var deleteButton = row.querySelector('.delete');
        var batalButton = row.querySelector('.batal');
        var cellContent = cell.textContent;
        // baris--;

        deleteButton.style.display = 'inline';
        editButton.style.display = 'inline';
        okButton.style.display = 'none';
        batalButton.style.display = 'none';

        cell.contentEditable = false;
        var range = document.createRange();
        range.selectNodeContents(cell);
        var selection = window.getSelection();
        selection.removeAllRanges();

        // alert(jenis + "," + kelas + "," + baris + "," + cellContent);
        var url = '<?= base_url() . "admin/simpan_mapel" ?>';
        var data = {
            jenis: jenis,
            kelas: kelas,
            baris: baris,
            cellContent: cellContent,
            addedit: addedit,
            idedit: idedit

        };

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => enableEditDeleteButtons())
            .catch(error => console.error('Error:', error));

    }

    function hapusMataPelajaran(button, jenis, kelas, baris) {
        if (confirm("Yakin mau menghapus mapel ini")) {
            var row = button.parentElement.parentElement;
            var url = '<?= base_url() . "admin/hapus_mapel" ?>';
            var data = {
                jenis: jenis,
                kelas: kelas,
                baris: baris,
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

    function batalMataPelajaran(button, baris) {
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
            cell.textContent = mapellama;
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

    function tambahMataPelajaranPilihan(kelas) {
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
            <button class="tbimpor" onclick="tampilkanstandarpil('${kelas}', '${subKelas.toUpperCase()}')">Pilih dari Daftar Mapel Pilihan</button>
            <button class="tbtambah" onclick="tambahMataPelajaran('pilihan${subKelas.toUpperCase()}', '${kelas}')">Tambah Mapel Pilihan Lokal</button>
            
            <table class="mata-pelajaran" id="mataPelajaranPilihan${subKelas.toUpperCase()}${kelas}">
            <tr>
            <th>Nama Mata Pelajaran</th>
            <th>Aksi</th>
            </tr>
            </table>`;
            divDaftarSubKelas.appendChild(divSubKelas);
            document.getElementById('subKelas' + kelas).value = '';
            document.getElementById('pilihan' + kelas).style.display = "none";
        }
    }

    function impormapel(kelas) {
        if (confirm("Standar mapel akan diimpor. Jika ada perubahan silakan diubah atau dihapus")) {

            var url = '<?= base_url() . "admin/impor_mapel_pilihan" ?>';
            var data = {
                kelas: kelas,
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
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
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

    function tampilkanstandarpil(kelas, subkelas) {
        window.open('<?= base_url() . "admin/mapel_pilihan" ?>?kelas=' + kelas + '&sub_kelas=' + subkelas, '_self');
    }
</script>
<?= $this->endSection() ?>
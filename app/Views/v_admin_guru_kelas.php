<?= $this->extend('layout/layout_admin') ?>

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
        border-radius: 20px;
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
        max-width: 600px;
    }

    .tabel {
        border-collapse: collapse;
        width: 100%;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .tabel th,
    .tabel {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
    }

    .tabel td {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
    }

    .tabel td:first-child {
        padding: 8px;
        font-size: 14px;
        border-bottom: none;
        border-top: none;
    }

    .tabel th {
        background-color: #4CAF50;
        color: white;
    }

    .tabel2 {
        border-collapse: collapse;
        width: 100%;
        max-width: 600px;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .tabel2 th,
    .tabel2 {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
    }

    .tabel2 td {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
    }

    .tabel2 td:first-child {
        padding: 8px;
        font-size: 14px;
    }

    .tabel2 th {
        background-color: skyblue;
        color: white;
    }

    /* .tabel tr:nth-child(even) {
        background-color: #f2f2f2;
    } */

    /* .tabel tr:hover {
        background-color: #ddd;
    } */

    .jkelas {
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 0px;
    }

    .opsi1 {
        width: 200px;
    }

    .opsi2 {
        width: 150px;
    }

    .opsi3 {
        width: 300px;
    }

    .opsi4 {
        width: 300px;
    }

    .dselect {
        margin-bottom: 2px;
    }

    .dselect label {
        vertical-align: middle;
    }

    #dtambah {
        border: 0.5px solid gray;
        border-radius: 5px;
        padding: 15px;
    }

    .tbtambah[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Guru Kelas / Mapel</h2>

    <div id="dtambah" style="display: none;">
        <div class="guru_mapel">
            <div class="dselect">
                <label for="guru">Guru</label><br>
                <select class="js-example-basic-single opsi1" name="guru" id="guru">
                    <option value="0">-- Pilih Guru --</option>
                    <?php foreach ($daftar_guru as $guru) : ?>
                        <option value=<?= $guru['id'] ?>><?= $guru['nama'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="dselect">
                <label for="kelas">Kelas</label><br>
                <select name="kelas" id="kelas" class="js-example-basic-single opsi2">
                    <option value="0">-- Kelas --</option>
                    <?php foreach ($daftar_kelas as $kelas) : ?>
                        <option value='<?= $kelas ?>'><?= $kelas ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="dselect">
                <label for="kelas">Kategori Mapel</label><br>
                <select name="pilihan" id="pilihan" class="js-example-basic-single opsi2">
                    <option value="0">-- Pilihan --</option>
                </select>
            </div>
            <div class="dselect">
                <label for="mapel">Mapel</label><br>
                <select name="mapel" id="mapel" class="js-example-basic-single opsi3">
                    <option value="0">-- Mata Pelajaran --</option>
                </select>
            </div>

            <table class="tabel2" name="pilihrombel" id="pilihrombel">
                <tr>
                    <th>Nama Rombel</th>
                    <th>Pilih</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <button class="batal" id="tbbatal" onclick="batalinput()">Batal</button>
            <button class="ok" id="tbsubmit" onclick="cekkelas()">Submit</button>
        </div>
    </div>
    <?= (!$daftar_rombel) ? "<span style='color:red'>Silakan lengkapi daftar Rombel yang ada di Sekolah terlebih dahulu</span><br>" : "" ?>
    <button <?= (!$daftar_rombel) ? "disabled" : "" ?> class="tbtambah" id="tbtambah" onclick="tampilinput()">Tambahkan Guru Mapel</button>

    <?php
    $baris = 0;
    $buattabel = true;
    $kelas_lama = '';
    $mapel_lama = '';
    $guru_lama = '';
    foreach ($daftar_guru_mapel as $datarow) {
        if ($datarow['kelas'] != $kelas_lama && $kelas_lama != '') {
            echo '</table>';
        }
        if ($datarow['kelas'] != $kelas_lama) {
            echo '<div class="jkelas">Kelas ' . $datarow['kelas'] . '</div>';
            echo '<table class="tabel">
                        <tr>
                            <th>Mata Pelajaran</th>
                            <th>Nama Guru</th>
                            <th>Nama Rombel</th>
                        </tr>';
            $kelas_lama = $datarow['kelas'];
        }
        $baris++;
        if ($datarow['nama_mapel'] != $mapel_lama) {
            $namamapel = "<td style='border-top:1px solid #ddd'>" . $datarow['nama_mapel'] . "</td>";
            $mapel_lama = $datarow['nama_mapel'];
        } else {
            $namamapel = "<td></td>";
        }
        echo "<tr>";
        echo $namamapel;
        echo "<td>" . $datarow['nama'] . "</td>";
        echo "<td>" . $datarow['nama_rombel'] . "</td>";
        echo "</tr>";
    }
    ?>
    </table>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    var tahunsekarang = <?= tahun_ajaran() ?>;
    var selectedKelas = 0;
    var selectedPilihan = 0;
    var selectedGuru = 0;
    var selectedMapel = 0;

    $('#guru').on('change', function() {
        selectedGuru = $(this).val();
        ambilrombel();
    });

    $('#mapel').on('change', function() {
        selectedMapel = $(this).val();
        ambilrombel();
    });

    $('#kelas').on('change', function() {
        selectedKelas = $(this).val();
        ambilsubkelas();
    });

    function tampilinput() {
        document.getElementById('dtambah').style.display = "block";
        document.getElementById('tbtambah').style.display = "none";
    }

    function batalinput() {
        document.getElementById('dtambah').style.display = "none";
        document.getElementById('tbtambah').style.display = "block";
    }

    function ambilsubkelas() {
        var filterRombelSelect = document.getElementById('pilihan');
        if (selectedKelas > 0) {
            fetch('<?= base_url() . "admin/get_sub_kelas_mapel/" ?>' + selectedKelas, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {

                    filterRombelSelect.innerHTML = '';

                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            var rombel = data[key];
                            var option = document.createElement('option');
                            option.value = rombel.sub_kelas;
                            option.text = rombel.sub_kelas;
                            filterRombelSelect.add(option);
                        }
                    }
                    selectedPilihan = filterRombelSelect.value;
                    ambilmapel();

                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            filterRombelSelect.innerHTML = '<option value="0">-- Pilihan --</option>';
            var filterMapelSelect = document.getElementById('mapel');
            filterMapelSelect.innerHTML = '<option value="0">-- Mata Pelajaran --</option>';
            var filterrombel = document.getElementById('pilihrombel');
            var tbody = filterrombel.getElementsByTagName('tbody')[0];
            tbody.innerHTML = "<tr><th>Nama Rombel</th> <th>Pilih</th></tr><tr><td></td><td></td></tr>";

        }
    }

    $('#pilihan').on('change', function() {
        selectedPilihan = $(this).val();
        ambilmapel();
    });

    function ambilmapel() {
        fetch('<?= base_url() . "admin/get_mapel/" ?>' + selectedKelas + "/" + selectedPilihan, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {

                var filterMapelSelect = document.getElementById('mapel');
                filterMapelSelect.innerHTML = '';

                var sekali = false;
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var mapel = data[key];
                        var option = document.createElement('option');
                        option.value = mapel.id;
                        option.text = mapel.nama_mapel;
                        filterMapelSelect.add(option);
                        if (sekali == false) {
                            sekali = true;
                            selectedMapel = mapel.id;
                        }
                    }
                }

                ambilrombel();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function ambilrombel() {
        if (selectedKelas > 0) {
            var url = '<?= base_url() . "admin/get_rombel_mapel" ?>';
            var data = {
                tahunsekarang: tahunsekarang,
                kelas: selectedKelas,
                pilihan: selectedPilihan,
                mapel: selectedMapel,
                guru: selectedGuru,
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
                    var filterrombel = document.getElementById('pilihrombel');
                    var tbody = filterrombel.getElementsByTagName('tbody')[0];
                    tbody.innerHTML = "<tr><th>Nama Rombel</th> <th>Pilih</th></tr>";

                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            var rombel = data[key];
                            var row = tbody.insertRow();

                            var cell1 = row.insertCell(0);
                            cell1.innerHTML = rombel.nama_rombel;

                            var cell2 = row.insertCell(1);
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.className = 'checkbox-rombel';
                            if (selectedGuru == 0) {
                                checkbox.checked = false;
                                checkbox.disabled = true;
                            }
                            if (rombel.aktif == 2) {
                                checkbox.checked = true;
                            } else if (rombel.aktif == 1) {
                                checkbox.disabled = true;
                            }
                            cell2.appendChild(checkbox);
                        }
                    }

                })
                .catch(error => console.error('Error:', error));
        }
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

    function cekkelas() {

        var rows = document.getElementById('pilihrombel').getElementsByTagName('tr');
        var rombelTerpilih = [];

        for (var i = 1; i < rows.length; i++) {
            var checkbox = rows[i].getElementsByTagName('input')[0];
            var nama_rombel = rows[i].cells[0].innerHTML;

            if (checkbox.checked) {
                rombelTerpilih.push(nama_rombel);
            }
        }

        if (selectedKelas > 0) {
            var url = '<?= base_url() . "admin/simpan_guru_mapel" ?>';
            var data = {
                tahunsekarang: tahunsekarang,
                rombelTerpilih: rombelTerpilih,
                selectedKelas: selectedKelas,
                selectedPilihan: selectedPilihan,
                selectedMapel: selectedMapel,
                selectedGuru: selectedGuru
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
                    // alert(data);
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    label {
        font-size: 14px;
        margin-bottom: 8px;
        /* display: block; */
    }

    select {
        margin-bottom: 5px;
        font-size: 16px;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        /* width: 100%; */
        box-sizing: border-box;
    }

    .tabel {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .tabel th,
    .tabel td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        font-size: 14px;
    }

    .tabel th {
        background-color: #4CAF50;
        color: white;
    }

    .tabel tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .tabel tr:hover {
        background-color: #ddd;
    }

    /* Tombol Utama */
    .button {
        display: inline-block;
        padding: 10px 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #4caf50;
        /* Warna Hijau */
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Tombol Sekunder */
    .button.secondary {
        background-color: #607d8b;
        /* Warna Abu-abu Tua */
    }

    .button.secondary:hover {
        background-color: #455a64;
        /* Warna Abu-abu Tua (Efek Hover) */
    }

    .button2 {
        display: inline-block;
        padding: 10px 10px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #4cafbb;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .button2:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .button2:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .button2:disabled:hover {
        transform: none;
        box-shadow: none;
    }

    .button3 {
        display: inline-block;
        padding: 10px 10px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #99cc00;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .button3:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .button3:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .button3:disabled:hover {
        transform: none;
        box-shadow: none;
    }

    #info {
        text-align: center;
        margin-top: 20px;
        color: blue;
        display: block;
    }

    .daftar {
        margin-left: 10px !important;
        margin-right: 10px !important;
        padding: 5px !important;
        max-width: 800px;
        margin: auto !important;
    }

    @media screen and (max-width: 400px) {

        label {
            font-size: 12px;
            margin-bottom: 8px;
            /* display: block; */
        }

        select {
            font-size: 12px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            /* width: 100%; */
            box-sizing: border-box;
        }

        .tabel th,
        .tabel td {
            font-size: 12px;
            /* Atur ukuran font untuk layar mobile di bawah 400px */
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="dkelas">
    <div class="back-button">
        <a href="/home"><img src="/assets/back.png" alt="back"></a>
    </div>
    <div class="center">
        <div class="judul_menu">Peserta Ekskul <?= $nama_ekskul ?></div>
    </div>
</div>

<div id="formContainer">
    <?php if (sizeof($daftar_peserta_ekskul) == 0) { ?>
        <span style='color:white'>
            <h3>Belum ada peserta eksul <?= $nama_ekskul ?></h3>Tunggu siswa agar mereka mendaftar sendiri, atau bisa menambahkan secara manual.
        </span>
    <?php } else { ?>

        <h3>Daftar Peserta Ekskul</h3>

        <div class="daftar">
            <div id="info"></div>
            <table class="tabel" id="daftarSiswaTahunNext">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Rombel</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $nomor = 1;
                foreach ($daftar_peserta_ekskul as $row) { ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $row['nis'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['nama_rombel'] ?></td>
                        <td><button onclick="hapusSiswa('<?= $row['nisn'] ?>')">Hapus</button></td>
                    </tr>
                <?php
                    $nomor++;
                } ?>
            </table>
        </div>
        <br>
    <?php } ?>
    <br>
    <center>
        <button style="display: <?= ($tampil) ? "block" : "none" ?>;" id="tb_siswa" class="button2" onclick="tampilsiswa()">Tambahkan Peserta</button>
    </center>
    <br>
    <br>
    <div id="dafsiswa" style="display: <?= ($tampil) ? "none" : "block" ?>;">
        <hr>
        <h3>Daftar Siswa Sekolah</h3>

        <label for="filterKelas">Kelas:</label>
        <select id="filterKelas">
            <?php
            foreach ($daftar_kelas as $baris) {
                $selected = '';
                if ($baris == $kelassiswa)
                    $selected = "selected";
                echo  "<option $selected value='" . $baris . "'>" . $baris . "</option>";
            }
            ?>
        </select>

        <label for="filterRombel">Rombel:</label>
        <select id="filterRombel">
            <?php

            foreach ($daftar_rombel as $baris) {
                $selected = '';
                if ($baris->nama_rombel == $rombelsiswa)
                    $selected = "selected";
                echo  "<option $selected value='" . $baris->nama_rombel . "'>" . $baris->nama_rombel . "</option>";
            }
            ?>
        </select>

        <button style="display: none;" id="terapkan1" class="button" onclick="terapkan()">Terapkan</button>

        <div class="daftar">
            <table class="tabel" id="daftarSiswa">
                <tr>
                    <th>Pilih</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Rombel</th>
                </tr>
                <?php foreach ($datasiswa as $row) { ?>
                    <tr>
                        <td><input type="checkbox" class="check-item">
                        </td>
                        <td data-nisn="<?= $row['nisn'] ?>"><?= $row['nis'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['kelas'] ?></td>
                        <td><?= $row['nama_rombel'] ?></td>
                    </tr>
                <?php } ?>
            </table>

            <label for="toggleCheckbox">Pilih Semua</label>
            <input type="checkbox" id="toggleCheckbox" onchange="toggleSelectAll()">
        </div>
        <button id="tb_batal" class="button2" onclick="bataltampil()">Batal</button>
        <button disabled id="tb_pindah" class="button2" onclick="pindahKelas()">Ikut Ekskul</button>

        <br>
        <br>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var dataSiswaTujuan = [];


    document.getElementById('filterKelas').addEventListener('change', function() {
        var selectedKelas = this.value;
        document.getElementById('terapkan1').style.display = "";

        fetch('<?= base_url() . "get_rombel_kelas/" ?>' + selectedKelas, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                var filterRombelSelect = document.getElementById('filterRombel');
                filterRombelSelect.innerHTML = '';

                for (var key in data) {
                    var rombel = data[key];
                    var option = document.createElement('option');
                    option.value = rombel.nama_rombel;
                    option.text = rombel.nama_rombel;
                    filterRombelSelect.add(option);
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    });


    document.getElementById('filterRombel').addEventListener('change', function() {
        document.getElementById('terapkan1').style.display = "";
    });

    function filterSiswa() {
        var filterKelas = document.getElementById('filterKelas').value;
        var filterRombel = document.getElementById('filterRombel').value.toUpperCase();

        var tabel = document.getElementById('daftarSiswa');
        var baris = tabel.getElementsByTagName('tr');

        for (var i = 1; i < baris.length; i++) {
            var kolomKelas = baris[i].getElementsByTagName('td')[3].textContent;
            var kolomRombel = baris[i].getElementsByTagName('td')[4].textContent.toUpperCase();

            if ((filterKelas === 'semua' || kolomKelas === filterKelas) &&
                (kolomRombel.includes(filterRombel) || filterRombel === 'SEMUA')) {
                baris[i].style.display = '';
            } else {
                baris[i].style.display = 'none';
            }
        }
    }

    function toggleSelectAll() {
        var checkboxes = document.querySelectorAll('#daftarSiswa input[type="checkbox"]');
        var toggleCheckbox = document.getElementById('toggleCheckbox');

        checkboxes.forEach(function(checkbox) {
            var siswa = {
                kelas: checkbox.parentElement.nextElementSibling.nextElementSibling.textContent,
                rombel: checkbox.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.textContent
            };

            if (checkbox.parentElement.parentElement.style.display !== 'none') {
                checkbox.checked = toggleCheckbox.checked;
                buttonPindah.disabled = !toggleCheckbox.checked;
            }

        });
    }


    function isSiswaSesuaiFilter(siswa) {
        var filterKelas = document.getElementById('filterKelas').value;
        var filterRombel = document.getElementById('filterRombel').value;

        if (filterKelas !== 'semua' && siswa.kelas !== filterKelas) {
            return false;
        }

        if (filterRombel !== 'Semua' && siswa.rombel !== filterRombel) {
            return false;
        }

        return true;
    }

    function hapusSiswa(nisn) {
        var idx_ekskul = <?= $idx_ekskul ?>;
        var requestData = {
            idx_ekskul: idx_ekskul,
            selectedNisn: nisn
        };

        fetch('<?= base_url() ?>user/hapus_siswa_ekskul', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }

    function pindahKelas() {
        var checkboxes = document.querySelectorAll('#daftarSiswa input[type="checkbox"]:checked');
        var tabelSiswaTahunNext = document.getElementById('daftarSiswaTahunNext');

        var totalpilihpindah = 0;

        var selectedNisn = [];

        var idx_ekskul = <?= $idx_ekskul ?>;

        checkboxes.forEach(function(checkbox) {
            totalpilihpindah++;
            var siswaBaru = checkbox.parentElement.parentElement.cloneNode(true);
            // var kolomKelas = siswaBaru.querySelector('td:nth-child(4)');
            // kolomKelas.textContent = kdaftarSiswaTahunNextelasTujuan;

            // tabelSiswaTahunNext.appendChild(siswaBaru);
            var nisn = checkbox.closest('tr').querySelector('[data-nisn]').dataset.nisn;
            // Menambahkan nilai data-nisn ke dalam array selectedNisn
            selectedNisn.push(nisn);
            // checkbox.parentElement.parentElement.remove();
        });

        var requestData = {
            idx_ekskul: idx_ekskul,
            selectedNisn: selectedNisn
        };

        <?php
        $jalan = true;
        if ($jalan) { ?>
            fetch('<?= base_url() ?>user/simpan_siswa_ekskul', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.json())
                .then(data => {
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        <?php } ?>

        // sortTable('daftarSiswaTahunNext', 2);
        if (totalpilihpindah == 0)
            alert("Pilih siswa yang akan dipindah")
        // else
        // document.getElementById('tb_simpan_kelas').disabled = false;
    }

    function terapkan() {
        kelassiswa = document.getElementById('filterKelas').value;
        rombelsiswa = document.getElementById('filterRombel').value;
        window.open("<?= base_url() . 'peserta_ekskul' ?>?kelas=<?= $kelas_pilihan ?>&swkelas=" + kelassiswa + "&swrombel=" + rombelsiswa, "_self");
    }

    function tampilsiswa() {
        dafsiswa = document.getElementById('dafsiswa');
        tb_siswa = document.getElementById('tb_siswa');
        dafsiswa.style.display = "block";
        tb_siswa.style.display = "none";
    }

    function bataltampil() {
        dafsiswa = document.getElementById('dafsiswa');
        tb_siswa = document.getElementById('tb_siswa');
        dafsiswa.style.display = "none";
        tb_siswa.style.display = "block";
    }

    function simpanKelas() {
        document.getElementById('tb_simpan_kelas').disabled = true;
        document.getElementById('tb_pindah').disabled = true;
        document.getElementById('tb_kembali').disabled = true;
        ambil_siswa_tabel_tujuan();
        fetch('<?= base_url() ?>admin/simpan_siswa_pindah', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataSiswaTujuan)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('info').innerText = data.message;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function ambil_siswa_tabel_tujuan() {
        var tahunAsal = document.getElementById('tahunAjaran').value;
        var tahunTujuan = document.getElementById('tahunAjaranTujuan').value;
        var kelasTujuan = document.getElementById('filterKelasTujuan').value;
        var rombelTujuan = document.getElementById('filterRombelTujuan').value;
        var tabelSiswaTahunNext = document.getElementById('daftarSiswaTahunNext');
        var barisSiswa = tabelSiswaTahunNext.querySelectorAll('tr');
        dataSiswaTujuan = [];

        for (var i = 1; i < barisSiswa.length; i++) {
            var kolomNIS = barisSiswa[i].querySelector('td:nth-child(2)').textContent;
            var kolomNISN = barisSiswa[i].querySelector('td:nth-child(2)').dataset.nisn;
            var kolomNama = barisSiswa[i].querySelector('td:nth-child(3)').textContent;
            var kolomKelasAsal = barisSiswa[i].querySelector('td:nth-child(4)').textContent;
            var kolomRombelAsal = barisSiswa[i].querySelector('td:nth-child(5)').textContent;

            var siswa = {
                nis: kolomNIS,
                nisn: kolomNISN,
                nama: kolomNama,
                kelas: kolomKelasAsal,
                rombel: kolomRombelAsal,
                tahun: tahunAsal,
                tahuntujuan: tahunTujuan,
                kelastujuan: kelasTujuan,
                rombeltujuan: rombelTujuan,
            };
            dataSiswaTujuan.push(siswa);
        }

    }

    const checkboxes = document.querySelectorAll('.check-item');
    const buttonPindah = document.getElementById('tb_pindah');

    function checkIfChecked() {
        let atLeastOneChecked = false;
        let allChecked = 0;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                allChecked++;
                atLeastOneChecked = true;
            }
        });
        buttonPindah.disabled = !atLeastOneChecked;
        toggleCheckbox.checked = false;
        if (allChecked == 3)
            toggleCheckbox.checked = true;
    }

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', checkIfChecked);
    });
</script>
<?= $this->endSection() ?>
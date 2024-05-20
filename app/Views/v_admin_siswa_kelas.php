<?php
if (tahun_sekarang() != $tahun_pilihan) {
    $selected2 = '';
    $selected1 = 'selected';
} else {
    $selected1 = '';
    $selected2 = 'selected';
}
?>

<?= $this->extend('layout/layout_admin') ?>

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

    .tabel td:nth-child(3) {
        text-align: left;
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

    /* select {
        width: 200px;
    } */

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
<h2 class="judul">Siswa Pindah / Naik Kelas</h2>
<h3>Tahun Ajaran <?= $tahun_ajaran ?></h3>
<hr>
<?php if (!$daftar_rombel) { ?>
    <span style='color:red'>Silakan lengkapi daftar Rombel yang ada di Sekolah terlebih dahulu</span>
<?php } else { ?>
    <div class="konten">
        <label for="tahun">Tahun Asal</label>
        <select id="tahunAjaran">
            <?php
            if (bulan_sekarang() < 6) { ?>
                <option value="<?= (tahun_sekarang() - 1) ?>"><?= (tahun_sekarang() - 1) . "/" . (tahun_sekarang()) ?></option>
            <?php } ?>
            <?php if (bulan_sekarang() >= 6 && bulan_sekarang() <= 7) { ?>
                <option <?= $selected1 ?> value="<?= (tahun_sekarang() - 1) ?>"><?= (tahun_sekarang() - 1) . "/" . (tahun_sekarang()) ?></option>
                <option <?= $selected2 ?> value="<?= (tahun_sekarang()) ?>"><?= (tahun_sekarang() . "/" . (tahun_sekarang() + 1)) ?></option>
            <?php } ?>
            <?php if (bulan_sekarang() > 7) { ?>
                <option value="<?= (tahun_sekarang()) ?>"><?= (tahun_sekarang()) . "/" . (tahun_sekarang() + 1) ?></option>
            <?php } ?>
        </select>
        <button style="display: none;" id="terapkantahunasal" onclick="terapkantahunasal()" class=" button">Terapkan</button>
        <br>
        <label for="filterKelas">Kelas:</label>
        <select id="filterKelas">
            <?php
            foreach ($daftar_kelas as $baris) {
                $selected = '';
                if ($baris == $kelas)
                    $selected = "selected";
                echo  "<option $selected value='" . $baris . "'>" . $baris . "</option>";
            }
            ?>
        </select>

        <label for="filterRombel">Rombel:</label>
        <select id="filterRombel">
            <?php
            if ($jumlah_rombel_kosong > 0) {
                $selected = '';
                if ($rombel == "-")
                    $selected = "selected";
                echo  "<option $selected value='-'>-</option>";
            }
            foreach ($daftar_rombel as $baris) {
                $selected = '';
                if ($baris->nama_rombel == $rombel)
                    $selected = "selected";
                echo  "<option $selected value='" . $baris->nama_rombel . "'>" . $baris->nama_rombel . "</option>";
            }
            ?>
        </select>

        <button style="display: none;" id="terapkan1" class="button" onclick="terapkan()">Terapkan</button>

    </div>

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
                <td><?php if ($row['status_pindah'] == 0) { ?>
                        <input type="checkbox">
                    <?php } ?>
                </td>
                <td data-nisn="<?= $row['nisn'] ?>"><?= $row['nis'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td><?= $row['nama_rombel'] ?></td>
            </tr>
        <?php } ?>
    </table>

    <div class="konten">
        <label for="toggleCheckbox">Pilih Semua</label>
        <input type="checkbox" id="toggleCheckbox" onchange="toggleSelectAll()">
    </div>

    <br><br>
    <hr>
    <div class="konten">
        <label for="tahun">Tahun Tujuan</label>
        <select id="tahunAjaranTujuan">
            <?php
            if (bulan_sekarang() < 6) { ?>
                <option value="<?= (tahun_sekarang() - 1) ?>"><?= (tahun_sekarang() - 1) . "/" . (tahun_sekarang()) ?></option>
            <?php } ?>
            <?php if (bulan_sekarang() >= 6 && bulan_sekarang() <= 7) { ?>
                <option value="<?= (tahun_sekarang() - 1) ?>"><?= (tahun_sekarang() - 1) . "/" . (tahun_sekarang()) ?></option>
                <option selected value="<?= (tahun_sekarang()) ?>"><?= (tahun_sekarang() . "/" . (tahun_sekarang() + 1)) ?></option>
            <?php } ?>
            <?php if (bulan_sekarang() > 7) { ?>
                <option value="<?= (tahun_sekarang()) ?>"><?= (tahun_sekarang()) . "/" . (tahun_sekarang() + 1) ?></option>
            <?php } ?>
        </select>

        <br>
        <label for="filterKelasTujuan">Kelas:</label>
        <select id="filterKelasTujuan">
            <option value="0">-Pilih-</option>
            <?php
            foreach ($daftar_kelas_tujuan as $baris) {
                echo  "<option value='" . $baris . "'>" . $baris . "</option>";
            }
            ?>
        </select>
        <label for="filterRombelTujuan">Rombel:</label>
        <select id="filterRombelTujuan">
            <option value="0">-</option>
        </select>
        <button style="display: none;" id="terapkan2" class="button">Terapkan</button>
        <br>
        <button disabled id="tb_pindah" class="button2" onclick="pindahKelas()">Pindah / Naik Kelas</button>
        <button disabled id="tb_kembali" class="button2" onclick="kembaliKeKelasTahunPrev()">Kembali ke Asal</button>
        <button disabled id="tb_simpan_kelas" class="button3" onclick="simpanKelas()">Simpan ke Database</button>
        <div id="info"></div>
    </div>
    <table class="tabel" id="daftarSiswaTahunNext">
        <tr>
            <th>Pilih</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas Asal</th>
            <th>Rombel Asal</th>
        </tr>
    </table>
<?php } ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var dataSiswaTujuan = [];
    var selectedTahun = "<?= $tahun_mulai ?>";
    var selectedTahunTujuan = document.getElementById('tahunAjaranTujuan').value;

    document.getElementById('tahunAjaran').addEventListener('change', function() {
        selectedTahun = this.value;
        document.getElementById('terapkantahunasal').style.display = "inline";
    });

    function terapkantahunasal() {
        window.open("<?= base_url() . 'admin/siswa_kelas/' ?>" + selectedTahun, "_self");
    }

    document.getElementById('tahunAjaranTujuan').addEventListener('change', function() {
        selectedTahunTujuan = this.value;
        document.getElementById('filterKelasTujuan').selectedIndex = 0;
        var filterRombelSelect = document.getElementById('filterRombelTujuan');
        filterRombelSelect.innerHTML = '';
        var optionKosong = document.createElement('option');
        optionKosong.value = '-';
        optionKosong.text = '-';
        filterRombelSelect.add(optionKosong);
        document.getElementById('terapkan2').style.display = "none";
    });

    document.getElementById('filterKelas').addEventListener('change', function() {
        var selectedKelas = this.value;
        document.getElementById('terapkan1').style.display = "";

        fetch('<?= base_url() . "admin/get_rombel_kelas/" ?>' + selectedTahun + "/" + selectedKelas, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                var filterRombelSelect = document.getElementById('filterRombel');
                filterRombelSelect.innerHTML = '';

                if ('rombel_kosong' in data) {
                    var optionKosong = document.createElement('option');
                    optionKosong.value = '-';
                    optionKosong.text = '-';
                    filterRombelSelect.add(optionKosong);
                }

                for (var key in data) {
                    if (data.hasOwnProperty(key) && key !== 'rombel_kosong') {
                        var rombel = data[key];
                        var option = document.createElement('option');
                        option.value = rombel.nama_rombel;
                        option.text = rombel.nama_rombel;
                        filterRombelSelect.add(option);
                    }
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.getElementById('filterKelasTujuan').addEventListener('change', function() {
        var selectedKelas = this.value;

        document.getElementById('terapkan2').style.display = "";
        document.getElementById('info').innerText = "";

        fetch('<?= base_url() . "admin/get_rombel_kelas/" ?>' + selectedTahunTujuan + "/" + selectedKelas, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                var filterRombelSelect = document.getElementById('filterRombelTujuan');
                filterRombelSelect.innerHTML = '';

                if ('rombel_kosong' in data) {
                    var optionKosong = document.createElement('option');
                    optionKosong.value = '-';
                    optionKosong.text = '-';
                    // filterRombelSelect.add(optionKosong);
                }

                for (var key in data) {
                    if (data.hasOwnProperty(key) && key !== 'rombel_kosong') {
                        var rombel = data[key];
                        var option = document.createElement('option');
                        option.value = rombel.nama_rombel;
                        option.text = rombel.nama_rombel;
                        filterRombelSelect.add(option);
                    }
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.getElementById('filterRombel').addEventListener('change', function() {
        document.getElementById('terapkan1').style.display = "";
    });

    document.getElementById('filterRombelTujuan').addEventListener('change', function() {
        document.getElementById('terapkan2').style.display = "";
        document.getElementById('info').innerText = "";
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

    function pindahKelas() {
        var kelasTujuan = document.getElementById('filterKelasTujuan').value;
        var checkboxes = document.querySelectorAll('#daftarSiswa input[type="checkbox"]:checked');
        var tabelSiswaTahunNext = document.getElementById('daftarSiswaTahunNext');

        var totalpilihpindah = 0;
        checkboxes.forEach(function(checkbox) {
            totalpilihpindah++;
            var siswaBaru = checkbox.parentElement.parentElement.cloneNode(true);
            // var kolomKelas = siswaBaru.querySelector('td:nth-child(4)');
            // kolomKelas.textContent = kdaftarSiswaTahunNextelasTujuan;

            tabelSiswaTahunNext.appendChild(siswaBaru);
            checkbox.parentElement.parentElement.remove();
        });

        sortTable('daftarSiswaTahunNext', 2);
        if (totalpilihpindah == 0)
            alert("Pilih siswa yang akan dipindah")
        else
            document.getElementById('tb_simpan_kelas').disabled = false;
    }

    function kembaliKeKelasTahunPrev() {
        var tabelSiswaTahunNext = document.getElementById('daftarSiswaTahunNext');
        var tabelSiswaTahunPrev = document.getElementById('daftarSiswa');

        var siswaBaru = [];
        var siswaYangKembali = [];

        for (var i = 1; i < tabelSiswaTahunNext.rows.length; i++) {
            var checkbox = tabelSiswaTahunNext.rows[i].getElementsByTagName('input')[0];
            if (checkbox.checked) {
                siswaYangKembali.push(tabelSiswaTahunNext.rows[i]);
            } else {
                siswaBaru.push(tabelSiswaTahunNext.rows[i]);
            }
        }

        var totalpilihkembali = 0;
        siswaYangKembali.forEach(function(row) {
            totalpilihkembali++;
            tabelSiswaTahunNext.removeChild(row);
            tabelSiswaTahunPrev.appendChild(row);
        });

        sortTable('daftarSiswa', 2);
        filterSiswa();

        if (totalpilihkembali == 0)
            alert("Pilih siswa yang akan batal pindah");
    }

    function terapkan() {
        window.open("<?= base_url() . 'admin/siswa_kelas/' ?>" + document.getElementById('tahunAjaran').value + "/" + document.getElementById('filterKelas').value + "/" +
            document.getElementById('filterRombel').value, "_self");
    }

    document.getElementById('terapkan2').addEventListener('click', function() {
        document.getElementById('terapkan2').style.display = "none";
        var tb_pindah = document.getElementById('tb_pindah').disabled = false;
        var tb_kembali = document.getElementById('tb_kembali').disabled = false;

        var kelasTujuan = document.getElementById('filterKelasTujuan').value;
        var rombelTujuan = document.getElementById('filterRombelTujuan').value;
        var tahunAjaranTujuan = document.getElementById('tahunAjaranTujuan').value;

        // Kirim permintaan Ajax ke controller
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= base_url() . "admin/get_daftar_siswa" ?>?kelas=' + kelasTujuan + '&rombel=' + rombelTujuan + '&tahun_ajaran=' + tahunAjaranTujuan, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                tampilkanDataSiswa(data);
            } else {
                console.error('Gagal memuat data.');
            }
        };
        xhr.send();
    });

    function tampilkanDataSiswa(data) {
        var tabel = document.getElementById('daftarSiswaTahunNext');
        barisHeader = tabel.rows[0];
        tabel.innerHTML = '';
        tabel.appendChild(barisHeader);

        for (var i = 0; i < data.length; i++) {
            var row = tabel.insertRow(i + 1);
            row.insertCell(0).innerHTML = '<input type="checkbox">';
            var cellNIS = row.insertCell(1);
            cellNIS.innerHTML = data[i].nis;
            cellNIS.dataset.nisn = data[i].nisn;
            row.insertCell(2).innerHTML = data[i].nama;
            row.insertCell(3).innerHTML = data[i].kelas;
            row.insertCell(4).innerHTML = data[i].nama_rombel;


        }
    }

    function sortTable(tableId, column, order) {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById(tableId);
        switching = true;

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[column + 1];
                y = rows[i + 1].getElementsByTagName("td")[column + 1];

                var kelasX = x.textContent.toLowerCase().trim();
                var kelasY = y.textContent.toLowerCase().trim();

                var namaX = rows[i].getElementsByTagName("td")[column].textContent.toLowerCase().trim();
                var namaY = rows[i + 1].getElementsByTagName("td")[column].textContent.toLowerCase().trim();

                if (kelasX === kelasY) {
                    if (namaX > namaY) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (kelasX > kelasY) {
                    shouldSwitch = true;
                    break;
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
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

    sortTable('daftarSiswa', 2);
</script>
<?= $this->endSection() ?>
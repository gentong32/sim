<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<label for="tahunAjaran">Tahun Ajaran:</label>
<select id="tahunAjaran">
    <option value="2022">2022</option>
    <option value="2023">2023</option>
    <!-- Tambahkan tahun ajaran lainnya jika diperlukan -->
</select>

<label for="filterKelas">Filter Kelas:</label>
<select id="filterKelas" onchange="updateRombelOptions()">
    <option value="semua">Semua Kelas</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
</select>

<label for="filterRombel">Filter Rombel:</label>
<select id="filterRombel"></select>

<button onclick="filterSiswa()">Terapkan Filter</button>

<table id="daftarSiswa">
    <tr>
        <th></th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Rombel</th>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>123</td>
        <td>John Doe</td>
        <td>7</td>
        <td>VII A</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>456</td>
        <td>Jane Doe</td>
        <td>7</td>
        <td>VII B</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>789</td>
        <td>James Smith</td>
        <td>8</td>
        <td>VIII A</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>101</td>
        <td>Jane Smith</td>
        <td>8</td>
        <td>VIII B</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>121</td>
        <td>Joe Smith</td>
        <td>8</td>
        <td>VIII C</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>289</td>
        <td>Dean Smith</td>
        <td>9</td>
        <td>IX A</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>151</td>
        <td>Jane Maria</td>
        <td>9</td>
        <td>IX B</td>
    </tr>
    <tr>
        <td><input type="checkbox"></td>
        <td>422</td>
        <td>Andi Tasman</td>
        <td>9</td>
        <td>IX C</td>
    </tr>
</table>

<label for="toggleCheckbox">Pilih Semua</label>
<input type="checkbox" id="toggleCheckbox" onchange="toggleSelectAll()">

<label for="kelasTujuan">Kelas Tujuan:</label>
<select id="kelasTujuan">
    <option value="8A">8A</option>
    <option value="8B">8B</option>
    <option value="8C">8C</option>
    <!-- Tambahkan pilihan kelas tujuan lainnya jika diperlukan -->
</select>

<button onclick="pindahKelas()">Pindah Kelas</button>
<button onclick="kembaliKeKelasTahun2022()">Kembali ke Tahun 2022</button>


<h2>Siswa Tahun 2023</h2>
<table id="daftarSiswaTahun2023">
    <tr>
        <th></th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Rombel</th>
    </tr>
</table>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function updateRombelOptions() {
        var filterKelas = document.getElementById('filterKelas').value;
        var filterRombelSelect = document.getElementById('filterRombel');
        filterRombelSelect.innerHTML = '';

        var rombelOptions = ['Semua'];

        if (filterKelas == '7') {
            rombelOptions = rombelOptions.concat(['VII A', 'VII B']);
        }
        if (filterKelas == '8') {
            rombelOptions = rombelOptions.concat(['VIII A', 'VIII B', 'VIII C']);
        }
        if (filterKelas == '9') {
            rombelOptions = rombelOptions.concat(['IX A', 'IX B', 'IX C']);
        }

        rombelOptions.forEach(function(rombel) {
            var option = document.createElement('option');
            option.value = rombel;
            option.text = rombel;
            filterRombelSelect.add(option);
        });
    }

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
        var kelasTujuan = document.getElementById('kelasTujuan').value;
        var checkboxes = document.querySelectorAll('#daftarSiswa input[type="checkbox"]:checked');
        var tabelSiswaTahun2023 = document.getElementById('daftarSiswaTahun2023');

        checkboxes.forEach(function(checkbox) {
            var siswaBaru = checkbox.parentElement.parentElement.cloneNode(true);
            // var kolomKelas = siswaBaru.querySelector('td:nth-child(4)');
            // kolomKelas.textContent = kelasTujuan;

            tabelSiswaTahun2023.appendChild(siswaBaru);
            checkbox.parentElement.parentElement.remove();
        });

        sortTable('daftarSiswaTahun2023', 2);
    }

    function kembaliKeKelasTahun2022() {
        var tabelSiswaTahun2023 = document.getElementById('daftarSiswaTahun2023');
        var tabelSiswaTahun2022 = document.getElementById('daftarSiswa');

        var siswaBaru = [];
        var siswaYangKembali = [];

        for (var i = 1; i < tabelSiswaTahun2023.rows.length; i++) {
            var checkbox = tabelSiswaTahun2023.rows[i].getElementsByTagName('input')[0];
            if (checkbox.checked) {
                siswaYangKembali.push(tabelSiswaTahun2023.rows[i]);
            } else {
                siswaBaru.push(tabelSiswaTahun2023.rows[i]);
            }
        }

        siswaYangKembali.forEach(function(row) {
            tabelSiswaTahun2023.removeChild(row);
            tabelSiswaTahun2022.appendChild(row);
        });

        sortTable('daftarSiswa', 2);
        filterSiswa();
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


    sortTable('daftarSiswa', 2);
</script>
<?= $this->endSection() ?>
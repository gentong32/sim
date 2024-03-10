<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<style>
    :root {
        --ukf: 13px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        text-align: left;
        font-size: 16px;
    }

    th,
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .btn {
        padding: 5px 5px;
        margin: 0 2px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-import {
        background-color: #3498db;
        color: #fff;
    }

    .btn-export {
        background-color: #e74c3c;
        color: #fff;
    }

    .btn-tambah {
        background-color: green;
        color: #fff;
        margin-bottom: 10px;
    }

    .tab-container {
        display: flex;

    }

    .tab {
        padding: 10px 20px;
        background-color: #555;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 16px;
        margin-right: 0px;
        margin-top: 20px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        transition: background-color 0.3s;
    }

    .active-tab {
        background-color: #333;
    }

    .content_tab {
        margin-top: 0px;
        padding: 20px;
        border: 1px solid #ccc;
        width: 95%;
    }

    h2 {
        margin-bottom: 5px;
    }

    .hidden-content {
        display: none;
    }

    .info_user tr>td:first-child {
        width: 100px;
    }

    .info_user tr>td:nth-child(2) {
        width: 40px;
    }

    @media screen and (max-width: 768px) {
        table {
            font-size: var(--ukf);
        }

        tr>td:first-child {
            width: 80px;
        }

        tr>td:nth-child(2) {
            width: 20px;
        }

        table.dataTable tbody td {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_title {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTable thead th {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_filter input {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_filter label {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_info {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: var(--ukf);
        }

        .dataTables_wrapper .dataTables_length label {
            font-size: var(--ukf);
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h2 class="judul">Daftar User Sekolah</h2>
<h3>Tahun Ajaran <?= $tahun_ajaran ?></h3>
<button onclick="bukapetunjuk()">Petunjuk Impor Data</button>
<table class="info_user">
    <tr>
        <td>Data Guru</td>
        <td><?= $info['jumlah_guru'] ?></td>
        <td>
            <button id="importButtonG" class="btn btn-import">Impor</button>
            <button id="exportButtonG" class="btn btn-export">Ekspor</button>
        </td>
    </tr>
    <tr>
        <td>Data Siswa</td>
        <td><?= $info['jumlah_siswa'] ?></td>
        <td>
            <button id="importButtonS" class="btn btn-import">Impor</button>
            <button id="exportButtonS" class="btn btn-export">Ekspor</button>
        </td>
    </tr>
    <tr>
        <td>Data Staf</td>
        <td><?= $info['jumlah_staf'] ?></td>
        <td>
            <button id="importButtonT" class="btn btn-import">Impor</button>
            <button id="exportButtonT" class="btn btn-export">Ekspor</button>
        </td>
    </tr>
</table>

<form id="uploadForm">
    <input type="file" id="fileInputG" accept=".xlsx" style="display:none;" />
    <input type="file" id="fileInputS" accept=".xlsx" style="display:none;" />
    <input type="file" id="fileInputT" accept=".xlsx" style="display:none;" />
</form>

<div class="tab-container">
    <div id="tguru" class="tab" onclick="showContent('guru')">Guru</div>
    <div id="tsiswa" class="tab" onclick="showContent('siswa')">Siswa</div>
    <div id="tstaf" class="tab" onclick="showContent('staf')">Staf</div>
</div>
<div id="guru" class="content_tab hiddent-content">
    <h2>Daftar Guru</h2>
    <button onclick="tambahguru()" class="btn btn-tambah">Tambah Guru</button>
    <table id="dataGuru" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th class="none">NUPTK</th>
                <th class="none">NIP</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th class="none">J. Kelamin</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div id="siswa" class="content_tab hidden-content">
    <h2>Daftar Siswa</h2>
    <button onclick="tambahsiswa()" id="importButtonS" class="btn btn-tambah">Tambah Siswa</button>
    <table id="dataSiswa" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th class="none">NISN</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th class="none">Tempat/Tanggal Lahir</th>
                <th class="none">J. Kelamin</th>
                <th class="none">Agama</th>
                <th>Telepon</th>
                <th class="none">Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<div id="staf" class="content_tab hidden-content">
    <h2>Daftar Staf</h2>
    <button onclick="tambahstaf()" id="importButtonT" class="btn btn-tambah">Tambah Staf</button>
    <table id="dataStaf" class="display">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th class="none">J. Kelamin</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    var kodeacak = '<?= $kode_acak ?>';
    var gurusekali = false;
    var siswasekali = false;
    var stafsekali = false;

    function bukapetunjuk() {
        window.open("<?= base_url() ?>admin/info_impor", "_self");
    }

    function tambahguru() {
        window.open("<?= base_url() ?>admin/tambah_guru", "_self");
    }

    function editguru(id_guru) {
        window.open("<?= base_url() ?>admin/edit_guru/" + id_guru, "_self");
    }

    function tambahsiswa() {
        window.open("<?= base_url() ?>admin/tambah_siswa", "_self");
    }

    function editsiswa(id_siswa) {
        window.open("<?= base_url() ?>admin/edit_siswa/" + id_siswa, "_self");
    }

    function tambahstaf() {
        window.open("<?= base_url() ?>admin/tambah_staf", "_self");
    }

    function editstaf(id_staf) {
        window.open("<?= base_url() ?>admin/edit_staf/" + id_staf, "_self");
    }

    function showContent(tabId) {
        localStorage.setItem('activeTab', tabId);
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.classList.remove('active-tab');
        });
        document.getElementById("t" + tabId).classList.add('active-tab');

        const contents = document.querySelectorAll('.content_tab');
        contents.forEach(content => {
            content.classList.add('hidden-content');
        });
        document.getElementById(tabId).classList.remove('hidden-content');

        if (tabId == "guru" && gurusekali == false) {
            gurusekali = true;
            loadguru();
        } else if (tabId == "siswa" && siswasekali == false) {
            siswasekali = true;
            loadsiswa();
        } else if (tabId == "staf" && stafsekali == false) {
            stafsekali = true;
            loadstaf();
        }

    }

    document.getElementById('importButtonG').addEventListener('click', function() {
        <?php if ($info['jumlah_guru'] > 0) { ?>
            if (confirm("Impor Data akan menghapus data lama yang sudah ada di tahun ajaran saat ini. Akan melanjutkan?"))
            <?php } ?>
            document.getElementById('fileInputG').click();
    });
    document.getElementById('importButtonS').addEventListener('click', function() {
        <?php if ($info['jumlah_siswa'] > 0) { ?>
            if (confirm("Impor Data akan menghapus data lama yang sudah ada di tahun ajaran dan kelas saat ini. Akan melanjutkan?"))
            <?php } ?>
            document.getElementById('fileInputS').click();
    });
    document.getElementById('importButtonT').addEventListener('click', function() {
        <?php if ($info['jumlah_staf'] > 0) { ?>
            if (confirm("Impor Data akan menghapus data lama yang sudah ada di tahun ajaran saat ini. Akan melanjutkan?"))
            <?php } ?>
            document.getElementById('fileInputT').click();
    });

    document.getElementById('fileInputG').addEventListener('change', function() {
        uploaddata("G");
    });
    document.getElementById('fileInputS').addEventListener('change', function() {
        uploaddata("S");
    });
    document.getElementById('fileInputT').addEventListener('change', function() {
        uploaddata("T");
    });

    document.getElementById('exportButtonG').addEventListener('click', function() {
        window.open('<?= base_url() . "admin/eksporDataGuru" ?>', '_self');
    });

    document.getElementById('exportButtonS').addEventListener('click', function() {
        window.open('<?= base_url() . "admin/eksporDataSiswa" ?>', '_self');
    });

    document.getElementById('exportButtonT').addEventListener('click', function() {
        window.open('<?= base_url() . "admin/eksporDataStaf" ?>', '_self');
    });

    function uploaddata(kode) {
        showOverlay();
        var idfile = "fileInput" + kode;
        var fileInput = document.getElementById(idfile);
        var uploadedFile = fileInput.files[0];

        if (uploadedFile.type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            alert('Hanya file dengan ekstensi .xlsx yang diizinkan.');
            return;
        }

        if (uploadedFile.size > 1048576) {
            alert('Ukuran file tidak boleh lebih dari 1MB.');
            return;
        }

        var formData = new FormData();
        formData.append('file', uploadedFile);
        formData.append('tahun_ajaran', '<?= tahun_ajaran() ?>');
        formData.append('pengguna', kode);

        fetch('/admin/upload_data/' + kodeacak, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log('Response:', data);
                // alert(data);
                hideOverlay();
                if (data == "sukses") {
                    if (kode == "G")
                        localStorage.setItem('activeTab', 'guru');
                    else if (kode == "S")
                        localStorage.setItem('activeTab', 'siswa');
                    else if (kode == "T")
                        localStorage.setItem('activeTab', 'staf');
                    window.open('<?= base_url("admin/user") ?>', '_self');
                } else {
                    alert('Gagal mengimpor. Silakan coba lagi, dan pastikan file sesuai format dan data yang akan diimpor.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideOverlay();
                localStorage.getItem('activeTab');
                showContent(activeTab);
                alert('Terjadi kesalahan saat mengunggah file.');
            });
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<script>
    let nama_bulan = ['', 'Jan', 'Peb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des'];
    $(document).ready(function() {

        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            showContent(activeTab);
        } else
            loadguru();

    });

    function loadguru() {
        var dataguru = <?php echo json_encode($dataguru); ?>;
        var table = $('#dataGuru').DataTable({
            language: {
                url: '/js/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: -1
                },
                {
                    responsivePriority: 2,
                    targets: 2
                }
            ],
        });

        dataguru.forEach(function(guru, index) {
            jk = "Laki-laki";
            if (guru.jenis_kelamin == "P")
                jk = "Perempuan";
            table.row.add([
                (index + 1),
                guru.nuptk,
                guru.nip,
                guru.nama,
                guru.alamat,
                jk,
                guru.telp,
                guru.email,
                '<button class="editButton" onclick="editguru(`' + guru.id_guru + '`)">Edit</button> <button class="deleteButton" data-id="' + index + '" onclick="konfirmasiDelete(`' + guru.id_guru + '`, ' + index + ')">Delete</button> <button class="editButton" onclick="resetgurupass(`' + guru.id_guru + '`)">Reset</button>'
            ]).draw(false);
        });
    }

    function loadsiswa() {
        var datasiswa = <?php echo json_encode($datasiswa); ?>;
        var table2 = $('#dataSiswa').DataTable({
            language: {
                url: '/js/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: -1
                },

            ],
        });

        datasiswa.forEach(function(siswa, index) {
            jk = "Laki-laki";
            if (siswa.jenis_kelamin == "P")
                jk = "Perempuan";
            tg_exp = siswa.tanggal_lahir.split('-');
            tanggallahir = tg_exp[2] + " " + nama_bulan[parseInt(tg_exp[1])] + " " + tg_exp[0];
            table2.row.add([
                (index + 1),
                siswa.nisn,
                siswa.nis,
                siswa.nama,
                siswa.kelas,
                siswa.alamat,
                siswa.tempat_lahir + ", " + tanggallahir,
                jk,
                siswa.agama,
                siswa.telp,
                siswa.email,
                '<button class="editButton" onclick="editsiswa(`' + siswa.id_siswa + '`)">Edit</button><button class="deleteButton" data-id="' + index + '" onclick="konfirmasiDeleteSiswa(`' + siswa.id_siswa + '`, ' + index + ')">Delete</button> <button class="editButton" onclick="resetsiswapass(`' + siswa.id_siswa + '`)">Reset</button>'
            ]).draw(false);
        });
    }

    function loadstaf() {
        var datastaf = <?php echo json_encode($datastaf); ?>;
        var table3 = $('#dataStaf').DataTable({
            language: {
                url: '/js/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: -1
                },
                {
                    responsivePriority: 2,
                    targets: 2
                }
            ],
        });

        datastaf.forEach(function(staf, index) {
            jk = "Laki-laki";
            if (staf.jenis_kelamin == "P")
                jk = "Perempuan";
            table3.row.add([
                (index + 1),
                staf.nama,
                staf.alamat,
                jk,
                staf.telp,
                staf.email,
                '<button class="editButton" onclick="editstaf(`' + staf.id_staf + '`)">Edit</button><button class="deleteButton" data-id="' + index + '" onclick="konfirmasiDeleteStaf(`' + staf.id_staf + '`, ' + index + ')">Delete</button> <button class="editButton" onclick="resetstafpass(`' + staf.id_staf + '`)">Reset</button>'
            ]).draw(false);
        });
    }

    // FUNGSI KONFIRM DELETE

    function konfirmasiDelete(id_guru, index) {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/hapus_guru_sekolah');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat menghapus data');
                }
            };
            xhr.send('id_guru=' + id_guru + '&tahun_ajaran=<?= $tahun_ajaran ?>');
        } else {
            return false;
        }
    }

    function konfirmasiDeleteSiswa(id_siswa, index) {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/hapus_siswa_sekolah');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat menghapus data');
                }
            };
            xhr.send('id_siswa=' + id_siswa + '&tahun_ajaran=<?= $tahun_ajaran ?>');
        } else {
            return false;
        }
    }

    function konfirmasiDeleteStaf(id_staf, index) {
        var konfirmasi = confirm("Apakah Anda yakin ingin menghapus data ini?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/hapus_staf_sekolah');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat menghapus data');
                }
            };
            xhr.send('id_staf=' + id_staf + '&tahun_ajaran=<?= $tahun_ajaran ?>');
        } else {
            return false;
        }
    }

    function resetgurupass(id_guru) {
        var konfirmasi = confirm("Ini mau di reset passwordnya menjadi default 123456?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/reset_guru_pass');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat reset password');
                }
            };
            xhr.send('id_guru=' + id_guru);
        } else {
            return false;
        }
    }

    function resetsiswapass(id_siswa) {
        var konfirmasi = confirm("Ini mau di reset passwordnya menjadi default 123456?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/reset_siswa_pass');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat reset password');
                }
            };
            xhr.send('id_siswa=' + id_siswa);
        } else {
            return false;
        }
    }

    function resetstafpass(id_staf) {
        var konfirmasi = confirm("Ini mau di reset passwordnya menjadi default 123456?");

        if (konfirmasi) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/reset_staf_pass');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    console.log('Terjadi kesalahan saat reset password');
                }
            };
            xhr.send('id_staf=' + id_staf);
        } else {
            return false;
        }
    }

    // setTimeout(function() {
    //     document.getElementById("siswa").classList.add('hidden-content');
    // }, 500);

    // });
</script>
<?= $this->endSection() ?>
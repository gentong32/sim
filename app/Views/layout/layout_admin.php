<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM S</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/s_umum.css?v1.1">
    <link rel="stylesheet" href="<?= base_url() ?>css/s_admin.css?v1.1">
    <?= $this->renderSection('style') ?>
    <link rel="icon" href="<?php echo base_url(); ?>images/icon.png" type="image/gif" sizes="16x16">
</head>

<body>
    <div id="overlay">
        <div class="loading-message">
            <span>Tunggu...</span>
        </div>
    </div>

    <div class="header">
        <div class="logo">
            <img src="<?= base_url() ?>assets/logotut.png" alt="Logo">
            <span><?= $sekolah['nama'] ?></span>
        </div>
        <div class="user-group">
            <div class="user-info">
                <a href="#" id="userLink"><?= $nama_user ?></a>
                <div class="dropdown" id="logoutDropdown">
                    <ul>
                        <li><a href="<?= base_url('login/change_password') ?>">- Ubah Password</a></li>
                        <li><a href="<?= base_url('login/logout') ?>">- Logout</a></li>
                    </ul>
                </div>
            </div>
            <button id="toggleSidebar">&#9776;</button>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <button id="closeSidebar" class="close-btn">×</button>
            <ul class="menu">
                <li><a href="<?= base_url() ?>admin/">Informasi Sekolah</a></li>
                <li><a href="<?= base_url() ?>admin/user">Data User</a></li>
                <li id="dataReferensiLokal"><a href="#">Data Referensi Lokal ></a>
                    <ul id="submenuReferensi">
                        <li><a href="<?= base_url() ?>admin/kepsek">Kepala Sekolah</a></li>
                        <li><a href="<?= base_url() ?>admin/mapel">Mata Pelajaran</a></li>
                        <li><a href="<?= base_url() ?>admin/rombel">Rombel - Wali Kelas</a></li>
                        <li><a href="<?= base_url() ?>admin/guru_mapel">Guru Kelas / Mapel</a></li>
                        <li><a href="<?= base_url() ?>admin/siswa_kelas">Siswa Kelas</a></li>
                        <li><a href="<?= base_url() ?>admin/projek">Projek Sekolah</a></li>
                        <li><a href="<?= base_url() ?>admin/dimensi">Dimensi Projek</a></li>
                        <li><a href="<?= base_url() ?>admin/ekskul">Ekskul</a></li>
                    </ul>
                </li>
                <li><a href="<?= base_url() ?>admin/agenda">Kalender Pendidikan</a></li>
            </ul>
        </div>
        <div class="content">
            <?= $this->renderSection('konten') ?>
        </div>
    </div>

    <div class="alamat">
        <p>&copy; 2023 Sawo 3 Production</p>
    </div>

</body>

</html>

<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');

        sidebar.style.width = sidebar.style.width === '250px' ? '0' : '250px';

        // Tampilkan tombol untuk menutup sidebar
        closeSidebarBtn.style.display = 'block';
    });

    document.getElementById('closeSidebar').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.width = '0';
    });

    document.addEventListener('DOMContentLoaded', function() {
        const dataReferensiLokal = document.getElementById('dataReferensiLokal');
        const submenuReferensi = document.getElementById('submenuReferensi');

        dataReferensiLokal.addEventListener('click', function(e) {
            // e.preventDefault();
            submenuReferensi.classList.toggle('show');
        });
    });

    let logoutDropdown = document.getElementById('logoutDropdown');
    let userLink = document.getElementById('userLink');

    userLink.addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah link mengarahkan ke halaman lain

        if (logoutDropdown.style.display === 'block') {
            logoutDropdown.style.display = 'none'; // Sembunyikan submenu jika sudah terbuka
        } else {
            logoutDropdown.style.display = 'block';
        }
    });

    // Fungsi untuk menampilkan overlay
    function showOverlay() {
        document.getElementById('overlay').style.display = 'flex';
    }

    // Fungsi untuk menyembunyikan overlay
    function hideOverlay() {
        document.getElementById('overlay').style.display = 'none';
    }
</script>

<?= $this->renderSection('script') ?>
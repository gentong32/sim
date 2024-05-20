<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM S</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/s_umum.css?v1.1">
    <link rel="stylesheet" href="<?= base_url() ?>css/s_admin.css?v2.1">
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
            <span><?= (isset($sekolah)) ? $sekolah['nama'] : "" ?></span>
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
                <li><a href="<?= base_url() ?>admin/info_sekolah">Informasi Sekolah</a></li>
                <li><a href="<?= base_url() ?>admin/user">Data User</a></li>
                <li id="dataReferensiLokal"><a href="#">Data Referensi Lokal ></a>
                    <ul id="submenuReferensi">
                        <li><a href="<?= base_url() ?>admin/kepsek" class="submenu-link">Kepala Sekolah</a></li>
                        <li><a href="<?= base_url() ?>admin/mapel" class="submenu-link">Mata Pelajaran</a></li>
                        <li><a href="<?= base_url() ?>admin/rombel" class="submenu-link">Rombel - Wali Kelas</a></li>
                        <li><a href="<?= base_url() ?>admin/guru_mapel" class="submenu-link">Guru Kelas / Mapel</a></li>
                        <li><a href="<?= base_url() ?>admin/siswa_kelas" class="submenu-link">Siswa Kelas</a></li>
                        <li><a href="<?= base_url() ?>admin/projek" class="submenu-link">Projek Sekolah</a></li>
                        <li><a href="<?= base_url() ?>admin/dimensi" class="submenu-link">Dimensi Projek</a></li>
                        <li><a href="<?= base_url() ?>admin/ekskul" class="submenu-link">Ekskul</a></li>
                        <li><a href="<?= base_url() ?>admin/jadwal_ujian" class="submenu-link">Jadwal Ujian</a></li>
                        <li><a href="<?= base_url() ?>admin/bobot_nilai" class="submenu-link">Bobot Nilai</a></li>
                        <li><a href="<?= base_url() ?>admin/kop_rapor" class="submenu-link">Kop Rapor</a></li>
                    </ul>
                </li>
                <li id="menuKalender"><a href="#">Kalender Pendidikan ></a>
                    <ul id="submenuKalender">
                        <li><a href="<?= base_url() ?>admin/kalender_sekolah" class="submenu-link2">Tanggal Penting</a></li>
                        <li><a href="<?= base_url() ?>admin/agenda" class="submenu-link2">Kalender Tahunan</a></li>
                        <li><a href="<?= base_url() ?>pengumuman/daftar" class="submenu-link2">Pengumuman</a></li>
                    </ul>
                </li>
                <!-- <li><a href="<? //= base_url() 
                                    ?>admin/pengumuman">Pengumuman</a></li> -->
            </ul>
        </div>
        <div class="content">
            <?= $this->renderSection('konten') ?>
            <div class="alamat">
                <p>&copy; 2023 Sawo 3 Production</p>
            </div>
        </div>
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
        const menuKalender = document.getElementById('menuKalender');
        const submenuKalender = document.getElementById('submenuKalender');
        const currentUrl = window.location.href;

        function closeAllSubmenus() {
            submenuReferensi.classList.remove('show');
            submenuKalender.classList.remove('show');
        }

        dataReferensiLokal.addEventListener('click', function(e) {
            if (!submenuReferensi.classList.contains('show')) {
                closeAllSubmenus();
            }
            submenuReferensi.classList.toggle('show');
        });

        menuKalender.addEventListener('click', function(e) {
            if (!submenuKalender.classList.contains('show')) {
                closeAllSubmenus();
            }
            submenuKalender.classList.toggle('show');
        });

        const menuItems = document.querySelectorAll('.menu a');
        menuItems.forEach(item => {
            const itemUrl = item.getAttribute('href');
            if (currentUrl.includes(itemUrl)) {
                item.classList.add('aktif');

                // Buka submenu jika item ada di dalam submenu
                const parentSubmenu = item.closest('ul');
                if (parentSubmenu) {
                    parentSubmenu.classList.add('show');
                }
            }
        });

        const submenuLinks = document.querySelectorAll('.submenu-link');
        submenuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                submenuReferensi.classList.toggle('show');
                e.preventDefault();
                const url = this.href;
                setTimeout(() => {
                    window.location.href = url;
                }, 100); // Adjust the delay as needed
            });
        });

        const submenuLinks2 = document.querySelectorAll('.submenu-link2');
        submenuLinks2.forEach(link => {
            link.addEventListener('click', function(e) {
                submenuKalender.classList.toggle('show');
                e.preventDefault();
                const url = this.href;
                setTimeout(() => {
                    window.location.href = url;
                }, 100); // Adjust the delay as needed
            });
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
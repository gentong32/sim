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
    <div class="header">
        <div class="logo">
            <img src="<?= base_url() ?>assets/logotut.png" alt="Logo">
            <span>Selamat datang Bos</span>
        </div>
        <div class="user-group">
            <div class="user-info">
                <a href="#" id="userLink">Bos</a>
                <div class="dropdown" id="logoutDropdown">
                    <ul>
                        <li><a href="<?= base_url('login/logout') ?>">Logout</a></li>
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
                <li><a href="<?= base_url() ?>superadmin/">Informasi Umum</a></li>
                <li><a href="<?= base_url() ?>superadmin/user">Daftar Admin</a></li>
                <li><a href="<?= base_url() ?>superadmin/kalender">Kalender Indonesia</a></li>
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

        closeSidebarBtn.style.display = 'block';
    });

    document.getElementById('closeSidebar').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.width = '0';
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
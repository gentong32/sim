<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Sekolah</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/s_umum.css?v1.1">
    <link rel="stylesheet" href="<?= base_url() ?>css/mystyle.css?v1.1">
    <?= $this->renderSection('style') ?>
    <link rel="icon" href="<?php echo base_url(); ?>images/icon.png" type="image/gif" sizes="16x16">
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
</head>

<body>
    <?php if (!isset($nofooter)) : ?>
        <div class="judul">
            <h1><?php
                $jam = date("H");
                if ($jam >= 5 && $jam < 11) {
                    echo "Selamat Pagi";
                } elseif ($jam >= 11 && $jam < 15) {
                    echo "Selamat Siang";
                } elseif ($jam >= 15 && $jam < 18) {
                    echo "Selamat Sore";
                } else {
                    echo "Selamat Malam";
                }
                ?></h1>
            <h2><?= session()->get('nama_user') ?></h2>
            <button onclick="keluar();">Logout</button>
        </div>
    <?php endif ?>

    <?php if (isset($beranda)) : ?>
        <div class="dkelas">
            <h2>SISWA KELAS <?= $data_saya['nama_rombel'] ?></h2>
        </div>
    <?php endif ?>

    <?php if (isset($submenu)) : ?>
        <div class="dkelas">
            <div class="back-button">
                <a href="/home"><img src="/assets/back.png" alt="back"></a>
            </div>

            <div class="center">
                <div style="margin-left:0px;"><img src="/assets/<?= $ikon ?>.png" alt="Ikon"></div>
                <div class="judul_menu">&nbsp;<?= $judul_submenu ?></div>
            </div>
        </div>
    <?php endif ?>


    <?= $this->renderSection('konten') ?>

    <?php if (!isset($nofooter)) : ?>
        <div class="alamat">
            <p>&copy; 2023 Sawo 3 Production</p>
        </div>
    <?php endif ?>
</body>

</html>

<script>
    var selectedKelas;
    var awalpil;

    function keluar() {
        window.open('<?= base_url() ?>login/logout', '_self');
    }
</script>
<?= $this->renderSection('script') ?>
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
            <h1>Selamat Pagi</h1>
            <h2>Pak Guru</h2>
        </div>
    <?php endif ?>

    <?php if (isset($beranda)) : ?>
        <div class="dkelas">
            <h1>Kelas: &nbsp;</h1>
            <div class="custom-select">
                <div class="selected-option" onclick="toggleOptions()">
                    <span><?= $kelas ?></span>
                    <img src="assets/downarrow.png" alt="Panah Bawah">
                </div>
                <div class="options">
                    <div onclick="selectOption('X - 1')" data-value="10_1">X - 1</div>
                    <div onclick="selectOption('X - 12')" data-value="10_12">X - 12</div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (isset($submenu)) : ?>
        <div class="dkelas">
            <div class="back-button">
                <a href="/home" onclick="appendKelasToLink('?kelas=<?= $valkelas ?>')"><img src=" assets/back.png" alt="back"></a>
            </div>
            <div class="center">
                <div style="margin-left:30px;"><img src="assets/<?= $ikon ?>.png" alt="Ikon"></div>
                <h1><?= $menutitle ?> Kelas: &nbsp;</h1>
                <div class="custom-select">
                    <div class="selected-option" onclick="toggleOptions()">
                        <span><?= $kelas ?></span>
                        <img src="assets/downarrow.png" alt="Panah Bawah">
                    </div>
                    <div class="options">
                        <div onclick="selectOption('X - 1')" data-value="10_1">X - 1</div>
                        <div onclick="selectOption('X - 12')" data-value="10_12">X - 12</div>
                    </div>
                </div>
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

<?= $this->renderSection('script') ?>
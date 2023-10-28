<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    .module {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .thumbnail-container {
        width: 150px;
    }

    .thumbnail-container img {
        max-width: 100px;
        max-height: 130px;
    }

    .info {
        line-height: 1.5;
        max-width: 150px;
        font-size: 12px;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="module">
    <div data-pdf="/assets/pdf/X_Indo.pdf">
        <div class="thumbnail-container">
            <img src="/assets/pdf/X_Indo.png" alt="Thumbnail">
        </div>
        <div class="info">
            <p>B. Indonesia Kelas X</p>
        </div>
    </div>

    <div data-pdf="/assets/pdf/X_Ppkn.pdf">
        <div class="thumbnail-container">
            <img src="/assets/pdf/X_Ppkn.png" alt="Thumbnail">
        </div>
        <div class="info">
            <p>PPKN Kelas X</p>
        </div>
    </div>
</div>

<!-- Tambahkan modul-modul lainnya di sini -->


<?= $this->endSection(); ?>


<?= $this->section('script') ?>


<?= $this->endSection(); ?>
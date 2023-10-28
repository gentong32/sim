<?= $this->extend('layout/layout_kosong') ?>

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
    <?php
    if ($url) {
        $videoId = $url;
        if ($videoId) {
            echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
        } else {
            echo 'URL video tidak valid';
        }
    } else {
        echo 'URL video tidak diberikan';
    }
    ?>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>

<?= $this->endSection(); ?>
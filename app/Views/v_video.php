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
    <div class="video-item" data-video-id="WAE3-XPclE4">
        <div class="thumbnail-container">
            <img src="https://img.youtube.com/vi/WAE3-XPclE4/default.jpg" alt="Thumbnail">
        </div>
        <div class="info">
            <p>Belajar Kimia</p>
        </div>
    </div>

    <div class="video-item" data-video-id="37qlKD55zOc">
        <div class=" thumbnail-container">
            <img src="https://img.youtube.com/vi/37qlKD55zOc/default.jpg" alt="Thumbnail">
        </div>
        <div class="info">
            <p>Belajar Fisika</p>
        </div>
    </div>
</div>

<!-- Tambahkan modul-modul lainnya di sini -->


<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoItems = document.querySelectorAll('.video-item');

        videoItems.forEach(item => {
            item.addEventListener('click', function() {
                const videoId = this.dataset.videoId;
                window.open(`<?= base_url() ?>video/detil?url=${videoId}`, '_blank');
            });
        });
    });
</script>

<?= $this->endSection(); ?>
<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    :root {
        --ukf: 12px;
    }

    .cumum {
        text-align: justify;
        background-color: #D6EAF8;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 25px;
        font-size: 14px;
        max-width: 900px;
        width: 100%;
        padding: 20px;
    }

    .tumum {
        width: 100%;
        min-height: 300px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<!-- <h2 class="calendar-title">PENGUMUMAN</h2> -->
<div class="editor cumum">
    <?php
    if (sizeof($pengumuman) > 0) {
        foreach ($pengumuman as $index => $row) : ?>
            <div>- <?= $row['judul'] ?> -</div>
            <textarea id="editor<?= $index ?>" name="editor<?= $index ?>" class="tumum"></textarea>
            <br>
    <?php endforeach;
    } ?>
</div>
<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?= base_url('ckeditor_2/ckeditor.js') ?>"></script>
<script>
    <?php

    if (sizeof($pengumuman) > 0) {
        foreach ($pengumuman as $index => $row) : ?>
            ClassicEditor
                .create(document.querySelector('#editor<?= $index ?>'), {
                    toolbar: [],
                })
                .then(editor => {
                    editor.setData(`<?= addslashes($row['pengumuman']) ?>`);
                    editor.enableReadOnlyMode('#editor<?= $index ?>');
                })
                .catch(error => {
                    console.error(error);
                });
    <?php endforeach;
    }
    ?>
</script>


<?= $this->endSection(); ?>
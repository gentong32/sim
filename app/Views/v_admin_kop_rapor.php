<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php if (isset($ckeditor) && $ckeditor === true) : ?>
    <script src="<?= base_url('ckeditor/ckeditor.js') ?>"></script>
<?php endif; ?>
<style>
    .submit-btn {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }

    .batal-btn {
        background-color: #ff2110;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .batal-btn:hover {
        background-color: #ff2019;
    }

    .text-danger {
        color: red;
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
    }

    .btn {
        padding: 5px;
        margin: 5px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="form-container">

    <h2>Kop Rapor Sekolah</h2>
    <form action="<?= base_url('admin/simpanKopRapor') ?>" method="post" onsubmit="return validateForm()">
        <textarea id="editor1" name=" editor1"><?= $kop_rapor ?></textarea>
        <br>
        <input id="updateBtn" class="submit-btn" type="submit" name="update" value="Update" style="display: none;">
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    const editor = CKEDITOR.replace('editor1');
    const updateBtn = document.getElementById('updateBtn');

    function validateForm() {
        var editorData = CKEDITOR.instances.editor1.getData();

        if (editorData.trim() === '') {
            alert("Teks masih kosong");
            return false;
        }

        return true;
    }

    editor.on('change', function() {
        updateBtn.style.display = 'block';
    });
</script>
<?= $this->endSection() ?>
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

    .bobot {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 20px;
        padding: 15px;
    }

    .inilai {
        font-size: 18px;
        padding: 10px;
        width: 50px;

    }

    .tabelnilai {
        text-align: center;
        border-collapse: collapse;
    }

    .tabelnilai tr td {
        border: solid 0.5px green;
        text-align: center;
        padding: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="form-container">
    <div class="bobot">
        <h2>Bobot Nilai Akhir</h2>
        <form action="<?= base_url('admin/simpan_bobot_nilai') ?>" method="post">
            <input type="hidden" name="tahunajaran" value="<?= $tahun_ajaran ?>">
            <table class="tabelnilai">
                <tr>
                    <td>
                        <h3>NA Sumatif Materi</h3>
                    </td>
                    <td>
                        <h3>NA Akhir Semester</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input disabled class="inilai" type="number" id="materi" name="materi" value="<?= 100 - $bobot_tes ?>"> %
                    </td>
                    <td>
                        <input class="inilai" type="number" id="bobotnilai" name="bobotnilai" max="100" min="0" value="<?= $bobot_tes ?>"> %
                    </td>
                </tr>
            </table>
            <br>
            <input id="updateBtn" class="submit-btn" type="submit" name="update" value="Update" style="display: none;">
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    document.getElementById("bobotnilai").addEventListener("input", function() {
        var nilaiInput = parseInt(this.value);
        var nilaiMateri = 100 - nilaiInput;
        document.getElementById("materi").value = nilaiMateri;
        document.getElementById("updateBtn").style.display = "block";
    });
</script>
<?= $this->endSection() ?>
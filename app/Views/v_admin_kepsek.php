<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .dkepsek {
        padding: 5px;
        line-height: 22px;
        border: 1px solid gray;
        border-radius: 5px;
        max-width: 300px;
    }

    .dkepsek label {
        display: block;
    }

    .dtdtgn {
        padding: 5px;
        line-height: 22px;
        border: 1px solid gray;
        border-radius: 5px;
        max-width: 300px;
        margin-top: 30px;
    }

    .dtdtgn label {
        display: block;
    }

    .inputtdtgn {
        margin-top: 20px;
    }

    .tbtambah {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #26BEAE;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit,
    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .delete,
    .batal {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit[disabled],
    .delete[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }

    button {
        height: 25px;
        margin-bottom: 2px;
    }

    .inputkepsek {
        margin-top: 25px;
    }

    .select2-dropdown .select2-results__option {
        font-size: 14px;
    }

    .js-select {
        width: 250px;
        font-size: 14px;
    }

    .text-danger {
        color: red;
        font-size: 14px;
        font-style: italic;
        width: 300px;
        margin-top: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Kepala Sekolah</h2>

    <div class="dkepsek">
        <?php if ($data_kepsek) : ?>
            <label for="nama"><b>Nama: </b></label>
            <?= $data_kepsek->nama ?>
            <label for="alamat"><b>Alamat: </b></label>
            <?= $data_kepsek->alamat ?>
            <label for="alamat"><b>HP: </b></label>
            <?= $data_kepsek->telp ?>
            <label for="alamat"><b>Email: </b></label>
            <?= $data_kepsek->email ?>
        <?php else : ?>
            <label for="nama"><b>Nama: </b></label>
            -
            <label for="alamat"><b>Alamat: </b></label>
            -
            <label for="alamat"><b>HP: </b></label>
            -
            <label for="alamat"><b>Email: </b></label>
            -
        <?php endif ?>
    </div>
    <div style="display: <?= ($info_sekolah['jumlah_guru'] == 0) ? "block" : "none" ?>;" class="text-danger">Silakan menambahkan data Guru terlebih dahulu untuk dipilih sebagai Kepala Sekolah</div>
    <button <?= ($info_sekolah['jumlah_guru'] == 0) ? "disabled" : "" ?> id="tbedit" class="edit" onclick="editkepsek()"><?= ($addedit == "add") ? "Pilih" : "Edit" ?> Kepala Sekolah</button>
    <div id="inputkepsek" style="display: none;">
        <br>
        <form action="<?= base_url('admin/simpan_kepsek') ?>" method="post">
            <label for="kepsek"><b>Pilih Kepala Sekolah: </b></label><br>
            <select class="js-select" name="kepsek" id="kepsek">
                <?php
                foreach ($daftar_guru as $row) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
                }
                ?>
            </select>
            <br>
            <input type="hidden" name="addedit" value="<?= $addedit ?>">
            <button type="reset" class="batal" onclick="batalkepsek()">Batal</button>
            <button type="submit" class="ok" onclick="okkepsek()">Update</button>
        </form>
    </div>
    <div class="dtdtgn">
        <label for="tdtgn">Tandatangan:</label>
        <?php
        if ($data_kepsek) { ?>
            <img width="100px" src="/tandatangan/tdtgn_<?= substr($sekolah['id_sekolah'], 0, 8) . $data_kepsek->id ?>.png" alt="">
        <?php } ?>
    </div>
    <div style="display: <?= ($data_kepsek) ? "none" : "block" ?>;" class="text-danger">Silakan pilih Kepala Sekolah terlebih dahulu</div>
    <button <?= (!$data_kepsek) ? "disabled" : "" ?> id="tbedittandatangan" class="edit" onclick="edittandatangan()"><?= ($addedit == "add") ? "Input" : "Edit" ?> Tandatangan Kepala Sekolah</button>
    <div id="inputtandatangan" class="inputtdtgn" style="display:none">
        <form id="f_input_sk" action="<?= base_url() ?>admin/upload_tdtgn" method="post" enctype="multipart/form-data">
            <?php if ($data_kepsek) { ?>
                <input type="hidden" name="id_kepsek" value="<?= $data_kepsek->id ?>">
            <?php } ?>
            <div style="border:1px solid green;padding:10px;max-width:400px;background-color:honeydew;">
                <label for="inputfiletdtgn">
                    <h3>Input file tandatangan (file png max. 100KB):</h3>
                </label>
                <div id="inputfiletdtgn" class="form-group">
                    <input type="file" id="file_tdtgn" name="file_tdtgn" accept=".png" maxFileSize="102400">
                </div>
            </div>
            <div style="margin-top: 5px;">
                <button type="reset" class="batal" onclick="bataltandatangan()">Batal</button>
                <input class="ok" onclick="return cekinput();" type="submit" value="Unggah File SK">
            </div>

        </form>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-select').select2();
    });

    function editkepsek() {
        document.getElementById('inputkepsek').style.display = 'block';
        document.getElementById('tbedit').style.display = 'none';
    }

    function batalkepsek() {
        document.getElementById('inputkepsek').style.display = 'none';
        document.getElementById('tbedit').style.display = 'block';
    }

    function edittandatangan() {
        document.getElementById('inputtandatangan').style.display = 'block';
        document.getElementById('tbedittandatangan').style.display = 'none';
    }

    function bataltandatangan() {
        document.getElementById('inputtandatangan').style.display = 'none';
        document.getElementById('tbedittandatangan').style.display = 'block';
    }

    function cekinput() {
        var valsk = document.getElementById("file_tdtgn").value;
        fileExt = valsk.split('.').pop();

        if (valsk == "") {
            alert("Pilih file dahulu!");
            return false;
        } else {
            return true;
        }
    }
</script>
<?= $this->endSection() ?>
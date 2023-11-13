<?php
$tg_exp = explode("-", $data_siswa['tanggal_lahir']);
$tanggal_lahir = $tg_exp[2] . "-" . $tg_exp[1] . "-" . $tg_exp[0];
?>

<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    :root {
        --ukf: 13px;
    }

    .form-container {
        max-width: 400px;
        margin: left;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
        margin-right: 25px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group .fa {
        color: #ccc;
        margin-right: 5px;
    }

    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

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
    }

    .btn {
        padding: 5px;
        margin: 5px;
    }

    .wajib {
        color: red;
        font-size: 10;
        vertical-align: super;
    }

    @media screen and (max-width: 768px) {}
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<h3>Tahun Ajaran <?= $tahun_ajaran ?></h3>
<div class="form-container">
    <h2>Edit Data Siswa</h2>
    <?= form_open(base_url() . 'admin/update_siswa'); ?>
    <div class="form-group">
        <label for="nisn"><i class="fas fa-user"></i> NISN <span class="wajib">*</span></label>
        <input type="text" id="nisn" name="nisn" value="<?= $data_siswa['nisn'] ?>" required>
        <small class="text-danger" id="nisnError"></small>
    </div>

    <div class="form-group">
        <label for="nis"><i class="fas fa-user"></i> NIS <span class="wajib">*</span></label>
        <input type="text" id="nis" name="nis" value="<?= $data_siswa['nis'] ?>" required>
        <small class="text-danger" id="nisError"></small>
    </div>

    <div class="form-group">
        <label for="nama"><i class="fas fa-user"></i> Nama <span class="wajib">*</span></label>
        <input type="text" id="nama" name="nama" value="<?= $data_siswa['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="nama"><i class="fas fa-user"></i> Kelas <span class="wajib">*</span></label>
        <select id="kelas" name="kelas" required>
            <?php foreach ($kelas as $value) : ?>
                <option <?= ($value == $data_siswa['kelas']) ? "selected" : "" ?> value="<?= $value ?>"><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat</label>
        <input type="text" id="alamat" name="alamat" value="<?= $data_siswa['alamat'] ?>" required>
    </div>

    <div class="form-group">
        <label for="tempat_lahir"><i class="fas fa-map-marker-alt"></i> Tempat Lahir <span class="wajib">*</span></label>
        <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?= $data_siswa['tempat_lahir'] ?>" required>
    </div>

    <div class="form-group">
        <label for="tanggal_lahir"><i class="fas fa-map-marker-alt"></i> Tanggal Lahir <span class="wajib">*</span></label>
        <input type="text" id="tanggal_lahir" name="tanggal_lahir" value="<?= $tanggal_lahir ?>" required>
    </div>

    <div class="form-group">
        <label for="jenis_kelamin"><i class="fas fa-venus-mars"></i> Jenis Kelamin <span class="wajib">*</span></label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option <?= ($data_siswa['jenis_kelamin'] == "L") ? 'selected' : '' ?> value="Laki-laki">Laki-laki</option>
            <option <?= ($data_siswa['jenis_kelamin'] == "P") ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
        </select>
    </div>

    <div class="form-group">
        <label for="agama"><i class="fas fa-venus-mars"></i> Agama <span class="wajib">*</span></label>
        <select id="agama" name="agama" required>
            <option <?= ($data_siswa['agama'] == "Islam") ? 'selected' : '' ?> value="Islam">Islam</option>
            <option <?= ($data_siswa['agama'] == "Kristen") ? 'selected' : '' ?> value="Kristen">Kristen</option>
            <option <?= ($data_siswa['agama'] == "Katolik") ? 'selected' : '' ?> value="Katolik">Katolik</option>
            <option <?= ($data_siswa['agama'] == "Buddha") ? 'selected' : '' ?> value="Buddha">Buddha</option>
            <option <?= ($data_siswa['agama'] == "Hindu") ? 'selected' : '' ?> value="Hindu">Hindu</option>
            <option <?= ($data_siswa['agama'] == "Khonghucu") ? 'selected' : '' ?> value="Khonghucu">Khonghucu</option>
        </select>
    </div>

    <div class="form-group">
        <label for="telp"><i class="fas fa-phone"></i> Telepon</label>
        <input type="text" id="telp" name="telp" value="<?= $data_siswa['telp'] ?>">
    </div>

    <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> Email</label>
        <input type="email" id="email" name="email" value="<?= $data_siswa['email'] ?>">
    </div>

    <input type="hidden" name="tahun_ajaran" value="<?= $tahun_ajaran ?>">
    <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">

    <button onclick="batal();" class="batal-btn">Batal</button>
    <button type="submit" onclick="return cekdata();" class="submit-btn">Update Data</button>

    <?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var ijinajax = true;
    var ijinajax2 = true;
    var nisn_lama = "<?= $data_siswa['nisn'] ?>";
    var nis_lama = "<?= $data_siswa['nis'] ?>";

    function batal() {
        window.open("<?= base_url() ?>admin/user", "_self");
    }

    function cekNISN(nisn) {
        $.ajax({
            url: '<?= base_url('admin/cek_nisn_sekolah') ?>',
            type: 'post',
            data: {
                nisn: nisn
            },
            success: function(response) {
                if (response == 'ada') {
                    $('#nisnError').text('NISN sudah terdaftar.');
                } else {
                    $('#nisnError').text('');
                    ijinajax = true;
                }
            }
        });
    }

    function cekNIS(nis) {
        $.ajax({
            url: '<?= base_url('admin/cek_nis_sekolah') ?>',
            type: 'post',
            data: {
                nis: nis
            },
            success: function(response) {
                if (response == 'ada') {
                    $('#nisError').text('NIS sudah terdaftar.');
                } else {
                    $('#nisError').text('');
                    ijinajax2 = true;
                }
            }
        });
    }

    $('#nisn').on('input', function() {
        $('#nisnError').text('');
        ijinajax = false;
    });

    $('#nisn').blur(function() {
        var nisn = $(this).val();
        if (nisn_lama != nisn)
            cekNISN(nisn);
        else
            ijinajax = true;
    });

    $('#nis').on('input', function() {
        $('#nisError').text('');
        ijinajax2 = false;
    });

    $('#nis').blur(function() {
        var nis = $(this).val();
        if (nis_lama != nis)
            cekNIS(nis);
        else
            ijinajax2 = true;
    });

    let rombelData = <?= json_encode($data_rombel) ?>;
    let selectedKelas = document.getElementById('kelas').value;

    document.getElementById('kelas').addEventListener('change', function() {
        filterrombel(this.value);
    });

    function cekdata() {
        var ijinlewat = false;

        if ($('#nisError').text() == '' && $('#nisnError').text() == '')
            ijinlewat = true;

        if (ijinlewat && ijinajax && ijinajax2)
            return true;
        else
            return false;
    }

    $(function() {
        $("#tanggal_lahir").datepicker({
            dateFormat: "dd-mm-yy", // Format tanggal Indonesia
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0", // Rentang tahun (dari 100 tahun lalu sampai sekarang)
            // Ganti bahasa ke Bahasa Indonesia
            monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sb"],
            weekHeader: "Mg"
        });
    });
</script>
<?= $this->endSection() ?>
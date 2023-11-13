<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style>
    :root {
        --ukf: 13px;
    }

    .form-container {
        max-width: 500px;
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
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
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

    .info_text {
        color: blue;
        font-style: italic;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .info_text ul,
    .info_text li {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    @media screen and (max-width: 768px) {}
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="form-container">

    <?= form_open(base_url() . 'admin/simpan_sekolah'); ?>
    <h2>Data Sekolah</h2>
    <div class="form-group">
        <label for="npsn"><i class="fas fa-user"></i>NPSN</label>
        <input type="text" id="npsn" name="npsn" value="<?= $sekolah['npsn'] ?>" required>
        <small class="text-danger" id="npsnError"></small>
    </div>

    <div class="form-group">
        <label for="nama_sekolah"><i class="fas fa-user"></i>Nama Sekolah</label>
        <input type="text" id="nama_sekolah" name="nama_sekolah" value="<?= $sekolah['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="alamat_sekolah"><i class="fas fa-user"></i>Alamat Sekolah</label>
        <input type="text" id="alamat_sekolah" name="alamat_sekolah" value="<?= $sekolah['alamat'] ?>" required>
    </div>

    <div class="form-group">
        <label for="kelurahan"><i class="fas fa-user"></i>Kelurahan</label>
        <input type="text" id="kelurahan" name="kelurahan" value="<?= $sekolah['kelurahan'] ?>" required>
    </div>

    <div class="form-group">
        <label for="kecamatan"><i class="fas fa-user"></i>Kecamatan</label>
        <input type="text" id="kecamatan" name="kecamatan" value="<?= $sekolah['kecamatan'] ?>" required>
    </div>

    <div class="form-group">
        <label for="kota"><i class="fas fa-user"></i>Kota</label>
        <input type="text" id="kota" name="kota" value="<?= $sekolah['kota'] ?>" required>
    </div>

    <div class="form-group">
        <label for="propinsi"><i class="fas fa-user"></i>Propinsi</label>
        <input type="text" id="propinsi" name="propinsi" value="<?= $sekolah['propinsi'] ?>" required>
    </div>

    <div class="form-group">
        <label for="telp"><i class="fas fa-user"></i>Telp Sekolah</label>
        <input type="text" id="telp_sekolah" name="telp_sekolah" value="<?= $sekolah['telp'] ?>" required>
    </div>

    <div class="form-group">
        <label for="email_sekolah"><i class="fas fa-envelope"></i>Email Sekolah</label>
        <input type="email" id="email_sekolah" name="email_sekolah" value="<?= $sekolah['email'] ?>" required>
        <small class="text-danger" id="emailError"></small>
    </div>

    <h2>Data Admin</h2>
    <div class="form-group">
        <label for="nama_admin"><i class="fas fa-user"></i>Nama Admin</label>
        <input type="text" id="nama_admin" name="nama_admin" value="<?= $admin['nama'] ?>" required>
    </div>
    <div class="form-group">
        <label for="nama_admin"><i class="fas fa-user"></i>Alamat Admin</label>
        <input type="text" id="alamat_admin" name="alamat_admin" value="<?= $admin['alamat'] ?>" required>
    </div>
    <div class="form-group">
        <label for="no_hp"><i class="fas fa-user"></i>No. HP Admin</label>
        <input type="text" id="telp_admin" name="telp_admin" value="<?= $admin['telp'] ?>" required>
    </div>
    <div class="form-group">
        <label for="nama_admin"><i class="fas fa-user"></i>Email Admin</label>
        <div class="info_text">
            <ul>
                <li>Jika sekolah sudah aktif, dapat mengajukan ubah alamat email untuk login</li>
            </ul>
        </div>
        <input <?= ($status_bayar == "Trial") ? "readonly " : "" ?> type="email" id="email_admin" name="email_admin" value="<?= $admin['email'] ?>" required>
    </div>

    <small class="text-danger" id="simpanError"></small>
    <button type="submit" onclick="return cekdata();" class="submit-btn">Simpan Data</button>

    <?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var ijinajax = true;

    function cekEmail(email_sekolah) {
        $.ajax({
            url: '<?= base_url('admin/cek_email_sekolah') ?>',
            type: 'post',
            data: {
                email_sekolah: email_sekolah
            },
            success: function(response) {
                if (response == 'ada') {
                    $('#emailError').text('Email sudah terdaftar.');
                } else {
                    $('#emailError').text('');
                    ijinajax = true;
                }
            }
        });
    }

    $('#npsn').on('input', function() {
        $('#npsnError').text('');
        ijinajax = false;
    });

    $('#npsn').blur(function() {
        var npsn = $(this).val();
        cekNPSN(npsn);
    });

    $('#email_sekolah').on('input', function() {
        $('#emailError').text('');
        ijinajax = false;
    });

    $('#email_sekolah').blur(function() {
        var email_sekolah = $(this).val();
        cekEmail(email_sekolah);
    });

    function cekNPSN(npsn) {
        $.ajax({
            url: '<?= base_url('admin/cek_npsn') ?>',
            type: 'post',
            data: {
                inpsn: npsn
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.pesan == 'ada') {
                    $('#npsnError').text('NPSN sudah terdaftar.');
                } else if (data.pesan == 'aman') {
                    $('#nama_sekolah').val(data.nama_sekolah);
                    $('#alamat_sekolah').val(data.alamat_sekolah);
                    $('#kelurahan').val(data.kelurahan);
                    $('#kecamatan').val(data.kecamatan);
                    $('#kota').val(data.nama_kota);
                    $('#propinsi').val(data.nama_propinsi);
                } else {
                    $('#npsnError').text('NPSN tidak terdaftar');
                    ijinajax = true;
                }
            }
        });
    }

    function cekdata() {
        var ijinlewat = false;

        if ($('#emailError').text() == '' && $('#emailError').text() == '')
            ijinlewat = true;

        if (ijinlewat && ijinajax)
            return true;
        else {
            $('#simpanError').text("Silakan lengkapi data terlebih dahulu")
            setTimeout(function() {
                $('#simpanError').text('');
            }, 2000);
            return false;
        }
    }
</script>
<?= $this->endSection() ?>
<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
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
    <h2>Edit Data staf</h2>
    <?= form_open(base_url() . 'admin/update_staf'); ?>

    <div class="form-group">
        <label for="nama"><i class="fas fa-user"></i> Nama <span class="wajib">*</span></label>
        <input type="text" id="nama" name="nama" value="<?= $data_staf['nama'] ?>" required>
    </div>

    <div class="form-group">
        <label for="alamat"><i class="fas fa-map-marker-alt"></i> Alamat <span class="wajib">*</span></label>
        <input type="text" id="alamat" name="alamat" value="<?= $data_staf['alamat'] ?>" required>
    </div>

    <div class="form-group">
        <label for="jenis_kelamin"><i class="fas fa-venus-mars"></i> Jenis Kelamin <span class="wajib">*</span></label>
        <select id="jenis_kelamin" name="jenis_kelamin" required>
            <option <?= ($data_staf['jenis_kelamin'] == "L") ? 'selected' : '' ?> value="Laki-laki">Laki-laki</option>
            <option <?= ($data_staf['jenis_kelamin'] == "P") ? 'selected' : '' ?> value="Perempuan">Perempuan</option>
        </select>
    </div>

    <div class="form-group">
        <label for="telp"><i class="fas fa-phone"></i> Telepon <span class="wajib">*</span></label>
        <input type="text" id="telp" name="telp" value="<?= $data_staf['telp'] ?>" required>
    </div>

    <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> Email <span class="wajib">*</span></label>
        <input type="email" id="email" name="email" value="<?= $data_staf['email'] ?>" required>
        <small class="text-danger" id="emailError"></small>
    </div>

    <input type="hidden" name="tahun_ajaran" value="<?= $tahun_ajaran ?>">
    <input type="hidden" name="id_staf" value="<?= $id_staf ?>">
    <input type="hidden" name="email_lama" value="<?= $data_staf['email'] ?>">

    <button onclick="batal();" class="batal-btn">Batal</button>
    <button type="submit" onclick="return cekdata();" class="submit-btn">Update Data</button>

    <?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var ijinajax = true;
    var email_lama = "<?= $data_staf['email'] ?>";

    function batal() {
        window.open("<?= base_url() ?>admin/user", "_self");
    }

    function cekemail(email) {
        $.ajax({
            url: '<?= base_url('admin/cek_email_sekolah') ?>',
            type: 'post',
            data: {
                email: email
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

    // Event listener ketika input email kehilangan fokus


    $('#email').on('input', function() {
        $('#emailError').text('');
        ijinajax = false;
    });

    $('#email').blur(function() {
        var email = $(this).val();
        if (email_lama != email)
            cekemail(email);
        else
            ijinajax = true;
    });

    function cekdata() {
        var ijinlewat = false;

        if ($('#emailError').text() == '')
            ijinlewat = true;

        if (ijinlewat && ijinajax)
            return true;
        else
            return false;
    }
</script>
<?= $this->endSection() ?>
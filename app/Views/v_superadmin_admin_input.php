<?= $this->extend('layout/layout_superadmin') ?>

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
<div class="form-container">
    <h2>Tambah Admin</h2>
    <?= form_open(base_url() . 'superadmin/simpan_admin'); ?>

    <div class="form-group">
        <label for="nama"><i class="fas fa-user"></i>Nama</label>
        <input type="text" id="nama" name="nama" required>
    </div>

    <div class="form-group">
        <label for="nama"><i class="fas fa-user"></i>Jenjang</label>
        <select id="jenjang" name="jenjang" required>
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
            <option value="SMA">SMA</option>
        </select>
    </div>

    <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i>Email</label>
        <input type="email" id="email" name="email" required>
        <small class="text-danger" id="emailError"></small>
    </div>

    <button onclick="batal();" class="batal-btn">Batal</button>
    <button type="submit" onclick="return cekdata();" class="submit-btn">Tambah Data</button>

    <?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var ijinajax = true;

    function batal() {
        window.open("<?= base_url() ?>superadmin/user", "_self");
    }

    function cekEmail(email) {
        $.ajax({
            url: '<?= base_url('superadmin/cek_email_admin') ?>',
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

    $('#email').on('input', function() {
        $('#emailError').text('');
        ijinajax = false;
    });

    $('#email').blur(function() {
        var email = $(this).val();
        cekEmail(email);
    });

    function cekdata() {
        var ijinlewat = false;

        if ($('#emailError').text() == '' && $('#emailError').text() == '')
            ijinlewat = true;

        if (ijinlewat && ijinajax)
            return true;
        else
            return false;
    }
</script>
<?= $this->endSection() ?>
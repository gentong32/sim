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
    <h2>Ubah password</h2>
    <?= form_open(base_url() . 'login/update_password', array('id' => 'myForm')); ?>

    <div class="form-group">
        <label for="password_lama">Password Lama </label>
        <input type="password" id="password_lama" name="password_lama" value="" required>
        <small class="text-danger" id="passwordLamaError"></small>
    </div>
    <div class="form-group">
        <label for="password_lama">Password Baru </label>
        <input type="password" id="password_baru1" name="password_baru1" value="" required>
    </div>
    <div class="form-group">
        <label for="password_lama">Password Baru <sup>*)ulangi</sup> </label>
        <input type="password" id="password_baru2" name="password_baru2" value="" required>
        <small class="text-danger" id="passwordBaruError"></small>
    </div>

    <button onclick="batal();" class="batal-btn">Batal</button>
    <button type="submit" onclick="return cekdata();" class="submit-btn">Ubah Password</button>

    <?= form_close(); ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var ijinajax = false;

    function batal() {
        window.history.back();
    }

    function cekdata() {
        var password_lama = document.getElementById('password_lama').value;
        var password_baru1 = document.getElementById('password_baru1').value;
        var password_baru2 = document.getElementById('password_baru2').value;
        $('#passwordLamaError').text('');
        $('#passwordBaruError').text('');

        $.ajax({
            url: '<?= base_url('login/cek_passlama') ?>',
            type: 'post',
            data: {
                password_lama: password_lama
            },
            success: function(response) {
                if (response == "OKE") {
                    if (password_baru1.length < 6) {
                        $('#passwordBaruError').text('Minimal 6 karakter');
                    }

                    if (password_baru1 == password_baru2) {
                        if (password_lama == password_baru1) {
                            $('#passwordBaruError').text('Password lama dan baru sama');
                        } else {
                            $('#myForm').submit();
                        }
                    } else {
                        $('#passwordBaruError').text('Password baru belum sama');

                    }
                } else {
                    $('#passwordLamaError').text('Password salah');
                }
            }
        });
        return false;
    }


    // Event listener ketika input email kehilangan fokus


    // function cekdata() {
    //     var ijinlewat = false;

    //     if ($('#emailError').text() == '')
    //         ijinlewat = true;

    //     if (ijinlewat && ijinajax)
    //         return true;
    //     else
    //         return false;
    // }
</script>
<?= $this->endSection() ?>
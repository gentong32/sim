<?= $this->extend('layout/layout_default') ?>

<?= $this->section('konten') ?>

<div class="wrap">
    <h2><span>Sistem Informasi Sekolah</span></h2>
    <h1>Sekolah ABC</h1>
    <h3 class="text" id="welcome"><span>Silakan login</span></h3>

    <?php if (session()->getFlashdata('error_message')) : ?>
        <div class="error">
            <?= session()->getFlashdata('error_message') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login/authenticate') ?>" class="login" method='post' id="theForm">
        <div class="inputan">
            <input type='text' id="username" name='username' placeholder='Email / NISN'>
            <input type='password' id='password' name='password' placeholder='Password'>

            <div class="checkbox">
                <input type="checkbox" id="adminCheckbox" name="adminCheckbox">
                <label for="adminCheckbox">Masuk sebagai admin</label>
            </div>
            <br>
            <div class='login'>
                <a href="#"><i class="icon-cog"></i>Lupa Password</a>
                <input type='submit' value='Login'>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
    $(document).ready(function() {
        $("#theForm").on("submit", function(event) {
            var name = $("#username").val(),
                auth = $("#password").val() === "" && name === "";
            var auth1 = $("#password").val() != "" && name != "";
            if (auth) {
                window.open('<?= base_url() ?>home', '_self');
            } else if (auth2) {
                return true;
            }

            event.preventDefault();
        });
        $(".error").fadeIn().delay(3000).fadeOut();
    });
</script>
<?= $this->endSection() ?>
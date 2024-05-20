<?= $this->extend('layout/layout_siswa') ?>

<?= $this->section('konten') ?>
<style>
    .menu {
        min-height: 40vh !important;
    }

    .menu-item {
        text-align: center;
        margin: 50px 20px !important;
    }
</style>

<div class="menu">
    <div class="menu-item" style="display: block;">
        <a href="/absensi/saya">
            <img src="assets/absen.png" alt="Absen">
            <p>Absensi</p>
        </a>
    </div>
    <div class="menu-item" style="display: block;">
        <a href="/ekskul_saya">
            <img src="assets/peserta.png" alt="Peserta">
            <p>Ekskul</p>
        </a>
    </div>
    <div class="menu-item" style="display: block;">
        <a href="/tugas/saya">
            <img src=" assets/tugas.png" alt="Tugas">
            <p>Tugas</p>
        </a>
    </div>
    <div class="menu-item" style="display: block;">
        <a href="/nilai/saya">
            <img src="assets/nilai.png" alt="Nilai">
            <p>Nilai</p>
        </a>
    </div>
    <div class="menu-item" style="display: block;">
        <a href="/agenda">
            <img src=" assets/kalender.png" alt="Agenda">
            <p>Agenda</p>
        </a>
    </div>
    <div class="menu-item" style="display: block;">
        <a href="/pengumuman">
            <img src="assets/info.png" alt="Info">
            <p>Pengumuman</p>
        </a>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>

</script>
<?= $this->endSection(); ?>
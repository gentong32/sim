<?= $this->extend('layout/layout_default') ?>

<?= $this->section('konten') ?>

<div class="menu">
    <div class="menu-item">
        <a href="/presensi" onclick="appendKelasToLink('presensi')">
            <img src="assets/absen.png" alt="Absen">
            <p>Presensi</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/agenda">
            <img src="assets/kalender.png" alt="Agenda">
            <p>Agenda</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/modul">
            <img src="assets/buku.png" alt="Modul">
            <p>Modul</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/video">
            <img src="assets/video.png" alt="Video">
            <p>Video</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/tugas">
            <img src="assets/tugas.png" alt="Tugas">
            <p>Tugas</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/soal">
            <img src="assets/soal.png" alt="Soal">
            <p>Soal</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/nilai">
            <img src="assets/nilai.png" alt="Nilai">
            <p>Nilai</p>
        </a>
    </div>
    <div class="menu-item">
        <a href="/pengumuman">
            <img src="assets/info.png" alt="Info">
            <p>Pengumuman</p>
        </a>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    var defaultKelas = '10_1';
    var options = document.querySelector('.options');
    var selectedOption = document.querySelector('.selected-option span');

    function toggleOptions() {
        options.style.display = (options.style.display === 'block') ? 'none' : 'block';
    }

    function selectOption(value) {
        selectedOption.textContent = value;
        selectedOption.dataContent = event.target.dataset.value;
        toggleOptions();
        // alert('Anda memilih kelas: ' + value); // Menampilkan alert dengan kelas yang dipilih
    }

    function appendKelasToLink(menu) {
        var selectedKelas = document.querySelector('.selected-option span').dataContent || defaultKelas;
        var link = document.querySelector('.menu-item a[href="/' + menu + '"]');

        if (selectedKelas) {
            link.href += '?kelas=' + selectedKelas;
        }
    }
</script>
<?= $this->endSection(); ?>
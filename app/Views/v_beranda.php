<?= $this->extend('layout/layout_default') ?>

<?= $this->section('konten') ?>


<div class="menu">
    <div class="menu-item ws" style="display: none;">
        <a href="/presensi" onclick="appendKelasToLink('presensi')">
            <img src="assets/absen.png" alt="Absen">
            <p>Presensi</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/tujuan_pembelajaran" onclick="appendKelasToLink('tujuan_pembelajaran')">
            <img src="assets/tp.png" alt="Tujuan Pembelajaran">
            <p>Tujuan Pembelajaran</p>
        </a>
    </div>
    <div class="menu-item wg" style="display: none;">
        <a href="/agenda" onclick="appendKelasToLink('agenda')">
            <img src=" assets/kalender.png" alt="Agenda">
            <p>Agenda</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/modul">
            <img src="assets/buku.png" alt="Modul">
            <p>Modul</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/video">
            <img src="assets/video.png" alt="Video">
            <p>Video</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/tugas">
            <img src="assets/tugas.png" alt="Tugas">
            <p>Tugas</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/soal">
            <img src="assets/soal.png" alt="Soal">
            <p>Soal</p>
        </a>
    </div>
    <div class="menu-item wg" style="display: none;">
        <a href="/nilai">
            <img src="assets/nilai.png" alt="Nilai">
            <p>Nilai</p>
        </a>
    </div>
    <div class="menu-item wg" style="display: none;">
        <a href="/pengumuman">
            <img src="assets/info.png" alt="Info">
            <p>Pengumuman</p>
        </a>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    <?php if ($daftarkelaswali) {
        echo "selectedKelas = 'w1';\n";
    } else if ($daftarkelaswaliguru > 0) {
        echo "selectedKelas = 'g1';\n";
    } ?>

    var lastSelected = localStorage.getItem('pilihsebagai');
    if (!lastSelected) {
        if (selectedKelas.substring(0, 1) == "w")
            tampilkanw();
        else
            tampilkang();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var radiobuttons = document.querySelectorAll('input[type="radio"]');

        radiobuttons.forEach(function(radiobutton) {
            radiobutton.addEventListener('change', function() {
                if (this.checked) {
                    selectedKelas = this.value;
                }
            });
        });
    });


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
        var link = document.querySelector('.menu-item a[href="/' + menu + '"]');

        if (selectedKelas) {
            link.href += '?kelas=' + selectedKelas;
        }
    }

    function tampilkanw() {
        var semuaWs = document.querySelectorAll('.ws');
        var semuaGs = document.querySelectorAll('.gs');
        var semuaWG = document.querySelectorAll('.wg');

        semuaWs.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaWG.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "none";
        });
    }

    function tampilkang() {
        var semuaWs = document.querySelectorAll('.ws');
        var semuaGs = document.querySelectorAll('.gs');
        var semuaWG = document.querySelectorAll('.wg');

        semuaWs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaWG.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "block";
        });
    }
</script>
<?= $this->endSection(); ?>
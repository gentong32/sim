<?= $this->extend('layout/layout_default') ?>

<?= $this->section('konten') ?>


<div class="menu">
    <div class="menu-item ws" style="display: none;">
        <a href="/presensi" onclick="appendKelasToLink('presensi')">
            <img src="assets/absen.png" alt="Absen">
            <p>Presensi</p>
        </a>
    </div>
    <div class="menu-item es" style="display: none;">
        <a href="/peserta_ekskul" onclick="appendKelasToLink('peserta_ekskul')">
            <img src="assets/peserta.png" alt="Peserta">
            <p>Peserta</p>
        </a>
    </div>
    <div class="menu-item ge" style="display: none;">
        <a href="/tujuan_pembelajaran" onclick="appendKelasToLink('tujuan_pembelajaran')">
            <img src="assets/tp.png" alt="Tujuan Pembelajaran">
            <p>T. Pembelajaran</p>
        </a>
    </div>
    <div class="menu-item nanti" style="display: none;">
        <a href="/modul">
            <img src="assets/buku.png" alt="Modul">
            <p>Modul</p>
        </a>
    </div>
    <div class="menu-item nanti" style="display: none;">
        <a href="/video">
            <img src="assets/video.png" alt="Video">
            <p>Video</p>
        </a>
    </div>
    <div class="menu-item gs" style="display: none;">
        <a href="/tugas" onclick="appendKelasToLink('tugas')">
            <img src=" assets/tugas.png" alt="Tugas">
            <p>Tugas</p>
        </a>
    </div>
    <div class="menu-item nanti" style="display: none;">
        <a href="/soal">
            <img src="assets/soal.png" alt="Soal">
            <p>Soal</p>
        </a>
    </div>
    <div class="menu-item wgle" style="display: none;">
        <a href="/nilai" onclick="appendKelasToLink('nilai')">
            <img src="assets/nilai.png" alt="Nilai">
            <p>Nilai</p>
        </a>
    </div>
    <div class="menu-item wgle" style="display: none;">
        <a href="/agenda" onclick="appendKelasToLink('agenda')">
            <img src=" assets/kalender.png" alt="Agenda">
            <p>Agenda</p>
        </a>
    </div>
    <div class="menu-item wgle" style="display: none;">
        <a href="/pengumuman">
            <img src="assets/info.png" alt="Info">
            <p>Pengumuman</p>
        </a>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    var options = document.querySelector('.options');
    var selectedOption = document.querySelector('.selected-option span');

    var semuaWs = document.querySelectorAll('.ws');
    var semuaGs = document.querySelectorAll('.gs');
    var semuaGE = document.querySelectorAll('.ge');
    var semuaEs = document.querySelectorAll('.es');
    var semuaWGLE = document.querySelectorAll('.wgle');

    // <?php //if ($daftarkelaswali) {
        //     echo "lastSelected = 'w1';\n";
        // } else if ($daftarkelasajar) {
        //     if ($daftarkelasajar > 0)
        //         echo "lastSelected = 'g1';\n";
        // } else if ($daftarkelasajarlain) {
        //     if ($daftarkelasajarlain > 0)
        //         echo "lastSelected = 'l1';\n";
        // } else if ($daftarwaliekskul) {
        //     if ($daftarwaliekskul > 0)
        //         echo "lastSelected = 'e1';\n";
        // } 
        ?>

    <?php
    if ($sekolah_saya['nama'] != "") { ?>
        localStorage.setItem('namasekolahsaya', "<?= $sekolah_saya['nama'] ?>");
    <?php } ?>

    var lastSelected = localStorage.getItem('pilihsebagai<?= session()->get('id_user') ?>');
    if (lastSelected) {
        const radiobuttons = document.querySelectorAll('input[name="toggle"]');

        radiobuttons.forEach(radiobutton => {
            if (radiobutton.value == lastSelected) {
                radiobutton.checked = true;
            }
        });

    } else {
        const radiobuttons = document.querySelectorAll('input[name="toggle"]');

        radiobuttons.forEach(radiobutton => {
            if (radiobutton.checked) {
                lastSelected = radiobutton.value;
            }
        });
    }

    if (lastSelected.substring(0, 1) == "w")
        tampilkanw();
    else if (lastSelected.substring(0, 1) == "g")
        tampilkang();
    else if (lastSelected.substring(0, 1) == "l")
        tampilkanl();
    else if (lastSelected.substring(0, 1) == "e")
        tampilkane();

    document.addEventListener('DOMContentLoaded', function() {
        var radiobuttons = document.querySelectorAll('input[type="radio"]');

        radiobuttons.forEach(function(radiobutton) {
            radiobutton.addEventListener('change', function() {
                if (this.checked) {
                    lastSelected = this.value;
                    localStorage.setItem('pilihsebagai<?= session()->get('id_user') ?>', this.value);
                    if (lastSelected.substring(0, 1) == "w") {
                        tampilkanw();
                    } else if (lastSelected.substring(0, 1) == "g")
                        tampilkang();
                    else if (lastSelected.substring(0, 1) == "l")
                        tampilkanl();
                    else if (lastSelected.substring(0, 1) == "e")
                        tampilkane();
                }
            });
        });

    });

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

        if (lastSelected) {
            link.href += '?kelas=' + lastSelected;
        }
    }

    function tampilkanw() {
        semuaWs.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaWGLE.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaEs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGE.forEach(function(elemen) {
            elemen.style.display = "none";
        });

    }

    function tampilkang() {
        semuaWs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaWGLE.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaEs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaGE.forEach(function(elemen) {
            elemen.style.display = "block";
        });
    }

    function tampilkanl() {
        semuaWs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaWGLE.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaEs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGE.forEach(function(elemen) {
            elemen.style.display = "none";
        });
    }

    function tampilkane() {
        semuaWs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaWGLE.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaEs.forEach(function(elemen) {
            elemen.style.display = "block";
        });

        semuaGs.forEach(function(elemen) {
            elemen.style.display = "none";
        });

        semuaGE.forEach(function(elemen) {
            elemen.style.display = "block";
        });
    }
</script>
<?= $this->endSection(); ?>
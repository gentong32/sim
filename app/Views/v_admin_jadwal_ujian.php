<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .judul {
        font-size: 24px;
        margin: 20px 0;
    }

    .kelas {
        margin-bottom: 40px;
        font-size: 14px;
        border: #288AA4 solid 1px;
        border-radius: 20px;
        padding: 15px;
    }

    .sub-judul {
        font-size: 16px;
        font-weight: bold;
        margin: 10px 0;
        margin-bottom: 0px;
    }

    .mata-pelajaran {
        width: 100%;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .mata-pelajaran td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .mata-pelajaran th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    /* .mata-pelajaran th:nth-child(2) {
        width: 100px;
    } */

    .tbtambah {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #26BEAE;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .tbimpor {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        margin-right: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit,
    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .delete,
    .batal {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .edit[disabled],
    .delete[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .tbpilihan {
        display: inline-block;
        padding: 6px 6px;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #288AA4;
        border: none;
        border-radius: 2px;
        cursor: pointer;
        height: 35px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .aksi {
        margin-right: 5px;
    }

    button {
        height: 25px;
        margin-bottom: 2px;
    }

    .infosub {
        color: red;
        font-style: italic;
        font-size: 14px;
    }

    .uppercase-input {
        text-transform: uppercase;
    }

    .info {
        color: green;
        font-style: italic;
        font-size: 12px;
    }

    #overlayprojek {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: none;
    }

    #formContainer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        max-width: 400px;
        width: 95%;
        z-index: 9999;
        display: none;
    }

    .calendar-container {
        flex: 1;
        margin: 15px;
    }

    .calendar {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        max-width: 300px;
        background-color: lightcyan;
        margin: auto;
    }

    .calendar th,
    .calendar td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .calendar th {
        background-color: #f2f2f2;
    }

    .calendar td:hover {
        background-color: #f9f9f9;
    }

    #bulantahun {
        width: 300px;
        margin: auto;
        text-align: center;
    }

    #monthyear {
        width: 140px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .has-event {
        cursor: pointer;
    }

    .tanggal {
        height: 22px;
        background: #ccc;
        box-shadow: 1px 1px darkgreen;
        color: black;
        padding-top: 5px;
        padding-bottom: 2px;
        padding-left: 7px;
        font-size: 14px;
        margin-top: 2px;
        margin-bottom: 2px;
        width: 90px;
    }

    .jam {
        width: 50px;
        text-align: center;
    }

    .tbpiltgl {
        height: 29px;
        display: inline-block;
        margin-top: 2px;
        margin-left: 2px;
        background-color: #b5d0eb;
        border: none;
        box-shadow: 1px 1px darkgreen;
        cursor: pointer;
    }

    .dkaltb {
        display: flex;
        align-items: center;
        vertical-align: middle;
        margin-top: -5px;
        margin-bottom: 5px;
    }

    input::placeholder {
        color: #ccc;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2>Jadwal Ujian Tahun Ajaran <?= tahun_ajaran('lengkap') ?></h2>

    <div id="overlayprojek"></div>
    <div id="formContainer">
        <div class="calendar-container">
            <div id="bulantahun"><button onclick="mundurmonth()">&lt;</button>
                <div id="monthyear"><span id="month"></span> <span id="year"></span></div><button onclick="majumonth()">&gt;</button>
            </div>
            <table class="calendar">
                <thead>
                    <tr>
                        <th style="color:darkred;">Ming</th>
                        <th>Sen</th>
                        <th>Sel</th>
                        <th>Rab</th>
                        <th>Kam</th>
                        <th>Jum</th>
                        <th style="color:#656">Sab</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Isi kalender -->
                </tbody>
            </table>
            <div class="bawah">
                <button onclick="batalkal()" class="batal">Batal</button>
                <button onclick="todaykal(0)" class="ok">Hari Ini</button>
            </div>
        </div>
    </div>
    <?php
    $daftar_subkelas = [];
    $kelasgrup = [];
    foreach ($daftar_kelas as $kelas) : ?>

        <div class="kelas">
            <h2>Kelas <?= $kelas ?></h2>

            <!-- Mata Pelajaran Umum -->
            <div class="sub-judul">Mata Pelajaran Umum:</div>
            <table class="mata-pelajaran" id="mataPelajaranUmum<?= $kelas ?>">
                <tr>
                    <th>Nama Mata Pelajaran</th>
                    <th>Jadwal Ujian Semester Ganjil</th>
                    <th>Jadwal Ujian Semester Genap</th>
                </tr>
                <?php
                $baris = 0;
                $adapilihan = 0;
                $daftar_pilihan = [];
                $kelasgrup[] = $kelas;
                $kelasgrup[$kelas] = array();
                $agamasekali = 0;
                foreach ($daftar_mapel as $datarow) {
                    if ($datarow['kelas'] == $kelas && ($datarow['jenis'] == 0 || $datarow['jenis'] == 1)) {
                        $namamapel = $datarow['nama_mapel'];
                        if ($datarow['jenis'] == 0) {
                            if ($agamasekali == 0) {
                                $agamasekali = 1;
                                $pola = '/(?<=Agama)\s+\w+/';
                                $namamapel = preg_replace($pola, '', $namamapel);
                                $namamapel = trim(preg_replace('/\s+/', ' ', $namamapel));
                            } else {
                                continue;
                            }
                        }
                        $kelasgrup[$kelas][] = $datarow['id'];
                        $baris++;
                        echo "<tr><td class='editable' contentEditable=false>" . $namamapel . "</td>";
                        echo "<td>
                        <div class='dkaltb'>
                        <div class='tanggal' id='dtgl" . $datarow['id'] . "' style='display: inline-block;'>" . ubahtanggaldb($datarow['jadwal_semester_ganjil_tgl']) . "</div>
                        <button onclick='tampilkal(`dtgl" . $datarow['id'] . "`)' class='tbpiltgl'><img src='/assets/kalender.png' height='22px' alt=''></button>
                        </div> 
                        <div id='djamtb'>
                        <input class='jam' type='text' id='djam_m" . $datarow['id'] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($datarow['jadwal_semester_ganjil_jam'], 0, 5) . "'> - 
                        <input class='jam' type='text' id='djam_a" . $datarow['id'] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($datarow['jadwal_semester_ganjil_jam'], 8, 5) . "'>
                        </div>
                        </td>";
                        echo "<td>
                        <div class='dkaltb'>
                        <div class='tanggal' id='dtglb" . $datarow['id'] . "' style='display: inline-block;'>" . ubahtanggaldb($datarow['jadwal_semester_genap_tgl']) . "</div>
                        <button onclick='tampilkal(`dtglb" . $datarow['id'] . "`)' class='tbpiltgl'><img src='/assets/kalender.png' height='22px' alt=''></button>
                        </div> 
                        <div id='djamtb'>
                        <input class='jam' type='text' id='djam_mb" . $datarow['id'] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($datarow['jadwal_semester_genap_jam'], 0, 5) . "'> - 
                        <input class='jam' type='text' id='djam_ab" . $datarow['id'] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($datarow['jadwal_semester_genap_jam'], 8, 5) . "'>
                        </div>
                        </td></tr>\n";
                    } else
                    if ($datarow['kelas'] == $kelas && $datarow['jenis'] == 2) {
                        if (!in_array($datarow['sub_kelas'], $daftar_pilihan)) {
                            $daftar_pilihan[] = $datarow['sub_kelas'];
                            $daftar_subkelas[] = $kelas . $datarow['sub_kelas'];
                            $nama_mapel[$datarow['sub_kelas']] = [];
                            $tglganjil[$datarow['sub_kelas']] = [];
                            $jamganjil[$datarow['sub_kelas']] = [];
                            $tglgenap[$datarow['sub_kelas']] = [];
                            $jamgenap[$datarow['sub_kelas']] = [];
                            $id[$datarow['sub_kelas']] = [];
                            $adapilihan++;
                        }
                        $nama_mapel[$datarow['sub_kelas']][] = $datarow['nama_mapel'];
                        $tglganjil[$datarow['sub_kelas']][] = $datarow['jadwal_semester_ganjil_tgl'];
                        $jamganjil[$datarow['sub_kelas']][] = $datarow['jadwal_semester_ganjil_jam'];
                        $tglgenap[$datarow['sub_kelas']][] = $datarow['jadwal_semester_genap_tgl'];
                        $jamgenap[$datarow['sub_kelas']][] = $datarow['jadwal_semester_genap_jam'];
                        $id[$datarow['sub_kelas']][] = $datarow['id'];
                        $kelasgrup[$kelas][] = $datarow['id'];
                    }
                }
                ?>
            </table>

            <div id="daftarSubKelas<?= $kelas ?>">
                <?php if ($adapilihan > 0) :
                    foreach ($daftar_pilihan as $sub_kelas) :
                        $baris++;
                ?> <div>
                            <div class="sub-judul">Mapel Pilihan <?= $sub_kelas ?></div>
                            <table class="mata-pelajaran" id="mataPelajaranPilihan<?= $sub_kelas ?><?= $kelas ?>">
                                <tr>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Jadwal Ujian Semester Ganjil</th>
                                    <th>Jadwal Ujian Semester Genap</th>
                                </tr>
                                <?php
                                for ($a = 0; $a < sizeof($nama_mapel[$sub_kelas]); $a++) :
                                    echo "<tr><td class='editable' contentEditable=false>" . $nama_mapel[$sub_kelas][$a] . "</td>";
                                    echo "<td>
                                    <div class='dkaltb'>
                                    <div class='tanggal' id='dtgl" . $id[$sub_kelas][$a] . "' style='display: inline-block;'>" . ubahtanggaldb($tglganjil[$sub_kelas][$a]) . "</div>
                                    <button onclick='tampilkal(`dtgl" . $id[$sub_kelas][$a] . "`)' class='tbpiltgl'><img src='/assets/kalender.png' height='22px' alt=''></button>
                                    </div> 
                                    <div id='djamtb'>
                                    <input class='jam' type='text' id='djam_m" . $id[$sub_kelas][$a] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($jamganjil[$sub_kelas][$a], 0, 5) . "'> - 
                                    <input class='jam' type='text' id='djam_a" . $id[$sub_kelas][$a] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($jamganjil[$sub_kelas][$a], 8, 5) . "'>
                                    </div>
                                    </td>";
                                    echo "<td>
                                    <div class='dkaltb'>
                                    <div class='tanggal' id='dtglb" . $id[$sub_kelas][$a] . "' style='display: inline-block;'>" . ubahtanggaldb($tglgenap[$sub_kelas][$a]) . "</div>
                                    <button onclick='tampilkal(`dtglb" . $id[$sub_kelas][$a] . "`)' class='tbpiltgl'><img src='/assets/kalender.png' height='22px' alt=''></button>
                                    </div> 
                                    <div id='djamtb'>
                                    <input class='jam' type='text' id='djam_mb" . $id[$sub_kelas][$a] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($jamgenap[$sub_kelas][$a], 0, 5) . "'> - 
                                    <input class='jam' type='text' id='djam_ab" . $id[$sub_kelas][$a] . "' oninput='formatjam(this)' maxlength='5' pattern='[0-9]{2}\:[0-9]{2}' title='Format harus HH:MM' placeholder='HH:MM' value='" . substr($jamgenap[$sub_kelas][$a], 8, 5) . "'>
                                    </div>
                                    </td></tr>\n";
                                endfor;
                                ?>
                            </table>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <button class="tbtambah" onclick="update_jadwal(<?= $kelas ?>)">UPDATE JADWAL</button>
            <span class="info" id="infoupdate<?= $kelas ?>"></span>
        </div>

    <?php
        $kelasgrup_json = json_encode($kelasgrup);
    endforeach ?>

    <div class="info">* Kelas yang muncul sesuai dengan kelas yang ada di daftar Rombel</div>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var daftarSubKelas = [];
    var addedit;
    var mapellama;
    var idedit = '';

    const today = new Date();
    var events = <?= $datakalender ?>;
    var tanggaledit;
    var addedit;

    var sekarang = new Date();
    var tanggal = sekarang.getDate();
    var bulan = sekarang.getMonth();
    var tahun = sekarang.getFullYear();

    var tahunsekarang = <?= tahun_ajaran() ?>;

    var tglterakhirpilih = "";

    var kelasgrup = <?php echo $kelasgrup_json; ?>;

    function update_jadwal(kelas) {
        var daftarID = kelasgrup[kelas];
        var daftarsimpan = Array();
        daftarID.forEach(function(daftar) {
            tanggal = document.getElementById('dtgl' + daftar).innerText;
            tanggalb = document.getElementById('dtglb' + daftar).innerText;
            jam_m = document.getElementById('djam_m' + daftar).value;
            jam_a = document.getElementById('djam_a' + daftar).value;
            jam_mb = document.getElementById('djam_mb' + daftar).value;
            jam_ab = document.getElementById('djam_ab' + daftar).value;
            if (tanggal == "")
                formattgl = null;
            else
                formattgl = konversiFormatTanggal(tanggal);
            if (tanggalb == "")
                formattglb = null;
            else
                formattglb = konversiFormatTanggal(tanggalb);
            daftarsimpan.push({
                id: daftar,
                tgl: formattgl,
                jam_m: jam_m,
                jam_a: jam_a,
                tglb: formattglb,
                jam_mb: jam_mb,
                jam_ab: jam_ab,
            });
        });

        fetch('<?= base_url() ?>admin/simpan_jadwal_ujian', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    daftarsimpan: daftarsimpan
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('infoupdate' + kelas).innerText = "Jadwal telah terupdate";
                setTimeout(function() {
                    document.getElementById('infoupdate' + kelas).innerText = "";
                }, 3000);
            })
            .catch(error => {
                console.error('Gagal menyimpan data:', error);
            });
    }

    function konversiFormatTanggal(input) {
        // Mendefinisikan daftar singkatan nama bulan
        var namaBulan = {
            Jan: '01',
            Peb: '02',
            Mar: '03',
            Apr: '04',
            Mei: '05',
            Jun: '06',
            Jul: '07',
            Ags: '08',
            Sep: '09',
            Okt: '10',
            Nop: '11',
            Des: '12'
        };

        // Memisahkan tanggal, bulan, dan tahun dari input
        var pecah = input.split(' ');
        var tanggal = pecah[0].padStart(2, '0');
        var bulan = namaBulan[pecah[1]];
        var tahun = pecah[2];

        // Mengonversi ke format yang diinginkan (YYYY-MM-DD)
        var tanggalISO = tahun + '-' + bulan + '-' + tanggal;

        return tanggalISO;
    }

    // Contoh penggunaan
    var tanggalInput = "2 Mar 2024";
    var tanggalOutput = konversiFormatTanggal(tanggalInput);
    console.log(tanggalOutput); // Output: 2024-03-02


    <?php
    foreach ($daftar_subkelas as $row) {
        echo "daftarSubKelas.push('$row');\n";
    }
    ?>

    function enableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var deleteButtons = document.querySelectorAll('.delete');

        editButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });

        deleteButtons.forEach(function(button) {
            button.removeAttribute('disabled');
        });
    }

    function disableEditDeleteButtons() {
        var editButtons = document.querySelectorAll('.edit');
        var deleteButtons = document.querySelectorAll('.delete');

        editButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });

        deleteButtons.forEach(function(button) {
            button.setAttribute('disabled', 'disabled');
        });
    }

    function set_tgl(baris) {
        alert(baris);
    }

    function set_jam(baris) {
        alert(baris);
    }

    function set_tgl2(baris) {
        alert(baris);
    }

    function set_jam2(baris) {
        alert(baris);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // todaykal(7);
        // createCalendar(tahun, bulan);
    });

    function getMonthAndYear(input) {
        const parts = input.split(' '); // Memisahkan string berdasarkan spasi
        const day = getMonthIndex(parts[0]); // Mendapatkan indeks bulan dari nama bulan
        const month = getMonthIndex(parts[1]); // Mendapatkan indeks bulan dari nama bulan
        const year = parseInt(parts[2]); // Mendapatkan tahun dalam bentuk angka

        return {
            day: day,
            month: month,
            year: year
        };
    }

    function tampilkal(idx) {
        selectedKotakTanggal = idx;
        var tanggalterpilih = document.getElementById(idx).innerText;
        if (tanggalterpilih == "") {
            if (tglterakhirpilih != "") {
                tanggalterpilih = tglterakhirpilih;
            } else {
                sakniki = new Date(today.getTime());
                tanggal = sakniki.getDate();
                bulan = sakniki.getMonth();
                tahun = sakniki.getFullYear();
                tglsaiki = tanggal + " " + getMonthName(bulan) + " " + tahun;
                tanggalterpilih = tglsaiki;
            }
        }
        var bultah = getMonthAndYear(tanggalterpilih);

        bulan = bultah.month;
        tahun = bultah.year;

        createCalendar(tahun, bulan);
        document.getElementById('overlayprojek').style.display = 'block';
        document.getElementById('formContainer').style.display = 'block';
    }

    function batalkal() {
        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function todaykal(maju) {

        berikutnya = new Date(today.getTime() + maju * 24 * 60 * 60 * 1000);
        tanggal = berikutnya.getDate();
        bulan = berikutnya.getMonth();
        tahun = berikutnya.getFullYear();
        tglsaiki = tanggal + " " + getMonthName(bulan) + " " + tahun;

        document.getElementById('dtgltugas1').innerText = tglsaiki;

        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function pilihkal(tgl, bln, thn) {
        tanggal = tgl
        bulan = bln
        tahun = thn
        tglsaiki = tanggal + " " + getMonthName(bulan) + " " + tahun;

        tglterakhirpilih = tglsaiki;

        document.getElementById(selectedKotakTanggal).innerText = tglsaiki;

        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function mundurmonth() {
        bulan--;
        if (bulan < 0) {
            bulan = 11;
            tahun--;
        }
        createCalendar(tahun, bulan);
    }

    function majumonth() {
        bulan++;
        if (bulan > 11) {
            bulan = 0;
            tahun++;
        }
        createCalendar(tahun, bulan);
    }

    function createCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startDay = firstDay.getDay();

        const monthElement = document.getElementById('month');
        const yearElement = document.getElementById('year');
        monthElement.textContent = getMonthName(month);
        yearElement.textContent = year;

        const calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = '';

        let day = 1;
        for (let i = 0; i < 6; i++) {
            const row = document.createElement('tr');
            for (let j = 0; j < 7; j++) {
                const cell = document.createElement('td');
                if (i === 0 && j < startDay) {
                    cell.textContent = '';
                } else if (day > daysInMonth) {
                    break;
                } else {
                    cell.textContent = day;

                    var tanggalObj = new Date(tahun, bulan, day);
                    var indeksHari = tanggalObj.getDay();
                    if (indeksHari == 0) {
                        cell.classList.add('tanggal_merah');
                    } else if (indeksHari == 6) {
                        cell.classList.add('hari_sabtu');
                    }

                    if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
                        cell.classList.add('today');
                    }

                    const eventOnDate = events.find(event => new Date(event.date).getFullYear() === year && new Date(event.date).getMonth() === (month) && new Date(event.date).getDate() === day);

                    if (eventOnDate) {
                        const eventDiv = document.createElement('div');
                        eventDiv.textContent = eventOnDate.title;
                        eventDiv.classList.add('event', eventOnDate.type);

                        cell.classList.add('has-event');
                        cell.dataset.title = eventOnDate.title;
                        cell.dataset.type = eventOnDate.type;
                        cell.dataset.jeniskal = eventOnDate.jeniskal;
                        if (cell.dataset.jeniskal == 1)
                            cell.style.color = 'red';
                        if (cell.dataset.type != "lain")
                            cell.style.backgroundColor = getColorForEventType(eventOnDate.type);

                        cell.dataset.addedit = "edit";

                        if (eventOnDate.jeniskal == 1) {
                            cell.dataset.addedit = "add";
                            cell.dataset.title = "";
                        }

                    } else {
                        cell.classList.add('has-event');
                        cell.dataset.addedit = "add";
                        cell.dataset.title = "";
                    }

                    cell.dataset.tgl = day;
                    cell.addEventListener('click', function() {
                        tanggal = cell.dataset.tgl;
                        bulan = month;
                        tahun = year;
                        pilihkal(tanggal, bulan, tahun);
                    });

                    day++;
                }

                row.appendChild(cell);
            }

            calendarBody.appendChild(row);
        }

    }

    function getColorForEventType(type) {
        switch (type) {
            case 'info':
                return 'lightblue';
            case 'tes':
                return 'lightgreen';
            case 'libur':
                return '#FF7C80';
            default:
                return 'white';
        }
    }

    function getMonthName(month) {
        const months = [
            "Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Ags", "Sep", "Okt", "Nop", "Des"
        ];
        return months[month];
    }

    function getMonthIndex(monthName) {
        const months = [
            "Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Ags", "Sep", "Okt", "Nop", "Des"
        ];
        return months.indexOf(monthName);
    }

    $(document).ready(function() {
        var tglsaiki = today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate();

    });

    function formatjam(input) {
        var sanitizedValue = input.value.replace(/\D/g, "");
        if (sanitizedValue.length === 4) {
            var hour = sanitizedValue.substring(0, 2);
            var minute = sanitizedValue.substring(2);

            input.value = hour + ":" + minute;
        }
    }
</script>
<?= $this->endSection() ?>
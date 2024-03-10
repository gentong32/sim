<?php $bulanpendek = [
    "Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
    "Jul", "Ags", "Sep", "Okt", "Nop", "Des"
];
?>
<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    .rombel {
        width: 100%;
        max-width: 600px;
        border: 0.5px solid gray;
        border-collapse: collapse;
        text-align: left;
        margin-bottom: 20px;
    }

    .rombel td {
        padding: 6px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .rombel th {
        text-align: center;
        padding: 8px 6px;
        border: 1px solid #ccc;
        /* border-bottom: 1px solid #ccc; */
    }

    .rombel th:nth-child(2) {
        width: 100px;
    }

    .tbtambah {
        display: inline-block;
        padding: 5px 5px;
        margin: auto;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color: #26BEAE;
        border: 0.5px solid green;
        border-radius: 2px;
        cursor: pointer;
        height: 30px;
        width: 200px;
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
        max-width: 600px;
    }

    .tabel {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin: auto;
        margin-top: 0px;
        margin-bottom: 25px;
    }

    .tabel th,
    .tabel {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
    }

    .tabel td {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        vertical-align: top;
        text-align: left;
    }

    .tabel td:first-child {
        padding: 8px;
        font-size: 14px;
        border-bottom: none;
        border-top: none;
        width: 100px;
    }

    .tabel td:nth-child(2) {
        padding: 8px;
        font-size: 14px;
        border-bottom: none;
        border-top: none;
        width: 160px;
    }

    .tabel th {
        background-color: #4CAF50;
        color: white;
    }

    .tabel tr {
        /* border-bottom: 1px solid black;
        border-top: none; */
    }

    .tabel2 {
        border-collapse: collapse;
        width: 100%;
        max-width: 600px;
        margin-top: 5px;
        margin-bottom: 15px;
    }

    .tabel2 th,
    .tabel2 {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
    }

    .tabel2 td {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
    }

    .tabel2 td:first-child {
        padding: 8px;
        font-size: 14px;
    }

    .tabel2 th {
        background-color: skyblue;
        color: white;
    }

    /* .tabel tr:nth-child(even) {
        background-color: #f2f2f2;
    } */

    /* .tabel tr:hover {
        background-color: #ddd;
    } */

    .jkelas {
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 0px;
    }

    .opsi1 {
        width: 200px;
    }

    .opsi2 {
        width: 150px;
    }

    .opsi3 {
        width: 300px;
    }

    .opsi4 {
        width: 300px;
    }

    .dselect {
        margin-bottom: 2px;
    }

    .dselect label {
        vertical-align: middle;
    }

    #dtambah {
        border: 0.5px solid gray;
        border-radius: 5px;
        padding: 15px;
        max-width: 600px;
        margin: auto;
        display: none;
    }

    .tbtambah[disabled] {
        opacity: 0.5;
        cursor: not-allowed;
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

    .dtugas {
        text-align: left;
    }

    .dtugas #tugas {
        height: 30px;
        background: #fff;
        box-shadow: 1px 1px darkgreen;
        color: black;
        padding-left: 7px;
        font-size: 16px;
    }

    #dtgltugas1,
    #dtgltugas2 {
        height: 26px;
        background: #b5d0eb;
        box-shadow: 1px 1px darkgreen;
        color: black;
        padding-top: 5px;
        padding-bottom: 2px;
        padding-left: 7px;
        font-size: 16px;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 160px;
    }

    #tbpiltgl1,
    #tbpiltgl2 {
        height: 33px;
        display: inline-block;
        margin-top: 2px;
        margin-left: 2px;
        background-color: #b5d0eb;
        border: none;
        box-shadow: 1px 1px darkgreen;
        cursor: pointer;
    }

    #dkaltb {
        display: flex;
        align-items: center;
        vertical-align: middle;
        margin-top: -5px;
    }

    input::placeholder {
        color: #999;
        background-color: #fff;
        font-style: italic;
        border-color: #fff;
    }

    .select1 {
        width: 200px;
        font-size: 16px;
        padding: 7px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    label {
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2><?= $nama_mapel ?></h2>
    <h3>Kelas <?= $nama_rombel ?></h3>

    <div id="dtambah" style="display: none">
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

        <div class="dtugas">
            <label for="jenis">Jenis</label><br>
            <select class="select1" name="sjenis" id="sjenis">
                <option value="1">Tes / Ulangan</option>
                <option value="2">Tugas / PR</option>
            </select>

            <br>
            <label id="ltugas" for="tugas">Tanggal Pelaksanaan</label><br>
            <div id="dkaltb">
                <div id="dtgltugas1" style="display: inline-block;"></div>
                <button onclick="tampilkal(1)" id="tbpiltgl1"><img src="/assets/kalender.png" height="28px" alt=""></button>
            </div>

            <label for="tugas">Nama Tugas / Tes</label><br>
            <input type="text" name="tugas" id="tugas" placeholder="misal: Ulangan 1" required>
            <br>

            <div id="tgltujuan" style="display: none;">
                <label for="tugas">Batas Pengumpulan Tugas / PR</label><br>
                <div id="dkaltb">
                    <div id="dtgltugas2" style="display: inline-block;"></div>
                    <button onclick="tampilkal(2)" id="tbpiltgl2"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
            </div>

            <div id="dtujuan">
                <table class="tabel2" name="pilih_tp" id="pilih_tp">
                    <tr>
                        <th>Tujuan Pembelajaran</th>
                        <th>Pilih</th>
                    </tr>
                    <?php foreach ($daftar_tp as $data) : ?>
                        <tr data-id="<?= $data->id ?>">
                            <td><?= $data->tujuan_pembelajaran ?></td>
                            <td><input type="checkbox"></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>

        <button class="batal" id="tbbatal" onclick="batalinput()">Batal</button>
        <button class="ok" id="tbsubmit" onclick="ceksubmit()">Submit</button>
    </div>
</div>
<?= (!$daftar_tp) ? "<span style='color:red'>Silakan tambahkan Tujuan Pembelajaran melalui menu di depan,  sebelum membuat Tugas</span><br>" : "" ?>
<button <?= (!$daftar_tp) ? "disabled" : "" ?> class="tbtambah" id="tbtambah" onclick="tampilinput()">Tambahkan Tugas / Tes</button>

<?php
$baris = 0;
$buattabel = true;
$tugas_lama = '';
?>
<table class="tabel">
    <tr>
        <th>Tanggal</th>
        <th>Nama Tugas / Tes</th>
        <th>Tujuan Pembelajaran</th>
        <th>Aksi</th>
    </tr>

    <?php
    $baris = 0;
    foreach ($daftar_tugas as $datarow) {
        $baris++;
        $tanggalnya = substr($datarow['tanggal_tugas'], 8, 2) . " "
            . $bulanpendek[intval(substr($datarow['tanggal_tugas'], 5, 2)) - 1] . " " . substr($datarow['tanggal_tugas'], 0, 4);
        if ($tanggalnya != $tugas_lama) {
            echo "<tr style='border-top:1px solid #ddd'>";
            $tugas_lama = $tanggalnya;
            echo "<td>" . $tanggalnya . "</td>";
        } else {
            echo "<tr>";
            echo "<td></td>";
        }
        echo "<td>" . $datarow['nama_tugas'] . "</td>";
        if ($datarow['tujuan_pembelajaran'] == "") {
            $tujuanpembelajaran = "-";
        } else {
            $tujuanpembelajaran = $datarow['tujuan_pembelajaran'];
        }
        echo "<td>" . $tujuanpembelajaran . "</td>";
        // if ($datarow['tanggal_batas_tugas'] == null)
        //     $tanggalnya2 = "-";
        // else
        //     $tanggalnya2 = substr($datarow['tanggal_batas_tugas'], 8, 2) . " "
        //         . $bulanpendek[intval(substr($datarow['tanggal_batas_tugas'], 5, 2)) - 1] . " " . substr($datarow['tanggal_batas_tugas'], 0, 4);
        // echo "<td>" . $tanggalnya2 . "</td>";
        echo "<td><button onclick='hapustugas(this, " . $baris . "," . $datarow['id'] . ")'>Hapus</button></td>";
        echo "</tr>";
    }
    ?>
</table>


</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const today = new Date();
    var events = <?= $datakalender ?>;
    var tanggaledit;
    var addedit;

    var sekarang = new Date();
    var tanggal = sekarang.getDate();
    var bulan = sekarang.getMonth();
    var tahun = sekarang.getFullYear();

    var tahunsekarang = <?= tahun_ajaran() ?>;
    var selectedKelas = 0;
    var selectedPilihan = 0;
    var selectedGuru = 0;
    var selectedMapel = 0;
    var selectedKotakTanggal = 1;
    var jenispil = 1;

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        todaykal(7);
    });

    document.getElementById('sjenis').addEventListener('change', function() {
        jenispil = this.value;
        if (jenispil == 1) {
            document.getElementById('dtujuan').style.display = "block";
            document.getElementById('ltugas').innerHTML = "Tanggal Pelaksanaan";
            document.getElementById('tugas').placeholder = "misal: Ulangan 1";
        } else {
            document.getElementById('dtujuan').style.display = "block";
            document.getElementById('ltugas').innerHTML = "Tanggal Pengumpulan Tugas";
            document.getElementById('tugas').placeholder = "misal: PR hal. 1 - 3";
        }
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

        var tanggalterpilih = document.getElementById('dtgltugas' + idx).innerText;
        if (tanggalterpilih == "")
            tanggalterpilih = document.getElementById('dtgltugas1').innerText;
        var bultah = getMonthAndYear(tanggalterpilih);

        bulan = bultah.month;
        tahun = bultah.year;

        createCalendar(tahun, bulan);
        document.getElementById('overlayprojek').style.display = 'block';
        document.getElementById('formContainer').style.display = 'block';
    }

    function hapustugas(button, baris, id_tugas) {
        if (confirm("Yakin mau menghapus tugas ini?")) {
            var row = button.parentElement.parentElement;
            var url = '<?= base_url() . "tugas/hapus_tugas" ?>';
            var data = {
                id_tugas: id_tugas,
                valkelas: "<?= $valkelas ?>"
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    row.remove();
                })
                .then()
                .catch(error => console.error('Error:', error));

        }
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

        document.getElementById('dtgltugas' + selectedKotakTanggal).innerText = tglsaiki;

        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function tampilinput() {
        document.getElementById('dtambah').style.display = "block";
        $('html, body').animate({
            scrollTop: $('#dtambah').offset().top + $('#dtambah').height()
        }, 'slow');
        document.getElementById('tbtambah').style.display = "none";
    }

    function batalinput() {
        document.getElementById('dtambah').style.display = "none";
        document.getElementById('tbtambah').style.display = "block";
    }


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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        createCalendar(tahun, bulan);
    });

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
            "Januari", "Pebruari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
        ];
        return months[month];
    }

    function getMonthIndex(monthName) {
        const months = [
            "Januari", "Pebruari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
        ];
        return months.indexOf(monthName);
    }

    $(document).ready(function() {
        var tglsaiki = today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate();

    });

    $('#data-table').on('draw.dt', function() {
        $('.rbut').change(function() {
            $('#tb_update').show();
            $('#info_update').hide();
        });
    });

    function ceksubmit() {

        var isitanggal1 = document.getElementById('dtgltugas1').innerHTML;
        // var isitanggal2 = document.getElementById('dtgltugas2').innerHTML;
        var isitugas = document.getElementById('tugas').value;
        var rows = document.getElementById('pilih_tp').getElementsByTagName('tr');
        var tpTerpilih = [];
        var jmlpilih = 0;
        var valid = false;

        for (var i = 1; i < rows.length; i++) {
            var checkbox = rows[i].getElementsByTagName('input')[0];
            var nama_tp = rows[i].cells[0].innerHTML;
            var id_tp = rows[i].getAttribute('data-id');

            if (checkbox.checked) {
                tpTerpilih.push(id_tp);
                jmlpilih++;
            }
        }

        pambiltanggal1 = getMonthAndYear(isitanggal1);

        ktanggal1 = pambiltanggal1.day;
        kbulan1 = pambiltanggal1.month;
        ktahun1 = pambiltanggal1.year;

        // pambiltanggal2 = getMonthAndYear(isitanggal2);

        // ktanggal2 = pambiltanggal2.day;
        // kbulan2 = pambiltanggal2.month;
        // ktahun2 = pambiltanggal2.year;

        if (jenispil == 1) {
            if (isitanggal1 != "" && isitugas != "" && jmlpilih > 0)
                valid = true;
        } else {
            if (isitanggal1 != "" && isitugas != "")
                valid = true;
        }

        if (valid) {
            var url = '<?= base_url() . "tugas/simpan_tugas" ?>';
            var data = {
                tanggaltugas: tahun + "/" + (bulan + 1) + "/" + tanggal,
                namatugas: isitugas,
                pilihantp: tpTerpilih,
                id_guru_mapel: '<?= $id_guru_mapel ?>'
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    // console.log('Response:', data);
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert("Lengkapi isian");
        }
    }
</script>
<?= $this->endSection() ?>
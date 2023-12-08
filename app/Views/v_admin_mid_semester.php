<?= $this->extend('layout/layout_admin') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php if (isset($ckeditor) && $ckeditor === true) : ?>
    <script src="<?= base_url('ckeditor/ckeditor.js') ?>"></script>
<?php endif; ?>
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
        max-width: 600px;
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
        max-width: 600px;
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

    .dtugas_container {
        display: flex;
        flex-wrap: wrap;
    }

    .dtugas {
        text-align: left;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
        margin-bottom: 20px;
    }

    .dtugas #tugas {
        height: 30px;
        background: #e4eaf1;
        box-shadow: 1px 1px darkgreen;
        color: black;
        padding-left: 7px;
        font-size: 16px;
    }

    .cdtglmid {
        height: 24px;
        background: #b5d0eb;
        box-shadow: 1px 1px darkgreen;
        color: black;
        padding-top: 7px;
        padding-bottom: 2px;
        padding-left: 7px;
        font-size: 16px;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 160px;
    }

    .tbpiltgl {
        height: 33px;
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
    }

    input::placeholder {
        color: #999999;
        font-style: italic;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="form-container">

    <h2>Tanggal Penting</h2>

    <div id="dtambah">
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
                </div>
            </div>
        </div>

        <div class="dtugas_container">
            <div class="dtugas">
                <b>SEMESTER I (GANJIL)</b><br><br>
                Awal Semester I<br>
                <div class="dkaltb">
                    <div id="dtglmid0" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(0)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
                <br>
                Laporan Mid Semester I<br>
                <div class="dkaltb">
                    <div id="dtglmid1" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(1)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
                <br>
                Rapor Semester I<br>
                <div class="dkaltb">
                    <div id="dtglmid2" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(2)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
            </div>
            <div class="dtugas">
                <b>SEMESTER II (GENAP)</b><br><br>
                Awal Semester II<br>
                <div class="dkaltb">
                    <div id="dtglmid3" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(3)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
                <br>
                Laporan Mid Semester II<br>
                <div class="dkaltb">
                    <div id="dtglmid4" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(4)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
                <br>
                Rapor Semester II<br>
                <div class="dkaltb">
                    <div id="dtglmid5" class="cdtglmid" style="display: inline-block;"></div>
                    <button onclick="tampilkal(5)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
                </div>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

    var tgl_awal_ganjil = "<?= $tgl_awal_ganjil ?>";
    var tgl_awal_genap = "<?= $tgl_awal_genap ?>";
    var tgl_mid_ganjil = "<?= $tgl_mid_ganjil ?>";
    var tgl_mid_genap = "<?= $tgl_mid_genap ?>";
    var tgl_rapor_ganjil = "<?= $tgl_rapor_ganjil ?>";
    var tgl_rapor_genap = "<?= $tgl_rapor_genap ?>";

    var selectedMid = 0;

    var tahunmid = Array("<?= substr($tgl_awal_ganjil, 0, 4) ?>", "<?= substr($tgl_mid_ganjil, 0, 4) ?>", "<?= substr($tgl_rapor_ganjil, 0, 4) ?>", "<?= substr($tgl_awal_genap, 0, 4) ?>", "<?= substr($tgl_mid_genap, 0, 4) ?>", "<?= substr($tgl_rapor_genap, 0, 4) ?>");
    var bulanmid = Array("<?= substr($tgl_awal_ganjil, 5, 2) ?>", "<?= substr($tgl_mid_ganjil, 5, 2) ?>", "<?= substr($tgl_rapor_ganjil, 5, 2) ?>", "<?= substr($tgl_awal_genap, 5, 2) ?>", "<?= substr($tgl_mid_genap, 5, 2) ?>", "<?= substr($tgl_rapor_genap, 5, 2) ?>");
    var tanggalmid = Array("<?= intval(substr($tgl_awal_ganjil, 8, 2)) ?>", "<?= intval(substr($tgl_mid_ganjil, 8, 2)) ?>", "<?= intval(substr($tgl_rapor_ganjil, 8, 2)) ?>", "<?= intval(substr($tgl_awal_genap, 8, 2)) ?>", "<?= intval(substr($tgl_mid_genap, 8, 2)) ?>", "<?= intval(substr($tgl_rapor_genap, 8, 2)) ?>");


    $(document).ready(function() {
        for (var a = 0; a <= 5; a++) {
            document.getElementById('dtglmid' + a).innerText = tanggalmid[a] + " " + getMonthName(parseInt(bulanmid[a] - 1)) + " " + tahunmid[a];
        }
    });

    function tampilkal(idx) {
        selectedMid = idx;
        if (tahunmid[idx] != "" && bulanmid[idx] != "") {
            tanggal = tanggalmid[selectedMid];
            bulan = bulanmid[selectedMid] - 1;
            tahun = tahunmid[selectedMid];
        }
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

        tanggalmid[selectedMid] = tanggal;
        bulanmid[selectedMid] = bulan;
        tahunmid[selectedMid] = tahun;
        document.getElementById('dtglmid' + selectedMid).innerText = tglsaiki;

        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function pilihkal(tgl, bln, thn) {
        tanggal = tgl
        bulan = bln
        tahun = thn
        tglsaiki = tanggal + " " + getMonthName(parseInt(bulan) - 1) + " " + tahun;

        tanggalmid[selectedMid] = tanggal;
        bulanmid[selectedMid] = bulan;
        tahunmid[selectedMid] = tahun;
        document.getElementById('dtglmid' + selectedMid).innerText = tglsaiki;

        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
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
                        bulan = month + 1;
                        tahun = year;

                        tanggalmid[selectedMid] = tanggal;
                        bulanmid[selectedMid] = bulan;
                        tahunmid[selectedMid] = tahun;

                        pilihkal(tanggal, bulan, tahun);
                        submit_tgl();
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

    $(document).ready(function() {
        var tglsaiki = today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate();

    });

    $('#data-table').on('draw.dt', function() {
        $('.rbut').change(function() {
            $('#tb_update').show();
            $('#info_update').hide();
        });
    });

    function submit_tgl() {

        var url = '<?= base_url() . "admin/simpan_mid" ?>';
        var data = {
            idx_mid: selectedMid,
            tgl_mid: tahun + '/' + (parseInt(bulan)) + '/' + tanggal,
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
                console.log('Response:', data);
                // window.location.reload();
            })
            .catch(error => console.error('Error:', error));
    }
</script>
<?= $this->endSection() ?>
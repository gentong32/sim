<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    :root {
        --ukf: 12px;
    }

    .cumum {
        background-color: #D6EAF8;
        margin-left: auto;
        margin-right: auto;
        margin-top: 15px;
        margin-bottom: 25px;
        font-size: 14px;
        max-width: 900px;
        width: 100%;
        padding: 0px;
    }

    .cumum h3 {
        color: black;
    }

    .dinput input {
        background-color: wheat;
        background: white;
        color: black;
        font-size: 16px;
    }

    .ck-editor__editable {
        min-height: 300px;
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

    .dkaltb {
        display: flex;
        align-items: center;
        vertical-align: middle;
    }

    .dtanggal {
        width: 100%;
        margin: auto;
        max-width: 900px;
        text-align: left;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<h2 class="calendar-title">INPUT PENGUMUMAN</h2>

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

<div class="dtanggal">
    <b>Tanggal Mulai</b>
    <div class="dkaltb">
        <div id="dtglmid0" class="cdtglmid" style="display: inline-block;"></div>
        <button onclick="tampilkal(0)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
    </div>
    <b>Tanggal Selesai</b>
    <div class="dkaltb">
        <div id="dtglmid1" class="cdtglmid" style="display: inline-block;"></div>
        <button onclick="tampilkal(1)" class="tbpiltgl"><img src="/assets/kalender.png" height="28px" alt=""></button>
    </div>
    <b>Label Pengumuman</b>
    <div class="dinput">
        <input type="text" width="200px" maxlength="50" id="label_pengumuman" oninput="tampilupdate()" value="<?= $label_pengumuman ?>">
    </div>
</div>

<div class="cumum">
    <form action="<?= base_url('pengumuman/simpanpengumuman') ?>" method="post" onsubmit="return validateForm()">

        <div class="editor tumum">
            <textarea id="editor1" name="editor1"></textarea>
        </div>
        <br>
        <input type="hidden" name="tanggal_mulai" id="tanggal_mulai">
        <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
        <input type="hidden" name="judul_pengumuman" id="judul_pengumuman">
        <?php if ($addedit == "edit") : ?>
            <input type="hidden" name="id_pengumuman" value="<?= $id_pengumuman ?>">
        <?php endif ?>
        <input id="updateBtn" class="submit-btn" type="submit" name="update" value="Update" style="display: none;"><br>
    </form>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?= base_url('ckeditor_2/ckeditor.js') ?>"></script>
<script>
    // Inisialisasi editor

    function validateForm() {
        var editorData = window.editor.getData();
        var tanggalMulai = document.getElementById('dtglmid0').innerText;
        var tanggalSelesai = document.getElementById('dtglmid1').innerText;

        tanggalMulai = reverseTanggal(tanggalMulai);
        tanggalSelesai = reverseTanggal(tanggalSelesai);

        $('#tanggal_mulai').val($('#dtglmid0').val());
        $('#tanggal_selesai').val($('#dtglmid1').val());
        $('#judul_pengumuman').val($('#label_pengumuman').val());

        document.getElementById('tanggal_mulai').value = tanggalMulai;
        document.getElementById('tanggal_selesai').value = tanggalSelesai;
        document.getElementById('editor1').value = editorData;

        if (editorData.trim() === '') {
            alert("Teks masih kosong");
            return false;
        }

        return true;
    }

    ClassicEditor
        .create(document.querySelector('.editor'), {
            // Editor configuration.
        })
        .then(editor => {
            window.editor = editor;
            <?php if ($addedit == "edit") : ?>
                editor.setData(`<?= $pengumuman ?>`);
            <?php endif ?>
            editor.model.document.on('change:data', () => {
                const updateBtn = document.getElementById('updateBtn');
                updateBtn.style.display = 'block';
            });
        })
        .catch(handleSampleError);

    function handleSampleError(error) {
        const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

        const message = [
            'Oops, something went wrong!',
            `Please, report the following error on ${issueUrl} with the build id "crx51sxxua9v-35s7ap8k3xzs" and the error stack trace:`
        ].join('\n');

        console.error(message);
        console.error(error);
    }

    var inputElement = document.getElementById('updateBtn');


    function tampilupdate() {
        $('#updateBtn').show();
    }
</script>
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

    var selectedMid = 0;

    var tahunmid = Array("<?= substr($tanggal_sekarang, 0, 4) ?>", "<?= substr($tanggal_sebulan, 0, 4) ?>");
    var bulanmid = Array("<?= substr($tanggal_sekarang, 5, 2) ?>", "<?= substr($tanggal_sebulan, 5, 2) ?>");
    var tanggalmid = Array("<?= intval(substr($tanggal_sekarang, 8, 2)) ?>", "<?= intval(substr($tanggal_sebulan, 8, 2)) ?>");


    $(document).ready(function() {
        for (var a = 0; a <= 1; a++) {
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
</script>
<script>
    const months = [
        "Januari", "Pebruari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
    ];

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
        return months[month];
    }

    function reverseTanggal(tanggalText) {
        var tanggalParts = tanggalText.split(' ');

        var hari = parseInt(tanggalParts[0]);
        var bulan = months.indexOf(tanggalParts[1]) + 1;
        var tahun = parseInt(tanggalParts[2]);

        var tanggalFormatted = tahun + '-' + ('0' + bulan).slice(-2) + '-' + ('0' + hari).slice(-2);

        return tanggalFormatted;
    }

    $(document).ready(function() {
        var tglsaiki = today.getFullYear() + "/" + (today.getMonth() + 1) + "/" + today.getDate();
    });
</script>

<?= $this->endSection(); ?>
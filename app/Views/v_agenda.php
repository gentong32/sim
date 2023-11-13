<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    .calendar {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        background-color: white !important;
    }

    .calendar th,
    .calendar td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
        width: 20px;
    }

    .calendar th {
        background-color: cornflowerblue;

    }

    .calendar td:hover {
        background-color: #f9f9f9;
    }

    .today {
        color: blue !important;
        font-weight: bold;
        font-size: 16px !important;
    }

    .tanggal_merah {
        color: red;
        font-size: 14px;
    }

    .hari_sabtu {
        color: rgba(20, 20, 20, .4);
        font-size: 14px;
    }

    .event {
        font-size: 10px;
        margin-top: 2px;
        text-align: center;
        white-space: nowrap;
    }

    .has-event {
        cursor: pointer;
    }

    .event-list {
        flex: 1;
        overflow: hidden;
    }

    #agenda {
        padding-left: 10px;
        text-align: left;
        background-color: #356fae;
        color: aliceblue;
        padding: 10px;
        min-height: 180px;
        vertical-align: top;
    }

    #agenda>div {
        margin-bottom: 10px;
    }


    .tanggalan {
        display: flex;
        margin-left: 5px;
        margin-right: 5px;
        flex-wrap: wrap;
        font-size: 14px;
        margin-bottom: 30px;
    }

    .calendar-container {
        flex: 1;
    }

    .event-list {
        flex: 1;
        overflow: hidden;
    }

    .event-table {
        width: 100%;
        border-collapse: collapse;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
    }

    .event-table th,
    .event-table td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ccc;
    }

    .event-table th {
        background-color: #f2f2f2;
    }

    #bulantahun {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    #bulantahun button {
        font-size: 16px;
        font-weight: bold;
        height: 30px;
        width: 30px;
        margin-left: 5px;
        margin-right: 5px;
    }

    #overlaykalender {
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
        max-width: 360px;
        width: 95%;
        z-index: 9999;
        display: none;
        font-size: 16px;
    }

    .cagenda {
        max-width: 220px;
        width: 100%;
        font-size: 16px;
        background-color: white;
    }

    .tbagenda,
    .ok {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 5px;
        margin-bottom: 0px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 150px;
    }



    #tagenda1 {
        display: block;
    }

    #tagenda2 {
        display: none;
    }

    .delete,
    .hapus {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 30px;
    }

    .batal {
        display: inline-block;
        padding: 0px 0px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: burlywood;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 50px;
    }

    #ipilih {
        font-size: 16px;
    }

    .dinput {
        margin-bottom: 5px;
    }

    .info-sementara {
        color: #A43728;
        margin-top: 7px;
        font-style: italic;
        font-size: 14px;
    }

    #monthyear {
        width: 130px;
        display: inline-block;
    }

    .judulevent {
        font-size: 16px;
        margin-bottom: 10px;
    }

    @media screen and (min-width: 600px) {

        .event-list {
            float: right;
            max-width: 100%;
            margin-left: 15px;
            margin-top: 10px;
        }

        .tanggalan {
            margin-right: 15px;
        }
    }

    @media screen and (max-width: 380px) {
        .tanggalan {
            font-size: 12px;
        }

        .tanggalan {
            flex-direction: column;
        }

        .event-list {
            order: 3;
            max-width: 100%;
        }

        .calendar-container {
            order: 2;
            margin-bottom: 20px;
        }

        .calendar-title {
            order: 1;
        }
    }

    @media screen and (max-width: 599px) {
        .tanggalan {
            flex-direction: column;
        }

        .event-list {
            margin-top: 0px;
        }

        #tagenda1 {
            display: none;
        }

        #tagenda2 {
            display: block;
        }
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div>
    <h2 class="calendar-title">Kalender Pendidikan</h2>
</div>
<div id="overlaykalender"></div>
<div id="formContainer">
    <form action="<?= base_url("agenda/simpan_agenda_kelas") ?>" method="post">
        <div class="formContent">
            <h5 id="judulinput">Agenda Tanggal</h5>
            <input type="hidden" name="ipilih" id="pilih" value="0">
            <div class="dinput">
                <label for="cprojek">Agenda:</label>
                <input type="text" style="background: white; box-shadow:none;border:1px solid gray;color: rebeccapurple" class="cagenda" id="iagenda" name="iagenda" \> <button id="tbhapus" class="hapus" onclick="return hapusInput()">X</button>
            </div>
            <input type="hidden" name="tanggal" id="tanggal" value="" />
            <input type="hidden" name="bulan" id="bulan" value="" />
            <input type="hidden" name="tahun" id="tahun" value="" />
            <input type="hidden" name="addedit" id="addedit" value="" />
            <input type="hidden" name="valkelas" id="valkelas" value="<?= $valkelas ?>" />

            <button class="batal" onclick="return batalInput()">Batal</button>
            <button type="submit" class="ok" onclick="return okInput()">OK</button>
        </div>
    </form>
    <form id="fhapus" action="<?= base_url("agenda/hapus_agenda_kelas") ?>" method="post">
        <input type="hidden" name="tanggal" id="tanggal2" value="" />
        <input type="hidden" name="bulan" id="bulan2" value="" />
        <input type="hidden" name="tahun" id="tahun2" value="" />
        <input type="hidden" name="valkelas" id="valkelas2" value="<?= $valkelas ?>" />
    </form>
</div>
<div class="tanggalan">
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
                <!-- Isi kalender akan di-generate oleh JavaScript -->
            </tbody>
        </table>
        <button class="tbagenda" id="tagenda1" onclick="lihatagenda();">Lihat semua agenda</button>
    </div>
    <div class="event-list">
        <div class="judulevent">Daftar Agenda</div>
        <div id="agenda">
            <!-- Daftar acara akan ditambahkan oleh JavaScript -->
        </div>
        <button class="tbagenda" id="tagenda2" onclick="lihatagenda();">Lihat semua agenda</button>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    var events = <?= $datakalender ?>;
    var tanggaledit;
    var addedit;
    var iduser = "<?= $id_user ?>";

    <?php if ($pesan != null) { ?>
        var sekarang = "<?= $pesan ?>";
        var bulantahun = sekarang.split("-");
        var bulan = parseInt(bulantahun[0]);
        var tahun = parseInt(bulantahun[1]);
    <?php } else { ?>
        var sekarang = new Date();
        var bulan = sekarang.getMonth();
        var tahun = sekarang.getFullYear();
    <?php } ?>


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
        const today = new Date();
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
                    // Sel-sel di bulan sebelumnya
                    cell.textContent = '';
                } else if (day > daysInMonth) {
                    // Sel-sel setelah akhir bulan
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

                    const eventOnDate = events.find(event => new Date(event.date).getFullYear() === year && new Date(event.date).getMonth() === (month) && new Date(event.date).getDate() === day && event.jeniskal == 1);

                    const eventOnDateAdmin = events.find(event => new Date(event.date).getFullYear() === year && new Date(event.date).getMonth() === (month) && new Date(event.date).getDate() === day && event.jeniskal == 2 && event.jenis < 3);

                    const eventOnDateWali = events.find(event => new Date(event.date).getFullYear() === year && new Date(event.date).getMonth() === (month) && new Date(event.date).getDate() === day && event.jenis == 3);

                    const eventOnDateGuru = events.find(event => new Date(event.date).getFullYear() === year && new Date(event.date).getMonth() === (month) && new Date(event.date).getDate() === day && event.jenis == 4);

                    cell.classList.add('has-event');
                    cell.dataset.addedit = "add";
                    cell.dataset.title = "";

                    if (eventOnDate) {
                        const eventDiv = document.createElement('div');
                        eventDiv.textContent = eventOnDate.title;
                        eventDiv.classList.add('event', eventOnDate.type);

                        cell.classList.add('has-event');
                        cell.dataset.title = eventOnDate.title;
                        cell.dataset.type = eventOnDate.type;
                        cell.dataset.jeniskal = eventOnDate.jeniskal;
                        cell.dataset.id_uploader = eventOnDate.id_uploader;
                        cell.style.color = 'red';
                    }

                    if (eventOnDateAdmin) {
                        const eventDiv = document.createElement('div');
                        eventDiv.textContent = eventOnDateAdmin.title;
                        eventDiv.classList.add('event', eventOnDateAdmin.type);

                        cell.classList.add('has-event');
                        cell.dataset.title = eventOnDateAdmin.title;
                        cell.dataset.type = eventOnDateAdmin.type;
                        cell.dataset.jeniskal = eventOnDateAdmin.jeniskal;
                        cell.dataset.id_uploader = eventOnDateAdmin.id_uploader;

                        if (cell.dataset.type == "info" || cell.dataset.type == "tes" || cell.dataset.type == "libur") {
                            cell.style.backgroundColor = getColorForEventType(eventOnDateAdmin.type);
                        }

                    }

                    if (eventOnDateWali) {
                        const eventDiv = document.createElement('div');
                        eventDiv.textContent = eventOnDateWali.title;
                        eventDiv.classList.add('event', eventOnDateWali.type);

                        cell.classList.add('has-event');
                        cell.dataset.title = eventOnDateWali.title;
                        cell.dataset.type = eventOnDateWali.type;
                        cell.dataset.jeniskal = eventOnDateWali.jeniskal;
                        cell.dataset.id_uploader = eventOnDateWali.id_uploader;

                        cell.style.border = '2px solid blue';

                    }
                    if (eventOnDateGuru) {
                        const eventDiv = document.createElement('div');
                        eventDiv.textContent = eventOnDateGuru.title;
                        eventDiv.classList.add('event', eventOnDateGuru.type);

                        cell.classList.add('has-event');
                        cell.dataset.title = eventOnDateGuru.title;
                        cell.dataset.type = eventOnDateGuru.type;
                        cell.dataset.jeniskal = eventOnDateGuru.jeniskal;
                        cell.dataset.id_uploader = eventOnDateGuru.id_uploader;

                        if (cell.dataset.id_uploader == iduser) {
                            cell.dataset.addedit = "edit";
                        } else {
                            cell.dataset.addedit = "add";
                            cell.dataset.title = "";
                        }

                        if (eventOnDateGuru.type == "guru") {
                            cell.style.border = '2px solid green';
                        }

                    }

                    cell.dataset.tgl = day;

                    cell.addEventListener('click', function() {
                        document.getElementById('overlaykalender').style.display = 'block';
                        document.getElementById('formContainer').style.display = 'block';
                        document.getElementById('judulinput').innerHTML = "Tanggal: " + cell.dataset.tgl + " " + getMonthName(month) + " " + year;

                        if (cell.dataset.id_uploader == iduser) {
                            document.getElementById('iagenda').value = cell.dataset.title;
                            addedit = "edit";
                        } else {
                            document.getElementById('iagenda').value = "";
                            addedit = "add";
                        }
                        tanggaledit = cell.dataset.tgl;
                        document.getElementById('tbhapus').style.display = "none";
                        if (cell.dataset.title == "")
                            document.getElementById('tbhapus').style.display = "none";
                        else if (cell.dataset.id_uploader == iduser)
                            document.getElementById('tbhapus').style.display = "inline";

                    });



                    day++;
                }

                row.appendChild(cell);
            }

            calendarBody.appendChild(row);
        }

        displayEventList(year, month);
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
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        return months[month];
    }

    function getMonthShortName(month) {
        const months = [
            "Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
            "Jul", "Ags", "Sep", "Okt", "Nop", "Des"
        ];
        return months[month];
    }

    function combineConsecutiveEvents(events) {
        const combinedEvents = [];

        let currentEvent = null;
        for (const event of events) {
            if (currentEvent && event.type === currentEvent.type &&
                event.title === currentEvent.title &&
                new Date(event.date).getTime() - currentEvent.endDate.getTime() === 24 * 60 * 60 * 1000) {
                currentEvent.endDate = new Date(event.date);
            } else {
                if (currentEvent) {
                    combinedEvents.push(currentEvent);
                }
                currentEvent = {
                    title: event.title,
                    type: event.type,
                    jeniskal: event.jeniskal,
                    date: new Date(event.date),
                    endDate: new Date(event.date),
                };
            }
        }

        if (currentEvent) {
            combinedEvents.push(currentEvent);
        }

        return combinedEvents;
    }

    function displayEventList(year, month) {
        const agendaDiv = document.getElementById('agenda');
        agendaDiv.innerHTML = '';

        const eventsInMonth = events.filter(event =>
            new Date(event.date).getFullYear() === year &&
            new Date(event.date).getMonth() === (month)
        );

        const combinedEvents = combineConsecutiveEvents(eventsInMonth);

        combinedEvents.forEach((event, index) => {
            const row = document.createElement('tr');
            var tanggalrange = new Date(event.date).getDate() + " - " + event.endDate.getDate();
            if (new Date(event.date).getDate() == event.endDate.getDate())
                tanggalrange = new Date(event.date).getDate();
            const entryDiv = document.createElement('div');
            if (event.jeniskal == 1) {
                entryDiv.innerHTML = `
            <div style='color:yellow'>${tanggalrange} ${getMonthName(new Date(event.date).getMonth())} ${new Date(event.date).getFullYear()}</div>
            <div style='color:yellow'>${event.title}</div>`
            } else {
                entryDiv.innerHTML = `
            <div>${tanggalrange} ${getMonthName(new Date(event.date).getMonth())} ${new Date(event.date).getFullYear()}</div>
            <div>${event.title}</div>`
            };
            agendaDiv.appendChild(entryDiv);
        });
    }

    function okInput() {

        document.getElementById('tanggal').value = tanggaledit;
        document.getElementById('bulan').value = bulan;
        document.getElementById('tahun').value = tahun;
        document.getElementById('addedit').value = addedit;

        if (document.getElementById('iagenda').value == "") {
            alert("Tidak boleh kosong!");
            return false;
        } else
            return true;
    }

    function hapusInput() {
        if (confirm("Apakah mau hapus agenda ini?")) {
            document.getElementById('tanggal2').value = tanggaledit;
            document.getElementById('bulan2').value = bulan;
            document.getElementById('tahun2').value = tahun;
            document.getElementById('fhapus').submit();
            return false;
        } else {
            return false;
        }

    }

    function batalInput() {
        document.getElementById('overlaykalender').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
        return false;
    }

    function lihatagenda() {
        window.open('<?= base_url("admin/list_agenda") ?>', '_self');
    }
</script>


<?= $this->endSection(); ?>
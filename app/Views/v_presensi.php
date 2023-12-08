<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    /* Gaya CSS untuk kalender */
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

    .event {
        font-size: 10px;
        margin-top: 2px;
        text-align: center;
        white-space: nowrap;
    }

    .meeting {
        background-color: lightblue;
    }

    .training {
        background-color: lightgreen;
    }

    .exam {
        background-color: lightcoral;
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
    }

    #agenda>div {
        margin-bottom: 10px;
    }

    .today {
        color: black !important;
        font-weight: bold;
        font-size: 18px !important;
    }

    .tanggal_merah {
        color: red;
        font-size: 16px;
    }

    .hari_sabtu {
        color: rgba(20, 20, 20, .4);
        font-size: 16px;
    }


    .tanggalan {
        display: flex;
        margin-left: 15px;
        margin-right: 15px;
        flex-wrap: wrap;
        font-size: 14px;
    }

    .calendar-container {
        flex: 1;
        margin: 15px;
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

    #data-table_wrapper {
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    table td:nth-child(3) {
        width: 50%;
    }

    .tgpresensi {
        font-size: 16px;
        font-weight: bold;
        margin: 5px;
    }

    .tbpiltgl {
        display: inline;
    }

    .piltgl {
        display: inline;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: steelblue;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100px;
    }

    .tbok {
        display: inline;
        padding: 5px 5px;
        margin-top: 10px;
        font-size: 14px;
        color: #fff;
        background-color: darkolivegreen;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 120px;
    }

    .ok {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: green;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .batal {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #A43728;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .rekap {
        display: inline-block;
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #4e5d84;
        border: 0.5px solid #293358;
        border-radius: 1px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info {
        margin-top: 10px;
        color: darkgreen;
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

    .bawah {
        display: flex;
        justify-content: space-between;
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    @media screen and (min-width: 600px) {

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

        .calendar {
            font-size: 14px;
        }

        .today {
            color: black !important;
            font-weight: bold;
            font-size: 14px !important;
        }

        .tanggal_merah {
            color: red;
            font-size: 14px;
        }

        .hari_sabtu {
            color: rgba(20, 20, 20, .4);
            font-size: 14px;
        }

    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="tbpiltgl">
    <button class="piltgl" onclick="pilihtanggal()">Per Tanggal</button>
</div>
<div class='tgpresensi' id='tanggal_terpilih'><?= tanggal_sekarang()['panjang'] ?></div>
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
            <button onclick="todaykal()" class="ok">Hari Ini</button>
        </div>
    </div>
</div>

<div class="daftar">
    <table id="data-table" class="display nowrap">
        <thead>
            <tr>
                <th>No</th>
                <th class='none'>NIS</th>
                <th>Nama</th>
                <th class="none">Jenis Kelamin</th>
                <th class="none">Alamat</th>
                <th class="none">No. Telp</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data -->
        </tbody>
    </table>


    <div class="bawah">
        <div id="keterangan" style="margin-left: 10px;">
            <label style="margin-left: -7px !important;">Keterangan:</label><br>
            <label>H: Hadir</label><br>
            <label>I: Ijin</label><br>
            <label>S: Sakit</label><br>
            <label>A: Tanpa Keterangan</label>
            <br>
            <!-- <i> *) Jika semua hadir tidak perlu dilakukan penyimpanan</i> -->
        </div>
        <div id="tb_update" style="display: none;"><button class="tbok">Update Presensi</button></div>
        <div id="info_update" class="info" style="display: none;">Data Tersimpan</div>
    </div>
    <div>
        <button onclick="rekappresensi();" class="rekap">REKAP DATA PRESENSI SISWA</button>
    </div>

</div>

<?= $this->endSection(); ?>


<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    var options = document.querySelector('.options');
    var selectedOption = document.querySelector('.selected-option span');

    function pilihtanggal() {
        document.getElementById('overlayprojek').style.display = 'block';
        document.getElementById('formContainer').style.display = 'block';
    }

    function toggleOptions() {
        options.style.display = (options.style.display === 'block') ? 'none' : 'block';
    }

    function selectOption(value) {
        selectedOption.textContent = value;
        selectedOption.dataContent = event.target.dataset.value;
        toggleOptions();
    }

    function batalkal() {
        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    function todaykal() {
        tanggal = today.getDate();
        bulan = today.getMonth();
        tahun = today.getFullYear();
        tglsaiki = tahun + "/" + (bulan + 1) + "/" + tanggal;
        fetchNewData(tglsaiki);
        document.getElementById('overlayprojek').style.display = 'none';
        document.getElementById('formContainer').style.display = 'none';
    }

    // function appendKelasToLink(menu) {
    //     var selectedKelas = document.querySelector('.selected-option span').dataContent;
    //     var link = document.querySelector('.menu-item a[href="/' + menu + '"]');

    //     if (selectedKelas) {
    //         link.href += '?kelas=' + selectedKelas;
    //     }
    // }

    function fetchNewData(tanggal) {
        // alert(tanggal);
        fetch('<?= base_url("presensi/get_data_presensi?tanggal=") ?>' + tanggal + '&kelas=<?= $kelaspilihan ?>')
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTable(newData) {
        var dataSet = [];

        for (var i = 0; i < newData.length; i++) {
            var data = newData[i];
            if (data.status)
                status = data.status;
            else
                status = "H";
            dataSet.push([i + 1, data.nis, data.nama, data.jenis_kelamin, data.alamat, data.telp, status]);
        }

        $('#data-table').DataTable().destroy();

        $('#data-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
            data: dataSet,
            responsive: true,
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 0
                },
                {
                    responsivePriority: 3,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: -1
                }
            ],
            columns: [{
                    title: 'No'
                }, {
                    title: 'NIS'
                },
                {
                    title: 'Nama',
                },
                {
                    title: 'Jenis Kelamin'
                },
                {
                    title: 'Alamat'
                },
                {
                    title: 'No. Telp'
                },
                {
                    title: 'Keterangan',
                    render: function(data, type, row) {
                        return '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="H" ' + (data === 'H' ? 'checked' : '') + '>H ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="I" ' + (data === 'I' ? 'checked' : '') + '>I ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="S" ' + (data === 'S' ? 'checked' : '') + '>S ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="A" ' + (data === 'A' ? 'checked' : '') + '>A';
                    }
                }
            ]
        });
        document.getElementById('tanggal_terpilih').innerText = tanggal + " " + getMonthName(bulan) + " " + tahun;
    }

    document.getElementById('tb_update').addEventListener('click', function() {

        var table = $('#data-table').DataTable();
        var dataToSend = [];

        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var NIS = data[1];

            var selectedValue = document.querySelector('input[name="keterangan_' + data[0] + '"]:checked').value;

            dataToSend.push({
                NIS: NIS,
                keterangan: selectedValue,
                tanggal: tahun + "/" + (bulan + 1) + "/" + tanggal
            });
        });

        fetch('<?= base_url("presensi/simpan_presensi") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(dataToSend)
            })
            .then(response => response.json())
            .then(data => {
                $('#tb_update').hide();
                $('#info_update').show();
                setTimeout(function() {
                    $('#info_update').hide();
                }, 2000);
            })
            .catch(error => console.error('Gagal menyimpan data:', error));
    });
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
                        tglsaiki = year + "/" + (month + 1) + "/" + cell.dataset.tgl;
                        fetchNewData(tglsaiki);
                        document.getElementById('overlayprojek').style.display = 'none';
                        document.getElementById('formContainer').style.display = 'none';

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
        fetchNewData(tglsaiki);

    });

    function rekappresensi() {
        window.open("<?= base_url('presensi_rekap/?kelas=') . $kelaspilihan; ?>", "_self");
    }

    $('#data-table').on('draw.dt', function() {
        $('.rbut').change(function() {
            $('#tb_update').show();
            $('#info_update').hide();
        });
    });
</script>

<?= $this->endSection(); ?>
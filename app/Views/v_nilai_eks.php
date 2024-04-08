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

    .inputsiswa-container {
        flex: 1;
        margin: 15px;
    }

    #dsiswa {
        width: 300px;
        margin: auto;
        text-align: center;
    }

    #dnamasiswa {
        width: 100px;
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

    .dpiltugas {
        display: inline;
        font-size: 16px;
        margin-bottom: 10px;
    }

    #piltugas {
        font-size: 16px;
        margin-top: 5px;
        padding: 5px;
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

    #inilai {
        height: 30px;
        width: 60px;
        background: none;
        background-color: white;
        box-shadow: 1px 1px 1px 1px black;
        text-align: center;
        padding: 0;
        color: black;
    }

    #tbl_container {
        width: 100%;
        max-width: 400px;
        margin: auto;
        margin-bottom: 20px;
    }

    .tabel2 {
        margin: auto;
        border-collapse: collapse;
        width: 100%;
        color: black;
    }

    .tabel2 th,
    .tabel2 {
        /* border: 1px solid #ddd; */
        padding: 5px;
        font-size: 12px;
    }

    .tabel2 td {
        padding: 3px;
        font-size: 12px;
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-top: 0px;
        border-bottom: 1px solid black;
        text-align: left;
        padding-left: 5px;
        vertical-align: top;
    }

    .tabel2 tr:first-child {
        font-size: 12px;
        border: 1px solid black;
    }

    .tabel2 td:first-child {
        font-size: 12px;
        text-align: center;
    }

    .tabel2 th {
        background-color: skyblue;
        color: black;
        border: 1px solid black;
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

        .inputsiswa-container {
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

        .data-table {
            width: 100% !important;
        }

        .daftar {
            margin-left: 10px !important;
            margin-right: 10px !important;
            padding: 5px !important;
        }

    }

    .tbnilai {
        width: 90px;
        height: 30px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .ijo {
        width: 10px;
        height: 10px;
        background-color: green;
        /* border-radius: 5px; */
        display: inline-block;
    }

    .merah {
        width: 10px;
        height: 10px;
        background-color: darkred;
        /* border-radius: 5px; */
        display: inline-block;
    }

    hr {
        margin-top: 0px;
        padding-top: 0px;
    }

    #dtepecontainer {
        display: none;
    }

    .dtepe {
        font-size: 14px;
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .dtepe th,
    td {
        border: 1px solid black;
    }

    .dtepe th:first-child {
        width: 60% !important;
    }

    .dtepe th:nth-child(2) {
        width: 20%;
    }

    .dtepe td:first-child {
        text-align: left;
        padding-left: 5px;
    }
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<?php if ($jml_tp_eks > 0) { ?>
    <h2><?= $nama_ekskul ?></h2>
    <div style="font-size:16px;margin-bottom:15px;color: white">Kelas
        <select style="font-size: 16px;" name="daftarkelas" id="daftarkelas">
            <?php foreach ($daftar_kelas as $row) :
                $selected = "";
                if ($kelas == $row['kelas']) {
                    $selected = "selected";
                }
            ?>
                <option <?= $selected ?> value="<?= $row['kelas'] ?>"><?= $row['kelas'] ?></option>
            <?php endforeach ?>
        </select>
        Rombel
        <select style="font-size: 16px;" name="daftarrombel" id="daftarrombel">
            <?php foreach ($daftar_rombel as $row) :
                $selected = "";
                if ($rombel == $row->nama_rombel) {
                    $selected = "selected";
                }
            ?>
                <option <?= $selected ?> value="<?= $row->id ?>"><?= $row->nama_rombel ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div id="tbl_container">
        <table class="tabel2" name="tabelindikator" id="tabelindikator">
            <tr>
                <th width="50px">No</th>
                <th>Indikator Penilaian</th>
            </tr>
            <?php
            $baris = 0;
            foreach ($daftartp as $row) :
                $baris++;
            ?>
                <tr>
                    <td><?= $baris ?></td>
                    <td><?= $row->tujuan_pembelajaran ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>

    <div class="daftar">
        <table id="data-table" class="display nowrap">
            <thead>
                <tr>
                    <th class='none'>Indeks</th>
                    <th>No</th>
                    <th class='none'>NIS</th>
                    <th>Nama</th>
                    <th class="none">Jenis Kelamin</th>
                    <th class="none">Alamat</th>
                    <th class="none">No. Telp</th>
                    <th>IP *</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>


        <div class="bawah">
            <div id="keterangan" style="margin-left: 10px;">
                <label style="margin-left: -7px !important;">Keterangan:</label><br>
                <label>* IP: Urutan Indikator Penilaian</label><br>
                <br>
            </div>
            <div id="tb_update" style="display: none;"><button class="tbok">Update Nilai</button></div>
            <div id="info_update" class="info" style="display: none;">Data Tersimpan</div>
        </div>
        <!-- <div>
            <button onclick="rekappresensi();" class="rekap">REKAP DATA NILAI EKSKUL SISWA</button>
        </div> -->
    </div>
<?php } else {
    echo "Silakan buat jadwal Tugas terlebih dahulu";
}

?>

<?= $this->endSection(); ?>

<?php if ($jml_tp_eks > 0) { ?>
    <?= $this->section('script') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        var selectedKelas = "<?= $kelas ?>";
        var selectedRombel = "<?= $rombel ?>";
        var idekskul = "<?= $id_ekskul ?>";

        $(document).ready(function() {
            fetchNewData(selectedKelas, selectedRombel);
        });

        $('#daftarkelas').on('change', function() {
            selectedKelas = $(this).val();
            ambilrombel(selectedKelas);
            ambilindikator(selectedKelas);
        });

        $('#daftarrombel').on('change', function() {
            selectedRombel = $(this).val();
            fetchNewData(selectedKelas, selectedRombel);
        });

        function fetchNewData(selectedKelas, selectedRombel) {
            fetch('<?= base_url() . "nilai/get_daftar_nilai_eks?valkelas=" . $valkelas . "&kelas=" ?>' + selectedKelas + '&rombel=' + selectedRombel)
                .then(response => response.json())
                .then(data => {
                    updateTable(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function updateTable(newData) {
            var dataSet = [];
            var nislama = "";
            var nomor = 0;
            var ntp = 0;

            for (var i = 0; i < newData.length; i++) {
                var data = newData[i];
                snomor = ""
                nama = "";
                if (nislama != data.nis) {
                    nislama = data.nis;
                    ntp = 0;
                    nomor++;
                    snomor = nomor;
                    nama = data.nama;
                }
                ntp++;
                stp = "IP-" + ntp;
                dataSet.push([i + 1, snomor, data.nis, nama, data.jenis_kelamin, data.alamat, data.telp, stp, data.nilai]);
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
                        title: 'Indeks'
                    }, {
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
                        title: 'IP *'
                    },
                    {
                        title: 'Nilai',
                        render: function(data, type, row) {
                            return '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="1" ' + (data === '1' ? 'checked' : '') + '>BB ' +
                                '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="2" ' + (data === '2' ? 'checked' : '') + '>MB ' +
                                '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="3" ' + (data === '3' ? 'checked' : '') + '>BSH ' +
                                '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="4" ' + (data === '4' ? 'checked' : '') + '>SB';
                        }
                    }
                ]
            });
        }

        function ambilrombel() {
            fetch('<?= base_url() . "nilai/get_rombel/" ?>' + selectedKelas, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {

                    var rombelSelect = document.getElementById('daftarrombel');
                    rombelSelect.innerHTML = '';

                    var sekali = false;
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            var rombel = data[key];
                            var option = document.createElement('option');
                            option.value = rombel.id;
                            option.text = rombel.nama_rombel;
                            rombelSelect.add(option);
                            if (sekali == false) {
                                sekali = true;
                                selectedRombel = rombel.id;
                                // alert(selectedRombel);
                            }
                        }
                    }
                    fetchNewData(selectedKelas, selectedRombel);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function ambilindikator() {
            fetch('<?= base_url() . "nilai/get_daftar_indikator_eks?kelas=" ?>' + selectedKelas + '&id_ekskul=' + idekskul, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {

                    var tblelemen = document.getElementById('tabelindikator');
                    var tbody = tblelemen.getElementsByTagName('tbody')[0];
                    tbody.innerHTML = "<tr><th width = '50px'>No</th><th>Indikator Penilaian</th></tr>";

                    var baris = 0;
                    jmldata = data.length;
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            baris++;
                            var ip = data[key];
                            var row = tbody.insertRow();

                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);

                            cell1.innerHTML = baris;
                            cell2.innerHTML = ip.tujuan_pembelajaran;
                        }
                    }

                })
                .catch(error => console.error('Error:', error));
        }

        document.getElementById('tb_update').addEventListener('click', function() {

            var table = $('#data-table').DataTable();
            var dataToSend = [];
            var pilihankelas = document.getElementById('daftarkelas').value;

            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data();
                var NIS = data[2];
                var indikator = data[7];

                var radioElement = document.querySelector('input[name="keterangan_' + data[0] + '"]:checked');
                var selectedValue = radioElement ? radioElement.value : '0';

                dataToSend.push({
                    NIS: NIS,
                    nilai: selectedValue,
                    indikator: indikator.substring(3, 4),
                });

            });

            var postData = {
                pilihankelas: pilihankelas,
                idekskul: idekskul,
                semester: <?= $semester ?>,
                dataToSend: dataToSend
            };

            // alert(JSON.stringify(postData));

            fetch('<?= base_url("nilai/simpan_nilai_eks") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => response.json())
                .then(data => {
                    // alert(JSON.stringify(data));
                    $('#tb_update').hide();
                    $('#info_update').show();
                    setTimeout(function() {
                        $('#info_update').hide();
                    }, 2000);
                })
                .catch(error => console.error('Gagal menyimpan data:', error));
        });

        $('#data-table').on('draw.dt', function() {
            $('.rbut').change(function() {
                $('#tb_update').show();
                $('#info_update').hide();
            });
        });
    </script>

    <?= $this->endSection(); ?>
<?php } ?>
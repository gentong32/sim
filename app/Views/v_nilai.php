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
        box-shadow: 1px 1px 1px 1px gray;
        text-align: center;
        padding: 0;
        color: black;
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
        border: 1px solid gray;
        border-collapse: collapse;
    }

    .dtepe th,
    td {
        border: 1px solid gray;
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

<?php if ($id_tugas > 0) { ?>
    <div class="dpiltugas">
        <h3>Tugas / Tes Kelas <?= $nama_rombel ?></h3>
        <select name="piltugas" id="piltugas">
            <?php
            foreach ($daftar_tugas as $datatugas) {
                $selected = "";
                if ($tugasterpilih == $datatugas['id'])
                    $selected = " selected ";
                echo "<option " . $selected . " value='" . $datatugas['id'] . "'>" . $datatugas['nama_tugas'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div id="overlayprojek"></div>
    <div id="formContainer">
        <div class="inputsiswa-container">
            <div id="dsiswa"><button id="tbmundur" onclick="mundursiswa()">&lt;</button>
                <div id="dnamasiswa">Siswa 31</div><button id="tbmaju" onclick="majusiswa()">&gt;</button>
            </div>
            <hr>
            <span>Nilai</span><br>
            <input type="text" name="inilai" id="inilai" maxlength="3">

            <div id="dtepecontainer">
                <table id="tabelinputan" class="dtepe">
                    <tr>
                        <th>T. Pembelajaran</th>
                        <th>Tercapai</th>
                        <th>Tidak</th>
                    </tr>
                    <?php
                    $dafidtugastp = [];
                    $jmlbaristp = 0;
                    foreach ($daftar_tp as $data_tp) :
                        $jmlbaristp++;
                        $dafidtugastp[] = $data_tp['id_tugas_tp'];
                    ?>
                        <tr>
                            <td><?= $data_tp['tujuan_pembelajaran'] ?></td>
                            <td><input type="radio" id="tp_c<?= $jmlbaristp ?>" name="tepe<?= $jmlbaristp ?>"></td>
                            <td><input type="radio" id="tp_t<?= $jmlbaristp ?>" name="tepe<?= $jmlbaristp ?>"></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div class="bawah">
                <button onclick="batalinput()" class="batal">Tutup</button>
                <button id="tbsimpan" style="display: none;" onclick="simpaninput()" class="ok">Simpan</button>
            </div>
        </div>
    </div>

    <div class="daftar">
        <table id="data-table" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th class='none'>NIS</th>
                    <th>Nama</th>
                    <th class="none">Jenis Kelamin</th>
                    <th class="none">Alamat</th>
                    <th class="none">No. Telp</th>
                    <th>Nilai | TP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $baris = 0;
                foreach ($daftar_nilai_siswa as $datasiswa) {
                    $baris++;
                    $nilaitp = $datasiswa['nilai_tp'];
                    $ntpall = explode(";", $nilaitp);
                    $divmerahijo = "";
                    foreach ($ntpall as $ntp) {
                        if ($ntp == "2")
                            $divmerahijo = $divmerahijo . " <div class='ijo'></div>";
                        else if ($ntp == "1")
                            $divmerahijo = $divmerahijo . " <div class='merah'></div>";
                    }
                    $nilaihasil = $datasiswa['nilai'] . $divmerahijo;
                    echo "<tr><td>" . $baris . "</td>\n";
                    echo "<td>" . $datasiswa['nis'] . "</td>\n";
                    echo "<td>" . $datasiswa['nama'] . "</td>\n";
                    echo "<td>" . $datasiswa['jenis_kelamin'] . "</td>\n";
                    echo "<td>" . $datasiswa['alamat'] . "</td>\n";
                    echo "<td>" . $datasiswa['telp'] . "</td>\n";
                    echo "<td><button id='tbisinilai" . $baris . "' onclick='gobaristabel(`" . $baris . "`)' class='tbnilai'>" . $nilaihasil . "</button></td></tr>";
                }
                ?>
            </tbody>
        </table>


        <div class="bawah">
            <div id="keterangan" style="margin-left: 10px;">
                <label style="margin-left: -7px !important;">Keterangan TP:</label><br>
                <?php
                $baris = 0;
                foreach ($daftar_tp as $data_tp) :
                    $baris++; ?>
                    <label>TP <?= $baris ?>: <?= $data_tp['tujuan_pembelajaran'] ?></label><br>
                <?php endforeach ?>
                <div class='ijo'></div> : Tercapai<br>
                <div class='merah'></div> : Belum Tercapai<br>
                <!-- <i> *) Jika semua hadir tidak perlu dilakukan penyimpanan</i> -->
            </div>
            <div id="tb_update" style="display: none;"><button class="tbok">Update Presensi</button></div>
            <div id="info_update" class="info" style="display: none;">Data Tersimpan</div>
        </div>
        <div>
            <button onclick="rekappresensi();" class="rekap">REKAP DATA PRESENSI SISWA</button>
        </div>

    </div>
<?php } else {
    echo "Silakan buat jadwal Tugas terlebih dahulu";
}

?>

<?= $this->endSection(); ?>

<?php if ($id_tugas > 0) { ?>
    <?= $this->section('script') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        const today = new Date();
        var tanggaledit;
        var addedit;
        var nis;

        var sekarang = new Date();
        var tanggal = sekarang.getDate();
        var bulan = sekarang.getMonth();
        var tahun = sekarang.getFullYear();

        var selectedRowIndex = 0;
        var table = document.getElementById('data-table');
        var jmlbaristp = <?= $jmlbaristp ?>;
        var daftarTugasTp = <?= json_encode($dafidtugastp); ?>

        var options = document.querySelector('.options');
        var selectedOption = document.querySelector('.selected-option span');

        function berinilai(nis, nama, nilai, nilai_tp) {
            alert(nis + ", " + nama + ", " + nilai + ", " + nilai_tp);
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

        function batalinput() {
            document.getElementById('overlayprojek').style.display = 'none';
            document.getElementById('formContainer').style.display = 'none';
        }

        function simpaninput() {
            isinilai = document.getElementById('inilai').value;
            adaeror = false;
            adaeror2 = false;

            if (isinilai > 100) {
                adaeror = true;
                alert("Nilai maksimal 100");
            } else {
                if (isinilai > 70) {
                    for (a = 1; a <= jmlbaristp; a++) {
                        if (document.getElementById('tp_c' + a).checked == false && document.getElementById('tp_t' + a).checked == false)
                            document.getElementById('tp_c' + a).checked = true;
                    }
                } else {
                    for (a = 1; a <= jmlbaristp; a++) {
                        if (document.getElementById('tp_c' + a).checked == false && document.getElementById('tp_t' + a).checked == false)
                            document.getElementById('tp_t' + a).checked = true;
                    }
                }
            }

            if (isinilai == "") {
                document.getElementById('dtepecontainer').style.display = "none";
                adaeror = true;
            } else {
                document.getElementById('dtepecontainer').style.display = "block";
            }

            var dataijomerah = "";
            for (a = 1; a <= jmlbaristp; a++) {
                if (document.getElementById('tp_c' + a).checked == false && document.getElementById('tp_t' + a).checked == false) {
                    adaeror2 = true;
                }
                if (document.getElementById('tp_c' + a).checked == true) {
                    dataijomerah = dataijomerah + "{" + daftarTugasTp[a - 1] + "=2},"
                } else {
                    dataijomerah = dataijomerah + "{" + daftarTugasTp[a - 1] + "=1},"
                }
            }
            // alert(dataijomerah);

            if (adaeror2) {
                alert("Ketercapaian tujuan pembelajaran diisi dulu");
            }
            if (adaeror == false && adaeror2 == false) {
                var url = '<?= base_url() . "nilai/simpan_nilai" ?>';
                var data = {
                    valkelas: "<?= $valkelas ?>",
                    id_tugas: "<?= $id_tugas ?>",
                    id_mapel: "<?= $id_mapel ?>",
                    nilai: isinilai,
                    nis: nis,
                    dataijomerah: dataijomerah,
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

                        var ijomerah = "";

                        for (a = 1; a <= jmlbaristp; a++) {
                            if (document.getElementById('tp_c' + a).checked == true) {
                                ijomerah = ijomerah + " <div class='ijo'></div>";
                            } else {
                                ijomerah = ijomerah + " <div class='merah'></div>";
                            }
                        }
                        document.getElementById('tbisinilai' + selectedRowIndex).innerHTML = isinilai + ijomerah;
                        // document.getElementById('overlayprojek').style.display = 'none';
                        // document.getElementById('formContainer').style.display = 'none';
                        document.getElementById('tbsimpan').style.display = 'none';
                        document.getElementById('tbmaju').disabled = false;
                        document.getElementById('tbmundur').disabled = false;

                    })
                    .catch(error => console.error('Error:', error));
            }

        }

        // function appendKelasToLink(menu) {
        //     var selectedKelas = document.querySelector('.selected-option span').dataContent;
        //     var link = document.querySelector('.menu-item a[href="/' + menu + '"]');

        //     if (selectedKelas) {
        //         link.href += '?kelas=' + selectedKelas;
        //     }
        // }


        $('#data-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            },
            "aLengthMenu": [
                [15, -1],
                [15, "All"]
            ],
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
        });

        document.getElementById('piltugas').addEventListener('change', function() {
            window.open("<?= base_url() . 'nilai?kelas=' . $valkelas . '&tugas=' ?>" + this.value, "_self");
        });

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
        function majusiswa() {
            if (selectedRowIndex < (table.rows.length - 1)) {
                selectedRowIndex++;
                gobaristabel(selectedRowIndex);
            }
        }

        document.getElementById('inilai').addEventListener('input', function() {
            document.getElementById('tbmaju').disabled = true;
            document.getElementById('tbmundur').disabled = true;
            document.getElementById('tbsimpan').style.display = "block";

        });

        var tableinput = document.getElementById('tabelinputan');

        tableinput.addEventListener('click', function(event) {
            if (event.target.type === 'radio') {
                if (event.target.checked) {
                    document.getElementById('tbmaju').disabled = true;
                    document.getElementById('tbmundur').disabled = true;
                    document.getElementById('tbsimpan').style.display = "block";
                }
            }
        });

        function mundursiswa() {
            if (selectedRowIndex > 1) {
                selectedRowIndex--;
                gobaristabel(selectedRowIndex);
            }
        }

        function gobaristabel(n) {
            selectedRowIndex = n;
            document.getElementById('overlayprojek').style.display = 'block';
            document.getElementById('formContainer').style.display = 'block';
            document.getElementById('tbsimpan').style.display = "none";
            if (n == 1)
                document.getElementById('tbmundur').disabled = true;
            else
                document.getElementById('tbmundur').disabled = false;

            if (n == table.rows.length - 1)
                document.getElementById('tbmaju').disabled = true;
            else
                document.getElementById('tbmaju').disabled = false;

            var nextRow = table.rows[n];
            if (nextRow) {
                // Mendapatkan nilai dari baris berikutnya
                nis = nextRow.cells[1].innerText;
                var nama = nextRow.cells[2].innerText;
                var nilai = nextRow.cells[6].innerText; // Ubah sesuai indeks kolom yang sesuai

                var carikelas = nextRow.cells[6].innerHTML;

                var regex = /class="([^"]*)"/g; // Mencocokkan nilai dalam atribut class
                var matches = [];
                var match;

                if (nilai == "") {
                    document.getElementById('dtepecontainer').style.display = "none";
                } else {
                    document.getElementById('dtepecontainer').style.display = "block";
                }

                for (a = 1; a <= jmlbaristp; a++) {
                    document.getElementById('tp_c' + a).checked = false;
                    document.getElementById('tp_t' + a).checked = false;
                }

                jmlbaris = 0;
                while ((match = regex.exec(carikelas)) !== null) {
                    matches.push(match[1]); // Menyimpan nilai dari atribut class dalam array
                    if (match[1] == "ijo") {
                        jmlbaris++;
                        document.getElementById('tp_c' + jmlbaris).checked = true;
                    } else if (match[1] == "merah") {
                        jmlbaris++;
                        document.getElementById('tp_t' + jmlbaris).checked = true;
                    }
                }

                document.getElementById('inilai').value = nilai.trim();
                document.getElementById('dnamasiswa').innerHTML = nama.trim();

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
            // fetchNewData(tglsaiki);

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
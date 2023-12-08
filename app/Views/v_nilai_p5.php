<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    :root {
        --ukf: 12px;
    }

    .opsi1 {
        width: 200px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        text-align: left;
    }

    .select2-results__option {
        text-align: left;
    }

    .dselect {
        margin-bottom: 10px;
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



    #dprojek {
        width: 100%;
        max-width: 600px;
        margin: auto;
        text-align: left;
    }

    .tabel2 {
        margin: auto;
        border-collapse: collapse;
        width: 100%;
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
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-top: 0px;
        border-bottom: 0px;
        text-align: left;
        padding-left: 5px;
        vertical-align: top;
    }

    .tabel2 tr:first-child {
        font-size: 12px;
        border: 1px solid #ddd;
    }

    .tabel2 td:first-child {
        font-size: 12px;
    }

    .tabel2 td:nth-child(2) {
        text-align: center;

    }

    .tabel2 th {
        background-color: skyblue;
        color: white;
        border: 1px solid #ddd;
    }

    #tbdetil {
        margin-right: 0px;
        text-align: right;
        float: right;
        margin-bottom: 30px;
    }

    .clear {
        clear: both;
    }

    @media screen and (min-width: 600px) {

        .tanggalan {
            margin-right: 15px;
        }
    }


    @media screen and (max-width: 599px) {
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

<?php if ($daf_projek) { ?>
    <div id="dprojek">

        <div class="dselect">
            <center>
                <h3>Nilai Projek Kelas <?= $nama_rombel ?></h3>
            </center>
            <label for="projek">Projek</label>
            <select class="js-example-basic-single opsi1" name="projek" id="projek">
                <?php foreach ($daf_projek as $daf) : ?>
                    <option value=<?= $daf['id_projek'] ?>><?= $daf['nama_projek'] ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <table class="tabel2" name="tabelelemen" id="tabelelemen">
            <tr>
                <th>Dimensi</th>
                <th width="40px">No</th>
                <th width="65%">Elemen</th>
            </tr>
            <?php
            $baris = 0;
            $dimensilama = "";
            $jmlbaris = sizeof($daf_dimensi);
            foreach ($daf_dimensi as $row) {
                $baris++;
                $dimensi = $row['dimensi'];
                if ($dimensi == $dimensilama) { ?>
                    <tr>
                        <td style="border-bottom:1px solid #ddd"></td>
                        <td style="border-bottom:1px solid #ddd"><?= $baris ?></td>
                        <td style="border-bottom:1px solid #ddd"><?= $row['sub_elemen'] . ".<br><span class='detil' style='display:none'>" . $row['fase_' . $fase] . "</span>" ?></td>
                    </tr>
                <?php } else {
                    $dimensilama = $dimensi; ?>
                    <tr>
                        <td style="border-top:1px solid #ddd<?= ($jmlbaris == $baris) ? ";border-bottom:1px solid #ddd" : "" ?>"><?= $dimensi ?></td>
                        <td style="border-bottom:1px solid #ddd"><?= $baris ?></td>
                        <td style="border-bottom:1px solid #ddd"><?= $row['sub_elemen'] . ".<br><span class='detil' style='display:none'>" . $row['fase_' . $fase] . "</span>" ?></td>
                    </tr>
                <?php }
                ?>

            <?php } ?>
        </table>
        <button id="tbdetil" onclick="togledetil()">Detil</button>
        <div class="clear"></div>


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
                        <th>Elemen</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data -->
                </tbody>
            </table>


            <div class="bawah">
                <div id="keterangan" style="margin-left: 10px;">
                    <label style="margin-left: -7px !important;">Keterangan:</label><br>
                    <label>Elemen: sesuai urutan dimensi proyek</label><br>
                    <br>
                </div>
                <div id="tb_update" style="display: none;"><button class="tbok">Update Nilai</button></div>
                <div id="info_update" class="info" style="display: none;">Data Tersimpan</div>
            </div>
            <div>
                <button onclick="rekappresensi();" class="rekap">REKAP DATA NILAI P5 SISWA</button>
            </div>
        </div>
    </div>
<?php } else {
    echo "<span style='color:darkred; font-size:20px'><b>Projek belum didefinisikan oleh admin sekolah!</b></span>";
} ?>

<?= $this->endSection(); ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var selectedProjek = "<?= $idprojek1 ?>";
    var xfase = "<?= $fase ?>";
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        fetchNewData(selectedProjek);
    });

    $('#projek').on('change', function() {
        selectedProjek = $(this).val();
        ambilelemen(selectedProjek);
        fetchNewData(selectedProjek);
    });

    function togledetil() {
        var detilElements = document.querySelectorAll('.detil');
        detilElements.forEach(function(element) {
            element.style.display = element.style.display === 'none' ? 'block' : 'none';
        });

    }

    function ambilelemen() {
        var url = '<?= base_url() . "nilai/get_daftar_elemen_sekolah" ?>';
        var data = {
            idprojek: selectedProjek,
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
                var tblelemen = document.getElementById('tabelelemen');
                var tbody = tblelemen.getElementsByTagName('tbody')[0];
                tbody.innerHTML = "<tr><th>Dimensi</th><th width='40px'>No</th><th width='65%'>Elemen</th></tr>";

                var baris = 0;
                var dimensilama = "";
                jmldata = data.length;
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        baris++;
                        var elemen = data[key];
                        var row = tbody.insertRow();
                        var dimensibaru = elemen.dimensi

                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);

                        if (dimensibaru == dimensilama) {
                            cell1.innerHTML = "";
                            cell1.style.borderBottom = '1px solid #ddd';
                        } else {
                            dimensilama = dimensibaru;
                            cell1.innerHTML = dimensibaru;
                            cell1.style.borderTop = '1px solid #ddd';
                            if (jmldata == baris)
                                cell1.style.borderBottom = '1px solid #ddd';
                        }

                        cell2.innerHTML = baris;
                        cell2.style.borderBottom = '1px solid #ddd';
                        cell3.innerHTML = elemen.sub_elemen + `<br><span class='detil' style='display:none'>${elemen['fase_' + xfase]}</span>`;


                        cell3.style.borderBottom = '1px solid #ddd';

                    }
                }

            })
            .catch(error => console.error('Error:', error));
    }

    function fetchNewData(id_projek) {
        fetch('<?= base_url("nilai/get_daftar_nilai_p5?projek=") ?>' + id_projek + '&kelas=<?= $valkelas ?>')
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTable(newData) {
        var dataSet = [];
        var nislama = "";
        var nnomor = 0;
        var nelemen = 0;

        for (var i = 0; i < newData.length; i++) {
            var data = newData[i];
            nomor = "";
            nama = "";
            if (nislama != data.nis) {
                nislama = data.nis;
                nelemen = 0;
                nnomor++;
                nomor = nnomor;
                nama = data.nama;
            }
            nelemen++;
            selemen = "El-" + nelemen;
            dataSet.push([i + 1, nomor, data.nis, nama, data.jenis_kelamin, data.alamat, data.telp, selemen, data.nilai]);
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
                    title: 'Elemen'
                },
                {
                    title: 'Nilai',
                    render: function(data, type, row) {
                        return '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="1" ' + (data === '1' ? 'checked' : '') + '>MB ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="2" ' + (data === '2' ? 'checked' : '') + '>SB ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="3" ' + (data === '3' ? 'checked' : '') + '>BSH ' +
                            '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="4" ' + (data === '4' ? 'checked' : '') + '>SB';
                    }
                }
            ]
        });
    }

    document.getElementById('tb_update').addEventListener('click', function() {

        var table = $('#data-table').DataTable();
        var dataToSend = [];
        var id_projek = document.getElementById('projek').value;

        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var NIS = data[2];
            var elemen = data[7];

            var radioElement = document.querySelector('input[name="keterangan_' + data[0] + '"]:checked');
            var selectedValue = radioElement ? radioElement.value : '0';

            dataToSend.push({
                NIS: NIS,
                nilai: selectedValue,
                elemen: elemen.substring(3, 4),
            });

        });

        var postData = {
            id_projek: id_projek,
            dataToSend: dataToSend
        };

        // alert(JSON.stringify(postData));

        fetch('<?= base_url("nilai/simpan_nilai_p5") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(postData)
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

    $('#data-table').on('draw.dt', function() {
        $('.rbut').change(function() {
            $('#tb_update').show();
            $('#info_update').hide();
        });
    });
</script>

<?= $this->endSection(); ?>
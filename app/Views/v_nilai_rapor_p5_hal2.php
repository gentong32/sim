<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>

<style>
    .rapor_container {
        max-width: 700px;
        width: 100%;
        border: 0.5px solid black;
        margin: auto;
        margin-bottom: 35px;
        background-color: azure;
    }

    .kop_rapor {

        width: 100%;
        text-align: left;
        margin: auto;
        border-radius: 5px;
        padding: 5px;
        padding-left: 10px;
        padding-bottom: 0px;
        font-size: 14px;
    }

    .kop_rapor p {
        line-height: 2px;
    }

    .judul_rapor {
        line-height: 5px;
    }

    .nama_siswa {
        padding-left: 8px;
    }

    .nama_siswa table tr td {
        font-size: 14px;
        line-height: 14px;
    }

    .daftar_nilai {
        padding: 10px;
    }

    .daftar_nilai table tr td {
        font-size: 14px;
        line-height: 14px;
        border: 0.5px solid black;
        padding: 5px;
    }

    .daftar_nilai table tr:nth-child(n+3) td:nth-child(2) {
        text-align: left;
    }

    .nama_siswa table tr td {
        text-align: left;
    }

    .tb_container {
        text-align: left !important;
        width: 100%;
        margin: auto;
        padding-left: 10px;
        padding-bottom: 25px;
    }

    .ok {
        padding: 5px 5px;
        margin-top: 5px;
        font-size: 14px;
        color: #fff;
        background-color: #41B55C;
        border: 0.5px solid darkgreen;
        border-radius: 6px;
        cursor: pointer;
        height: 25px;
        transition: transform 0.2s, box-shadow 0.2s;
        width: 100px;
    }

    .ketdanlaku {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .ketdanlaku .daftar_nilai:nth-child(2) {
        padding-right: 25px;
    }

    .catatan {
        text-align: left;
        padding: 10px;
        font-size: smaller;
        font-style: italic;
    }

    .tandatangan {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding-bottom: 20px;
        font-size: 14px;
    }

    .ortu {
        text-align: left;
        padding-left: 10px;
        padding-top: 45px;
    }

    .wali {
        text-align: left;
        padding-right: 25px;
    }

    #pilsemester {
        width: 220px;
        margin: auto;
        margin-bottom: 10px;
        padding: 5px;
    }

    .cprojek {
        margin-top: 35px;
        margin-left: 10px;
        text-align: left !important;
        font-size: 12px;
    }

    .tombol_atas_rapor {
        max-width: 700px;
        width: 100%;
        margin: auto;
        text-align: left;
        margin-bottom: 5px;
    }
</style>
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<?php

use function PHPUnit\Framework\isNull;

$jumlah_s = "-";
$jumlah_i = "-";
$jumlah_a = "-";
if ($absensi) {
    $jumlah_s = ($absensi['Jumlah_S'] == 0) ? "-" : $absensi['Jumlah_S'];
    $jumlah_i = ($absensi['Jumlah_I'] == 0) ? "-" : $absensi['Jumlah_I'];
    $jumlah_a = ($absensi['Jumlah_A'] == 0) ? "-" : $absensi['Jumlah_A'];
}

$nilaikekalimat = array("", "mulai memahami dalam", "telah memahami dalam", "telah memahami dengan baik dalam", "memiliki kemampuan yang sangat baik terutama dalam");

$kelakuan = "-";
$kerajinan = "-";
$kerapihan = "-";
$kebersihan = "-";

if ($kepribadian) {
    $kelakuan = $kepribadian['kelakuan' . $suffiks];
    $kerajinan = $kepribadian['kerajinan' . $suffiks];
    $kerapihan = $kepribadian['kerapihan' . $suffiks];
    $kebersihan = $kepribadian['kebersihan' . $suffiks];
}

$nilaiangka = array("-", "Kurang", "Cukup", "Baik", "Sangat Baik");
$nilaipribadi = array("-", "D", "C", "B", "A");
?>

<h2><?= "RAPOR SISWA" ?></h2>
<select name="pilsemester" id="pilsemester">
    <option <?= ($pilihsemester == "midganjil") ? "selected" : "" ?> value="midganjil">TENGAH SEMESTER GANJIL</option>
    <option <?= ($pilihsemester == "raporganjil") ? "selected" : "" ?> value="raporganjil">AKHIR SEMESTER GANJIL</option>
    <option <?= ($pilihsemester == "midgenap") ? "selected" : "" ?> value="midgenap">TENGAH SEMESTER GENAP</option>
    <option <?= ($pilihsemester == "raporgenap") ? "selected" : "" ?> value="raporgenap">AKHIR SEMESTER GENAP</option>
</select>

<div style="font-size:16px;margin-bottom:15px;color: white">Nama Siswa
    <select style="font-size: 16px;" name="daftarsiswa" id="daftarsiswa">
        <?php
        $namasiswa = "";
        $nissiswa = "";
        $nisnsiswa = "";
        $agamasiswa = "";
        foreach ($daftar_siswa as $row) :
            $selected = "";
            if ($nis == $row['nis']) {
                $selected = "selected";
                $namasiswa = $row['nama'];
                $nissiswa = $row['nis'];
                $nisnsiswa = $row['nisn'];
                $agamasiswa = $row['agama'];
            }
        ?>
            <option <?= $selected ?> value="<?= $row['nis'] ?>"><?= $row['nama'] ?></option>
        <?php endforeach ?>
    </select>
</div>

<div class="tombol_atas_rapor">
    <button onclick="cetak_rapor()" class="tb_biru">Cetak Rapor</button>
    <button style="float: right;" onclick="rapornilai()" class="tb_biru">Rapor Nilai</button>
</div>
<div class="tombol_atas_rapor">
</div>

<div class="rapor_container">
    <div class="kop_rapor">
        <?= $kop_rapor ?>
    </div>
    <hr style="border: 0.5px solid #111;  width:680px;">
    <div class="nama_siswa">
        <table>
            <tr>
                <td style="width:80px">N a m a</td>
                <td style="width:10px;">:</td>
                <td style="width:200px;"><?= $namasiswa ?></td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
                <td><?= $nissiswa ?> / <?= $nisnsiswa ?></td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td><?= $nama_rombel ?></td>
            </tr>
        </table>
    </div>

    <div class="daftar_nilai">
        <table>
            <?php
            $nomor = 0;
            $id_projek_old = 0;
            $id_dimensi_old = 0;
            $jmldata = sizeof($nilai_projek);
            for ($a = 0; $a < $jmldata; $a++) {
                if ($id_projek_old != $nilai_projek[$a]['id_projek']) {
                    $catatan = "";
                    $id_projek_old = $nilai_projek[$a]['id_projek'];
                    $nomor++; ?>
                    <tr style="text-align: center;">
                        <td style="text-align:left;vertical-align:center;width:30px;"><b><?= $nomor ?></b></td>
                        <td style="text-align:left;vertical-align:center;width:200px;"><b><?= $nilai_projek[$a]['nama_projek'] ?></b></td>
                        <td><b>Mulai Berkembang</b></td>
                        <td><b>Sedang Berkembang</b></td>
                        <td><b>Berkembang Sesuai Harapan</b></td>
                        <td><b>Sangat Berkembang</b></td>
                    </tr>

                <?php }

                if ($id_dimensi_old != $nilai_projek[$a]['id_dimensi']) {
                    $id_dimensi_old = $nilai_projek[$a]['id_dimensi']; ?>
                    <tr class="merge-row">
                        <td colspan="6" style="text-align: left; background-color:#E2F3F4;"><b><?= $nilai_projek[$a]['dimensi'] ?></b></td>
                    </tr>
                <?php } ?>

                <tr style="text-align: center;">
                    <td style="text-align:center;vertical-align:top;width:30px;">-</td>
                    <td style="text-align:left;vertical-align:top;width:200px;"><?= $nilai_projek[$a]['sub_elemen'] ?>. <?= $nilai_projek[$a]['fase'] ?></td>
                    <td><?= ($nilai_projek[$a]['nilai'] == 1) ? "&#x2713" : "" ?></td>
                    <td><?= ($nilai_projek[$a]['nilai'] == 2) ? "&#x2713" : "" ?></td>
                    <td><?= ($nilai_projek[$a]['nilai'] == 3) ? "&#x2713" : "" ?></td>
                    <td><?= ($nilai_projek[$a]['nilai'] == 4) ? "&#x2713" : "" ?></td>
                </tr>
                <?php
                if ($nilai_projek[$a]['nilai'] != "")
                    $catatan = $catatan . $nilaikekalimat[$nilai_projek[$a]['nilai']] . " " . $nilai_projek[$a]['sub_elemen'] . ", ";
                if (((($a + 1) < $jmldata) && $id_projek_old != $nilai_projek[$a + 1]['id_projek']) || ($a + 1 == $jmldata)) { ?>
                    <tr class="merge-row">
                        <td colspan="6" style="text-align: left;">Catatan Proses:<br>
                            Dalam mengerjakan projek ini, <?= $namasiswa . " " . $catatan ?>
                        </td>
                    </tr>
            <?php    }
            }
            ?>
        </table>
    </div>

    <div class="tandatangan">
        <div class="ortu">
            Orang Tua / Wali,
            <br>
            <br>
            <br>
            <br>
            <br>
            <hr style='width:200px;text-align: left;border:0.5px solid black;margin-left:0'>
        </div>
        <div class="wali">
            <?php
            $tempat = str_replace('Kota ', '', $get_sekolah['kota']);
            $tempat = str_replace('Kab. ', '', $tempat);
            echo "<br>" . $tempat . ", " . format_tanggal($tglakhir)['panjang'] ?><br>
            Wali Kelas,
            <br>
            <br>
            <br>
            <br>
            <b><?= $nama_wali ?></b>
            <hr style='width:200px;text-align: left;border:0.5px solid black;margin-left:0'>
            NIP. <?= $nip_wali ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    var selectedNIS = "<?= $nis ?>";
    var valkelas = "<?= $valkelas ?>";

    $(document).ready(function() {
        //fetchNewData(selectedNIS);
    });

    $('#daftarsiswa').on('change', function() {
        updatepilihan();
    });

    $('#pilsemester').on('change', function() {
        updatepilihan();
    });

    function updatepilihan() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS, "_self");
    }

    function cetak_rapor() {
        var nis = document.getElementById('daftarsiswa').value;
        window.open("<?= base_url() . 'buatrapor/raporPDF?kelas=' ?>" + valkelas + "&nis=" + nis, "_blank");
    }

    function fetchNewData(selectedNIS) {
        fetch('<?= base_url() . "nilai/get_daftar_rapor_siswa?nis=" ?>' + selectedNIS)
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function lanjut() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS + "&rapor=p5", "_self");
    }

    function rapornilai() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS, "_self");
    }

    function cetak_rapor() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'buatrapor/raporPDF?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS, "_blank");
    }

    function updateTable(newData) {
        // var dataSet = [];
        // var nislama = "";
        // var nomor = 0;
        // var ntp = 0;

        // for (var i = 0; i < newData.length; i++) {
        //     var data = newData[i];
        //     snomor = ""
        //     nama = "";
        //     if (nislama != data.nis) {
        //         nislama = data.nis;
        //         ntp = 0;
        //         nomor++;
        //         snomor = nomor;
        //         nama = data.nama;
        //     }
        //     ntp++;
        //     stp = "IP-" + ntp;
        //     dataSet.push([i + 1, snomor, data.nis, nama, data.jenis_kelamin, data.alamat, data.telp, stp, data.nilai]);
        // }

        // $('#data-table').DataTable().destroy();

        // $('#data-table').DataTable({
        //     language: {
        //         url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
        //     },
        //     "aLengthMenu": [
        //         [15, -1],
        //         [15, "All"]
        //     ],
        //     data: dataSet,
        //     responsive: true,
        //     columnDefs: [{
        //             responsivePriority: 1,
        //             targets: 0
        //         },
        //         {
        //             responsivePriority: 3,
        //             targets: 2
        //         },
        //         {
        //             responsivePriority: 2,
        //             targets: -1
        //         }
        //     ],
        //     columns: [{
        //             title: 'Indeks'
        //         }, {
        //             title: 'No'
        //         }, {
        //             title: 'NIS'
        //         },
        //         {
        //             title: 'Nama',
        //         },
        //         {
        //             title: 'Jenis Kelamin'
        //         },
        //         {
        //             title: 'Alamat'
        //         },
        //         {
        //             title: 'No. Telp'
        //         },
        //         {
        //             title: 'IP *'
        //         },
        //         {
        //             title: 'Nilai',
        //             render: function(data, type, row) {
        //                 return '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="1" ' + (data === '1' ? 'checked' : '') + '>MB ' +
        //                     '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="2" ' + (data === '2' ? 'checked' : '') + '>SB ' +
        //                     '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="3" ' + (data === '3' ? 'checked' : '') + '>BSH ' +
        //                     '<input class="rbut" type="radio" name="keterangan_' + row[0] + '" value="4" ' + (data === '4' ? 'checked' : '') + '>SB';
        //             }
        //         }
        //     ]
        // });
    }

    // document.getElementById('tb_update').addEventListener('click', function() {

    //     var table = $('#data-table').DataTable();
    //     var dataToSend = [];
    //     var pilihankelas = document.getElementById('daftarkelas').value;

    //     table.rows().every(function(rowIdx, tableLoop, rowLoop) {
    //         var data = this.data();
    //         var NIS = data[2];
    //         var indikator = data[7];

    //         var radioElement = document.querySelector('input[name="keterangan_' + data[0] + '"]:checked');
    //         var selectedValue = radioElement ? radioElement.value : '0';

    //         dataToSend.push({
    //             NIS: NIS,
    //             nilai: selectedValue,
    //             indikator: indikator.substring(3, 4),
    //         });

    //     });

    //     var postData = {
    //         pilihankelas: pilihankelas,
    //         idekskul: idekskul,
    //         dataToSend: dataToSend
    //     };

    //     // alert(JSON.stringify(postData));

    //     fetch('<?php //= base_url("nilai/simpan_nilai_eks") 
                    ?>', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify(postData)
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             // alert(JSON.stringify(data));
    //             $('#tb_update').hide();
    //             $('#info_update').show();
    //             setTimeout(function() {
    //                 $('#info_update').hide();
    //             }, 2000);
    //         })
    //         .catch(error => console.error('Gagal menyimpan data:', error));
    // });

    // $('#data-table').on('draw.dt', function() {
    //     $('.rbut').change(function() {
    //         $('#tb_update').show();
    //         $('#info_update').hide();
    //     });
    // });
</script>

<?= $this->endSection(); ?>
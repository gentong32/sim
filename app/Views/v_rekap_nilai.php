<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>

<style>
    .rapor_container {
        margin: auto;
        border: 0.5px solid black;
        margin-top: 0px;
        margin-bottom: 20px;
        background-color: azure;
        box-sizing: content-box;
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
        padding: 20px;

    }

    .daftar_nilai table tr td {
        font-size: 14px;
        line-height: 14px;
        border: 0.5px solid black;
    }


    .daftar_nilai table td:nth-child(2) {
        text-align: center;
        padding-left: 0px;
    }

    .daftar_nilai table thead tr:nth-child(1) td {
        text-align: center;
        padding-left: 7px;
        padding-right: -12px;
    }

    .infomp {
        margin-left: 20px;
        margin-bottom: 20px;
    }

    .infomp table tr td {
        font-size: 12px;
        text-align: left;
        line-height: 14px;
        border: 0.5px solid black;
        padding: 2px;

    }

    .infomp table {
        border-collapse: collapse;
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

    .pilihan {
        margin: auto;
        margin-bottom: 10px;
        padding: 5px;
    }

    .tombol_atas_rapor {
        max-width: 700px;
        width: 100%;
        margin: auto;
        text-align: left;
        margin-bottom: 5px;
    }

    .kanan {
        text-align: right;
        padding-right: 8px !important;
    }

    .tengah {
        text-align: center;
    }

    .kiri {
        text-align: left;
    }

    div.dt-container {
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        padding: 0px;
    }

    div.dt-scroll-head {
        text-align: left;
        padding: 0px;
    }

    div.dt-scroll-body {
        text-align: left;
        padding: 0px;
    }

    .action-buttons {
        display: none;
    }

    .kenaikan-dropdown {
        height: 30px;
    }

    .btn-ok {
        background-color: #41B55C;
        color: #fff;
        padding: 5px;
        margin-bottom: 10px;
        border: 0.5px solid black;
        border-radius: 5px;
    }

    .btn-cancel {
        background-color: #E74C3C;
        color: #fff;
        padding: 4px;
        margin-bottom: 10px;
        border: 0.5px solid black;
        border-radius: 3px;
    }
</style>
</style>
<link rel="stylesheet" href="<?= base_url() ?>css/s_presensi.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css">
<?= $this->endSection() ?>


<?= $this->section('konten') ?>

<?php
$txtnaik = array("", "naik", "tidak naik");
?>

<div style="margin:0px;">
    <h2>REKAP NILAI SISWA</h2>
    <h3>Kelas <?= $rombel ?></h3>
    <select class="pilihan" name="pilsemester" id="pilsemester">
        <option <?= ($semester == "1") ? "selected" : "" ?> value="1">SEMESTER GANJIL</option>
        <option <?= ($semester == "2") ? "selected" : "" ?> value="2">SEMESTER GENAP</option>
    </select>
    <select class="pilihan" name="pildetil" id="pildetil">
        <option <?= ($detil == "false") ? "selected" : "" ?> value="false">NON DETIL</option>
        <option <?= ($detil == "true") ? "selected" : "" ?> value="true">DETIL</option>
    </select>
</div>

<div class="tombol_atas_rapor">
    <button onclick="rapor_siswa()" class="tb_biru">Rapor Siswa</button>
</div>

<div class="rapor_container">
    <div class="daftar_nilai">
        <table id="myTable">
            <thead>
                <tr>
                    <td style="width:30px;"><b>No</b></td>
                    <td><b>NIS</b></td>
                    <td><b>Nama</b></td>
                    <?php
                    if ($detil == "true") {
                        for ($a = 1; $a <= $total_mapel; $a++) :
                            echo "<td style='width:30px;'>MP" . $a . "</td>\n";
                        endfor;
                    } ?>
                    <td><b>Nilai</b></td>
                    <td><b>Catatan</b></td>
                    <?php if ($semester == 2) : ?>
                        <td><b>Kenaikan</b></td>
                    <?php endif ?>
                </tr>
            </thead>
            <?php
            $nomor = 0;
            $nomor2 = 0;
            $sekali1 = 0;
            $sekali2 = 0;
            $nis_old = "";
            $totalbaris = sizeof($rekap_nilai);
            for ($a = 0; $a < $totalbaris; $a++) :
                if ($nis_old != $rekap_nilai[$a]['nis']) {
                    $nis_old = $rekap_nilai[$a]['nis'];
                    $nomor2 = 0;
                    $nomor++;
                    echo "<tr data-nisn='" . $rekap_nilai[$a]['nisn'] . "'><td>" . $nomor . "</td><td>" . $rekap_nilai[$a]['nis'] . "</td><td>" . $rekap_nilai[$a]['nama'] . "</td>";
                }
                if ($detil == "true") {
                    echo "<td class='kanan'>" . number_format($rekap_nilai[$a]['nilai_akhir'], 1, ',', '.') . "</td>\n";
                }

                $catatan = ($semester == "1") ? $rekap_nilai[$a]['catatan_ganjil'] : $rekap_nilai[$a]['catatan_genap'];
                $inputcatatan = '<textarea style="height: 50px; width: 250px;" class="catatan-input" data-initial-value="' . $catatan . '">' . $catatan . '</textarea>
                    <div class="action-buttons">
                        <button class="btn-ok">OK</button>
                        <button class="btn-cancel">Batal</button>
                    </div>';
                $nomor2++;
                if ($nomor2 == $total_mapel) {
                    echo "<td>" . number_format($rekap_nilai[$a]['total_nilai'], 1, ',', '.') . "</td>";
                    echo "<td>" . $inputcatatan . "</td>";
                    if ($semester == 2) {
                        $selected1 = ($rekap_nilai[$a]['status_naik'] != "2") ? "selected" : "";
                        $selected2 = ($rekap_nilai[$a]['status_naik'] == "2") ? "selected" : "";
                        $inputkenaikan = '<select class="kenaikan-dropdown" data-initial-value="' . $rekap_nilai[$a]['status_naik'] . '">
                        <option ' . $selected1 . ' value="1">Naik</option>
                        <option ' . $selected2 . ' value="2">Tidak Naik</option>
                    </select>';
                        echo "<td>" . $inputkenaikan . "</td>\n";
                    }
                }

                if (($a < $totalbaris - 1) && $nis_old != $rekap_nilai[$a + 1]['nis']) {
                    echo "</tr>\n";
                }

                if ($a == $totalbaris - 1) {
                    echo "</tr>\n";
                }
            endfor; ?>
        </table>
    </div>

    <?php if ($detil == "true") : ?>
        <div class="infomp">
            <table>
                <tr>
                    <td>Kode MP</td>
                    <td>Nama Mata Pelajaran</td>
                </tr>
                <?php
                $nomor = 0;
                foreach ($mapel_sekolah as $row) {
                    $nomor++;
                    echo "<tr>";
                    echo "<td>MP" . $nomor . "</td>";
                    echo "<td>" . $row['nama_mapel'] . "</td>";
                }
                ?>
            </table>
        </div>
    <?php endif ?>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script') ?>

<script src=" https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script>
    var valkelas = "<?= $val_kelas ?>";
    var nilaiAwal;
    var nilaiAwal2;
    var nilaiSaatIni;

    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollX": true,
            "responsive": false,
            scrollCollapse: true,
            "lengthChange": false,
            "searching": false,
            "info": false,
            "paging": false
        });

        $('.catatan-input').on('input', function() {
            nilaiAwal = $(this).data('initial-value');
            nilaiSaatIni = $(this).val();

            if (nilaiAwal !== nilaiSaatIni) {
                $(this).closest('td').find('.action-buttons').show();
            } else {
                $(this).closest('td').find('.action-buttons').hide();
            }
        });

        $('.kenaikan-dropdown').on('change', function() {
            nilaiAwal = $(this).closest('tr').find('.catatan-input').data('initial-value');
            nilaiAwal2 = $(this).data('initial-value');
            $(this).closest('tr').find('.catatan-input').siblings('.action-buttons').show();

        });

        $('.btn-ok').click(function() {
            var nisn = $(this).closest('tr').data('nisn');
            var catatan = $(this).closest('tr').find('.catatan-input').val();
            var kenaikan = $(this).closest('tr').find('.kenaikan-dropdown').val();

            var postData = {
                nisn: nisn,
                catatan: catatan,
                kenaikan: kenaikan,
                semester: <?= $semester ?>
            };

            fetch('<?= base_url("nilai/simpanrekap") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(postData)
                })
                .then(response => response.json())
                .then(data => {
                    // alert(JSON.stringify(data));
                    $(this).closest('td').find('.action-buttons').hide();
                    // setTimeout(function() {
                    //     $('#info_update').hide();
                    // }, 2000);
                })
                .catch(error => console.error('Gagal menyimpan data:', error));

        });

        // Event handler untuk tombol Batal
        $('.btn-cancel').click(function() {
            if (nilaiAwal2 == "")
                nilaiAwal2 = 1;
            $(this).closest('tr').find('.catatan-input').val(nilaiAwal);
            $(this).closest('tr').find('.kenaikan-dropdown').val(nilaiAwal2);
            $(this).closest('td').find('.action-buttons').hide();
        });

    });

    $('#pilsemester').on('change', function() {
        updatepilihan();
    });

    $('#pildetil').on('change', function() {
        updatepilihan();
    });

    function updatepilihan() {
        selectedSemester = $('#pilsemester').val();
        selectedDetil = $('#pildetil').val();
        window.open("<?= base_url() . 'nilai/rekap_nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&detil=" + selectedDetil, "_self");
    }

    function rapor_siswa() {
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas, "_self");
    }
</script>

<?= $this->endSection(); ?>
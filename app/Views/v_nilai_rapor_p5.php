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
    <button onclick="rapornilai()" class="tb_biru">Rapor Nilai</button>
</div>

<div class="rapor_container">
    <div class="kop_rapor">
        <?= $kop_rapor ?>
    </div>
    <hr style="border: 0.5px solid #111;  width:680px;">
    <div class="judul_rapor">
        <p>RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA</p>
        <p><?= $judulsemester ?></p>
        <p>TAHUN PELAJARAN 2023/2024</p>
    </div>
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

    <div class="cprojek">
        <?php
        $nomor = 0;
        foreach ($datfar_projek as $row) {
            $nomor++;
            echo "<b>Projek $nomor | " . $row['nama_projek'] . "</b><br>";
            echo $row['deskripsi_projek'] . "<br><br>";
        }
        ?>
    </div>

    <div class="tb_container">
        <button class="ok" onclick="lanjut()">Selanjutnya</button>
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

    function lanjut() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS + "&rapor=p5b", "_self");
    }

    function rapornilai() {
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'nilai?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS, "_self");
    }
</script>

<?= $this->endSection(); ?>
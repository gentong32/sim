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
$jumlah_s = "-";
$jumlah_i = "-";
$jumlah_a = "-";
if ($absensi) {
    $jumlah_s = ($absensi['Jumlah_S'] == 0) ? "-" : $absensi['Jumlah_S'];
    $jumlah_i = ($absensi['Jumlah_I'] == 0) ? "-" : $absensi['Jumlah_I'];
    $jumlah_a = ($absensi['Jumlah_A'] == 0) ? "-" : $absensi['Jumlah_A'];
}

$kelakuan = "";
$kerajinan = "";
$kerapihan = "";
$kebersihan = "";

if ($kepribadian) {
    $kelakuan = $kepribadian['kelakuan' . $suffiks];
    $kerajinan = $kepribadian['kerajinan' . $suffiks];
    $kerapihan = $kepribadian['kerapihan' . $suffiks];
    $kebersihan = $kepribadian['kebersihan' . $suffiks];
}

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
</div>

<div class="rapor_container">
    <div class="kop_rapor">
        <?= $kop_rapor ?>
    </div>
    <hr style="border: 0.5px solid #111;  width:680px;">
    <div class="judul_rapor">
        <p>LEMBAR HASIL KEGIATAN BELAJAR</p>
        <p><?= $judulsemester ?></p>
        <p>TAHUN PELAJARAN <?= tahun_ajaran('lengkap') ?></p>
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

    <div class="daftar_nilai">
        <table>
            <tr>
                <td rowspan="2" style="width:30px;"><b>No</b></td>
                <td rowspan="2" style="width:450px;"><b>Mata Pelajaran</b></td>
                <td colspan="<?= $maks_kolom ?>" style="width:<?= $maks_kolom * 40 ?>px;"><b>Nilai Hasil Belajar</b></td>
            </tr>
            <tr>
                <?php for ($a = 1; $a <= $maks_kolom; $a++) : ?>
                    <td style="width:40px;"><?= $a ?></td>
                <?php endfor ?>
            </tr>

            <?php
            $nomor = 0;
            $nomor2 = 0;
            $sekali1 = 0;
            $sekali2 = 0;
            foreach ($rapor_siswa as $row) :
                if ($row['jenis'] == 0) {
                    if ($sekali1 == 0) {
                        $sekali1 = 1; ?>
                        <tr>
                            <td><b>A.</b> </td>
                            <td><b>MATA PELAJARAN UMUM</b></td>
                            <td></td>
                        </tr>
                    <?php }
                    $string = $row['nama_mapel'];
                    $substring = $agamasiswa;
                    if (strstr($string, $substring)) {
                        $nomor++; ?>
                        <tr>
                            <td><?= $nomor ?></td>
                            <td><?= $row['nama_mapel'] ?></td>
                            <?php if ($maks_kolom == 0) {
                                echo "<td>-</td>";
                            } else {
                                for ($a = 1; $a <= $maks_kolom; $a++) : ?>
                                    <td><?= (is_null($row['tugas_' . $a]) ? '-' : $row['tugas_' . $a]) ?></td>
                            <?php endfor;
                            }
                            ?>

                        </tr>
                    <?php }
                } else if ($row['jenis'] == 1) {
                    $nomor++;
                    ?>
                    <tr>
                        <td><?= $nomor ?></td>
                        <td><?= $row['nama_mapel'] ?></td>
                        <?php if ($maks_kolom == 0) {
                            echo "<td>-</td>";
                        } else {
                            for ($a = 1; $a <= $maks_kolom; $a++) : ?>
                                <td><?= (is_null($row['tugas_' . $a]) ? '-' : $row['tugas_' . $a]) ?></td>
                        <?php endfor;
                        } ?>
                    </tr>
                    <?php } else if ($row['jenis'] == 2) {
                    if ($sekali2 == 0) {
                        $sekali2 = 1; ?>
                        <tr>
                            <td><b>B.</b></td>
                            <td><b>MATA PELAJARAN PILIHAN</b></td>
                            <td></td>
                        </tr>
                    <?php }
                    $nomor2++;
                    ?>
                    <tr>
                        <td><?= $nomor2 ?></td>
                        <td><?= $row['nama_mapel'] ?></td>
                        <?php if ($maks_kolom == 0) {
                            echo "<td>-</td>";
                        } else {
                            for ($a = 1; $a <= $maks_kolom; $a++) : ?>
                                <td><?= (is_null($row['tugas_' . $a]) ? '-' : $row['tugas_' . $a]) ?></td>
                        <?php endfor;
                        } ?>
                    </tr>
            <?php }
            endforeach; ?>

        </table>
    </div>
    <div class="ketdanlaku">
        <div class="daftar_nilai">
            <table>
                <tr>
                    <td colspan="3"><b>KETIDAKHADIRAN</b></td>
                </tr>
                <tr>
                    <td style="width:30px; text-align:center;"><b>No</b></td>
                    <td style="width:140px; text-align: center;"><b>Alasan</b></td>
                    <td style="width:100px; text-align: center; "><b>Jumlah</b></td>
                </tr>
                <tr>
                    <td style="text-align:center;">1</td>
                    <td style="text-align: left;"> Sakit</td>
                    <td style="text-align: center; "><?= $jumlah_s ?> hari</td>
                </tr>
                <tr>
                    <td style="text-align:center;">2</td>
                    <td style="text-align: left;"> Ijin</td>
                    <td style="text-align: center; "><?= $jumlah_i ?> hari</td>
                </tr>
                <tr>
                    <td style="text-align:center;">3</td>
                    <td style="text-align: left;"> Tanpa Keterangan</td>
                    <td style="text-align: center; "><?= $jumlah_a ?> hari</td>
                </tr>
                <tr>
                </tr>
            </table>
        </div>
        <div class="daftar_nilai">
            <table>
                <tr>
                    <td colspan="3"><b>KEPRIBADIAN</b></td>
                </tr>
                <tr>
                    <td style="width:30px; text-align:center;"><b>No</b></td>
                    <td style="width:150px; text-align: center;"><b>Aspek</b></td>
                    <td style="width:100px; text-align: center; "><b>Keterangan</b></td>
                </tr>
                <tr>
                    <td style="text-align:center;">1</td>
                    <td style="text-align: left;"> Kelakuan</td>
                    <td style="text-align: center; "><?= ($kelakuan != "") ? $nilaipribadi[$kelakuan] : "-" ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;">2</td>
                    <td style="text-align: left;"> Kerajinan/kedisiplinan</td>
                    <td style="text-align: center; "><?= ($kerajinan != "") ? $nilaipribadi[$kerajinan] : "-" ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;">3</td>
                    <td style="text-align: left;"> Kerapihan</td>
                    <td style="text-align: center; "><?= ($kerapihan != "") ? $nilaipribadi[$kerapihan] : "-" ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;">4</td>
                    <td style="text-align: left;"> Kebersihan</td>
                    <td style="text-align: center; "><?= ($kebersihan != "") ? $nilaipribadi[$kebersihan] : "-" ?></td>
                </tr>
                <tr>
                </tr>
            </table>
        </div>
    </div>
    <div class="catatan">
        <b>Catatan :</b>
        <br>
        A = Istimewa &nbsp;&nbsp;&nbsp; B = Baik &nbsp;&nbsp;&nbsp; C = Cukup &nbsp;&nbsp;&nbsp; D = Kurang &nbsp;&nbsp;&nbsp;
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
            Diberikan di: <?php
                            $tempat = str_replace('Kota ', '', $get_sekolah['kota']);
                            $tempat = str_replace('Kab. ', '', $tempat);
                            echo $tempat; ?><br>
            Pada tanggal: <?= format_tanggal($tglakhir)['panjang'] ?><br>
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
        selectedNIS = $('#daftarsiswa').val();
        selectedSemester = $('#pilsemester').val();
        window.open("<?= base_url() . 'buatrapor/raporPDF?kelas=' ?>" + valkelas + "&semester=" + selectedSemester + "&nis=" + selectedNIS, "_blank");
    }

    function fetchNewData(selectedNIS) {
        fetch('<?= base_url() . "nilai/get_daftar_rapor_siswa?nis=" ?>' + selectedNIS)
            .then(response => response.json())
            .then(data => {
                updateTable(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTable(newData) {

    }
</script>

<?= $this->endSection(); ?>
<?php

// controllers/PdfController.php

namespace App\Controllers;

use App\Models\M_sekolah;
use App\Models\M_user;
use App\Libraries\Pdf;

class Buatrapor extends BaseController
{

    function __construct()
    {
        $this->M_sekolah = new M_sekolah();
        $this->M_user = new M_user();
    }

    public function raporPDF()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
        $valkelas = $this->request->getVar('kelas');
        $nis = $this->request->getVar('nis');
        $idx = substr($valkelas, 1, 1);
        $id_sekolah = session()->get('id_sekolah');
        $kelas = $daftarkelasajar[$idx - 1]['kelas'];
        $sub_kelas = $daftarkelasajar[$idx - 1]['sub_kelas'];
        $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];

        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel);
        // echo var_dump($getdaftarsiswa);
        $adasiswa = "-";
        foreach ($getdaftarsiswa as $row) {
            if ($row['nis'] == $nis) {
                $adasiswa = $nis;
                $namasiswa = $row['nama'];
                $nissiswa = $row['nis'];
                $nisnsiswa = $row['nisn'];
                $agamasiswa = $row['agama'];
            }
        }

        if ($adasiswa != "-") {
            $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
            $tglawalganjil = $infosekolah['tgl_awal_ganjil'];
            $tglmidganjil = $infosekolah['tgl_mid_ganjil'];
            $maks_kolom = $this->M_user->get_max_kolom_nilai_mid($id_sekolah, $kelas, $sub_kelas, tahun_ajaran(), $tglawalganjil, $tglmidganjil);
            $get_rapor_nilai = $this->M_user->rapor_nilai_mid($id_sekolah, $kelas, $sub_kelas, $nisnsiswa, $maks_kolom, tahun_ajaran(), $tglawalganjil, $tglmidganjil);
            $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
            $kop_rapor = $info_sekolah['kop_rapor'];
            $tglawalganjil = $infosekolah['tgl_awal_ganjil'];
            $tglmidganjil = $infosekolah['tgl_mid_ganjil'];

            $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());

            $awgj = $infosekolah['tgl_awal_ganjil'];
            $mdgj = $infosekolah['tgl_mid_ganjil'];
            $akgj = $infosekolah['tgl_rapor_ganjil'];
            $awgn = $infosekolah['tgl_awal_genap'];
            $mdgn = $infosekolah['tgl_mid_genap'];
            $akgn = $infosekolah['tgl_rapor_genap'];

            $pilihsemester = $this->request->getVar('semester');
            if (!isset($pilihsemester)) {
                $tg_sekarang = date("Y-m-d");
                if ($tg_sekarang <= $akgn)
                    $pilihsemester = "raporgenap";
                if ($tg_sekarang <= $mdgn)
                    $pilihsemester = "midgenap";
                if ($tg_sekarang <= $akgj)
                    $pilihsemester = "raporganjil";
                if ($tg_sekarang <= $mdgj)
                    $pilihsemester = "midganjil";
            }

            if ($pilihsemester == "midganjil") {
                $tglawal = $awgj;
                $tglakhir = $mdgj;
                $judulsemester = "TENGAH SEMESTER GANJIL";
            } else if ($pilihsemester == "raporganjil") {
                $tglawal = $mdgj;
                $tglakhir = $akgj;
                $judulsemester = "AKHIR SEMESTER GANJIL";
            } else if ($pilihsemester == "midgenap") {
                $tglawal = $awgn;
                $tglakhir = $mdgn;
                $judulsemester = "TENGAH SEMESTER GENAP";
            } else if ($pilihsemester == "raporgenap") {
                $tglawal = $mdgn;
                $tglakhir = $akgn;
                $judulsemester = "AKHIR SEMESTER GENAP";
            }

            $absensi = $this->M_user->get_absensi($id_sekolah, $nisnsiswa, $tglawal, $tglakhir);
            $kepribadian = $this->M_user->get_pribadi($id_sekolah, $nisnsiswa, tahun_ajaran());
            $get_sekolah = $this->M_sekolah->getSekolah($id_sekolah);
            $get_datawali = $this->M_user->getDataGuru($id_user);
            $nama_wali = $get_datawali['nama'];
            $nip_wali = $get_datawali['nip'];

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
                $kelakuan = $kepribadian['kelakuan_mid_ganjil'];
                $kerajinan = $kepribadian['kerajinan_mid_ganjil'];
                $kerapihan = $kepribadian['kerapihan_mid_ganjil'];
                $kebersihan = $kepribadian['kebersihan_mid_ganjil'];
            }
            // echo var_dump($info_sekolah);
            // die();
            $data['maks_kolom'] = $maks_kolom;
            $data['rapor_siswa'] = $get_rapor_nilai;
            $data['kop_rapor'] = $kop_rapor;

            $pdf = new Pdf();
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(5, 10, 0);

            $pdf->AddPage();
            $kop_rapor = str_replace("Comic Sans MS", "comicsansms3", $kop_rapor);
            $kop_rapor = str_replace("Arial,Helvetica,sans-serif", "arial", $kop_rapor);
            $kop_rapor = str_replace("Courier New,Courier,monospace", "courier", $kop_rapor);
            $kop_rapor = str_replace("Georgia,serif", "georgia", $kop_rapor);
            $kop_rapor = str_replace("Lucida Sans Unicode,Lucida Grande,sans-serif", "lucida", $kop_rapor);
            $kop_rapor = str_replace("Tahoma,Geneva,sans-serif", "tahoma", $kop_rapor);
            $kop_rapor = str_replace("Times New Roman,Times,serif", "times", $kop_rapor);
            $kop_rapor = str_replace("Trebuchet MS,Helvetica,sans-serif", "trebuchet", $kop_rapor);
            $kop_rapor = str_replace("Verdana,Geneva,sans-serif", "verdana", $kop_rapor);
            $html = "<style>p{line-height:0px;}</style>" . $kop_rapor . "<br>";

            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->Cell(0, 5, 'LEMBAR HASIL KEGIATAN BELAJAR', 0, true, 'C', 0, '', 0, false, 'T', 'T');
            $pdf->Cell(0, 5, 'TENGAH SEMESTER GANJIL', 0, true, 'C', 0, '', 0, false, 'T', 'T');
            $pdf->Cell(0, 10, 'TAHUN PELAJARAN 2023/2024', 0, true, 'C', 0, '', 0, false, 'T', 'T');

            $namaniskelas = '<br><div>
            <table id="namasiswa" border="0">
            <tr>
                    <td style="width:80px">N a m a</td>
                    <td style="width:10px;">:</td>
                    <td style="width:200px;">' . $namasiswa . '</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">NIS / NISN</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">' . $nis . ' / ' . $nisnsiswa . '</td>
                </tr><tr>
                    <td style="padding: 5px;">Kelas</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">' . $nama_rombel . '</td>
                    </tr>
                    </table></div>';

            $pdf->writeHTML($namaniskelas, true, false, true, true, 'L');
            $posisiY = $pdf->GetY() + 2;
            $posisihmapel = intval((((530 - ($maks_kolom * 40)) / 2) - 10) / 2.667);
            // echo $posisihmapel;
            // die();

            if ($maks_kolom == 0)
                $maks_kolom = 1;

            $kolomheadernilai = "";
            for ($a = 1; $a <= $maks_kolom; $a++) {
                $kolomheadernilai = $kolomheadernilai .
                    '<td style="width:40px; text-align: center;">' . $a . '</td>';
            }

            if ($kelas >= 11) {
                $dafnilai = '<tr>
                    <td style="width:30px;text-align:center"><b>A.</b></td>
                    <td style="width:' . (530 - ($maks_kolom * 40)) . 'px;"> <b>Mata Pelajaran Umum</b></td>
                    </tr>';
            } else {
                $dafnilai = '';
            }

            $nomor = 0;
            $nomor2 = 0;
            $sekali = true;
            foreach ($get_rapor_nilai as $row) :
                if ($row['jenis'] == 0) {
                    $string = $row['nama_mapel'];
                    $substring = $agamasiswa;
                    if (strstr($string, $substring)) {
                        $nomor++;
                        $koltugas = "";
                        if ($maks_kolom == 0) {
                            $koltugas = $koltugas . "<td>-</td>";
                        } else {
                            for ($a = 1; $a <= $maks_kolom; $a++) :
                                $koltugas = $koltugas . "
                                <td style=\"text-align: center;\">" . (is_null($row['tugas_' . $a]) ? '' : $row['tugas_' . $a]) . "</td>";
                            endfor;
                        }
                        $dafnilai = $dafnilai . "
                        <tr>
                            <td style=\"text-align: center;\">" . $nomor . "</td>
                            <td style=\"padding-left: 5px;\"> " . $row['nama_mapel'] . "</td>" .
                            $koltugas . "                           
                        </tr>
                        ";
                    }
                } else {
                    $nomor++;
                    $nomornya = $nomor;
                    if ($row['jenis'] == 2) {
                        $nomor2++;
                        $nomornya = $nomor2;
                    }
                    if ($row['jenis'] == 2 && $sekali == true) {
                        $sekali = false;
                        $dafnilai = $dafnilai . '<tr>
                    <td style="width:30px;text-align:center"><b>B.</b></td>
                    <td style="font-weight:bold;width:' . (530 - ($maks_kolom * 40)) . 'px;"> Mata Pelajaran Pilihan</td>
                    </tr>';
                    }

                    $koltugas = "";
                    if ($maks_kolom == 0) {
                        $koltugas = $koltugas . "<td>-</td>";
                    } else {
                        for ($a = 1; $a <= $maks_kolom; $a++) :
                            $koltugas = $koltugas . "
                                <td style=\"text-align: center;\">" . (is_null($row['tugas_' . $a]) ? '' : $row['tugas_' . $a]) . "</td>";
                        endfor;
                    }
                    $dafnilai = $dafnilai . "
                        <tr>
                            <td style=\"text-align: center;\">" . $nomornya . "</td>
                            <td style=\"padding-left: 5px;\"> " . $row['nama_mapel'] . "</td>" .
                        $koltugas . "                           
                        </tr>
                        ";
                }
            endforeach;

            $tabelnilai = '
            <table border="1">
                <tr>
                    <td rowspan="2" style="width:30px;"></td>
                    <td rowspan="2" style="width:' . (530 - ($maks_kolom * 40)) . 'px;"></td>
                    <td colspan="' . $maks_kolom . '" style="width:' . ($maks_kolom * 40) . 'px; text-align: center; font_weight:bold">Nilai Hasil Belajar</td>
                </tr>
                <tr>
                    ' . $kolomheadernilai . '
                </tr>' . $dafnilai .
                '</table><br>';

            // echo $namaniskelas;
            // die();

            $pdf->writeHTML($tabelnilai, true, false, true, true, 'L');
            $akhirY = $pdf->getY();
            $pdf->SetXY(8, $posisiY);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 0, 'No', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $pdf->SetXY($posisihmapel, $posisiY);
            $pdf->Cell(0, 0, 'Mata Pelajaran ', 0, true, 'L', 0, '', 0, false, 'T', 'T');


            // KETIDAKHADIRAN
            $tabelnilai = '
            <table border="1">
            <tr>
            <td colspan="3" style="width:260px; text-align:center;"><b>KETIDAKHADIRAN</b></td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;"><b>No</b></td>
                <td style="width:130px; text-align: center;"><b>Alasan</b></td>
                <td style="width:100px; text-align: center; "><b>Jumlah</b></td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">1</td>
                <td style="width:130px; text-align: left;"> Sakit</td>
                <td style="width:100px; text-align: center; ">' . $jumlah_s . ' hari</td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">2</td>
                <td style="width:130px; text-align: left;"> Ijin</td>
                <td style="width:100px; text-align: center; ">' . $jumlah_i . ' hari</td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">3</td>
                <td style="width:130px; text-align: left;"> Tanpa Keterangan</td>
                <td style="width:100px; text-align: center; ">' . $jumlah_a . ' hari</td>
            </tr>
            </table><br>';

            $pdf->SetFont('times', 12);
            $pdf->SetY($akhirY);
            $pdf->writeHTML($tabelnilai, true, false, true, true, 'L');


            // KEPRIBADIAN
            $tabelnilai = '
            <table border="1">
            <tr>
            <td colspan="3" style="width:260px; text-align:center;"><b>KEPRIBADIAN</b></td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;"><b>No</b></td>
                <td style="width:130px; text-align: center;"><b>Aspek</b></td>
                <td style="width:100px; text-align: center; "><b>Keterangan</b></td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">1</td>
                <td style="width:130px; text-align: left;"> Kelakuan</td>
                <td style="width:100px; text-align: center; ">' . $kelakuan . '</td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">2</td>
                <td style="width:130px; text-align: left;"> Kerajinan/Kedisiplinan</td>
                <td style="width:100px; text-align: center; ">' . $kerajinan . '</td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">3</td>
                <td style="width:130px; text-align: left;"> Kerapihan</td>
                <td style="width:100px; text-align: center; ">' . $kerapihan . '</td>
            </tr>
            <tr>
                <td style="width:30px; text-align:center;">4</td>
                <td style="width:130px; text-align: left;"> Kebersihan</td>
                <td style="width:100px; text-align: center; ">' . $kebersihan . '</td>
            </tr>
            </table><br>';

            $pdf->SetFont('times', 12);
            $pdf->SetXY(111, $akhirY);
            $pdf->writeHTML($tabelnilai, true, false, true, true, 'L');

            $akhirY = $pdf->getY();
            $pdf->SetXY(5, $akhirY);
            $pdf->SetFont('times', 'BI', 12);
            $pdf->Cell(0, 0, 'Catatan', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $akhirY = $pdf->getY();
            $pdf->SetXY(5, $akhirY);
            $pdf->SetFont('times', 'I', 12);
            $pdf->Cell(0, 0, 'A = Istimewa    B = Baik    C = Cukup     D = Kurang', 0, true, 'L', 0, '', 0, false, 'T', 'T');

            $tempat = str_replace('Kota ', '', $get_sekolah['kota']);
            $tempat = str_replace('Kab. ', '', $tempat);
            $tanggal = format_tanggal($tglmidganjil)['panjang'];

            $poskanan = 130;

            $akhirY = $pdf->getY();
            $pdf->SetFont('times', 12);
            $pdf->SetXY($poskanan, $akhirY);
            $pdf->Cell(0, 0, 'Diberikan di: ' . $tempat, 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $akhirY = $pdf->getY();
            $pdf->SetXY($poskanan, $akhirY);
            $pdf->Cell(0, 0, 'Pada tanggal: ' . $tanggal, 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $akhirY = $pdf->getY();
            $pdf->SetXY(5, $akhirY);
            $pdf->Cell(0, 0, 'Orang Tua / Wali,', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $pdf->SetXY($poskanan, $akhirY);
            $pdf->Cell(0, 0, 'Wali Kelas,', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $akhirY = $pdf->getY();
            $pdf->SetXY($poskanan, $akhirY + 18);
            $pdf->SetFont('times', 'B', 12);
            $pdf->Cell(0, 0, $nama_wali, 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $pdf->SetFont('times', '', 12);
            $akhirY = $pdf->getY();
            $pdf->SetXY(5, $akhirY - 5);
            $pdf->Cell(0, 0, '________________________', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $pdf->SetXY($poskanan, $akhirY - 5);
            $pdf->Cell(0, 0, '________________________', 0, true, 'L', 0, '', 0, false, 'T', 'T');
            $akhirY = $pdf->getY();
            $pdf->SetXY($poskanan, $akhirY);
            $pdf->Cell(0, 0, 'NIP. ' . $nip_wali, 0, true, 'L', 0, '', 0, false, 'T', 'T');

            $pdf->Output('example.pdf', 'I'); // 'D' untuk unduh, 'I' untuk tampilkan di browser

            exit();
        } else {
            echo "TIDAK VALID! SILAKAN LOGIN LAGI SEBAGAI WALI KELAS!";
        }
    }
}

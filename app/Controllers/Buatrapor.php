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

        $idx = substr($valkelas, 1, 1);
        $id_sekolah = session()->get('id_sekolah');
        $kelas = $daftarkelasajar[$idx - 1]['kelas'];
        $sub_kelas = $daftarkelasajar[$idx - 1]['sub_kelas'];
        $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];

        $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel);

        $nispilihan = $this->request->getVar('nis');
        if (isset($nispilihan))
            $nis = $nispilihan;
        else
            $nis = $getdaftarsiswa[0]['nis'];
        $data['nis'] = $nis;
        $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $data['nis']);
        $nisn = $datasiswa['nisn'];

        $semester = $this->request->getVar('semester');
        $marginbawah = $this->request->getVar('mb');
        if (!isset($marginbawah))
            $marginbawah = 0;

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
            $kop_rapor = $infosekolah['kop_rapor'];
            $tglawalganjil = $infosekolah['tgl_awal_ganjil'];
            $tglmidganjil = $infosekolah['tgl_mid_ganjil'];

            $maks_kolom = $this->M_user->get_max_kolom_nilai($id_sekolah, $kelas, $sub_kelas, tahun_ajaran(), $tglawalganjil, $tglmidganjil);

            $awgj = $infosekolah['tgl_awal_ganjil'];
            $mdgj = $infosekolah['tgl_mid_ganjil'];
            $akgj = $infosekolah['tgl_rapor_ganjil'];
            $awgn = $infosekolah['tgl_awal_genap'];
            $mdgn = $infosekolah['tgl_mid_genap'];
            $akgn = $infosekolah['tgl_rapor_genap'];

            $pilihsemester = $this->request->getVar('semester');
            $rapor = $this->request->getVar('rapor');

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

            if (!isset($rapor)) {
                $rapor = "";
            }

            if ($pilihsemester == "midganjil") {
                $tglawal = $awgj;
                $tglakhir = $mdgj;
                $judulsemester = "TENGAH SEMESTER GANJIL";
                $suffiks = "_mid_ganjil";
            } else if ($pilihsemester == "raporganjil") {
                $tglawal = $mdgj;
                $tglakhir = $akgj;
                $judulsemester = "AKHIR SEMESTER GANJIL";
                $suffiks = "_akhir_ganjil";
            } else if ($pilihsemester == "midgenap") {
                $tglawal = $awgn;
                $tglakhir = $mdgn;
                $judulsemester = "TENGAH SEMESTER GENAP";
                $suffiks = "_mid_genap";
            } else if ($pilihsemester == "raporgenap") {
                $tglawal = $mdgn;
                $tglakhir = $akgn;
                $judulsemester = "AKHIR SEMESTER GENAP";
                $suffiks = "_akhir_genap";
            }

            if ($pilihsemester == "midganjil" || $pilihsemester == "midgenap") {
                $get_rapor_nilai = $this->M_user->rapor_nilai_mid($id_sekolah, $kelas, $sub_kelas, $nisn, $maks_kolom, tahun_ajaran(), $tglawal, $tglakhir);
                $get_nilai_ekskul = "";
            } else {
                $persenujian = $infosekolah['bobot_tes'];
                $get_rapor_nilai = $this->M_user->rapor_nilai_akhir($id_sekolah, $kelas, $sub_kelas, $nama_rombel, $nisn, $pilihsemester, tahun_ajaran(), $tglawal, $tglakhir, $persenujian);
                $get_nilai_ekskul = $this->M_user->rapor_nilai_ekskul($id_sekolah, $kelas, $sub_kelas, $nisn, $pilihsemester, tahun_ajaran());
            }

            $rapor_ekskul_siswa = $get_nilai_ekskul;

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

            $nilaikekalimat = array("", "mulai memahami dalam", "telah memahami dalam", "telah memahami dengan baik dalam", "memiliki kemampuan yang sangat baik terutama dalam");

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

            $nilaiangka = array("-", "Kurang", "Cukup", "Baik", "Sangat Baik");
            $nilaipribadi = array("-", "D", "C", "B", "A");

            $kelakuan = ($kelakuan != "") ? $nilaipribadi[$kelakuan] : "-";
            $kerajinan = ($kerajinan != "") ? $nilaipribadi[$kerajinan] : "-";
            $kerapihan = ($kerapihan != "") ? $nilaipribadi[$kerapihan] : "-";
            $kebersihan = ($kebersihan != "") ? $nilaipribadi[$kebersihan] : "-";

            $data['maks_kolom'] = $maks_kolom;
            $data['rapor_siswa'] = $get_rapor_nilai;
            $data['kop_rapor'] = $kop_rapor;

            $pdf = new Pdf();
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(5, 10, 10);
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, $marginbawah);
            $kop_rapor = str_replace("Comic Sans MS", "comicsansms3", $kop_rapor);
            $kop_rapor = str_replace("Arial,Helvetica,sans-serif", "arial", $kop_rapor);
            $kop_rapor = str_replace("Courier New,Courier,monospace", "courier", $kop_rapor);
            $kop_rapor = str_replace("Georgia,serif", "georgia", $kop_rapor);
            $kop_rapor = str_replace("Lucida Sans Unicode,Lucida Grande,sans-serif", "lucida", $kop_rapor);
            $kop_rapor = str_replace("Tahoma,Geneva,sans-serif", "tahoma", $kop_rapor);
            $kop_rapor = str_replace("Times New Roman,Times,serif", "times", $kop_rapor);
            $kop_rapor = str_replace("Trebuchet MS,Helvetica,sans-serif", "trebuchet", $kop_rapor);
            $kop_rapor = str_replace("Verdana,Geneva,sans-serif", "verdana", $kop_rapor);


            /////============= HEADER RAPOR ================================================
            $html = "<style>p{line-height:0px;}</style>" . $kop_rapor . "<br>";

            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->Cell(0, 5, 'LEMBAR HASIL KEGIATAN BELAJAR', 0, true, 'C', 0, '', 0, false, 'T', 'T');
            $pdf->Cell(0, 5, $judulsemester, 0, true, 'C', 0, '', 0, false, 'T', 'T');
            $pdf->Cell(0, 10, 'TAHUN PELAJARAN ' . tahun_ajaran('lengkap'), 0, true, 'C', 0, '', 0, false, 'T', 'T');

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

            ////////////////////////////// ISI RAPOR //////////////////////////////////
            //--------------------------- NILAI TENGAH SEMESTER -----------------------
            if ($pilihsemester == "midganjil" || $pilihsemester == "midgenap") {

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
                $tanggal = format_tanggal($tglakhir)['panjang'];


                $poskanan = 130;
                $akhirY = $pdf->getY();
                $pdf->SetFont('times', 12);
                $pdf->SetXY(5, $akhirY);

                if ($akhirY > 250)
                    $pdf->AddPage();

                $teks = str_repeat(" ", 115);
                $teks .= "Diberikan di: $tempat\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "Pada tanggal: $tanggal\n";

                $teks .= "Orang Tua / Wali";

                $teks .= str_repeat(" ", 87);
                $teks .= "Wali Kelas";

                $teks .= "\n\n\n\n";
                $teks .= str_repeat(" ", 115);
                $teks .= $nama_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $akhirY = $pdf->getY() - 5;
                $pdf->SetXY(5, $akhirY);
                $teks = "________________________";
                $pdf->MultiCell(0, 10, $teks);
                $pdf->SetXY(5, $akhirY);
                $teks = str_repeat(" ", 115);
                $teks .= "________________________\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "NIP. " . $nip_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);
            } else {

                //--------------------------- NILAI AKHIR SEMESTER -----------------------
                //////////////////////////////// PROJEK ///////////////////////////////
                $daftar_projek = $this->M_sekolah->daftar_projek($id_sekolah, $kelas, tahun_ajaran());
                $fase = fase($kelas);
                $nilai_projek = $this->M_user->get_daftar_nilai_p5($id_sekolah, $kelas, tahun_ajaran(), $nisn, $fase);

                $nomor = 0;
                $nomor2 = 0;
                $sekali1 = 0;
                $sekali2 = 0;
                $tblumum = '';
                $tblumum2 = '';
                foreach ($get_rapor_nilai as $row) :
                    if ($row['jenis'] == 0) {
                        if ($sekali1 == 0 && $kelas >= 11) {
                            $sekali1 = 1;
                            $tblumum = '<tr>
                                <td><b>A.</b> </td>
                                <td colspan="4" style="text-align:left;width:582px;"><b>MATA PELAJARAN UMUM</b></td>
                            </tr>';
                        }
                        $string = $row['nama_mapel'];
                        $substring = $agamasiswa;
                        if (strstr($string, $substring)) {
                            $nomor++;
                            $nilai1 = (!is_null($row['nilai_rata_rata']) ? round($row['nilai_rata_rata']) : "-");
                            $capaian1 = (!is_Null($row['tujuan_pembelajaran_status'])) ? capaiannilai($row['tujuan_pembelajaran_status']) : "";
                            $tblumum2 = '<tr>
                                <td style="text-align:center">' . $nomor . '</td>
                                <td style="text-align: left;">' . $row['nama_mapel'] . '</td>
                                <td style="text-align: center;">' . $nilai1 . '</td>
                                <td style="text-align: left;">' . $capaian1 . '</td>
                            </tr>';
                        }
                    } else if ($row['jenis'] == 1) {
                        $nomor++;
                        $nilai1 = (!is_null($row['nilai_rata_rata']) ? round($row['nilai_rata_rata']) : "-");
                        $capaian1 = (!is_Null($row['tujuan_pembelajaran_status'])) ? capaiannilai($row['tujuan_pembelajaran_status']) : "";
                        $tblumum2 .= '<tr>
                            <td style="text-align:center">' . $nomor . '</td>
                            <td>' . $row['nama_mapel'] . '</td>
                            <td style="text-align: center;">' . $nilai1 . '</td>
                            <td>' . $capaian1 . '</td>
                        </tr>';
                    } else if ($row['jenis'] == 2) {
                        $nilai1 = (!is_null($row['nilai_rata_rata']) ? round($row['nilai_rata_rata']) : "-");
                        $capaian1 = (!is_Null($row['tujuan_pembelajaran_status'])) ? capaiannilai($row['tujuan_pembelajaran_status']) : "";
                        if ($sekali2 == 0) {
                            $sekali2 = 1;
                            $tblumum2 .= '<tr>
                                <td><b>B.</b></td>
                                <td colspan="3" style="width:582px;"><b>MATA PELAJARAN PILIHAN</b></td>
                            </tr>';
                        }
                        $nomor2++;
                        $tblumum2 .= '<tr>
                            <td>' . $nomor2 . '</td>
                            <td>' . $row['nama_mapel'] . '</td>
                            <td style="text-align: center;">' . $nilai1 . '</td>
                            <td>' . $capaian1 . '</td>
                        </tr>';
                    }
                endforeach;

                $tabelnilai = '
                <table border="1" style="padding-left:5px;">
                    <tr>
                        <td style="width:30px;text-align: center;"><b>No</b></td>
                        <td style="width:200px;text-align: center;"><b>Mata Pelajaran</b></td>
                        <td style="width:60px;text-align: center;"><b>Nilai Akhir</b></td>
                        <td style="width:270px;text-align: center;"><b>Capaian Kompetensi</b></td>
                    </tr>';

                $tabelnilaitutup = '</table><br>';
                $pdf->writeHTML($tabelnilai . $tblumum . $tblumum2 . $tabelnilaitutup, true, false, true, true, 'L');

                /////////////// ------------------ EKSKUL --------------------------------
                $tabelekskul = '<table border="1" style="padding-left:5px;">
                <tr style="text-align: center;">
                    <td style="width:30px;"><b>No</b></td>
                    <td style="width:200px;"><b>Kegiatan Ekstrakurikuler</b></td>
                    <td style="width:60px;"><b>Predikat</b></td>
                    <td style="width:270px;"><b>Keterangan</b></td>
                </tr>';

                $nomor = 0;
                $nomor2 = 0;
                $sekali1 = 0;
                $sekali2 = 0;
                foreach ($rapor_ekskul_siswa as $row) :
                    $nomor++;
                    $str_nilai = $row['tujuan_pembelajaran_status'];
                    $sentences = explode(';', $str_nilai);
                    $jumlah_kalimat = count($sentences);

                    $sentencesbaru = "";

                    $maxChar  = 0;
                    $kalimatke = 0;
                    foreach ($sentences as $sentence) {
                        $kalimatke++;
                        $firstChar = trim(substr($sentence, 0, 1));
                        if ($maxChar === 0 || $firstChar > $maxChar) {
                            $maxChar = $firstChar;
                        }
                        if ($kalimatke < $jumlah_kalimat - 1)
                            $sentencesbaru .= substr(trim($sentence), 1) . ", ";
                        else if ($kalimatke < $jumlah_kalimat) {
                            if ($jumlah_kalimat > 2)
                                $sentencesbaru .= substr(trim($sentence), 1) . ", dan ";
                            else
                                $sentencesbaru .= substr(trim($sentence), 1) . " dan ";
                        } else
                            $sentencesbaru .= substr(trim($sentence), 1);
                    }
                    $tabelnilaiekskul = '<tr>
                    <td>' . $nomor . '</td>
                    <td style="text-align: left;">' . $row['nama_ekskul'] . '</td>
                    <td style="text-align: center;">' . $nilaiangka[$maxChar] . '</td>
                    <td style="text-align: left;">' . ucfirst(strtolower($nilaiangka[$maxChar])) . " dalam hal " . strtolower($sentencesbaru) . '</td>
                </tr>';
                endforeach;
                $tutuptable = '</table><br>';

                $pdf->writeHTML($tabelekskul . $tabelnilaiekskul . $tutuptable, true, false, true, true, 'L');

                ////// ---------------------- Presensi ---------------------------
                $tabelpresensi = '<table border="1" style="padding-left:5px;">
                    <tr>
                        <td style="width:270px;" colspan="3"><b>KETIDAKHADIRAN</b></td>
                    </tr>
                    <tr>
                        <td style="width:30px; text-align:center;"><b>No</b></td>
                        <td style="width:140px; text-align: center;"><b>Alasan</b></td>
                        <td style="width:100px; text-align: center; "><b>Jumlah</b></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">1</td>
                        <td style="text-align: left;"> Sakit</td>
                        <td style="text-align: center; ">' . $jumlah_s . ' hari</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">2</td>
                        <td style="text-align: left;"> Ijin</td>
                        <td style="text-align: center; ">' . $jumlah_i . ' hari</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">3</td>
                        <td style="text-align: left;"> Tanpa Keterangan</td>
                        <td style="text-align: center; ">' . $jumlah_a . ' hari</td>
                    </tr>
                </table>';
                $akhirY = $pdf->getY();
                $pdf->SetY($akhirY);
                $pdf->writeHTML($tabelpresensi, true, false, true, true, 'L');

                //////// ------------------- Kepribadian --------------------
                $tabelpribadi = '<table border="1" style="padding-left:5px;">
                    <tr>
                        <td colspan="3" style="width:270px;"><b>KEPRIBADIAN</b></td>
                    </tr>
                    <tr>
                        <td style="width:30px; text-align:center;"><b>No</b></td>
                        <td style="width:150px; text-align: center;"><b>Aspek</b></td>
                        <td style="width:90px; text-align: center; "><b>Keterangan</b></td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">1</td>
                        <td style="text-align: left;"> Kelakuan</td>
                        <td style="text-align: center; ">' . $kelakuan . '</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">2</td>
                        <td style="text-align: left;"> Kerajinan/kedisiplinan</td>
                        <td style="text-align: center; ">' . $kerajinan . '</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">3</td>
                        <td style="text-align: left;"> Kerapihan</td>
                        <td style="text-align: center; ">' . $kerapihan . '</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">4</td>
                        <td style="text-align: left;"> Kebersihan</td>
                        <td style="text-align: center; ">' . $kebersihan . '</td>
                    </tr>
                </table>';

                $pdf->SetXY(107, $akhirY);
                $pdf->writeHTML($tabelpribadi, true, false, true, true, 'L');

                // ---------------------------- Tandatangan -------------
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
                $tanggal = format_tanggal($tglakhir)['panjang'];

                $poskanan = 130;
                $akhirY = $pdf->getY();
                $pdf->SetXY(5, $akhirY);
                $pdf->SetFont(
                    'times',
                    12
                );

                if ($akhirY > 210)
                    $pdf->AddPage();

                $teks = str_repeat(" ", 115);
                $teks .= "Diberikan di: $tempat\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "Pada tanggal: $tanggal\n";

                $teks .= "Orang Tua / Wali";

                $teks .= str_repeat(" ", 87);
                $teks .= "Wali Kelas";

                $teks .= "\n\n\n\n";
                $teks .= str_repeat(" ", 115);
                $teks .= $nama_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $akhirY = $pdf->getY() - 5;
                $pdf->SetXY(5, $akhirY);
                $teks = "________________________";
                $pdf->MultiCell(0, 10, $teks);
                $pdf->SetXY(5, $akhirY);
                $teks = str_repeat(" ", 115);
                $teks .= "________________________\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "NIP. " . $nip_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $data_kepsek = $this->M_user->getKepsek($id_sekolah);

                $teks = '<div style="text-align: center;">';
                $teks .= 'Mengetahui<br>Kepala Sekolah<br><br><br><br>';
                $teks .= $data_kepsek->nama . '<br></div>';
                $pdf->writeHTML($teks, true, false, false, false, '');

                $akhirY = $pdf->getY() - 7;
                $pdf->SetXY(5, $akhirY);
                $teks = '<div style="text-align: center;">';
                $teks .= "________________________<br>";
                $teks .= "NIP. " . $data_kepsek->nip . "\n";
                $teks .= '</div>';
                $pdf->writeHTML($teks, true, false, false, false, '');


                //////////////////////////=============NILAI P5==========================
                /////============= HEADER RAPOR =========================================
                $pdf->AddPage();

                $pdf->Cell(0, 5, 'RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA', 0, true, 'C', 0, '', 0, false, 'T', 'T');
                $pdf->Cell(0, 5, $judulsemester, 0, true, 'C', 0, '', 0, false, 'T', 'T');
                $pdf->Cell(0, 10, 'TAHUN PELAJARAN ' . tahun_ajaran('lengkap'), 0, true, 'C', 0, '', 0, false, 'T', 'T');

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
                // $posisiY = $pdf->GetY() + 2;
                // $posisihmapel = intval((((530 - ($maks_kolom * 40)) / 2) - 10) / 2.667);

                ////////////////////////////// ISI RAPOR //////////////////////////////////
                $pdf->writeHTML("<hr>", true, false, true, false, '');
                $akhirY = $pdf->getY();
                $nomor = 0;
                foreach ($daftar_projek as $row) {
                    $nomor++;
                    $judul = "<b>Projek $nomor | " . $row['nama_projek'] . "</b><br>";
                    $deskripsi =  $row['deskripsi_projek'] . "<br><br>";
                    $pdf->SetXY(5, $akhirY);
                    $pdf->SetFont('', 'B', 12);
                    $pdf->writeHTML($judul, true, false, true, false, '');
                    $akhirY = $pdf->getY();
                    $pdf->SetXY(5, $akhirY);
                    $pdf->SetFont('', '', 12);
                    $pdf->writeHTML($deskripsi, true, false, true, false, '');
                    $akhirY = $pdf->getY();
                }

                $tempat = str_replace('Kota ', '', $get_sekolah['kota']);
                $tempat = str_replace('Kab. ', '', $tempat);
                $tanggal = format_tanggal($tglakhir)['panjang'];

                $poskanan = 130;
                $akhirY = $pdf->getY();
                $pdf->SetFont(
                    'times',
                    12
                );
                $pdf->SetXY(5, $akhirY);

                if ($akhirY > 250)
                    $pdf->AddPage();

                $teks = str_repeat(" ", 115);
                $teks .= "$tempat, $tanggal\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "Wali Kelas";

                $teks .= "\n\n\n\n";
                $teks .= str_repeat(" ", 115);
                $teks .= $nama_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $akhirY = $pdf->getY() - 5;
                $pdf->SetXY(5, $akhirY);
                $teks = str_repeat(" ", 115);
                $teks .= "________________________\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "NIP. " . $nip_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);


                //// ---------------- RAPOR P5 Detail -------------------------------------
                /////============= HEADER RAPOR =========================================
                $pdf->AddPage();

                $pdf->Cell(0, 5, 'RAPOR PROJEK PENGUATAN PROFIL PELAJAR PANCASILA', 0, true, 'C', 0, '', 0, false, 'T', 'T');
                $pdf->Cell(0, 5, $judulsemester, 0, true, 'C', 0, '', 0, false, 'T', 'T');
                $pdf->Cell(0, 10, 'TAHUN PELAJARAN ' . tahun_ajaran('lengkap'), 0, true, 'C', 0, '', 0, false, 'T', 'T');

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

                $nomor = 0;
                $id_projek_old = 0;
                $id_dimensi_old = 0;
                $jmldata = sizeof($nilai_projek);

                $detilp5 = '<table border="1" style="font-size:11px;padding-left:5px;">';

                for ($a = 0; $a < $jmldata; $a++) {
                    if ($id_projek_old != $nilai_projek[$a]['id_projek']) {
                        $catatan = "";
                        $id_projek_old = $nilai_projek[$a]['id_projek'];
                        $nomor++;

                        $detilp5 .= '<tr style="text-align: center;">
                    <td style="text-align:left; width:30px;"><b>' . $nomor . '</b></td>
                    <td style="text-align:left;vertical-align:center;width:250px;"><b>' . $nilai_projek[$a]['nama_projek'] . '</b></td>
                    <td style="width:70px"><b>Mulai Berkembang</b></td>
                    <td style="width:70px"><b>Sedang Berkembang</b></td>
                    <td style="width:70px"><b>Berkembang Sesuai Harapan</b></td>
                    <td style="width:70px"><b>Sangat Berkembang</b></td>
                    </tr>';
                    }

                    if ($id_dimensi_old != $nilai_projek[$a]['id_dimensi']) {
                        $id_dimensi_old = $nilai_projek[$a]['id_dimensi'];
                        $detilp5 .= '<tr class="merge-row">
                        <td colspan="6" style="text-align: left; background-color:#E2F3F4;"><b>' . $nilai_projek[$a]['dimensi'] . '</b></td>
                        </tr>';
                    }

                    $contreng1 = ($nilai_projek[$a]['nilai'] == 1) ? "v" : "";
                    $contreng2 = ($nilai_projek[$a]['nilai'] == 2) ? "v" : "";
                    $contreng3 = ($nilai_projek[$a]['nilai'] == 3) ? "v" : "";
                    $contreng4 = ($nilai_projek[$a]['nilai'] == 4) ? "v" : "";

                    $detilp5 .= '<tr style="text-align: center;">
                <td style="text-align:center;vertical-align:top;width:30px;">-</td>
                <td style="text-align:left;vertical-align:top;width:250px;">' . $nilai_projek[$a]['sub_elemen'] . '. ' . $nilai_projek[$a]['fase'] . '</td>
                <td style="width:70px">' . $contreng1 . '</td>
                <td style="width:70px">' . $contreng2 . '</td>
                <td style="width:70px">' . $contreng3 . '</td>
                <td style="width:70px">' . $contreng4 . '</td>
                </tr>';

                    if ($nilai_projek[$a]['nilai'] != "")
                        $catatan = $catatan . $nilaikekalimat[$nilai_projek[$a]['nilai']] . " " . $nilai_projek[$a]['sub_elemen'] . ", ";
                    if (((($a + 1) < $jmldata) && $id_projek_old != $nilai_projek[$a + 1]['id_projek']) || ($a + 1 == $jmldata)) {
                        $catatan = substr($catatan, 0, -2);
                        $catatan = $catatan . ".";
                        $detilp5 .= '<tr class="merge-row">
                        <td colspan="6" style="text-align: left;">Catatan Proses:
                        <br>Dalam mengerjakan projek ini, ' . $namasiswa . " " . $catatan . '</td>
                    </tr>';
                    }
                }
                $detilp5 .= '</table>';
                $pdf->writeHTML($detilp5, true, false, true, true, 'L');

                // ---------------------------- Tandatangan -------------
                $akhirY = $pdf->getY();
                $pdf->SetXY(5, $akhirY);

                $tempat = str_replace('Kota ', '', $get_sekolah['kota']);
                $tempat = str_replace('Kab. ', '', $tempat);
                $tanggal = format_tanggal($tglakhir)['panjang'];

                $poskanan = 130;
                $akhirY = $pdf->getY();
                $pdf->SetFont('times', 12);
                $pdf->SetXY(5, $akhirY);

                if ($akhirY > 210)
                    $pdf->AddPage();

                $teks = str_repeat(" ", 115);
                $teks .= "\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "$tempat, $tanggal\n";

                $teks .= "Orang Tua / Wali";

                $teks .= str_repeat(" ", 87);
                $teks .= "Wali Kelas\n\n\n\n";
                $pdf->MultiCell(0, 10, $teks);

                $teks = str_repeat(" ", 115);
                $teks .= $nama_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $akhirY = $pdf->getY() - 10;
                $pdf->SetXY(5, $akhirY);
                $teks = "________________________";
                $teks .= str_repeat(" ", 66);
                $teks .= "________________________\n";
                $teks .= str_repeat(" ", 115);
                $teks .= "NIP. " . $nip_wali . "\n";
                $pdf->MultiCell(0, 10, $teks);

                $data_kepsek = $this->M_user->getKepsek($id_sekolah);

                $teks = '<div style="text-align: center;">';
                $teks .= 'Mengetahui<br>Kepala Sekolah<br><br><br><br>';
                $teks .= $data_kepsek->nama . '<br></div>';
                $pdf->writeHTML($teks, true, false, false, false, '');

                $akhirY = $pdf->getY() - 7;
                $pdf->SetXY(5, $akhirY);
                $teks = '<div style="text-align: center;">';
                $teks .= "________________________<br>";
                $teks .= "NIP. " . $data_kepsek->nip . "\n";
                $teks .= '</div>';
                $pdf->writeHTML($teks, true, false, false, false, '');
            }

            ///////////////////////----------------------------------------------------
            $pdf->Output('example.pdf', 'I'); // 'D' untuk unduh, 'I' untuk tampilkan di browser

            exit();
        } else {
            echo "TIDAK VALID! SILAKAN LOGIN LAGI SEBAGAI WALI KELAS!";
        }
    }
}

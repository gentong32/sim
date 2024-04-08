<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Nilai extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $nama_mapel_lain = ['', 'B - K', 'P - 5'];

        $kelaspilihan = $this->request->getVar('kelas');
        $tugasterpilih = $this->request->getVar('tugas');
        $semesterterpilih = $this->request->getVar('semester');
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $wgl = substr($kelaspilihan, 0, 1);
        $idx = substr($kelaspilihan, 1, 1);
        if ($wgl == "w") {
            $daftarkelasajar = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
        } else if ($wgl == "g") {
            $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        } else if ($wgl == "l") {
            $daftarkelasajar = $this->M_user->cekajarlain($nuptk);
        } else if ($wgl == "e") {
        } else {
            return redirect("home");
        }

        if ($wgl == "g") {
            $nama_mapel = $daftarkelasajar[($idx) - 1]['nama_mapel'];
            $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
            $id_guru_mapel = $daftarkelasajar[($idx) - 1]['id_guru_mapel'];
            $jenis_mapel = $daftarkelasajar[($idx) - 1]['jenis'];

            $daftartugas = $this->M_sekolah->get_tugas($id_guru_mapel, tahun_ajaran());

            if (isset($semesterterpilih))
                $semesterke = $semesterterpilih;
            else {
                $semesterke = 0;
            }

            if (isset($tugasterpilih))
                $id_tugas = $tugasterpilih;
            else {
                if ($daftartugas)
                    $id_tugas = $daftartugas[0]['id'];
                else
                    $id_tugas = 0;
            }

            $kelas = $daftarkelasajar[($idx) - 1]['kelas'];
            $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];

            $agama = "";
            if ($jenis_mapel == 0) {
                $keyword = "Agama";
                $posisi_keyword = strpos($nama_mapel, $keyword);
                if ($posisi_keyword !== false) {
                    $posisi_awal_kata = $posisi_keyword + strlen($keyword) + 1;
                    $kata_setelah_keyword = substr($nama_mapel, $posisi_awal_kata);
                    $posisi_spasi_setelah_kata = strpos($kata_setelah_keyword, ' ');
                    if ($posisi_spasi_setelah_kata !== false) {
                        $agama = substr($kata_setelah_keyword, 0, $posisi_spasi_setelah_kata);
                    } else {
                        $agama =  $kata_setelah_keyword;
                    }
                }
            }
            // $id_guru = $daftarkelasajar[($idx) - 1]['id_guru'];
            if ($semesterke > 0) {
                $daftartp = "";
                $daftarnilaisiswa = $this->M_user->getDaftarNilaiSemester($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $semesterke, $agama);
            } else {
                $daftartp = $this->M_sekolah->get_tugas_tp($id_tugas);
                $daftarnilaisiswa = $this->M_user->getDaftarnilai($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $id_tugas, $agama);
            }
            // $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
            $data['kelas'] = $kelas;
            $data['nama_rombel'] = $nama_rombel;
            $data['nama_mapel'] = $nama_mapel;
            $data['id_guru_mapel'] = $id_guru_mapel;
            $data['id_mapel'] = $id_mapel;
            $data['id_tugas'] = $id_tugas;
            $data['tugasterpilih'] = $tugasterpilih;
            $data['daftar_tugas'] = $daftartugas;
            $data['semester'] = $semesterke;
            $data['daftar_tp'] = $daftartp;
            $data['daftar_nilai_siswa'] = $daftarnilaisiswa;
            $data['daftarkelasajar'] = $daftarkelasajar;
            $data['pilidx'] = $idx;

            // echo '<pre>';
            // echo var_dump($daftarkelasajar);
            // echo '</pre>';
            // die();
        } else if ($wgl == "l") {
            $jenis = $daftarkelasajar[($idx) - 1]['jenis_mapel'];
            $nama_mapel = $nama_mapel_lain[$jenis];
            $id_mapel = "0";
            $id_guru_mapel = $daftarkelasajar[($idx) - 1]['id_guru_lain'];
            $kelas = $daftarkelasajar[($idx) - 1]['kelas'];
            $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];
            $daf_projek = $this->M_sekolah->get_projek_sekolah($id_sekolah, tahun_ajaran(), $kelas);
            $data['kelas'] = $kelas;
            $data['nama_rombel'] = $nama_rombel;
            $data['nama_mapel'] = $nama_mapel;
            $data['daf_projek'] = $daf_projek;
            if ($daf_projek)
                $idprojek1 = $daf_projek[0]['id_projek'];
            else
                $idprojek1 = 0;
            $data['idprojek1'] = $idprojek1;
            $daf_dimensi = $this->M_sekolah->get_dimensi_elemen_sekolah($idprojek1);
            $data['daf_dimensi'] = $daf_dimensi;
            $data['fase'] = fase($kelas);
            $data['kelas'] = $kelas;
        } else if ($wgl == "e") {
            $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
            $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];
            $nama_ekskul = $daftarwaliekskul[($idx) - 1]['nama_ekskul'];
            $namakelaspilihan = $this->request->getVar('n_kelas');
            $daftarkelas_sekolah = $this->M_sekolah->get_daftar_kelas($id_sekolah, tahun_ajaran());
            if (!isset($namakelaspilihan)) {
                $namakelaspilihan = $daftarkelas_sekolah[0]['kelas'];
            }
            $rombelpilihan = $this->request->getVar('rombel');
            $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran(), $namakelaspilihan);
            if (!isset($rombelpilihan)) {
                $namarombelpilihan = $daftar_rombel[0]->nama_rombel;
                $rombelpilihan = $daftar_rombel[0]->id;
            }
            $daftartp = $this->M_sekolah->getTP_Ekskul($id_ekskul, $namakelaspilihan);
            $id_sekolah = session()->get('id_sekolah');
            $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
            $tgl_awal_ganjil = $info_sekolah['tgl_awal_ganjil'];
            if (date("Y-m-d") >= date($tgl_awal_ganjil)) {
                $semester = 1;
            } else {
                $semester = 2;
            }
            $nilai_eks1 = $this->M_user->getDaftarNilaiEks($id_sekolah, tahun_ajaran(), $namakelaspilihan, $namarombelpilihan, $id_ekskul, $semester);
            $data['id_ekskul'] = $id_ekskul;
            $data['nama_ekskul'] = $nama_ekskul;
            $data['daftar_kelas'] = $daftarkelas_sekolah;
            $data['daftar_rombel'] = $daftar_rombel;
            $data['kelas'] = $namakelaspilihan;
            $data['rombel'] = $rombelpilihan;
            $data['daftartp'] = $daftartp;
            $data['jml_tp_eks'] = sizeof($daftartp);
            $data['semester'] = $semester;
            $data['nilai_eks1'] = $nilai_eks1;
        } else if ($wgl == "w") {
            $id_sekolah = session()->get('id_sekolah');
            $kelas = $daftarkelasajar[($idx) - 1]['kelas'];
            $nama_rombel = $daftarkelasajar[$idx - 1]['nama_rombel'];
            $sub_kelas = $daftarkelasajar[$idx - 1]['sub_kelas'];
            $getdaftarsiswa = $this->M_user->getDaftarSiswa($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel);
            $data['daftar_siswa'] = $getdaftarsiswa;
            $nispilihan = $this->request->getVar('nis');
            if (isset($nispilihan))
                $nis = $nispilihan;
            else
                $nis = $getdaftarsiswa[0]['nis'];
            $data['nis'] = $nis;
            $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $data['nis']);
            $nisn = $datasiswa['nisn'];
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
                $kodepribadi = "_mid_ganjil";
            } else if ($pilihsemester == "raporganjil") {
                $tglawal = $mdgj;
                $tglakhir = $akgj;
                $judulsemester = "AKHIR SEMESTER GANJIL";
                $kodepribadi = "_akhir_ganjil";
            } else if ($pilihsemester == "midgenap") {
                $tglawal = $awgn;
                $tglakhir = $mdgn;
                $judulsemester = "TENGAH SEMESTER GENAP";
            } else if ($pilihsemester == "raporgenap") {
                $tglawal = $mdgn;
                $tglakhir = $akgn;
                $judulsemester = "AKHIR SEMESTER GENAP";
            }

            $get_absensi = $this->M_user->get_absensi($id_sekolah, $nisn, $tglawal, $tglakhir);
            $get_kepribadian = $this->M_user->get_pribadi($id_sekolah, $nisn, tahun_ajaran());
            $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
            $kop_rapor = $info_sekolah['kop_rapor'];
            $get_sekolah = $this->M_sekolah->getSekolah($id_sekolah);
            $get_datawali = $this->M_user->getDataGuru($id_user);
            $nama_wali = $get_datawali['nama'];
            $nip_wali = $get_datawali['nip'];
            $maks_kolom = $this->M_user->get_max_kolom_nilai($id_sekolah, $kelas, $sub_kelas, tahun_ajaran(), $tglawal, $tglakhir);
            if ($pilihsemester == "midganjil" || $pilihsemester == "midgenap") {
                $get_rapor_nilai = $this->M_user->rapor_nilai_mid($id_sekolah, $kelas, $sub_kelas, $nisn, $maks_kolom, tahun_ajaran(), $tglawal, $tglakhir);
            } else {
                $persenujian = $info_sekolah['bobot_tes'];
                $get_rapor_nilai = $this->M_user->rapor_nilai_akhir($id_sekolah, $kelas, $sub_kelas, $nisn, $pilihsemester, tahun_ajaran(), $tglawal, $tglakhir, $persenujian);
                $get_nilai_ekskul = $this->M_user->rapor_nilai_ekskul($id_sekolah, $nisn, $pilihsemester, tahun_ajaran());
                $data['nilai_ekskul'] = $get_nilai_ekskul;
                // $get_rapor_p5 = $this->M_user->rapor_nilai_p5($id_sekolah, $kelas, $sub_kelas, $nisn, $maks_kolom, tahun_ajaran(), $tglawal, $tglakhir);
                // echo '<pre>';
                // echo var_dump($get_rapor_nilai);
                // echo '</pre>';
            }
            // echo var_dump($get_rapor_nilai);
            $data['maks_kolom'] = $maks_kolom;
            $data['rapor_siswa'] = $get_rapor_nilai;
            $data['kop_rapor'] = $kop_rapor;
            $data['nama_rombel'] = $nama_rombel;
            $data['absensi'] = $get_absensi;
            $data['get_sekolah'] = $get_sekolah;
            $data['tglakhir'] = $tglakhir;
            $data['nama_wali'] = $nama_wali;
            $data['nip_wali'] = $nip_wali;
            $data['judulsemester'] = $judulsemester;
            $data['pilihsemester'] = $pilihsemester;
            $data['kepribadian'] = $get_kepribadian;
            $data['kelas'] = $kelas;
        }

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;
        $data['id_user'] = $id_user;

        $judul_submenu = "&nbsp;Nilai";
        $data['valkelas'] = $kelaspilihan;

        $data['judul_submenu'] = $judul_submenu;
        // $data['datakalender'] = json_encode($datakalender);
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'nilai';

        // echo var_dump($data['rapor_siswa']);
        // die();

        if ($wgl == "g") {
            return view('v_nilai', $data);
        } else if ($wgl == "l") {
            return view('v_nilai_p5', $data);
        } else if ($wgl == "e") {
            return view('v_nilai_eks', $data);
        } else if ($wgl == "w") {
            if ($pilihsemester == "midganjil" || $pilihsemester == "midgenap")
                return view('v_nilai_rapor_aja', $data);
            else
                return view('v_nilai_rapor', $data);
        }
    }

    public function get_daftar_elemen_sekolah()
    {
        if (!khusususer())
            return redirect()->to("/");

        $dataMapel = json_decode(file_get_contents('php://input'), true);

        $idprojek = $dataMapel['idprojek'];
        $daf_dimensi = $this->M_sekolah->get_dimensi_elemen_sekolah($idprojek);
        echo json_encode($daf_dimensi);
    }

    public function get_daftar_nilai_p5()
    {
        $id_projek = $_GET['projek'];
        $kelaspilihan = $_GET['kelas'];
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);

        $nuptk = $data_saya->nuptk;
        $id_sekolah = session()->get('id_sekolah');

        // echo $tanggal . $kelaspilihan;
        // die();

        // $kelaspilihan = $this->request->getVar('kelas');
        // $kelaspilihan = "w1";
        $idx = substr($kelaspilihan, 1, 1);
        $daftarajarlain = $this->M_user->cekajarlain($nuptk, $id_sekolah);

        $nama_rombel = $daftarajarlain[$idx - 1]['nama_rombel'];
        $kelas = $daftarajarlain[$idx - 1]['kelas'];

        $daftar_nilai_p5 = $this->M_user->getDaftarNilaiP5($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $id_projek);

        // echo var_dump($daftar_nilai_p5);

        return json_encode($daftar_nilai_p5);
    }

    public function simpan_nilai()
    {
        $id_sekolah = session()->get('id_sekolah');

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $id_tugas = $dataToSave['id_tugas'];
        $semester = $dataToSave['semester'];
        $id_mapel = $dataToSave['id_mapel'];
        $dataijomerah = $dataToSave['dataijomerah'];
        $nilai = $dataToSave['nilai'];
        $nis = $dataToSave['nis'];
        $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $nis);
        $nisn = $datasiswa['nisn'];

        $savedata['id_sekolah'] = $id_sekolah;
        $savedata['nisn'] = $nisn;
        $savedata['id_mapel'] = $id_mapel;
        $savedata['nilai'] = $nilai;

        if ($semester == 0) {
            $savedata['id_tugas'] = $id_tugas;
            $cek_nilai = $this->M_sekolah->cek_nilai($savedata);
        } else {
            $savedata['semester'] = $semester;
            $cek_nilai = $this->M_sekolah->cek_nilai_semester($savedata);
        }

        if ($semester > 0) {
            $pair = str_replace(['{', '}', ','], '', $dataijomerah);
            $values = explode('=', $pair);
            $id_tugas_tp = $values[0];
            $status = $values[1];
            $savedata['status'] = $status;
        }

        if ($cek_nilai) {
            $lastInsertedID = $cek_nilai->id;
            if ($semester == 0) {
                $this->M_sekolah->update_nilai($savedata);
                $info = $id_sekolah . "-" . $nisn . "-" . $id_mapel . "-" . $id_tugas . "-" . $nilai;
            } else {
                $this->M_sekolah->update_nilai_semester($savedata);
                $info = $id_sekolah . "-" . $nisn . "-" . $id_mapel . "-" . $semester . "-" . $nilai;
            }
        } else {
            if ($semester == 0)
                $lastInsertedID = $this->M_sekolah->insert_nilai($savedata);
            else
                $lastInsertedID = $this->M_sekolah->insert_nilai_semester($savedata);
            $info = "add";
        }

        // $dataijomerah = "{7=1},{8=1},";

        if ($semester == 0) {
            $pairs = explode(',', $dataijomerah);
            // if ($pairs)
            foreach ($pairs as $pair) {
                if ($pair != null) {
                    $pair = str_replace(['{', '}'], '', $pair);
                    $values = explode('=', $pair);
                    $id_tugas_tp = $values[0];
                    $status = $values[1];
                    $savedatatp['id_nilai_siswa'] = $lastInsertedID;
                    $savedatatp['id_tugas_tp'] = $id_tugas_tp;
                    $savedatatp['status'] = $status;
                    if ($cek_nilai) {
                        $this->M_sekolah->update_nilai_tp($savedatatp);
                    } else {
                        $this->M_sekolah->insert_nilai_tp($savedatatp);
                    }
                }
            }
        }

        echo json_encode($info);
    }

    public function rekap()
    {
        if (!khusususer())
            return redirect()->to("/");

        $kelaspilihan = $this->request->getVar('kelas');
        $semester = $this->request->getVar('semester');
        if (!$semester) {
            $id_sekolah = session()->get('id_sekolah');
            $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
            $tgl_awal_ganjil = $info_sekolah['tgl_awal_ganjil'];

            // if (date("n")>=7)
            if (date("Y-m-d") >= date($tgl_awal_ganjil))
                $semester = 1;
            else
                $semester = 2;
        }

        if (substr($kelaspilihan, 0, 1) == "w") {
            $id_user = session()->get('id_user');
            $data_saya = $this->M_user->get_data_guru($id_user);

            $nuptk = $data_saya->nuptk;
            $id_sekolah = session()->get('id_sekolah');

            $idx = substr($kelaspilihan, 1, 1);
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

            $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
            $kelas = $daftarkelaswali[$idx - 1]['kelas'];

            $rekappresensi = $this->M_user->getrekappresensi($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $semester);

            // echo var_dump($rekappresensi);
            // die();

            $judul_submenu = "Presensi Kelas " . $nama_rombel;
            $data['rekappresensi'] = $rekappresensi;
            $data['judul_submenu'] = $judul_submenu;
            $data['valkelas'] = $kelas;
            $data['submenu'] = true;
            $data['semester'] = $semester;
            $data['menutitle'] = 'Presensi';
            $data['ikon'] = 'absen';
            $data['kelaspilihan'] = $kelaspilihan;
            $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
            $data['datakalender'] = json_encode($datakalender);
            return view('v_presensi_rekap', $data);
        } else {
            echo "Khusus Wali Kelas";
            die();
        }
    }

    public function get_data_nilai_p5()
    {
        $kelaspilihan = $_GET['kelas'];
        $id_projek = $_GET['projek'];
        $sub_elemen = $_GET['sub_elemen'];
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);

        $nuptk = $data_saya->nuptk;
        $id_sekolah = session()->get('id_sekolah');
        $idx = substr($kelaspilihan, 1, 1);
        $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

        $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
        $kelas = $daftarkelaswali[$idx - 1]['kelas'];

        $daftar_nilai_p5 = $this->M_user->getDaftarNilaiP5($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $id_projek, $sub_elemen);

        return json_encode($daftar_nilai_p5);
    }

    public function simpan_nilai_p5()
    {
        $id_sekolah = session()->get('id_sekolah');
        $dataPost = json_decode(file_get_contents('php://input'), true);

        $id_projek = $dataPost['id_projek'];
        $get_id_elemen = $this->M_sekolah->get_id_elemen($id_sekolah, $id_projek);

        foreach ($dataPost['dataToSend'] as $data) {
            if ($data != null) {

                $nis = $data['NIS'];
                $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $nis);
                $nisn = $datasiswa['nisn'];
                $nilai = $data['nilai'];
                $elemen = $data['elemen'];
                $id_dimensi_projek = $get_id_elemen[$elemen - 1]['id'];
                $this->M_user->hapus_nilai_p5($id_sekolah, $nisn, $id_dimensi_projek);
                $this->M_user->tambah_nilai_p5($id_sekolah, $nisn, $id_dimensi_projek, $nilai);
            }
        }

        echo json_encode($nis);
    }

    public function get_rombel($kelas)
    {
        $id_sekolah = session()->get('id_sekolah');
        $daftar_rombel = $this->M_sekolah->get_rombel_sekolah($id_sekolah, tahun_ajaran(), $kelas);
        return json_encode($daftar_rombel);
    }

    public function get_daftar_nilai_eks()
    {
        $kelas = $_GET['kelas'];
        $id_rombel = $_GET['rombel'];
        $kelaspilihan = $_GET['valkelas'];
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);

        $nuptk = $data_saya->nuptk;
        $id_sekolah = session()->get('id_sekolah');

        $idx = substr($kelaspilihan, 1, 1);

        $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
        $id_ekskul = $daftarwaliekskul[($idx) - 1]['id_ekskul'];

        $get_rombel = $this->M_sekolah->get_rombel_byid($id_rombel);
        $rombel = $get_rombel['nama_rombel'];

        $id_sekolah = session()->get('id_sekolah');
        $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $tgl_awal_ganjil = $info_sekolah['tgl_awal_ganjil'];
        if (date("Y-m-d") >= date($tgl_awal_ganjil))
            $semester = 1;
        else
            $semester = 2;

        $daftar_nilai_eks = $this->M_user->getDaftarNilaiEks($id_sekolah, tahun_ajaran(), $kelas, $rombel, $id_ekskul, $semester);

        return json_encode($daftar_nilai_eks);
    }

    public function simpan_nilai_eks()
    {
        $id_sekolah = session()->get('id_sekolah');
        $dataPost = json_decode(file_get_contents('php://input'), true);

        $pilihankelas = $dataPost['pilihankelas'];
        $id_ekskul = $dataPost['idekskul'];
        $daftartp = $this->M_sekolah->getTP_Ekskul($id_ekskul, $pilihankelas);
        $semester = $dataPost['semester'];

        // echo json_encode($dataPost['dataToSend']);

        foreach ($dataPost['dataToSend'] as $data) {
            if ($data != null) {

                $nis = $data['NIS'];
                $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $nis);
                $nisn = $datasiswa['nisn'];
                $nilai = $data['nilai'];
                $indikator = $data['indikator'];
                $id_tp_eks = $daftartp[$indikator - 1]->id;
                $this->M_user->hapus_nilai_eks($id_sekolah, $nisn, $id_tp_eks);
                $this->M_user->tambah_nilai_eks($id_sekolah, $nisn, $id_tp_eks, $nilai, $semester);
            }
        }

        return json_encode("sukses");
    }

    public function get_daftar_indikator_eks()
    {
        $kelas = $_GET['kelas'];
        $id_ekskul = $_GET['id_ekskul'];

        $daftar_indikator_eks = $this->M_sekolah->getTP_Ekskul($id_ekskul, $kelas);

        return json_encode($daftar_indikator_eks);
    }

    public function testabel()
    {
        echo capaianekskul("3 Membuat api unggun; 2 Mendirikan tenda");
    }
}

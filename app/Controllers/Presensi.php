<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Presensi extends BaseController
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

        $kelaspilihan = $this->request->getVar('kelas');

        if (substr($kelaspilihan, 0, 1) == "w") {
            $id_user = session()->get('id_user');
            $data_saya = $this->M_user->get_data_guru($id_user);

            $nuptk = $data_saya->nuptk;
            $id_sekolah = session()->get('id_sekolah');

            $idx = substr($kelaspilihan, 1, 1);
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

            $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
            $kelas = $daftarkelaswali[$idx - 1]['kelas'];

            $judul_submenu = "Presensi Siswa ";
            $data['judul_submenu'] = $judul_submenu;
            $data['valkelas'] = $kelas;
            $data['submenu'] = true;
            $data['menutitle'] = 'Presensi';
            $data['ikon'] = 'absen';
            $data['kelaspilihan'] = $kelaspilihan;
            $data['daftarkelaswali'] = $daftarkelaswali;
            $data['pilidx'] = $idx;
            $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
            $data['datakalender'] = json_encode($datakalender);
            return view('v_presensi', $data);
        } else {
            echo "Khusus Wali Kelas";
            die();
        }
    }

    public function get_data_presensi()
    {
        $tanggal = $_GET['tanggal'];
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
        $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

        $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
        $kelas = $daftarkelaswali[$idx - 1]['kelas'];
        $daftar_presensi = $this->M_user->getDaftarpresensi($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $tanggal);

        return json_encode($daftar_presensi);
    }

    public function simpan_presensi()
    {
        $id_sekolah = session()->get('id_sekolah');

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        $hapussekali = false;
        foreach ($dataToSave as $data) {
            $nis = $data['NIS'];
            $keterangan = $data['keterangan'];
            $tanggal = $data['tanggal'];

            if ($hapussekali == false) {
                $cekdata = $tanggal;
                $this->M_user->hapus_presensi($id_sekolah, $tanggal);
                $hapussekali = true;
            }

            if ($keterangan != "H") {
                $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $nis);
                $nisn = $datasiswa['nisn'];
                $savedata['id_sekolah'] = $id_sekolah;
                $savedata['nisn'] = $nisn;
                $savedata['status'] = $keterangan;
                $savedata['tanggal'] = $tanggal;
                $this->M_user->simpan_presensi($savedata);
            }
        }

        echo json_encode("OK");
    }

    public function rekap()
    {
        if (!khusususer())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');

        $kelaspilihan = $this->request->getVar('kelas');
        $semester = $this->request->getVar('semester');

        $info_sekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());
        $tgl_awal_ganjil = $info_sekolah['tgl_awal_ganjil'];
        $tgl_awal_genap = $info_sekolah['tgl_awal_genap'];
        $tgl_rapor_ganjil = $info_sekolah['tgl_rapor_ganjil'];
        $tgl_rapor_genap = $info_sekolah['tgl_rapor_genap'];

        if (!$semester) {
            // if (date("n")>=7)
            if (date("Y-m-d") >= date($tgl_awal_genap)) {
                $semester = 2;
            } else {
                $semester = 1;
            }
        }

        if ($semester == 1) {
            $batasawal = $tgl_awal_ganjil;
            $batasakhir = $tgl_rapor_ganjil;
        } else {
            $batasawal = $tgl_awal_genap;
            $batasakhir = $tgl_rapor_genap;
        }

        if (substr($kelaspilihan, 0, 1) == "w") {
            $id_user = session()->get('id_user');
            $data_saya = $this->M_user->get_data_guru($id_user);

            $nuptk = $data_saya->nuptk;

            $idx = substr($kelaspilihan, 1, 1);
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

            $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
            $kelas = $daftarkelaswali[$idx - 1]['kelas'];

            $rekappresensi = $this->M_user->getrekappresensi($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $batasawal, $batasakhir);

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

    public function absensi_siswa()
    {
        if (session()->get('sebagai') != "siswa")
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->getDataSiswa($id_user, tahun_ajaran());
        $nisn = $data_saya['nisn'];

        $semesterterpilih = $this->request->getVar('semester');

        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());

        $awgj = $infosekolah['tgl_awal_ganjil'];
        $mdgj = $infosekolah['tgl_mid_ganjil'];
        $akgj = $infosekolah['tgl_rapor_ganjil'];
        $awgn = $infosekolah['tgl_awal_genap'];
        $mdgn = $infosekolah['tgl_mid_genap'];
        $akgn = $infosekolah['tgl_rapor_genap'];

        if (!isset($semesterterpilih)) {
            $tg_sekarang = date("Y-m-d");
            if ($tg_sekarang <= $akgn)
                $semesterterpilih = "raporgenap";
            // if ($tg_sekarang <= $mdgn)
            //     $semesterterpilih = "midgenap";
            if ($tg_sekarang <= $akgj)
                $semesterterpilih = "raporganjil";
            // if ($tg_sekarang <= $mdgj)
            //     $semesterterpilih = "midganjil";
        }

        if ($semesterterpilih == "midganjil") {
            $tglawal = $awgj;
            $tglakhir = $mdgj;
            $judulsemester = "TENGAH SEMESTER GANJIL";
        } else if ($semesterterpilih == "raporganjil") {
            $tglawal = $awgj; //$mdgj;
            $tglakhir = $akgj;
            $judulsemester = "AKHIR SEMESTER GANJIL";
        } else if ($semesterterpilih == "midgenap") {
            $tglawal = $awgn;
            $tglakhir = $mdgn;
            $judulsemester = "TENGAH SEMESTER GENAP";
        } else if ($semesterterpilih == "raporgenap") {
            $tglawal = $awgn; //$mdgn;
            $tglakhir = $akgn;
            $judulsemester = "AKHIR SEMESTER GENAP";
        }

        $get_daftar_absensi = $this->M_user->get_absensi_siswa($id_sekolah, $nisn, $tglawal, $tglakhir);

        // dd($get_daftar_absensi);

        $data['judul_submenu'] = "&nbsp;Absensi";
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'absen';
        $data['semester'] = $semesterterpilih;
        $data['daftar_absensi'] = $get_daftar_absensi;

        return view('v_absensi_siswa', $data);
    }

    public function absensi_siswa_nis()
    {
        if (!khusususer())
            return redirect()->to("/");

        $kelasterpilih = $this->request->getVar('kelas');
        $semesterterpilih = $this->request->getVar('semester');
        $nisterpilih = $this->request->getVar('nis');

        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;

        $cekwalirombel = $this->M_sekolah->get_wali_rombel($id_sekolah, $nuptk);
        $kelassiswa = $cekwalirombel['kelas'];
        $rombelsiswa = $cekwalirombel['nama_rombel'];

        $nisn_siswasaya = $this->M_sekolah->cekSiswaWali($id_sekolah, $nisterpilih, $kelassiswa, $rombelsiswa, tahun_ajaran());

        $nisn = "";
        if ($nisn_siswasaya) {
            $nisn = $nisn_siswasaya['nisn'];
            $data_siswasaya = $this->M_user->get_data_siswa($nisn);
            $namasiswa = $data_siswasaya->nama;
        } else {
            echo "Bukan siswa dari wali";
            die();
        }

        $infosekolah = $this->M_sekolah->getInfoSekolah($id_sekolah, tahun_ajaran());

        $awgj = $infosekolah['tgl_awal_ganjil'];
        $mdgj = $infosekolah['tgl_mid_ganjil'];
        $akgj = $infosekolah['tgl_rapor_ganjil'];
        $awgn = $infosekolah['tgl_awal_genap'];
        $mdgn = $infosekolah['tgl_mid_genap'];
        $akgn = $infosekolah['tgl_rapor_genap'];

        if (!isset($semesterterpilih)) {
            $tg_sekarang = date("Y-m-d");
            if ($tg_sekarang <= $akgn)
                $semesterterpilih = "raporgenap";
            // if ($tg_sekarang <= $mdgn)
            //     $semesterterpilih = "midgenap";
            if ($tg_sekarang <= $akgj)
                $semesterterpilih = "raporganjil";
            // if ($tg_sekarang <= $mdgj)
            //     $semesterterpilih = "midganjil";
        }

        if ($semesterterpilih == "midganjil") {
            $tglawal = $awgj;
            $tglakhir = $mdgj;
            $judulsemester = "TENGAH SEMESTER GANJIL";
        } else if ($semesterterpilih == "raporganjil") {
            $tglawal = $awgj; //$mdgj;
            $tglakhir = $akgj;
            $judulsemester = "AKHIR SEMESTER GANJIL";
        } else if ($semesterterpilih == "midgenap") {
            $tglawal = $awgn;
            $tglakhir = $mdgn;
            $judulsemester = "TENGAH SEMESTER GENAP";
        } else if ($semesterterpilih == "raporgenap") {
            $tglawal = $awgn; //$mdgn;
            $tglakhir = $akgn;
            $judulsemester = "AKHIR SEMESTER GENAP";
        }

        $get_daftar_absensi = $this->M_user->get_absensi_siswa($id_sekolah, $nisn, $tglawal, $tglakhir);

        $data['judul_submenu'] = "&nbsp;Absensi " . $namasiswa;
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'absen';
        $data['detilabsensi'] = true;
        $data['kelasterpilih'] = $kelasterpilih;
        $data['semester'] = $semesterterpilih;
        $data['nisterpilih'] = $nisterpilih;
        $data['namasiswa'] = $namasiswa;
        $data['daftar_absensi'] = $get_daftar_absensi;

        return view('v_absensi_siswa_nis', $data);
    }
}

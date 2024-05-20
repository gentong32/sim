<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Kepribadian extends BaseController
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
        $semesterpilihan = $this->request->getVar('semester');

        if (substr($kelaspilihan, 0, 1) == "w") {
            $id_user = session()->get('id_user');
            $data_saya = $this->M_user->get_data_guru($id_user);

            $nuptk = $data_saya->nuptk;
            $id_sekolah = session()->get('id_sekolah');

            $idx = substr($kelaspilihan, 1, 1);
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);

            $nama_rombel = $daftarkelaswali[$idx - 1]['nama_rombel'];
            $kelas = $daftarkelaswali[$idx - 1]['kelas'];

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

            $judul_submenu = "Kepribadian Siswa ";
            $data['judul_submenu'] = $judul_submenu;
            $data['valkelas'] = $kelas;
            $data['pilihsemester'] = $pilihsemester;
            $data['submenu'] = true;
            $data['menutitle'] = 'Kepribadian';
            $data['ikon'] = 'pribadi';
            $data['kelaspilihan'] = $kelaspilihan;
            $data['daftarkelaswali'] = $daftarkelaswali;
            $data['pilidx'] = $idx;
            return view('v_pribadi', $data);
        } else {
            echo "Khusus Wali Kelas";
            die();
        }
    }

    public function get_data_kepribadian()
    {
        $kelaspilihan = $_GET['kelas'];
        $semesterpilihan = $_GET['semester'];
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
        $daftar_kepribadian = $this->M_user->getDaftarKepribadian($id_sekolah, tahun_ajaran(), $kelas, $nama_rombel, $semesterpilihan);

        return json_encode($daftar_kepribadian);
    }

    public function simpan_kepribadian()
    {
        $id_sekolah = session()->get('id_sekolah');

        $dataToSave = json_decode(file_get_contents('php://input'), true);

        foreach ($dataToSave as $data) {
            $nis = $data['NIS'];
            $kepribadians = $data['kepribadian'];
            $semester = $data['semester'];
            $idx = 0;
            foreach ($kepribadians as $kepribadian) {
                $idx++;
                if ($idx == 1)
                    $kelakuan = $kepribadian;
                else if ($idx == 2)
                    $kerajinan = $kepribadian;
                else if ($idx == 3)
                    $kerapihan = $kepribadian;
                else if ($idx == 4)
                    $kebersihan = $kepribadian;
            }
            $datasiswa = $this->M_user->getnisnfromnis($id_sekolah, $nis);
            $nisn = $datasiswa['nisn'];
            $this->M_user->simpan_kepribadian($id_sekolah, $nisn, tahun_ajaran(), $semester, $kelakuan, $kerajinan, $kerapihan, $kebersihan);
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
            if (date("Y-m-d") >= date($tgl_awal_ganjil)) {
                $semester = 1;
            } else {
                $semester = 2;
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
}

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

            $judul_submenu = "Presensi Kelas " . $nama_rombel;
            $data['judul_submenu'] = $judul_submenu;
            $data['valkelas'] = $kelas;
            $data['submenu'] = true;
            $data['menutitle'] = 'Presensi';
            $data['ikon'] = 'absen';
            $data['kelaspilihan'] = $kelaspilihan;
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
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);

        $nuptk = $data_saya->nuptk;
        $id_sekolah = session()->get('id_sekolah');

        $kelaspilihan = "w1";
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

        $kelaspilihan = $this->request->getVar('kelas');
        $semester = $this->request->getVar('semester');
        if (!$semester) {
            // if (date("n")>=7)
            if (date("n") >= 7)
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
}

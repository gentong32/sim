<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Tujuanpembelajaran extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index(): string
    {
        $id_sekolah = session()->get('id_sekolah');
        $id_user = session()->get('id_user');

        $kelaspilihan = $this->request->getVar('kelas');
        $idx = substr($kelaspilihan, 1, 1);
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $id_mapel = $daftarkelasajar[($idx) - 1]['id_mapel'];
        $id_kelas = $daftarkelasajar[($idx) - 1]['kelas'];

        echo var_dump($daftarkelasajar);
        // die();

        $daftartp = $this->M_sekolah->getTP($id_user, $id_mapel, $id_kelas);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;
        $data['id_user'] = $id_user;
        $judul_submenu = "Tujuan Pembelajaran";
        $data['valkelas'] = $kelaspilihan;
        $data['daftartp'] = $daftartp;
        $data['judul_submenu'] = $judul_submenu;
        $data['submenu'] = true;
        $data['menutitle'] = 'TP';
        $data['ikon'] = 'tp';
        return view('v_tujuan_pembelajaran', $data);
    }
}

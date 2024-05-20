<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Home extends BaseController
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

        if (session()->get('sebagai') == "admin")
            return redirect()->to("/admin");

        $id_user = session()->get('id_user');
        $id_sekolah = session()->get('id_sekolah');
        $sekolah_saya = $this->M_sekolah->getSekolah($id_sekolah);

        $data = [];

        $data['beranda'] = true;
        $data['sekolah_saya'] = $sekolah_saya;

        if (session()->get('sebagai') == "guru") {
            $data_saya = $this->M_user->get_data_guru($id_user);
            $nuptk = $data_saya->nuptk;
            $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
            $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
            $daftarkelasajarlain = $this->M_user->cekajarlain($nuptk, $id_sekolah);
            $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
            $data['ikon'] = 'absen';
            $data['daftarkelaswali'] = $daftarkelaswali;
            $data['daftarkelasajar'] = $daftarkelasajar;
            $data['daftarkelasajarlain'] = $daftarkelasajarlain;
            $data['daftarwaliekskul'] = $daftarwaliekskul;
            return view('v_beranda', $data);
        } else if (session()->get('sebagai') == "siswa") {
            $data_saya = $this->M_user->getDataSiswa($id_user, tahun_ajaran());

            $data['data_saya'] = $data_saya;

            return view('v_beranda_siswa', $data);
        }



        // echo var_dump($daftarkelasajar);
        // echo '</pre>';
        // die();

    }

    public function tes()
    {
        return view('vtes');
    }
}

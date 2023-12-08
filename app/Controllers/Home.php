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
        $id_user = session()->get('id_user');
        $data_saya = $this->M_user->get_data_guru($id_user);
        $nuptk = $data_saya->nuptk;
        $id_sekolah = session()->get('id_sekolah');
        $daftarkelaswali = $this->M_user->cekwalikelas($nuptk, $id_sekolah);
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk, $id_sekolah);
        $daftarkelasajarlain = $this->M_user->cekajarlain($nuptk, $id_sekolah);
        $daftarwaliekskul = $this->M_user->cekwaliekskul($nuptk, $id_sekolah, tahun_ajaran());
        $sekolah_saya = $this->M_sekolah->getSekolah($id_sekolah);
        $data['beranda'] = true;
        $data['ikon'] = 'absen';
        $data['daftarkelaswali'] = $daftarkelaswali;
        $data['daftarkelasajar'] = $daftarkelasajar;
        $data['daftarkelasajarlain'] = $daftarkelasajarlain;
        $data['daftarwaliekskul'] = $daftarwaliekskul;
        $data['sekolah_saya'] = $sekolah_saya;

        return view('v_beranda', $data);
    }

    public function tes()
    {
        return view('vtes');
    }
}

<?php

namespace App\Controllers;

use App\Models\M_user;

class Home extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
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
        $daftarkelasajar = $this->M_user->cekajarkelas($nuptk);
        $data['beranda'] = true;
        $data['ikon'] = 'absen';
        $data['daftarkelaswali'] = $daftarkelaswali;
        $data['daftarkelasajar'] = $daftarkelasajar;

        return view('v_beranda', $data);
    }
}

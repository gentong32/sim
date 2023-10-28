<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Registrasi extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        //laman pendaftaran sekolah oleh admin / operator sekolah;
    }

    public function getInfoSekolah($npsn)
    {
        $url = "https://referensi.data.kemdikbud.go.id/publikasi/home/getInfoSekolah/" . $npsn;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data;
    }

    public function ceksekolah($npsn)
    {
        $datasekolah = $this->M_sekolah->getSekolahbyNPSN($npsn);
        if (!$datasekolah)
            $sekolahData = $this->getInfoSekolah($npsn);
    }
}

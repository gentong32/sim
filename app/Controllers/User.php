<?php

namespace App\Controllers;

class User extends BaseController
{
    public function index(): string
    {
        $infosekolah = array("jumlah_siswa" => 1200, "jumlah_rombel" => 33);
        $data['info'] = $infosekolah;
        return view('v_user_dashboard', $data);
    }
}

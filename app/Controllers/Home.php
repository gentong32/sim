<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $kelas_map = [
            '10_1' => 'X - 1',
            '10_12' => 'X - 12',
        ];
        $kelas = $this->request->getVar('kelas');
        if (!isset($kelas))
            $data['kelas']  = "X - 1";
        else {
            $formatKelas = $kelas_map[$kelas] ?? '';
            $data['kelas'] = $formatKelas;
        }
        $data['beranda'] = true;
        $data['valkelas'] = $kelas;
        $data['ikon'] = 'absen';
        return view('v_beranda', $data);
    }
}

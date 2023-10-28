<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use TCPDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdf;

class Video extends BaseController
{

    public function __construct()
    {
    }

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
        $data['valkelas'] = $kelas;
        $data['submenu'] = true;
        $data['menutitle'] = 'Video';
        $data['ikon'] = 'video';
        return view('v_video', $data);
    }

    public function detil()
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
        $data['valkelas'] = $kelas;
        $data['submenu'] = true;
        $data['menutitle'] = 'Video';
        $data['ikon'] = 'video';

        helper('getyoutube');
        $url = $this->request->getVar('url');
        $data['url'] = $url;

        return view('v_video_detil', $data);
    }
}

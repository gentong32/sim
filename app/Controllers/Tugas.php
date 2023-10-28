<?php

namespace App\Controllers;

class Tugas extends BaseController
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
        $data['valkelas'] = $kelas;
        $data['submenu'] = true;
        $data['menutitle'] = 'Tugas';
        $data['ikon'] = 'tugas';
        return view('v_tugas', $data);
    }

    public function hasil1(): string
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
        $data['menutitle'] = '';
        $data['tugas'] = 'Membuat Karangan Deskripsi';
        $data['ikon'] = 'tugas';
        return view('v_hasil_tugas1', $data);
    }

    public function hasil2(): string
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
        $data['menutitle'] = '';
        $data['tugas'] = 'Praktikum Biologi Percobaan Fotosintesis';
        $data['ikon'] = 'tugas';
        return view('v_hasil_tugas2', $data);
    }
}

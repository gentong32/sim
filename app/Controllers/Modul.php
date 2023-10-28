<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use TCPDF;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\Fpdf;

class Modul extends BaseController
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
        $data['menutitle'] = 'Modul';
        $data['ikon'] = 'buku';
        return view('v_modul', $data);
    }

    public function uploadForm()
    {
        return view('upload_form');
    }

    public function uploadPdf()
    {
        $uploadedFile = $this->request->getFile('pdf_file');

        if ($uploadedFile->isValid() && $uploadedFile->getClientMimeType() === 'application/pdf') {
            // Simpan file PDF
            $pdfPath = './uploads/';
            $uploadedFile->move($pdfPath);
        } else {
            return "Harap unggah file PDF yang valid.";
        }
    }

    public function daftarmodul()
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
        $data['menutitle'] = 'Modul';
        $data['ikon'] = 'buku';
        return view('v_dafmodul', $data);
    }
}

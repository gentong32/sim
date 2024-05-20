<?php

namespace App\Controllers;

use App\Models\M_sekolah;

class Pengumuman extends BaseController
{

    function __construct()
    {
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        $id_sekolah = session()->get('id_sekolah');
        $tanggal_sekarang = Date('Y-m-d');
        $getpengumuman = $this->M_sekolah->get_pengumuman($id_sekolah, $tanggal_sekarang);
        $dariadmin = false;
        $cekadmin = $this->request->getVar('i');
        if (isset($cekadmin) && $cekadmin == 1) {
            $dariadmin = true;
        }
        $data['ckeditor'] = true;
        $data['judul_submenu'] = "Pengumuman";
        $data['submenu'] = true;
        $data['dariadmin'] = $dariadmin;
        $data['menutitle'] = 'Agenda';
        $data['ikon'] = 'info';
        $data['pengumuman'] = $getpengumuman;

        return view('v_pengumuman', $data);
    }

    public function daftar()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $daftar_pengumuman = $this->M_sekolah->get_daftar_pengumuman($id_sekolah, tahun_ajaran());
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['nama_user'] = session()->get('nama_user');
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');

        $data['daftar_pengumuman'] = $daftar_pengumuman;

        return view('v_admin_pengumuman_daftar', $data);
    }

    public function pengumuman_baru()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $tanggal_sekarang = Date('Y-m-d');
        $tanggal_sebulan = date('Y-m-d', strtotime('+1 month', strtotime($tanggal_sekarang)));
        $data['pengumuman'] = "";
        $data['label_pengumuman'] = "";
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
        $data['datakalender'] = json_encode($datakalender);
        $data['tanggal_sekarang'] = $tanggal_sekarang;
        $data['tanggal_sebulan'] = $tanggal_sebulan;
        $data['ckeditor'] = true;
        $data['judul_submenu'] = "Pengumuman";
        $data['submenu'] = true;
        $data['menutitle'] = 'Agenda';
        $data['ikon'] = 'info';
        $data['addedit'] = 'add';

        return view('v_admin_pengumuman_baru', $data);
    }

    public function pengumuman_edit($id_pengumuman)
    {
        if (!khususadmin())
            return redirect()->to("/");
        $id_sekolah = session()->get('id_sekolah');
        $getpengumuman = $this->M_sekolah->edit_pengumuman($id_sekolah, $id_pengumuman);
        $datakalender = $this->M_sekolah->getAgenda($id_sekolah);
        $data['datakalender'] = json_encode($datakalender);
        $data['ckeditor'] = true;
        $data['judul_submenu'] = "Pengumuman";
        $data['id_pengumuman'] = $getpengumuman['id'];
        $data['label_pengumuman'] = $getpengumuman['judul'];
        $data['pengumuman'] = $getpengumuman['pengumuman'];
        $data['tanggal_sekarang'] = $getpengumuman['tanggal_mulai'];
        $data['tanggal_sebulan'] = $getpengumuman['tanggal_selesai'];
        $data['submenu'] = true;
        $data['menutitle'] = 'Agenda';
        $data['ikon'] = 'info';
        $data['addedit'] = 'edit';


        return view('v_admin_pengumuman_baru', $data);
    }

    public function simpanpengumuman()
    {
        if (!khususadmin())
            return redirect()->to("/");
        $id_pengumuman = $this->request->getPost('id_pengumuman');
        $id_sekolah = session()->get('id_sekolah');
        $tgl_mulai = $this->request->getPost('tanggal_mulai');
        $tgl_selesai = $this->request->getPost('tanggal_selesai');
        $judul_pengumuman = $this->request->getPost('judul_pengumuman');
        $pengumuman = $this->request->getPost('editor1');
        if (isset($id_pengumuman))
            $this->M_sekolah->update_pengumuman($id_pengumuman, $tgl_mulai, $tgl_selesai, $judul_pengumuman, $pengumuman);
        else
            $this->M_sekolah->tambah_pengumuman($id_sekolah, $tgl_mulai, $tgl_selesai, $judul_pengumuman, $pengumuman, tahun_ajaran());

        shell_exec('php ' . ROOTPATH . 'index.php sendmailjob');

        // return redirect()->to("/pengumuman?i=1");
    }

    public function hapuspengumuman()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $dataProjek = json_decode(file_get_contents('php://input'), true);

        $id = $dataProjek['id_projek'];

        $hapusdata1 = $this->M_sekolah->hapus_pengumuman($id_sekolah, $id);

        if ($hapusdata1)
            $response = ['pesan' => "Berhasil"];
        else
            $response = ['pesan' => "Gagal Menghapus"];

        return $this->response->setJSON($response);
    }

    private function sendEmail()
    {
        $email = \Config\Services::email();

        $email->setFrom('admin@sman3_smg.id', 'Sekretariat');
        $email->setTo('antok2000@yahoo.com');
        $email->setSubject('Email Test');

        $message = "<html>
                    <head>
                        <title>Ini adalah tes email</title>
                    </head>
                    <body>
                        <h2>Terimakasih sudah berpartisipasi</h2>
                    </body>
                    </html>
                    ";

        $email->setMessage($message);

        if ($email->send()) {
            echo 'Email successfully sent';
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
}

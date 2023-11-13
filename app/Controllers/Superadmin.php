<?php

namespace App\Controllers;

use App\Models\M_sekolah;
use App\Models\M_user;

class Superadmin extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $getdaftaradmin = $this->M_user->getDaftarAdmin();
        $tglsekarang = tanggal_sekarang();
        $data['jumlah_admin'] = sizeof($getdaftaradmin);
        $data['tanggal'] = $tglsekarang['panjang'];
        return view('v_superadmin_dashboard', $data);
    }

    public function user()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $getdaftaradmin = $this->M_user->getDaftarAdmin();

        // echo var_dump($getdaftaradmin);
        $tglsekarang = tanggal_sekarang();
        $data['daftar_admin'] = $getdaftaradmin;
        $data['tanggal'] = $tglsekarang['panjang'];
        return view('v_superadmin_daftaradmin', $data);
    }

    public function tambah_admin()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        helper('form');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_superadmin_admin_input', $data);
    }

    public function cek_email_admin()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $email = $this->request->getPost('email');
        // $email = "aa@sas.kom";
        $cek_email = $this->M_user->cek_email_admin($email);
        if ($cek_email) {
            echo "ada";
        } else {
            echo "aman";
        }
    }

    public function simpan_admin()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $nama = ($this->request->getVar('nama'));
        $jenjang = ($this->request->getVar('jenjang'));
        $email = ($this->request->getVar('email'));
        $uuiduser = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        $data = [
            'id_user'       => $uuiduser,
            'nama'          => htmlspecialchars($nama),
            'jenjang'       => htmlspecialchars($jenjang),
            'email'         => htmlspecialchars($email),
            'token'         => password_hash('admin123', PASSWORD_DEFAULT),
            'id_sekolah'    => $uuid,
        ];

        $this->M_user->tambah_admin($data);
        // $cekmapel = $this->M_sekolah->cek_mapel($uuid, kelasdarijenjang($jenjang)[0]);
        // if (!$cekmapel) {
        //     foreach (kelasdarijenjang($jenjang) as $kelas) {
        //         $this->M_sekolah->impor_mapel($uuid, $kelas);
        //     }
        // }

        return redirect()->to("/superadmin/user");
    }

    public function edit_admin($id_admin)
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        helper('form');
        $dataadmin = $this->M_user->get_admin($id_admin);
        $data['data_admin'] = $dataadmin;
        return view('v_superadmin_admin_edit', $data);
    }

    public function update_admin()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $id_admin = ($this->request->getVar('id_admin'));
        $nama = ($this->request->getVar('nama'));
        $email = ($this->request->getVar('email'));
        $jenjang = ($this->request->getVar('jenjang'));

        $data = [
            'nama'          => htmlspecialchars($nama),
            'email'         => htmlspecialchars($email),
            'jenjang'       => htmlspecialchars($jenjang),
        ];

        $this->M_user->update_admin($data, $id_admin);

        return redirect()->to("/superadmin/user");
    }

    public function hapus_admin()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $dataAdmin = json_decode(file_get_contents('php://input'), true);
        $id_admin = $dataAdmin['id_admin'];

        $this->M_user->hapus_admin($id_admin);

        $response = ['message' => $id_admin];
        return $this->response->setJSON($response);
    }

    public function reset_admin_pass($id_admin)
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $data['token'] = password_hash('admin123', PASSWORD_DEFAULT);
        $this->M_user->update_admin($data, $id_admin);
        return redirect()->to("/superadmin/user");
    }

    public function kalender()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $datakalender = $this->M_sekolah->getKalender();
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['datakalender'] = json_encode($datakalender);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;

        return view('v_superadmin_kalender', $data);
    }

    public function simpan_kalender()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $kalender = $this->request->getVar('ikalender');
        $jenis = 2;
        $addedit = $this->request->getVar('addedit');

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        if ($addedit == "add")
            $this->M_sekolah->tambah_kalender($tanggalnya, $kalender, $jenis);
        else
            $this->M_sekolah->update_kalender($tanggalnya, $kalender, $jenis);

        return redirect()->to(base_url() . 'superadmin/kalender');
    }

    public function hapus_kalender()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $tanggal = $this->request->getVar('tanggal');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        session()->setFlashdata('pesan', $bulan . "-" . $tahun);

        $tanggalnya = $tahun . "-" . (intval($bulan) + 1) . "-" . $tanggal;

        $this->M_sekolah->hapus_kalender($tanggalnya);

        return redirect()->to(base_url() . 'superadmin/kalender');
    }

    public function list_kalender()
    {
        if (!khusussuperadmin())
            return redirect()->to("/");

        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $listkalender = $this->M_sekolah->getListKalender(tahun_ajaran());
        $data['sekolah'] = $datasekolah;
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        $data['listkalender'] = $listkalender;
        $data['jmldatakalender'] = sizeof($listkalender);

        $pesan = session()->getFlashdata('pesan');
        $data['pesan'] = $pesan;

        return view('v_superadmin_kalender_list', $data);
    }

    public function tesjenjang()
    {
        $jenjang = "SMA";
    }
}

<?php

namespace App\Controllers;

use App\Models\M_user;
use App\Models\M_sekolah;

class Login extends BaseController
{
    function __construct()
    {
        $this->M_user = new M_user();
        $this->M_sekolah = new M_sekolah();
    }

    public function index(): string
    {
        $data['nofooter'] = true;
        return view('v_login', $data);
    }

    public function createpassword($kode)
    {
        $hashed_password = password_hash($kode, PASSWORD_DEFAULT);
        // echo $hashed_password;
        return $hashed_password;
    }

    private function cekpassword($token, $kode)
    {
        if (password_verify($kode, $token))
            return "OKE";
    }

    public function change_password()
    {
        if (!khususadmin())
            return redirect()->to("/");
        helper('form');
        $tglsekarang = tanggal_sekarang();
        $id_sekolah = session()->get('id_sekolah');
        $datasekolah = $this->M_sekolah->getSekolah($id_sekolah);
        $data['sekolah'] = $datasekolah;
        $data['tanggal'] = $tglsekarang['panjang'];
        $data['tahun_ajaran'] = tahun_ajaran('lengkap');
        $data['nama_user'] = session()->get('nama_user');
        return view('v_ganti_password', $data);
    }

    public function update_password()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $password_baru = $this->request->getVar('password_baru1');
        $tokenbaru = password_hash($password_baru, PASSWORD_DEFAULT);
        $id_user = session()->get('id_user');
        $this->M_user->update_password($id_user, $tokenbaru);
        return redirect()->to("/admin");
    }

    public function cek_passlama()
    {
        if (!khususadmin())
            return redirect()->to("/");

        $dataadmin = $this->M_user->getAdmin(session()->get('id_user'));
        $token = $dataadmin['token'];
        $password_lama = $this->request->getPost('password_lama');

        $cekpassword = $this->cekpassword($token, $password_lama);
        echo $cekpassword;
    }

    public function authenticate()
    {
        session()->set('loggedIn', false);

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $adminbukan = $this->request->getPost('adminCheckbox');

        if ($adminbukan == "on") {
            $ceklogin = $this->M_user->cekLoginAdmin($username, $password);
        } else {
            $ceklogin = $this->M_user->cekLoginGuru($username, $password);
        }

        $hasil = $ceklogin['hasil'];

        $id_sekolah = $ceklogin['id_sekolah'];
        $id_user = $ceklogin['id_user'];
        $nama_user = $ceklogin['nama_user'];
        $jenis_kelamin = $ceklogin['jenis_kelamin'];

        if ($hasil == "ganteng") {

            session()->set('loggedIn', true);
            session()->set('id_user', $id_user);
            session()->set('nama_user', $nama_user);
            session()->set('sebagai', "superadmin");
            return redirect()->to(base_url('superadmin'));
        } else if ($hasil == "ok") {

            session()->set('loggedIn', true);
            session()->set('id_sekolah', $id_sekolah);
            session()->set('id_user', $id_user);
            session()->set('nama_user', $nama_user);
            session()->set('sex', $jenis_kelamin);
            $this->M_user->tambahlog();

            if ($adminbukan == "on") {
                session()->set('sebagai', "admin");
                return redirect()->to(base_url('admin'));
            } else {
                session()->set('sebagai', "guru");
                return redirect()->to(base_url('home'));
            }
        } else {
            // cek admin bukan guru yang gak klik masuk sebagai admin
            $cekloginadmin = $this->M_user->cekLoginAdmin($username, $password);
            $hasil = $cekloginadmin['hasil'];
            if ($hasil == "ok") {
                $id_sekolah = $cekloginadmin['id_sekolah'];
                $id_user = $cekloginadmin['id_user'];
                $nama_user = $cekloginadmin['nama_user'];
                $jenis_kelamin = $cekloginadmin['jenis_kelamin'];
                session()->set('loggedIn', true);
                session()->set('id_sekolah', $id_sekolah);
                session()->set('id_user', $id_user);
                session()->set('nama_user', $nama_user);
                session()->set('sex', $jenis_kelamin);
                $this->M_user->tambahlog();
                session()->set('sebagai', "admin");
                return redirect()->to(base_url('admin'));
            } else {
                $cekloginsiswa = $this->M_user->cekLoginSiswa($username, $password);
                if ($cekloginsiswa) {
                    session()->set('sebagai', "siswa");
                }
            }
            // session()->set('loggedIn', true);
            // return redirect()->to(base_url('admin'));
            // Jika login tidak berhasil, kembali ke halaman login dengan pesan kesalahan
            session()->setFlashdata('error_message', 'Username atau password tidak valid.');
            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        session()->remove('loggedIn');
        session()->remove('sebagai');
        session()->remove('id_user');
        session()->remove('id_sekolah');
        session()->remove('nama_user');
        session()->remove('sex');
        return redirect()->to(base_url('/'));
    }
}

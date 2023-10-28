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
        echo $hashed_password;
    }

    public function cekpassword($token, $kode)
    {
        if (password_verify($kode, $token))
            echo "OKE";
    }

    public function authenticate()
    {
        session()->set('loggedIn', false);

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $adminbukan = $this->request->getPost('adminCheckbox');

        if ($adminbukan == "on") {
            $ceklogin = $this->M_user->cekLoginAdmin($username, $password, null);
        } else {
            $ceklogin = $this->M_user->cekLoginGuru($username, $password, null);
        }

        $hasil = $ceklogin['hasil'];

        $id_sekolah = $ceklogin['id_sekolah'];
        $id_user = $ceklogin['id_user'];
        $nama_user = $ceklogin['nama_user'];

        if ($hasil == "ok") {

            session()->set('loggedIn', true);
            session()->set('id_sekolah', $id_sekolah);
            session()->set('id_user', $id_user);
            session()->set('nama_user', $nama_user);

            if ($adminbukan == "on") {
                session()->set('sebagai', "admin");
                return redirect()->to(base_url('admin'));
            } else {
                session()->set('sebagai', "guru");
                return redirect()->to(base_url('home'));
            }
        } else {
            $cekloginsiswa = $this->M_user->cekLoginSiswa($username, $password);
            if ($cekloginsiswa) {
                session()->set('sebagai', "siswa");
            }
            session()->set('loggedIn', true);
            return redirect()->to(base_url('admin'));
            // Jika login tidak berhasil, kembali ke halaman login dengan pesan kesalahan
            session()->setFlashdata('error_message', 'Username atau password tidak valid.');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->remove('loggedIn');
        session()->remove('sebagai');
        session()->remove('id_user');
        session()->remove('id_sekolah');
        return redirect()->to(base_url('login'));
    }
}
